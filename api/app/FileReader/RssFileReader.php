<?php

namespace App\FileReader;

use App\Contracts\FileReaderProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;
use SimpleXMLElement;

class RssFileReader implements FileReaderProvider
{
    protected LoggerInterface $logger;

    protected array $resultData = [];

    const NUMERIC_TAGS = ['credit', 'viewingoption'];

    public function __construct()
    {
        $this->logger = Log::channel('rssreader');
        $this->resultData = [];
    }

    public function read(string $url, array $queryParams = []): array
    {
        $uri = $this->buildUrl($url, $queryParams);

        try {
            $xml = new SimpleXMLElement($this->extractRssFromHtml($uri));

            $this->resultData = $this->parseItems($xml);

            return $this->resultData;
        } catch (\Exception $e) {
            $this->logger->error('Failed to read or parse the RSS feed', ['exception' => $e]);
            return [];
        }
    }

    protected function parseXmlRecursively(SimpleXMLElement $xml): array
    {
        $result = [];

        foreach ($xml->children() as $element) {
            $tag = $element->getName();

            $value = (count($element->children()) > 0)
                ? $this->parseXmlRecursively($element)
                : (string)$element;

            $locale = (string)$element['locale'];

            if (in_array($tag, self::NUMERIC_TAGS)) {
                $result[] = $value;
            } else {
                if (!isset($result[$tag])) {
                    if ($locale) {
                        $result[$locale] = $value;
                    } else {
                        $result[$tag] = $value;
                    }
                } else {
                    if (!is_array($result[$tag])) {
                        $result[$tag] = [$result[$tag]];
                    }

                    $result[$tag][$locale] = $value;
                }
            }
        }

        return $result;
    }

    public function parseItems(SimpleXMLElement $xml): array
    {
        $result = [];

        if (isset($xml->channel)) {
            foreach ($xml->channel->item as $item) {
                $parsedItem = $this->parseXmlRecursively($item);
                $result[] = $parsedItem;
            }
        }

        return $result;
    }

    protected function extractRssFromHtml(string $url): ?string
    {
        $htmlContent = $this->fetchContent($url);

        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();
        $dom->loadHTML($htmlContent);
        libxml_clear_errors();

        $rssElement = $dom->getElementsByTagName('rss')->item(0);
        if ($rssElement) {
            return $dom->saveXML($rssElement);
        }

        return null;
    }


    protected function fetchContent(string $url): string
    {
        $response = Http::get($url);

        if ($response->failed()) {
            Log::channel('rss_reader')->error('Failed to fetch URL', [
                'url' => $url,
                'status' => $response->status(),
            ]);

            throw new \Exception('Failed to fetch the URL: ' . $url);
        }

        return $response->body();
    }

    protected function buildUrl(string $url, array $queryParams): string
    {
        if (!empty($queryParams)) {
            $queryString = http_build_query($queryParams);
            return $url . '?' . $queryString;
        }

        return $url;
    }
}
