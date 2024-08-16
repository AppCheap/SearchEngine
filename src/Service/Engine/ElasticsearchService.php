<?php

namespace Appcheap\SearchEngine\Service\Engine;

use Appcheap\SearchEngine\Service\Engine\Models\Schema;
use Appcheap\SearchEngine\Service\Engine\Models\SearchQuery;
use Appcheap\SearchEngine\Service\Engine\SearchServiceInterface;
use Appcheap\SearchEngine\App\Http\HttpClientInterface;

class ElasticsearchService implements SearchServiceInterface
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
     * @param string              $baseUrl    The Elasticsearch base URL.
     * @param string              $apiKey     The Elasticsearch API key.
     */
    public function __construct(HttpClientInterface $httpClient, string $baseUrl, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function createCollection(string $name, Schema $schema): array
    {
        $url = $this->baseUrl . '/' . $name;
        return $this->httpClient->put($url, $schema->toElasticsearchSchema(), [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function indexDocument(string $name, array $document): string
    {
        $url = $this->baseUrl . '/_doc';
        $response = $this->httpClient->post($url, $document, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
        return $response['_id'];
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
    public function search(string $name, SearchQuery $query): array
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
    public function deleteDocument(string $name, string $objectId): void
    {
        $url = $this->baseUrl . '/_doc/' . $objectId;
        $this->httpClient->delete($url, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function deleteCollection(string $name): void
    {
        $url = $this->baseUrl . '/' . $name;
        $this->httpClient->delete($url, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getDocument(string $name, string $objectId): array
    {
        $url = $this->baseUrl . '/_doc/' . $objectId;
        return $this->httpClient->get($url, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function updateDocument(string $name, string $objectId, array $document): void
    {
        $url = $this->baseUrl . '/_doc/' . $objectId;
        $this->httpClient->put($url, $document, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function updateSchema(string $name, Schema $schema): void
    {
        $url = $this->baseUrl . '/' . $name;
        $this->httpClient->put($url, $schema->toElasticsearchSchema(), [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getSchema(string $name): array
    {
        $url = $this->baseUrl . '/' . $name;
        $response = $this->httpClient->get($url, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
        return $response['mappings']['properties'];
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection(string $name): array
    {
        $url = $this->baseUrl . '/' . $name;
        return $this->httpClient->get($url, [
            'Authorization: ApiKey ' . $this->apiKey,
        ]);
    }
}
