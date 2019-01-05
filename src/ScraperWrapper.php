<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2019-01-03
 */

namespace Larangular\UFScraper;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

class ScraperWrapper {

    public $isValid;
    private $response, $content;

    public function __construct(ResponseInterface $response) {
        $this->response = $response;
        $this->isValid = ($response->getStatusCode() === 200);
        $this->content = $this->response->getBody()->getContents();
    }

    public function getTextContent(): string {
        return $this->content;
    }

    public function getContent() {
        $content = $this->getTextContent();
        if($this->isContentTypeOf('text/html')) {
            $content = new Crawler($this->getTextContent());
        }
        return $content;
    }

    private function contentType(): string {
        return $this->response->getHeaderLine('Content-Type');
    }

    private function isContentTypeOf(string $type): bool {
        return (stripos($this->contentType(), $type) !== false);
    }


}
