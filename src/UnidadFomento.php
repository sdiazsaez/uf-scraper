<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2019-01-02
 */


namespace Larangular\UFScraper;

use Larangular\Support\Instance;
use GuzzleHttp\Client as GuzzleClient;

class UnidadFomento {

    private $scrapers;
    private $client;

    public function __construct() {
        $this->scrapers = config('uf-scraper.scrapers');
        $this->client = new GuzzleClient(['timeout' => 30]);
    }

    public function getUnidadFomento($date = null) {
        if (is_null($date)) {
            $date = date('Y-m-d');
        }

        $response = false;

        foreach($this->scrapers as $scraper) {
            $response = $this->callScraper($scraper, $date);
            if($response !== false) break;
        }

        return $response;
    }

    private function callScraper($scraperName, $date) {
        $response = false;
        $scraper = new $scraperName;

        if (Instance::instanceOf($scraper, Scraper::class)) {
            $request = $this->client->request('GET', $scraper->getScrapeUrl($date));
            $scraperWrapper = new ScraperWrapper($request);
            if($scraperWrapper->isValid) {
                $scrapedValue = $scraper->getScrapedValue($scraperWrapper);
                $response = $this->formatScrapedValue($scrapedValue);
            }
        }

        return $response;
    }


    private function formatScrapedValue(string $value) {
        return \str_to_float($value);
    }

}
