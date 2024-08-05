<?php

namespace Appcheap\SearchEngine\App\Config;

class AlgoliaConfig {
    private $appId;
    private $apiKey;

    public function __construct($appId, $apiKey) {
        $this->appId = $appId;
        $this->apiKey = $apiKey;
    }

    public function getAppId() {
        return $this->appId;
    }

    public function getApiKey() {
        return $this->apiKey;
    }
}