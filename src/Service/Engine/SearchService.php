<?php

namespace Appcheap\SearchEngine\Service\Engine;

use Appcheap\SearchEngine\Service\Engine\Models\Schema;
use Appcheap\SearchEngine\Service\Engine\Models\SearchQuery;

/**
 * Interface SearchService
 *
 * This interface defines the methods that a search service must implement.
 */
interface SearchService
{
    /**
     * Create a new collection with the given name and schema.
     *
     * @param Schema $schema The schema of the collection.
     *
     * @return array The response from the server.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function createCollection(Schema $schema): array;

    /**
     * Index a document in the search engine.
     *
     * @param string $name     The name of the collection to index the document in.
     * @param array  $document The document to be indexed.
     *
     * @return array The response from the server.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function indexDocument(string $name, array $document): array;

    /**
     * Bulk index documents in the search service.
     *
     * @param string $name      The name of the collection to index the documents in.
     * @param array  $documents The documents to be indexed.
     *
     * @return mixed The response from the server.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function bulkIndexDocuments(string $name, array $documents);

    /**
     * Search for documents that match the given query.
     *
     * @param string      $name  The name of the collection to search in.
     * @param SearchQuery $query The search query.
     *
     * @return array An array of documents that match the query.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function search(string $name, SearchQuery $query): array;

    /**
     * Delete a document with the given ID from the search service.
     *
     * @param string $name The name of the collection to delete the document from.
     * @param string $id   The ID of the document to be deleted.
     *
     * @return void
     * @throws HttpClientError If there is an HTTP error.
     */
    public function deleteDocument(string $name, string $id): void;

    /**
     * Delete a collection with the given name from the search service.
     *
     * @param string $name The name of the collection to be deleted.
     *
     * @return void
     * @throws HttpClientError If there is an HTTP error.
     */
    public function deleteCollection(string $name): void;

    /**
     * Get a document with the given ID from the search service.
     *
     * @param string $name The name of the collection to retrieve the document from.
     * @param string $id   The ID of the document to be retrieved.
     *
     * @return array The retrieved document.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function getDocument(string $name, string $id): array;

    /**
     * Update a document with the given ID in the search service.
     *
     * @param string $name     The name of the collection to update the document in.
     * @param string $id       The ID of the document to be updated.
     * @param array  $document The updated document.
     *
     * @return void
     * @throws HttpClientError If there is an HTTP error.
     */
    public function updateDocument(string $name, string $id, array $document): void;

    /**
     * Update the schema of a collection with the given name in the search service.
     *
     * @param string $name   The name of the collection to be updated.
     * @param Schema $schema The updated schema.
     *
     * @return void
     * @throws HttpClientError If there is an HTTP error.
     */
    public function updateSchema(string $name, Schema $schema): void;

    /**
     * Get the schema of a collection with the given name from the search service.
     *
     * @param string $name The name of the collection.
     *
     * @return array The schema of the collection.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function getSchema(string $name): array;

    /**
     * Get a collection with the given name from the search service.
     *
     * @param string $name The name of the collection.
     *
     * @return array The collection.
     * @throws HttpClientError If there is an HTTP error.
     */
    public function getCollection(string $name): array;
}