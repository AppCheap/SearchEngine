<?php

namespace Appcheap\SearchEngine\App\Config;

class MeilisearchConfig
{
    private $host;
    private $apiKey;

    public function __construct($host, $apiKey)
    {
        $this->host = $host;
        $this->apiKey = $apiKey;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }
}
