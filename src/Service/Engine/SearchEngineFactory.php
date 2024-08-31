<?php

namespace Appcheap\SearchEngine\Service\Engine;

use Appcheap\SearchEngine\App\Http\HttpClientInterface;
use Appcheap\SearchEngine\App\Config\SearchConfigFactory;
use Appcheap\SearchEngine\Service\Engine\ElasticsearchService;
use Appcheap\SearchEngine\Service\Engine\TypesenseService;
use Appcheap\SearchEngine\Service\Engine\AlgoliaService;
use Appcheap\SearchEngine\Service\Engine\MeilisearchService;
use Exception;

/**
 * Class SearchEngineFactory
 *
 * This class is responsible for creating search engine service instances based on the provided configuration.
 */
class SearchEngineFactory
{
    /**
     * Create a search engine service instance based on the provided configuration.
     *
     * @param string              $serviceType The type of search engine service.
     * @param HttpClientInterface $http        The HTTP client to use for requests.
     * @param array               $config      The configuration array.
     *
     * @return mixed
     * @throws Exception If the search engine service type is not supported.
     */
    public static function createService(string $serviceType, HttpClientInterface $http, array $config)
    {
        $config = SearchConfigFactory::create($serviceType, $config);
        switch ($serviceType) {
            case 'elasticsearch':
                return new ElasticsearchService($http, $config);
            case 'typesense':
                return new TypesenseService($http, $config);
            case 'algolia':
                return new AlgoliaService($http, $config);
            case 'meilisearch':
                return new MeilisearchService($http, $config);
            case 'openai':
                return new OpenAiService($http, $config);
            default:
                throw new Exception("Unsupported service type: $serviceType");
        }
    }
}
