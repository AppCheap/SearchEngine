<?php

namespace Appcheap\SearchEngine\App\Config;

class SearchConfigFactory {
    public static function create($serviceType, $config) {
        switch ($serviceType) {
            case 'typesense':
                return new TypesenseConfig($config['apiKey'], $config['nodes'], $config['connectionTimeoutSeconds'] ?? 2.0);
            case 'algolia':
                return new AlgoliaConfig($config['appId'], $config['apiKey']);
            case 'elasticsearch':
                return new ElasticsearchConfig($config['hosts']);
            case 'meilisearch':
                return new MeilisearchConfig($config['host'], $config['apiKey']);
            default:
                throw new \Exception("Unsupported service type: $serviceType");
        }
    }
}