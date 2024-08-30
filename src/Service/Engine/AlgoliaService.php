<?php

namespace Appcheap\SearchEngine\Service\Engine;

use Appcheap\SearchEngine\App\Config\AlgoliaConfig;
use Appcheap\SearchEngine\Service\Engine\Models\Schema;
use Appcheap\SearchEngine\Service\Engine\Models\SearchQuery;
use Appcheap\SearchEngine\Service\Engine\SearchService;
use Appcheap\SearchEngine\App\Http\HttpClientInterface;

class AlgoliaService implements SearchService
{
    /**
     * @var HttpClientInterface The HTTP client to use for requests.
     */
    private $httpClient;

    /**
     * @var string The Algolia base URL.
     */
    private $baseUrl;

    /**
     * @var string The Algolia API key.
     */
    private $apiKey;

    /**
     * @var string The Algolia application ID.
     */
    private $applicationId;

    /**
     * AlgoliaService constructor.
     *
     * @param HttpClientInterface $httpClient The HTTP client to use for requests.
     * @param AlgoliaConfig       $config     The Algolia configuration.
     */
    public function __construct(HttpClientInterface $httpClient, AlgoliaConfig $config)
    {
        $this->httpClient = $httpClient;
        $this->baseUrl = '';
        $this->apiKey = $config->getApiKey();
        $this->applicationId = $config->getAppId();
    }

    /**
     * Get headers for the request.
     *
     * @return array The headers for the request.
     */
    private function getHeaders(): array
    {
        return [
            'X-Algolia-API-Key: ' . $this->apiKey,
            'X-Algolia-Application-Id: ' . $this->applicationId,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function createCollection(string $name, Schema $schema): void
    {
        // Send a POST request to the Algolia API to create a new index.
        $this->httpClient->post(sprintf("%s/indexes", $this->baseUrl), [
            'name' => $name,
            'schema' => $schema->toAlgoliaSchema(),
        ], $this->getHeaders());
    }

    /**
     * {@inheritdoc}
     */
    public function indexDocument(string $name, array $document): array
    {
        // Send a POST request to the Algolia API to index a document.
        $response = $this->httpClient->post(sprintf("%s/indexes/documents", $this->baseUrl), $document, $this->getHeaders());
        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function bulkIndexDocuments(string $name, array $documents)
    {
        // Send a POST request to the Algolia API to index documents.
        return $this->httpClient->post(sprintf("%s/indexes/documents/batch", $this->baseUrl), $documents, $this->getHeaders());
    }

    /**
     * {@inheritdoc}
     */
    public function search(string $name, SearchQuery $query): array
    {
        // Send a POST request to the Algolia API to search for documents.
        return $this->httpClient->post(sprintf("%s/indexes/documents/search", $this->baseUrl), $query->toArray(), $this->getHeaders());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteDocument(string $name, string $id): void
    {
        // Send a DELETE request to the Algolia API to delete a document.
        $this->httpClient->delete(sprintf("%s/indexes/documents/%s", $this->baseUrl, $id), [], $this->getHeaders());
    }

    /**
     * {@inheritdoc}
     */
    public function deleteCollection(string $name): void
    {
        // Send a DELETE request to the Algolia API to delete an index.
        $this->httpClient->delete(sprintf("%s/indexes/%s", $this->baseUrl, $name), [], $this->getHeaders());
    }

    /**
     * {@inheritdoc}
     */
    public function getDocument(string $name, string $id): array
    {
        // Send a GET request to the Algolia API to get a document.
        return $this->httpClient->get(sprintf("%s/indexes/documents/%s", $this->baseUrl, $id), $this->getHeaders());
    }

    /**
     * {@inheritdoc}
     */
    public function updateDocument(string $name, string $id, array $document): void
    {
        // Send a PUT request to the Algolia API to update a document.
        $this->httpClient->put(sprintf("%s/indexes/documents/%s", $this->baseUrl, $id), $document, $this->getHeaders());
    }

    /**
     * {@inheritdoc}
     */
    public function updateSchema(string $name, Schema $schema): void
    {
        // Send a PUT request to the Algolia API to update an index.
        $this->httpClient->put(sprintf("%s/indexes/%s", $this->baseUrl, $name), [
            'schema' => $schema->toAlgoliaSchema(),
        ], $this->getHeaders());
    }

    /**
     * {@inheritdoc}
     */
    public function getSchema(string $name): array
    {
        // Send a GET request to the Algolia API to get the schema of an index.
        $response = $this->httpClient->get(sprintf("%s/indexes/%s", $this->baseUrl, $name), $this->getHeaders());
        return $response['schema'];
    }

    /**
     * {@inheritdoc}
     */
    public function getCollection(string $name): array
    {
        // Send a GET request to the Algolia API to get an index.
        return $this->httpClient->get(sprintf("%s/indexes/%s", $this->baseUrl, $name), $this->getHeaders());
    }
}
