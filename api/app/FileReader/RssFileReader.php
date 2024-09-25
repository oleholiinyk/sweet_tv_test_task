<?php

namespace App\FileReader;

use App\Contracts\FileReaderProvider;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;
use SimpleXMLElement;
use XMLReader;

class RssFileReader implements FileReaderProvider
{
    protected LoggerInterface $logger;

    protected array $skippedAttributes = ['ismain'];
    protected array $shouldBeAssociativeArray = ['videoinfo'];
    protected array $resultData = [];

    public function __construct()
    {
        $this->logger = Log::channel('rssreader');
        $this->resultData = [];
    }

    public function read(string $url, array $queryParams = []): array
    {
        $uri = $this->buildUrl($url, $queryParams);

        $this->logger->info('Starting to read XML file from URI: ' . $uri);

        $reader = new XMLReader();
        $reader->open($uri);

        while ($reader->read()) {
            if ($reader->nodeType == \XMLReader::ELEMENT && $reader->localName == 'item') {
                $itemXml = new \DOMDocument();
                $itemXml->loadXML($reader->readOuterXML());

                foreach ($itemXml->documentElement->childNodes as $node) {
                    $this->parseXmlRecursively($node);
                }
            }
        }

        dd($this->resultData);

        $this->logger->info('Finished reading RSS feed');

        return $this->resultData;
    }

    protected function parseXmlRecursively($node, $parent = false)
    {
        $result = [];
        foreach ($node->childNodes as $childNode) {
            switch ($childNode->nodeType) {
                case (XMLReader::ELEMENT):
                    // Initialize as an array if not already
                    if (!$parent && (!isset($result[$node->localName]) || !is_array($result[$node->localName]))) {
                        $result[$node->localName] = [];
                    }

                    if ($childNode->childNodes->length > 1) {
//                        var_dump($childNode->nodeType, $childNode->nodeName);
//                        dd($childNode->nodeType, $childNode->nodeName, $childNode->nodeValue);

                        $data = $this->parseXmlRecursively($childNode, true);

                        $result[$node->parentNode->nodeName] = $data;
                        dd($result);
                    }

                    $attributes = [];
                    if ($childNode->hasAttributes()) {
                        foreach ($childNode->attributes as $attr) {
                            if (!in_array($attr->nodeName, $this->skippedAttributes)) {
                                $attributes[$attr->nodeName] = $attr->nodeValue;
                            }
                        }

                        if ($attributes) {
                            $attributes[$childNode->nodeName] = trim($childNode->textContent);
                        }

                        $result[$node->localName][] = $attributes ?? trim($childNode->textContent);
                    } else if (isset($result[$node->localName])) {
                        $value = trim($childNode->textContent);
                        if (in_array($node->nodeName, $this->shouldBeAssociativeArray)) {
                            $result[$node->localName][$childNode->nodeName] = $value;
                        } else {
                            $result[$node->localName][] = $value;
                        }
                    }
                    break;

                case (XMLReader::TEXT):
                    $result[$node->nodeName] = $childNode->nodeValue;
                    break;
            }
        }

        if ($parent) {
            return $result;
        }
        $this->resultData = $result;
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
