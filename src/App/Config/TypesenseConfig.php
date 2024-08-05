<?php

namespace Appcheap\SearchEngine\App\Config;

class TypesenseConfig {
    private $apiKey;
    private $nodes;
    private $connectionTimeoutSeconds;

    public function __construct($apiKey, $nodes = [], $connectionTimeoutSeconds = 2.0) {
        $this->apiKey = $apiKey;
        $this->nodes = $nodes;
        $this->connectionTimeoutSeconds = $connectionTimeoutSeconds;
    }

    public function getApiKey() {
        return $this->apiKey ?? '';
    }

    public function getNodes() {
        return $this->nodes;
    }

    public function getConnectionTimeoutSeconds() {
        return $this->connectionTimeoutSeconds;
    }

    public function getUrl() {
        if (count($this->nodes) === 0) {
            return '';
        }

        $node = $this->nodes[0];
        $protocol = $node['protocol'] ?? 'http';
        $host = $node['host'] ?? 'localhost';
        $port = $node['port'] ?? '8108';

        return "$protocol://$host:$port";
    }
}