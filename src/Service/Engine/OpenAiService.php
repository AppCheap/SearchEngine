<?php

namespace Appcheap\SearchEngine\Service\Engine;

use Appcheap\SearchEngine\App\Config\OpenAiConfig;
use Appcheap\SearchEngine\Service\Engine\Models\Schema;
use Appcheap\SearchEngine\Service\Engine\Models\SearchQuery;
use Appcheap\SearchEngine\Service\Engine\SearchService;
use Appcheap\SearchEngine\App\Http\HttpClientInterface;
use Appcheap\SearchEngine\App\Config\TypesenseConfig;
use Appcheap\SearchEngine\App\Exception\HttpClientError;

/**
 * The OpenAI search service.
 */
class OpenAiService implements SearchService
{
    /**
     * @var HttpClientInterface The HTTP client to use for requests.
     */
    private $httpClient;

    /**
     * @var TypesenseConfig The Typesense configuration.
     */
    private $config;

    /**
     * OpenAiService constructor.
     *
     * @param HttpClientInterface $httpClient The HTTP client to use for requests.
     * @param OpenAiConfig        $config     The Open AI configuration.
     */
    public function __construct(HttpClientInterface $httpClient, OpenAiConfig $config)
    {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    /**
     * Create a collection in Typesense.
     *
     * @param Schema $schema The schema of the collection.
     *
     * @return array The response from the server.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function createCollection(Schema $schema): array
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Index a document in Typesense.
     *
     * @param string $name     The name of the collection.
     * @param array  $document The document to index.
     * @return array The response from the server.
     */
    public function indexDocument(string $name, array $document): array
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Bulk index documents in Typesense.
     *
     * @param string $name      The name of the collection.
     * @param array  $documents The documents to index.
     * @return mixed The response from the server.
     */
    public function bulkIndexDocuments(string $name, array $documents)
    {

        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Search for documents in Typesense.
     *
     * @param string      $name  The name of the collection.
     * @param SearchQuery $query The search query.
     *
     * @return array The search results.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function search(string $name, SearchQuery $query): array
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Delete a document from Typesense.
     *
     * @param string $collectionName The name of the collection.
     * @param string $documentId     The ID of the document to delete.
     */
    public function deleteDocument(string $name, string $documentId): void
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Delete a collection from Typesense.
     *
     * @param string $name The name of the collection to delete.
     */
    public function deleteCollection(string $name): void
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Get a document from Typesense.
     *
     * @param string $documentId The ID of the document to retrieve.
     * @return array The retrieved document.
     */
    public function getDocument(string $name, string $documentId): array
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Update a document in Typesense.
     *
     * @param string $name       The name of the collection.
     * @param string $documentId The ID of the document to update.
     * @param array  $document   The updated document.
     */
    public function updateDocument(string $name, string $documentId, array $document): void
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Update the schema of a collection in Typesense.
     *
     * @param string $name   The name of the collection.
     * @param Schema $schema The updated schema.
     */
    public function updateSchema(string $name, Schema $schema): void
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Get the schema of a collection in Typesense.
     *
     * @param string $name The name of the collection.
     * @return array The schema of the collection.
     */
    public function getSchema(string $name): array
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Get a collection from Typesense.
     *
     * @param string $name The name of the collection.
     * @return array The collection.
     */
    public function getCollection(string $name): array
    {
        throw new HttpClientError(403, 'Not implemented');
    }
}
