<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::with('parent');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by template
        if ($request->filled('template')) {
            $query->where('template', $request->template);
        }

        // Filter by parent
        if ($request->filled('parent')) {
            if ($request->parent === 'root') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent);
            }
        }

        $pages = $query->orderBy('sort_order')->orderBy('created_at', 'desc')->paginate(15);

        $parentPages = Page::whereNull('parent_id')->pluck('title', 'id');
        $templateOptions = Page::getTemplateOptions();

        return view('admin.pages.index', compact('pages', 'parentPages', 'templateOptions'));
    }

    public function create()
    {
        $parentPages = Page::whereNull('parent_id')->orWhereNotNull('parent_id')->pluck('title', 'id');
        $templateOptions = Page::getTemplateOptions();

        return view('admin.pages.create', compact('parentPages', 'templateOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'template' => 'required|string',
            'parent_id' => 'nullable|exists:pages,id',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,published,archived',
            'show_in_menu' => 'boolean',
            'is_homepage' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        // Set admin_id from authenticated user
        $request->merge(['admin_id' => auth()->id()]);

        $data = $request->all();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Page::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::slug($data['title']) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('pages/featured', $imageName, 'public');
            $data['featured_image'] = $imagePath;
        }

        // Handle homepage setting
        if ($request->has('is_homepage') && $request->is_homepage) {
            // Remove homepage flag from other pages
            Page::where('is_homepage', true)->update(['is_homepage' => false]);
            $data['is_homepage'] = true;
        }

        // Set sort order
        if (!isset($data['sort_order']) || $data['sort_order'] === null) {
            $maxOrder = Page::where('parent_id', $data['parent_id'])->max('sort_order') ?? 0;
            $data['sort_order'] = $maxOrder + 1;
        }

        $page = Page::create($data);

        return redirect()->route('admin.pages.edit', $page)
                ->with('success', 'Halaman berhasil dibuat.');
    }

    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        $parentPages = Page::where('id', '!=', $page->id)
                          ->whereNotIn('id', $this->getChildrenIds($page))
                          ->pluck('title', 'id');
        $templateOptions = Page::getTemplateOptions();

        return view('admin.pages.edit', compact('page', 'parentPages', 'templateOptions'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'template' => 'required|string',
            'parent_id' => 'nullable|exists:pages,id|not_in:' . $page->id,
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,published,archived',
            'show_in_menu' => 'boolean',
            'is_homepage' => 'boolean',
            'published_at' => 'nullable|date'
        ]);

        $data = $request->all();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Page::where('slug', $data['slug'])->where('id', '!=', $page->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($page->featured_image && Storage::disk('public')->exists($page->featured_image)) {
                Storage::disk('public')->delete($page->featured_image);
            }

            $image = $request->file('featured_image');
            $imageName = time() . '_' . Str::slug($data['title']) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('pages/featured', $imageName, 'public');
            $data['featured_image'] = $imagePath;
        }

        // Handle homepage setting
        if ($request->has('is_homepage') && $request->is_homepage) {
            // Remove homepage flag from other pages
            Page::where('is_homepage', true)->where('id', '!=', $page->id)->update(['is_homepage' => false]);
            $data['is_homepage'] = true;
        } else {
            $data['is_homepage'] = false;
        }

        $page->update($data);

        return redirect()->back();
    }

    public function destroy(Page $page)
    {
        // Check if page has children
        if ($page->children()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Tidak dapat menghapus halaman yang memiliki sub-halaman.');
        }

        // Delete featured image
        if ($page->featured_image && Storage::disk('public')->exists($page->featured_image)) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
                        ->with('success', 'Halaman berhasil dihapus.');
    }

    // Helper method to get all children IDs (prevent circular reference)
    private function getChildrenIds(Page $page)
    {
        $childrenIds = [];
        $children = $page->children;

        foreach ($children as $child) {
            $childrenIds[] = $child->id;
            $childrenIds = array_merge($childrenIds, $this->getChildrenIds($child));
        }

        return $childrenIds;
    }

    // AJAX methods for better UX
    public function updateOrder(Request $request)
    {
        $request->validate([
            'pages' => 'required|array',
            'pages.*.id' => 'required|exists:pages,id',
            'pages.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->pages as $pageData) {
            Page::where('id', $pageData['id'])->update(['sort_order' => $pageData['sort_order']]);
        }

        return response()->json(['success' => true]);
    }

    public function toggleStatus(Page $page)
    {
        $newStatus = $page->status === 'published' ? 'draft' : 'published';
        $page->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'badge' => $page->status_badge
        ]);
    }

    public function duplicate(Page $page)
    {
        $newPage = $page->replicate();
        $newPage->title = $page->title . ' (Copy)';
        $newPage->slug = $page->slug . '-copy';
        $newPage->status = 'draft';
        $newPage->is_homepage = false;
        $newPage->published_at = null;

        // Ensure unique slug
        $originalSlug = $newPage->slug;
        $counter = 1;
        while (Page::where('slug', $newPage->slug)->exists()) {
            $newPage->slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $newPage->save();

        return redirect()->route('admin.pages.edit', $newPage)
                        ->with('success', 'Halaman berhasil diduplikasi.');
    }

    /**
     * Upload image for CKEditor 5
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120' // 5MB max
        ]);

        try {
            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('pages/images', $filename, 'public');

                // CKEditor 5 expects specific response format
                return response()->json([
                    'url' => asset('storage/' . $path),
                    'uploaded' => true
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'message' => 'Failed to upload image: ' . $e->getMessage()
                ],
                'uploaded' => false
            ], 500);
        }

        return response()->json([
            'error' => [
                'message' => 'No file uploaded'
            ],
            'uploaded' => false
        ], 400);
    }
}
