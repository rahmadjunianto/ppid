<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'featured_image',
        'template',
        'parent_id',
        'sort_order',
        'status',
        'show_in_menu',
        'is_homepage',
        'is_featured',
        'seo_data',
        'admin_id',
        'custom_fields',
        'published_at'
    ];

    protected $casts = [
        'custom_fields' => 'array',
        'show_in_menu' => 'boolean',
        'is_homepage' => 'boolean',
        'published_at' => 'datetime'
    ];

    protected $dates = [
        'published_at'
    ];

    // Boot method untuk auto-generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($page) {
            if (empty($page->slug)) {
                $page->slug = Str::slug($page->title);
            }
            
            // Auto set published_at if status is published
            if ($page->status === 'published' && !$page->published_at) {
                $page->published_at = now();
            }
        });

        static::updating(function ($page) {
            // Auto set published_at when status changed to published
            if ($page->status === 'published' && !$page->published_at) {
                $page->published_at = now();
            }
            
            // Clear published_at if status changed to draft
            if ($page->status === 'draft') {
                $page->published_at = null;
            }
        });
    }

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id')->orderBy('sort_order');
    }

    public function publishedChildren()
    {
        return $this->children()->published();
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where(function ($q) {
                        $q->whereNull('published_at')
                          ->orWhere('published_at', '<=', now());
                    });
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true);
    }

    public function scopeRootPages($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    // Accessors
    public function getUrlAttribute()
    {
        if ($this->is_homepage) {
            return url('/');
        }
        
        if ($this->parent_id) {
            $parents = collect();
            $page = $this;
            
            while ($page->parent_id) {
                $page = $page->parent;
                $parents->prepend($page->slug);
            }
            
            return url('/' . $parents->implode('/') . '/' . $this->slug);
        }
        
        return url('/' . $this->slug);
    }

    public function getFullTitleAttribute()
    {
        if ($this->parent_id) {
            return $this->parent->title . ' → ' . $this->title;
        }
        
        return $this->title;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'published' => '<span class="badge badge-success">Published</span>',
            'draft' => '<span class="badge badge-secondary">Draft</span>',
            'archived' => '<span class="badge badge-warning">Archived</span>'
        ];
        
        return $badges[$this->status] ?? '<span class="badge badge-light">Unknown</span>';
    }

    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        // Auto generate excerpt from content
        return Str::limit(strip_tags($this->content), 160);
    }

    public function getPublishedAtFormattedAttribute()
    {
        return $this->published_at ? $this->published_at->format('d F Y H:i') : '-';
    }

    // Helper methods
    public function isPublished()
    {
        return $this->status === 'published' && 
               ($this->published_at === null || $this->published_at <= now());
    }

    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    public function getBreadcrumb()
    {
        $breadcrumb = collect();
        $page = $this;
        
        $breadcrumb->prepend([
            'title' => $page->title,
            'url' => $page->getUrl(),
            'active' => true
        ]);
        
        while ($page->parent_id) {
            $page = $page->parent;
            $breadcrumb->prepend([
                'title' => $page->title,
                'url' => $page->getUrl(),
                'active' => false
            ]);
        }
        
        return $breadcrumb;
    }

    // Alias for getBreadcrumb() to match template expectations
    public function getBreadcrumbs()
    {
        return $this->getBreadcrumb();
    }

    public function getUrl()
    {
        if ($this->is_homepage) {
            return url('/');
        }

        $segments = collect([$this->slug]);
        $parent = $this->parent;
        
        while ($parent) {
            $segments->prepend($parent->slug);
            $parent = $parent->parent;
        }
        
        return url($segments->implode('/'));
    }

    // Static methods
    public static function getTemplateOptions()
    {
        return [
            'default' => 'Default Page',
            'home' => 'Homepage',
            'contact' => 'Contact Page',
            'page-with-sidebar' => 'Page with Sidebar',
            'full-width' => 'Full Width',
            'landing-page' => 'Landing Page',
            'gallery' => 'Gallery',
            'news' => 'News/Blog Layout'
        ];
    }

    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->published()->first();
    }

    public static function getHomepage()
    {
        return static::where('is_homepage', true)->published()->first();
    }

    public static function getMenuPages()
    {
        return static::published()
                    ->inMenu()
                    ->rootPages()
                    ->with(['publishedChildren' => function ($query) {
                        $query->inMenu()->ordered();
                    }])
                    ->ordered()
                    ->get();
    }
}
