<?php

namespace Appcheap\SearchEngine\Service\Engine;

use Appcheap\SearchEngine\App\Config\ElasticsearchConfig;
use Appcheap\SearchEngine\Service\Engine\Models\Schema;
use Appcheap\SearchEngine\Service\Engine\Models\SearchQuery;
use Appcheap\SearchEngine\Service\Engine\SearchService;
use Appcheap\SearchEngine\App\Http\HttpClientInterface;

class ElasticsearchService implements SearchService
{
    /**
     * @var HttpClientInterface The HTTP client to use for requests.
     */
    private $httpClient;

    /**
     * @var string The Elasticsearch base URL.
     */
    private $baseUrl;

    /**
     * @var string The Elasticsearch API key.
     */
    private $apiKey;

    /**
     * ElasticsearchService constructor.
     *
     * @param HttpClientInterface $httpClient The HTTP client to use for requests.
     * @param ElasticsearchConfig $config     The Elasticsearch configuration.
     */
    public function __construct(HttpClientInterface $httpClient, ElasticsearchConfig $config)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $config->getHosts();
        $this->apiKey = $config->getApiKey();
    }

    /**
     * {@inheritdoc}
     */
    public function createCollection(string $name, Schema $schema)
    {
        $url = $this->baseUrl . '/' . $name;
        return $this->httpClient->put($url, $schema->toElasticsearchSchema(), [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function indexDocument(string $name, array $document)
    {
        $url = $this->baseUrl . '/_doc';
        $response = $this->httpClient->post($url, $document, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function bulkIndexDocuments(string $name, array $documents)
    {
        $url = $this->baseUrl . '/_bulk';
        $body = '';
        foreach ($documents as $document) {
            $body .= json_encode(['index' => ['_index' => $name]]) . "\n";
            $body .= json_encode($document) . "\n";
        }
        return $this->httpClient->post($url, $body, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function search(string $name, SearchQuery $query)
    {
        $url = $this->baseUrl . '/_search';
        $response = $this->httpClient->post($url, $query->toArray(), [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
        return $response['hits']['hits'];
    }

    /**
     * {@inheritdoc}
     */
    public function deleteDocument(string $name, string $objectId)
    {
        $url = $this->baseUrl . '/_doc/' . $objectId;
        $this->httpClient->delete($url, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteCollection(string $name)
    {
        $url = $this->baseUrl . '/' . $name;
        $this->httpClient->delete($url, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getDocument(string $name, string $objectId)
    {
        $url = $this->baseUrl . '/_doc/' . $objectId;
        return $this->httpClient->get($url, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function updateDocument(string $name, string $objectId, array $document)
    {
        $url = $this->baseUrl . '/_doc/' . $objectId;
        $this->httpClient->put($url, $document, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function updateSchema(string $name, Schema $schema)
    {
        $url = $this->baseUrl . '/' . $name;
        $this->httpClient->put($url, $schema->toElasticsearchSchema(), [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getSchema(string $name)
    {
        $url = $this->baseUrl . '/' . $name;
        $response = $this->httpClient->get($url, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
        return $response['mappings']['properties'];
    }

    /**
     * Get a collection with the given name from the search service.
     *
     * @param string $name             The name of the collection.
     * @param string $preview_response The preview response.
     *
     * @return array The collection.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function getCollection(string $name, ?string $preview_response)
    {
        $url = $this->baseUrl . '/' . $name;
        return $this->httpClient->get($url, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }
}
