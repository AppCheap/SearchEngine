<?php

namespace Appcheap\SearchEngine\Service\Engine;

use Appcheap\SearchEngine\App\Config\MeilisearchConfig;
use Appcheap\SearchEngine\Service\Engine\Models\Schema;
use Appcheap\SearchEngine\Service\Engine\Models\SearchQuery;
use Appcheap\SearchEngine\Service\Engine\SearchService;
use Appcheap\SearchEngine\App\Http\HttpClientInterface;

/**
 * The Meilisearch search service.
 */
class MeilisearchService implements SearchService
{
    /**
     * @var HttpClientInterface The HTTP client to use for requests.
     */
    private $httpClient;

    /**
     * @var string The Meilisearch index name.
     */
    private $indexName;

    /**
     * @var string The Meilisearch base URL.
     */
    private $baseUrl;

    /**
     * @var string The Meilisearch API key.
     */
    private $apiKey;

    /**
     * MeilisearchService constructor.
     *
     * @param HttpClientInterface $httpClient The HTTP client to use for requests.
     * @param MeilisearchConfig   $config     The Meilisearch configuration.
     */
    public function __construct(HttpClientInterface $httpClient, MeilisearchConfig $config)
    {
        $this->httpClient = $httpClient;
        $this->indexName = $config->getIndexName();
        $this->baseUrl = $config->getHost();
        $this->apiKey = $config->getApiKey();
    }

    /**
     * Create an index in Meilisearch.
     *
     * @param string $name   The name of the index.
     * @param Schema $schema The schema of the index.
     */
    public function createCollection(string $name, Schema $schema)
    {
        $url = $this->baseUrl . '/indexes';
        $this->httpClient->post($url, ['uid' => $name, 'schema' => $schema->toMeilisearchSchema()], [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function indexDocument(string $name, array $document)
    {
        $url = $this->baseUrl . '/indexes/' . $this->indexName . '/documents';
        $response = $this->httpClient->post($url, $document, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
        return $response;
    }

    /**
     * Bulk index documents in Meilisearch.
     *
     * @param array $documents The documents to index.
     */
    public function bulkIndexDocuments(string $name, array $documents)
    {
        $url = $this->baseUrl . '/indexes/' . $this->indexName . '/documents';
        return $this->httpClient->post($url, $documents, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
    }

    /**
     * Search for documents in Meilisearch.
     *
     * @param SearchQuery $query The search query.
     * @return array The search results.
     */
    public function search(string $name, SearchQuery $query)
    {
        $url = $this->baseUrl . '/indexes/' . $this->indexName . '/search';
        $response = $this->httpClient->post($url, $query->toArray(), [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
        return $response['hits'];
    }

    /**
     * Delete a document from Meilisearch.
     *
     * @param string $documentId The ID of the document to delete.
     */
    public function deleteDocument(string $name, string $documentId)
    {
        $url = $this->baseUrl . '/indexes/' . $this->indexName . '/documents/' . $documentId;
        $this->httpClient->delete($url, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
    }

    /**
     * Delete an index from Meilisearch.
     *
     * @param string $name The name of the index to delete.
     */
    public function deleteCollection(string $name)
    {
        $url = $this->baseUrl . '/indexes/' . $name;
        $this->httpClient->delete($url, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
    }

    /**
     * Get a document from Meilisearch.
     *
     * @param string $documentId The ID of the document to retrieve.
     * @return array The retrieved document.
     */
    public function getDocument(string $name, string $documentId)
    {
        $url = $this->baseUrl . '/indexes/' . $this->indexName . '/documents/' . $documentId;
        return $this->httpClient->get($url, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
    }

    /**
     * Update a document in Meilisearch.
     *
     * @param string $documentId The ID of the document to update.
     * @param array  $document   The updated document.
     */
    public function updateDocument(string $name, string $documentId, array $document)
    {
        $url = $this->baseUrl . '/indexes/' . $this->indexName . '/documents/' . $documentId;
        $this->httpClient->put($url, $document, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
    }

    /**
     * Update the schema of an index in Meilisearch.
     *
     * @param string $name   The name of the index to update.
     * @param Schema $schema The updated schema.
     */
    public function updateSchema(string $name, Schema $schema)
    {
        $url = $this->baseUrl . '/indexes/' . $name;
        $this->httpClient->put($url, ['schema' => $schema->toMeilisearchSchema()], [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
    }

    /**
     * Get the schema of an index from Meilisearch.
     *
     * @param string $name The name of the index.
     * @return array The schema of the index.
     */
    public function getSchema(string $name)
    {
        $url = $this->baseUrl . '/indexes/' . $name;
        $response = $this->httpClient->get($url, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
        return $response['schema'];
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
        $url = $this->baseUrl . '/indexes/' . $name;
        return $this->httpClient->get($url, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
    }
}
