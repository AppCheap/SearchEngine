<?php

namespace Appcheap\SearchEngine\App\Config;

/**
 * Factory class to create search config objects
 */
class SearchConfigFactory
{
    /**
     * Create a search config object based on the service type
     *
     * @param string $serviceType The type of search service.
     * @param array  $config      The configuration array.
     * @return mixed The search config object.
     * @throws \Exception If the service type is not supported.
     */
    public static function create(string $serviceType, array $config)
    {
        switch ($serviceType) {
            case 'typesense':
                return new TypesenseConfig($config['apiKey'], $config['nodes'], $config['connectionTimeoutSeconds'] ?? 2.0);
            case 'algolia':
                return new AlgoliaConfig($config['appId'], $config['apiKey']);
            case 'elasticsearch':
                return new ElasticsearchConfig($config['hosts']);
            case 'meilisearch':
                return new MeilisearchConfig($config['host'], $config['apiKey']);
            case 'openai':
                return new OpenaiConfig($config['apiKey']);
            default:
                throw new \Exception("Unsupported service type: $serviceType");
        }
    }
}
