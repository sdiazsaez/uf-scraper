<?php

namespace Larangular\UFScraper;

use \Illuminate\Support\ServiceProvider;

class UFScraperServiceProvider extends ServiceProvider {

    public function boot() {
        $this->publishes([
                             __DIR__ . '/../config/uf-scraper.php' => config_path('uf-scraper.php'),
                         ]);
    }

    public function register() {
        $this->app->register('Larangular\Support\SupportServiceProvider');
        $this->mergeConfigFrom(__DIR__ . '/../config/uf-scraper.php', 'uf-scraper');
    }
}
