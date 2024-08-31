<?php

namespace Appcheap\SearchEngine\Service\Engine;

use Appcheap\SearchEngine\App\Config\OpenAiConfig;
use Appcheap\SearchEngine\Service\Engine\Models\Schema;
use Appcheap\SearchEngine\Service\Engine\Models\SearchQuery;
use Appcheap\SearchEngine\Service\Engine\SearchService;
use Appcheap\SearchEngine\App\Http\HttpClientInterface;
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
     * @var OpenAiConfig The Typesense configuration.
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
     * Create a vector store in OpenAI.
     *
     * @param Schema $schema The schema of the collection.
     *
     * @return array The response from the server.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function createCollection(Schema $schema)
    {
        $response = $this->httpClient->post('https://api.openai.com/v1/vector_stores', [
            'name' => $schema->getName(),
            ], [
            'OpenAI-Beta' => 'assistants=v2',
            'Authorization' => 'Bearer ' . $this->config->getApiKey(),
            'Content-Type' => 'application/json',
        ]);

        if ($response['response']['code'] >= 400) {
            throw new HttpClientError($response['response']['code'], $response['body'] ?? $response['response']['message']);
        }
        
        return $response;
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
        throw new HttpClientError(403, 'Not implemented');
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

        if (null === $collection_created_response) {
            throw new HttpClientError(400, 'The collection did not exist');
        }

        $collectionData = json_decode($collection_created_response, true);
        if (null === $collectionData) {
            throw new HttpClientError(400, 'Invalid collection data');
        }

        // Collection ID
        $vertorStoreId = $collectionData['id'];
        if (empty($vertorStoreId)) {
            throw new HttpClientError(400, 'Invalid collection ID');
        }

        // 1. Upload the documents to the server.
        $files = [];
        foreach ($documents as $document) {
            if (!isset($document['id'])) {
                throw new HttpClientError(400, 'Document ID is required');
            }

            $boundary = uniqid();

            $headers = [
                'Content-Type' => 'multipart/form-data; boundary=' . $boundary,
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $this->config->getApiKey(),
            ];

            $body = '--' . $boundary . "\r\n";
            $body .= 'Content-Disposition: form-data; name="purpose"' . "\r\n\r\n";
            $body .= 'assistants' . "\r\n";
            $body .= '--' . $boundary . "\r\n";
            $body .= 'Content-Disposition: form-data; name="file"; filename="' . $document['id'] . '.json"' . "\r\n";
            $body .= 'Content-Type: application/json' . "\r\n\r\n";
            $body .= json_encode($document) . "\r\n";
            $body .= '--' . $boundary . '--';

            $response = $this->httpClient->post('https://api.openai.com/v1/files', $body, $headers);

            // TODO: Handle errors.

            $files[] = $response['body'];
        }

        // 2. Create vector store file
        $file_ids = [];

        foreach ($files as $file) {
            $fileData = json_decode($file, true);
            if (null === $fileData) {
                continue;
            }
            if (!isset($fileData['id'])) {
                continue;
            }
            $file_ids[] = $fileData['id'];
        }

        $response = $this->httpClient->post('https://api.openai.com/v1/vector_stores/' . $vertorStoreId . '/file_batches', [
            'file_ids' => $file_ids,
            ], [
            'OpenAI-Beta' => 'assistants=v2',
            'Authorization' => 'Bearer ' . $this->config->getApiKey(),
            'Content-Type' => 'application/json',
        ]);

        return $response;
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
    public function search(string $name, SearchQuery $query)
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Delete a document from Typesense.
     *
     * @param string $collectionName The name of the collection.
     * @param string $documentId     The ID of the document to delete.
     */
    public function deleteDocument(string $name, string $documentId)
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Delete a collection from Typesense.
     *
     * @param string $name The name of the collection to delete.
     */
    public function deleteCollection(string $name)
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Get a document from Typesense.
     *
     * @param string $documentId The ID of the document to retrieve.
     * @return array The retrieved document.
     */
    public function getDocument(string $name, string $documentId)
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
    public function updateDocument(string $name, string $documentId, array $document)
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Update the schema of a collection in Typesense.
     *
     * @param string $name   The name of the collection.
     * @param Schema $schema The updated schema.
     */
    public function updateSchema(string $name, Schema $schema)
    {
        throw new HttpClientError(403, 'Not implemented');
    }

    /**
     * Get the schema of a collection in Typesense.
     *
     * @param string $name The name of the collection.
     * @return array The schema of the collection.
     */
    public function getSchema(string $name)
    {
        throw new HttpClientError(403, 'Not implemented');
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
        if (null === $preview_response) {
            throw new HttpClientError(400, 'Preview response is required');
        }

        $previewReponseData = json_decode($preview_response, true);
        if (null === $previewReponseData) {
            throw new HttpClientError(400, 'Invalid preview response');
        }

        $id = $previewReponseData['id'];
        if (empty($id)) {
            throw new HttpClientError(400, 'Invalid preview response id');
        }

        $response = $this->httpClient->get('https://api.openai.com/v1/vector_stores/' . $id, [
            'OpenAI-Beta' => 'assistants=v2',
            'Authorization' => 'Bearer ' . $this->config->getApiKey(),
            'Content-Type' => 'application/json',
        ]);

        if ($response['response']['code'] >= 400) {
            throw new HttpClientError($response['response']['code'], $response['body'] ?? $response['response']['message']);
        }
        
        return $response;
    }
}
