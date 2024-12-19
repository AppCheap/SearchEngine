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
    private HttpClientInterface $http;

    /**
     * Constructor
     *
     * @param HttpClientInterface $http The HTTP client to use for requests.
     */
    public function __construct(HttpClientInterface $http)
    {
        $this->http = $http;
    }

    /**
     * Create a search engine service instance based on the provided configuration.
     *
     * @param string $serviceType The type of search engine service.
     * @param mixed  $config      The configuration array.
     *
     * @return mixed
     * @throws Exception If the search engine service type is not supported.
     */
    public function create(string $serviceType, mixed $config)
    {
        switch ($serviceType) {
            case 'elasticsearch':
                return new ElasticsearchService($this->http, $config);
            case 'typesense':
                return new TypesenseService($this->http, $config);
            case 'algolia':
                return new AlgoliaService($this->http, $config);
            case 'meilisearch':
                return new MeilisearchService($this->http, $config);
            case 'openai':
                return new OpenAiService($this->http, $config);
            default:
                throw new Exception("Unsupported service type: $serviceType");
        }
    }
}
