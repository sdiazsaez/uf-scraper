<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2019-01-03
 */

namespace Larangular\UFScraper\ImpuestosInternos;

use Larangular\UFScraper\Scraper;
use Larangular\UFScraper\ScraperWrapper;
use Symfony\Component\DomCrawler\Crawler;

class ImpuestosInternosScraper extends Scraper {

    private $date;
    public function getScrapeUrl($date): string {
        $this->date = $date;
        $year = date_format(date_create($date), 'Y');
        //$date = date_format(date_create($date), 'd-m-Y');
        return 'http://www.sii.cl/valores_y_fechas/uf/uf'.$year.'.htm';
    }

    public function getScrapedValue(ScraperWrapper $wrapper): string {
        $scrapedValue = '';
        $day = $this->getDayNumber();
        $crawler = $wrapper->getContent();
        $dayRow = $crawler->filter('#mes_all table#table_export tbody tr')->eq($day-1);

        if($this->isValidDayRow($dayRow)) {
            $scrapedValue = $dayRow->filter('td')->eq($this->getMonthNumber()-1)->text();
        }
        return $scrapedValue;
    }

    private function isValidDayRow(Crawler $row): bool {
        $rowDay = (int)$row->filter('th')->text();
        return ($rowDay === $this->getDayNumber());
    }

    private function getDayNumber(): int {
       return (int)date_format(date_create($this->date), 'd');
    }

    private function getMonthNumber(): int {
        return (int)date_format(date_create($this->date), 'm');
    }
}
