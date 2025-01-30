<?php

namespace Appcheap\SearchEngine\Service\Engine;

use Appcheap\SearchEngine\Service\Engine\Models\Schema;
use Appcheap\SearchEngine\Service\Engine\Models\SearchQuery;
use Appcheap\SearchEngine\Service\Engine\SearchService;
use Appcheap\SearchEngine\App\Http\HttpClientInterface;
use Appcheap\SearchEngine\App\Config\TypesenseConfig;

class TypesenseService implements SearchService
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
     * TypesenseService constructor.
     *
     * @param HttpClientInterface $httpClient The HTTP client to use for requests.
     * @param TypesenseConfig     $config     The Typesense configuration.
     */
    public function __construct(HttpClientInterface $httpClient, TypesenseConfig $config)
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
    public function createCollection(Schema $schema)
    {
        $url = $this->config->getUrl() . '/collections';
        return $this->httpClient->post($url, $schema->toTypesenseSchema(), [
            'X-TYPESENSE-API-KEY' => $this->config->getApiKey(),
        ]);
    }

    /**
     * Index a document in Typesense.
     *
     * @param string $name     The name of the collection.
     * @param array  $document The document to index.
     * @return array The response from the server.
     */
    public function indexDocument(string $name, array $document)
    {
        $url = $this->config->getUrl() . '/collections/' . $name . '/documents?action=upsert';
        $response = $this->httpClient->post($url, $document, [
            'X-TYPESENSE-API-KEY' => $this->config->getApiKey(),
        ]);
        return $response;
    }

    /**
     * Bulk index documents in the search service.
     *
     * @param string $name                        The name of the collection to index the documents in.
     * @param array  $documents                   The documents to be indexed.
     * @param string $collection_created_response The collection created response.
     *
     * @return array The response from the server.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function bulkIndexDocuments(string $name, array $documents, ?string $collection_created_response)
    {

        $data = '';
        foreach ($documents as $document) {
            $data .= json_encode($document) . "\n";
        }

        error_log('bulkIndexDocuments' . $data);

        $url = $this->config->getUrl() . '/collections/' . $name . '/documents/import?action=upsert';
        return $this->httpClient->post($url, $data, [
            'X-TYPESENSE-API-KEY' => $this->config->getApiKey(),
            'Content-Type' => 'text/plain',
        ]);
    }

    /**
     * Search for documents in Typesense.
     *
     * @param string      $name  The name of the collection.
     * @param SearchQuery $query The search query.
     * @return array The search results.
     */
    public function search(string $name, SearchQuery $query)
    {
        $url = $this->config->getUrl() . '/collections/' . $name . '/documents/search';
        $queryString = http_build_query($query->toArray());
        $url .= '?' . $queryString;

        $response = $this->httpClient->get($url, [
            'X-TYPESENSE-API-KEY' => $this->config->getApiKey(),
        ]);
        return $response;
    }

    /**
     * Delete a document from Typesense.
     *
     * @param string $collectionName The name of the collection.
     * @param string $documentId     The ID of the document to delete.
     */
    public function deleteDocument(string $name, string $documentId)
    {
        $url = $this->config->getUrl() . '/collections/' . $name . '/documents/' . $documentId;
        $this->httpClient->delete($url, [
            'X-TYPESENSE-API-KEY' => $this->config->getApiKey(),
        ]);
    }

    /**
     * Delete a collection from Typesense.
     *
     * @param string $name The name of the collection to delete.
     */
    public function deleteCollection(string $name)
    {
        $url = $this->config->getUrl() . '/collections/' . $name;
        $this->httpClient->delete($url, [
            'X-TYPESENSE-API-KEY' => $this->config->getApiKey(),
        ]);
    }

    /**
     * Get a document from Typesense.
     *
     * @param string $documentId The ID of the document to retrieve.
     * @return array The retrieved document.
     */
    public function getDocument(string $name, string $documentId)
    {
        $url = $this->config->getUrl() . '/collections/' . $name . '/documents/' . $documentId;
        return $this->httpClient->get($url, [
            'X-TYPESENSE-API-KEY' => $this->config->getApiKey(),
        ]);
    }

    /**
     * Update a document in Typesense.
     *
     * @param string $name       The name of the collection.
     * @param string $documentId The ID of the document to update.
     * @param array  $document   The updated document.
     */
    public function updateDocument(string $name, string $documentId, array $document)
    {
        $url = $this->config->getUrl() . '/collections/' . $name . '/documents/' . $documentId;
        $this->httpClient->put($url, $document, [
            'X-TYPESENSE-API-KEY' => $this->config->getApiKey(),
        ]);
    }

    /**
     * Update the schema of a collection in Typesense.
     *
     * @param string $name   The name of the collection.
     * @param Schema $schema The updated schema.
     */
    public function updateSchema(string $name, Schema $schema)
    {
        $url = $this->config->getUrl() . '/collections/' . $name;
        $this->httpClient->put($url, $schema->toTypesenseSchema($name), [
            'X-TYPESENSE-API-KEY' => $this->config->getApiKey(),
        ]);
    }

    /**
     * Get the schema of a collection in Typesense.
     *
     * @param string $name The name of the collection.
     * @return array The schema of the collection.
     */
    public function getSchema(string $name)
    {
        $url = $this->config->getUrl() . '/collections/' . $name;
        $response = $this->httpClient->get($url, [
            'X-TYPESENSE-API-KEY' => $this->config->getApiKey(),
        ]);
        return $response['fields'];
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
        $url = $this->config->getUrl() . '/collections/' . $name;
        return $this->httpClient->get($url, [
            'X-TYPESENSE-API-KEY' => $this->config->getApiKey(),
        ]);
    }
}
