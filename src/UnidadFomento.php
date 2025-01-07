<?php
namespace Larangular\UFScraper;

use GuzzleHttp\Exception\RequestException;
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
            try {
                // Attempt to execute the HTTP request
                $request = $this->client->request('GET', $scraper->getScrapeUrl($date));

                // Process the response only if the request was successful
                $scraperWrapper = new ScraperWrapper($request);

                if ($scraperWrapper->isValid) {
                    $scrapedValue = $this->getScrapedValue($scraper, $scraperWrapper);
                    $response = $this->formatScrapedValue($scrapedValue);
                }
            } catch (\Exception $e) {
                // Ignore any exception and move on
            }
        }

        return $response;
    }

    private function getScrapedValue(Scraper $scraper, ScraperWrapper $scraperWrapper): string {
        $value = @$scraper->getScrapedValue($scraperWrapper);
        return (!is_string($value)? '': $value);
    }


    private function formatScrapedValue(string $value) {
        return \str_to_float($value);
    }

}
