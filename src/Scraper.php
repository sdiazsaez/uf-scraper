<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2019-01-03
 */

namespace Larangular\UFScraper;

abstract class Scraper {

    abstract public function getScrapeUrl($date): string;

    abstract public function getScrapedValue(ScraperWrapper $wrapper): string;
}
