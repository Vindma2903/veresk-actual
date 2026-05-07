<?php

namespace App\Providers;

use App\Models\SiteOption;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Mechanisms\FrontendAssets\FrontendAssets;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (class_exists(FrontendAssets::class)) {
            app(FrontendAssets::class)->setScriptRoute(function () {
                return Route::get('/livewire/livewire.js', function () {
                    return response()->file(
                        base_path('vendor/livewire/livewire/dist/livewire.js'),
                        ['Content-Type' => 'application/javascript; charset=utf-8']
                    );
                });
            });
        }

        $data = [];

        if (Schema::hasTable('site_options')) {
            $options = SiteOption::query()
                ->select(['id', 'body', 'body_json', 'type'])
                ->get()
                ->keyBy('id')
                ->toArray();
            foreach ($options as $option) {
                $data[$option['id']] = $option['type'] === SiteOption::BODY_TYPE_JSON ? $option['body_json'] : $option['body'];
            }
        }

        View::share('site_options', $data);
    }
}
