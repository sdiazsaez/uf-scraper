<?php

namespace Larangular\UFScraper\Tests;

use Larangular\UFScraper\UFScraperServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase {

    protected function getEnvironmentSetUp($app) {
        $app['config']->set('uf-scraper', require(__DIR__ . '/../config/uf-scraper.php'));
    }

    protected function getPackageProviders($app)
    {
        return [
            UFScraperServiceProvider::class
        ];
    }

}
