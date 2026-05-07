<?php

namespace App\Providers;

use App\Models\SiteOption;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
