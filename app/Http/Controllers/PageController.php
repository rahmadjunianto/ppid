<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($slug)
    {
        // Handle nested slugs (parent/child structure)
        $slugs = explode('/', $slug);
        $page = null;
        $currentParent = null;

        foreach ($slugs as $currentSlug) {
            $query = Page::where('slug', $currentSlug)->published();

            if ($currentParent) {
                $query->where('parent_id', $currentParent->id);
            } else {
                $query->whereNull('parent_id');
            }

            $page = $query->first();

            if (!$page) {
                abort(404);
            }

            $currentParent = $page;
        }

        if (!$page) {
            abort(404);
        }

        // Get breadcrumb
        $breadcrumb = $page->getBreadcrumb();

        // Get template
        $template = $page->template ?: 'default';
        $viewPath = "pages.{$template}";

        // Check if template view exists, fallback to default
        if (!view()->exists($viewPath)) {
            $viewPath = 'pages.default';
        }

        // Get related pages (siblings or children)
        $relatedPages = collect();

        if ($page->children()->published()->count() > 0) {
            // If page has children, show them
            $relatedPages = $page->children()->published()->orderBy('sort_order')->get();
        } elseif ($page->parent_id) {
            // If page has parent, show siblings
            $relatedPages = Page::where('parent_id', $page->parent_id)
                               ->where('id', '!=', $page->id)
                               ->published()
                               ->orderBy('sort_order')
                               ->get();
        }

        // Get latest pages for homepage template
        $latestPages = null;
        if ($template === 'home') {
            $latestPages = Page::published()
                              ->where('id', '!=', $page->id)
                              ->orderBy('published_at', 'desc')
                              ->orderBy('created_at', 'desc')
                              ->limit(4)
                              ->get();
        }

        return view($viewPath, compact('page', 'breadcrumb', 'relatedPages', 'latestPages'));
    }

    public function home()
    {
        $homepage = Page::getHomepage();

        if (!$homepage) {
            // Fallback to existing beranda view if no homepage is set
            return view('beranda');
        }

        $template = $homepage->template ?: 'home';
        $viewPath = "pages.{$template}";

        if (!view()->exists($viewPath)) {
            $viewPath = 'pages.home';
        }

        // Get latest pages for homepage
        $latestPages = Page::published()
                          ->where('id', '!=', $homepage->id)
                          ->orderBy('published_at', 'desc')
                          ->orderBy('created_at', 'desc')
                          ->limit(4)
                          ->get();

        return view($viewPath, [
            'page' => $homepage,
            'latestPages' => $latestPages
        ]);
    }

    public function sitemap()
    {
        $pages = Page::published()
                    ->with('children')
                    ->whereNull('parent_id')
                    ->orderBy('sort_order')
                    ->get();

        return view('pages.sitemap', compact('pages'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $pages = collect();

        if ($query) {
            $pages = Page::published()
                        ->where(function($q) use ($query) {
                            $q->where('title', 'like', "%{$query}%")
                              ->orWhere('content', 'like', "%{$query}%")
                              ->orWhere('excerpt', 'like', "%{$query}%");
                        })
                        ->orderBy('title')
                        ->paginate(10);
        }

        return view('pages.search', compact('pages', 'query'));
    }
}
