<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Service;
use App\Utils\SitemapGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SitemapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sitemap generator';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //always
        //hourly
        //daily
        //weekly
        //monthly
        //yearly
        //never

        $sitemap = new SitemapGenerator(config('app.url'));
        $sitemap->addUrl('', null, 'always', 1.0);

        $pages = Page::query()
            ->where('slug', '!=', 'homepage')
            ->where('is_active', '=', true)
            ->get();
        foreach ($pages as $model) {
            $sitemap->addUrl(route('pages.show', ['slug' => $model->slug], false), $model->updated_at, 'weekly', $model->slug === 'services' ? 0.9 : 0.8);
        }

        $services = Service::query()->where('is_active', '=', true)->get();
        foreach ($services as $model) {
            $sitemap->addUrl(route('services.show', ['slug' => $model->slug], false), $model->updated_at, 'weekly', 0.9);
        }

        $portfolios = Portfolio::query()->where('is_active', '=', true)->get();
        foreach ($portfolios as $portfolio) {
            $sitemap->addUrl(route('portfolios.show', ['slug' => $portfolio->slug]), $model->updated_at, 'monthly', 0.8);
        }

        $sitemap->generate(public_path());

        return 0;
    }
}
