<?php

namespace Appcheap\SearchEngine\App\Config;

class OpenAiConfig
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getApiKey()
    {
        return $this->apiKey ?? '';
    }
}
