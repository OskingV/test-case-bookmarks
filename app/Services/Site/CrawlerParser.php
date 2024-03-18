<?php

namespace App\Services\Site;

use App\Services\Site\Contracts\Parser;
use Symfony\Component\DomCrawler\Crawler;

class CrawlerParser implements Parser
{
    /**
     * Crawler instance.
     *
     * @var Crawler
     */
    private Crawler $crawler;

    /**
     * Info for parsing by Crawler.
     *
     * @var array|null
     */
    private ?array $xPathes;

    /**
     * Create a new parser service instance.
     *
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $this->crawler = $crawler;
        $this->setXPathes();
    }

    /**
     * Set xPathes property.
     *
     * @return void
     */
    private function setXPathes(): void
    {
        $this->xPathes = [
            'title' => [
                '//title',
                'text'
            ],
            'favicon_path' => [
                '//link[@rel="shortcut icon"]',
                'attr',
                'href'
            ],
            'meta_description' => [
                '//meta[@name="description"]',
                'attr',
                'content'
            ],
            'meta_keywords' => [
                '//meta[@name="keywords"]',
                'attr',
                'content'
            ]
        ];
    }

    /**
     * Get parsed data.
     *
     * @param string $url
     *
     * @return array
     */
    public function parse(string $url): array
    {
        $this->crawler->add(file_get_contents($url));
        foreach ($this->xPathes as $name => $xPath) {
            $element = $this->crawler->filterXPath($xPath[0]);
            $parsedData[$name] = ($element->count() === 1) ? $this->getContentFromElement($xPath, $element) : '';
        }

        return $parsedData;
    }

    /**
     * Get content from html element by Crawler.
     *
     * @param array $xPath
     * @param Crawler $element
     *
     * @return mixed
     */
    private function getContentFromElement(array $xPath, Crawler $element)
    {
        if (isset($xPath[2])) {
            return $element->{$xPath[1]}($xPath[2]);
        }
        return $element->{$xPath[1]}();
    }
}
