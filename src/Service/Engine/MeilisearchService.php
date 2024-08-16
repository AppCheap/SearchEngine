<?php

namespace Appcheap\SearchEngine\Service\Engine;

use Appcheap\SearchEngine\Service\Engine\Models\Schema;
use Appcheap\SearchEngine\Service\Engine\Models\SearchQuery;
use Appcheap\SearchEngine\Service\Engine\SearchServiceInterface;
use Appcheap\SearchEngine\App\Http\HttpClientInterface;

class MeilisearchService implements SearchServiceInterface
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
     * @param string $indexName The name of the index.
     * @param string $baseUrl The Meilisearch base URL.
     * @param string $apiKey The Meilisearch API key.
     */
    public function __construct(HttpClientInterface $httpClient, string $indexName, string $baseUrl, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->indexName = $indexName;
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * Create an index in Meilisearch.
     *
     * @param string $name The name of the index.
     * @param Schema $schema The schema of the index.
     */
    public function createCollection(string $name, Schema $schema): void
    {
        $url = $this->baseUrl . '/indexes';
        $this->httpClient->post($url, ['uid' => $name, 'schema' => $schema->toMeilisearchSchema()], [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
    }

    /**
     * Index a document in Meilisearch.
     *
     * @param array $document The document to index.
     * @return string The ID of the indexed document.
     */
    public function indexDocument(string $name, array $document): string
    {
        $url = $this->baseUrl . '/indexes/' . $this->indexName . '/documents';
        $response = $this->httpClient->post($url, $document, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
        return $response['id'];
    }

    /**
     * Bulk index documents in Meilisearch.
     *
     * @param array $documents The documents to index.
     */
    public function bulkIndexDocuments(string $name, array $documents) {
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
    public function search(string $name, SearchQuery $query): array
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
    public function deleteDocument(string $name, string $documentId): void
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
    public function deleteCollection(string $name): void
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
    public function getDocument(string $name, string $documentId): array
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
     * @param array $document The updated document.
     */
    public function updateDocument(string $name, string $documentId, array $document): void
    {
        $url = $this->baseUrl . '/indexes/' . $this->indexName . '/documents/' . $documentId;
        $this->httpClient->put($url, $document, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
    }

    /**
     * Update the schema of an index in Meilisearch.
     *
     * @param string $name The name of the index to update.
     * @param Schema $schema The updated schema.
     */
    public function updateSchema(string $name, Schema $schema): void
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
    public function getSchema(string $name): array
    {
        $url = $this->baseUrl . '/indexes/' . $name;
        $response = $this->httpClient->get($url, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
        return $response['schema'];
    }

    /**
     * Get an index from Meilisearch.
     *
     * @param string $name The name of the index.
     * @return array The index.
     */
    public function getCollection(string $name): array
    {
        $url = $this->baseUrl . '/indexes/' . $name;
        return $this->httpClient->get($url, [
            'Authorization: Bearer ' . $this->apiKey,
        ]);
    }
}
