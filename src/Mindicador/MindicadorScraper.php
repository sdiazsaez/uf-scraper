<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2019-01-03
 */

namespace Larangular\UFScraper\Mindicador;

use Larangular\UFScraper\Scraper;
use Larangular\UFScraper\ScraperWrapper;

class MindicadorScraper extends Scraper {

    public function getScrapeUrl($date): string {
        $date = date_format(date_create($date), 'd-m-Y');
        return 'https://mindicador.cl/api/uf/' . $date;
    }

    public function getScrapedValue(ScraperWrapper $wrapper): ?string {
        $response = json_decode($wrapper->getContent());
        return $response->serie[0]->valor;
    }
}
