<?php

namespace App\Providers;

use App\Models\Page;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Share menu data with all views
        View::composer('*', function ($view) {
            // Cache menu data for better performance
            $menuPages = Cache::remember('navigation_menu', 60, function () {
                return Page::published()
                          ->where('show_in_menu', true)
                          ->whereNull('parent_id')
                          ->with(['children' => function($query) {
                              $query->published()
                                    ->where('show_in_menu', true)
                                    ->orderBy('sort_order');
                          }])
                          ->orderBy('sort_order')
                          ->get();
            });

            $view->with('menuPages', $menuPages);
        });
    }
}
