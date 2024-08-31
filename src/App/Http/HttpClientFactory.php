<?php

namespace Appcheap\SearchEngine\App\Http;

class HttpClientFactory
{
    public static function createHttpClient(string $type, array $config = [])
    {
        switch ($type) {
            case 'guzzle':
                return new GuzzleHttpClient($config);
            case 'curl':
                return new CurlHttpClient();
            case 'WordPress':
                return new WpHttpClient();
            default:
                throw new \InvalidArgumentException("Unknown HTTP client type: $type");
        }
    }
}
