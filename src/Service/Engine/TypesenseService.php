<?php
namespace Appcheap\SearchEngine\App\Service\Engine;

use Appcheap\SearchEngine\Service\Engine\Models\Schema;
use Appcheap\SearchEngine\Service\Engine\Models\SearchQuery;
use Appcheap\SearchEngine\App\Service\Engine\SearchServiceInterface;
use Appcheap\SearchEngine\App\Http\HttpClientInterface;

class TypesenseService implements SearchServiceInterface {
    /**
     * @var HttpClientInterface The HTTP client to use for requests.
     */
    private $httpClient;

    /**
     * @var string The collection name.
     */
    private $collectionName;

    /**
     * @var string The Typesense base URL.
     */
    private $baseUrl;

    /**
     * @var string The Typesense API key.
     */
    private $apiKey;

    /**
     * TypesenseService constructor.
     *
     * @param HttpClientInterface $httpClient The HTTP client to use for requests.
     * @param string $collectionName The name of the collection.
     * @param string $baseUrl The Typesense base URL.
     * @param string $apiKey The Typesense API key.
     */
    public function __construct(HttpClientInterface $httpClient, string $collectionName, string $baseUrl, string $apiKey) {
        $this->collectionName = $collectionName;        
        $this->httpClient = $httpClient;
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    /**
     * Create a collection in Typesense.
     *
     * @param string $name The name of the collection.
     * @param Schema $schema The schema of the collection.
     */
    public function createCollection(string $name, Schema $schema): void {
        $url = $this->baseUrl . '/collections';
        $this->httpClient->post($url, $schema->toTypesenseSchema($name), [
            'X-TYPESENSE-API-KEY: ' . $this->apiKey,
        ]);
    }

    /**
     * Index a document in Typesense.
     *
     * @param string $collectionName The name of the collection.
     * @param array $document The document to index.
     * @return string The ID of the indexed document.
     */
    public function indexDocument(array $document): string {
        $url = $this->baseUrl . '/collections/' . $this->collectionName . '/documents';
        $response = $this->httpClient->post($url, $document, [
            'X-TYPESENSE-API-KEY: ' . $this->apiKey,
        ]);
        return $response['id'];
    }

    /**
     * Search for documents in Typesense.
     *
     * @param string $collectionName The name of the collection.
     * @param SearchQuery $query The search query.
     * @return array The search results.
     */
    public function search(SearchQuery $query): array {
        $url = $this->baseUrl . '/collections/' . $this->collectionName . '/documents/search';
        $response = $this->httpClient->get($url, $query->toArray(), [
            'X-TYPESENSE-API-KEY: ' . $this->apiKey,
        ]);
        return $response['hits'];
    }

    /**
     * Delete a document from Typesense.
     *
     * @param string $collectionName The name of the collection.
     * @param string $documentId The ID of the document to delete.
     */
    public function deleteDocument(string $documentId): void {
        $url = $this->baseUrl . '/collections/' . $this->collectionName . '/documents/' . $documentId;
        $this->httpClient->delete($url, [
            'X-TYPESENSE-API-KEY: ' . $this->apiKey,
        ]);
    }

    /**
     * Delete a collection from Typesense.
     *
     * @param string $name The name of the collection to delete.
     */
    public function deleteCollection(string $name): void {
        $url = $this->baseUrl . '/collections/' . $name;
        $this->httpClient->delete($url, [
            'X-TYPESENSE-API-KEY: ' . $this->apiKey,
        ]);
    }

    /**
     * Get a document from Typesense.
     *
     * @param string $documentId The ID of the document to retrieve.
     * @return array The retrieved document.
     */
    public function getDocument(string $documentId): array {
        $url = $this->baseUrl . '/collections/' . $this->collectionName . '/documents/' . $documentId;
        return $this->httpClient->get($url, [
            'X-TYPESENSE-API-KEY: ' . $this->apiKey,
        ]);
    }

    /**
     * Update a document in Typesense.
     *
     * @param string $documentId The ID of the document to update.
     * @param array $document The updated document.
     */
    public function updateDocument(string $documentId, array $document): void {
        $url = $this->baseUrl . '/collections/' . $this->collectionName . '/documents/' . $documentId;
        $this->httpClient->put($url, $document, [
            'X-TYPESENSE-API-KEY: ' . $this->apiKey,
        ]);
    }

    /**
     * Update the schema of a collection in Typesense.
     *
     * @param string $name The name of the collection.
     * @param Schema $schema The updated schema.
     */
    public function updateSchema(string $name, Schema $schema): void {
        $url = $this->baseUrl . '/collections/' . $name;
        $this->httpClient->put($url, $schema->toTypesenseSchema($name), [
            'X-TYPESENSE-API-KEY: ' . $this->apiKey,
        ]);
    }

    /**
     * Get the schema of a collection in Typesense.
     *
     * @param string $name The name of the collection.
     * @return array The schema of the collection.
     */
    public function getSchema(string $name): array {
        $url = $this->baseUrl . '/collections/' . $name;
        $response = $this->httpClient->get($url, [
            'X-TYPESENSE-API-KEY: ' . $this->apiKey,
        ]);
        return $response['fields'];
    }

    /**
     * Get a collection from Typesense.
     *
     * @param string $name The name of the collection.
     * @return array The collection.
     */
    public function getCollection(string $name): array {
        $url = $this->baseUrl . '/collections/' . $name;
        return $this->httpClient->get($url, [
            'X-TYPESENSE-API-KEY: ' . $this->apiKey,
        ]);
    }
}