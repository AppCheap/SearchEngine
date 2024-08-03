<?php
namespace Appcheap\SearchEngine\App\Http;

class HttpClientFactory {
    public static function createHttpClient(string $type, array $config = []): HttpClientInterface {
        switch ($type) {
            case 'guzzle':
                return new GuzzleHttpClient($config);
            case 'curl':
                return new CurlHttpClient();
            case 'wordpress':
                return new WpHttpClient();
            default:
                throw new \InvalidArgumentException("Unknown HTTP client type: $type");
        }
    }
}