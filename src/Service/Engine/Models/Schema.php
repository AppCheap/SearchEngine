<?php
namespace Appcheap\SearchEngine\Service\Engine\Models;

class Schema {
    /**
     * @var array $fields The fields of the schema
     */
    private $fields;

    /**
     * Schema constructor.
     *
     * @param array $fields The fields of the schema
     * 
     * @example
     * $fields = [
     *    ['name' => 'title', 'type' => 'string', 'facet' => true, 'index' => true],
     *    ['name' => 'content', 'type' => 'string'],
     * ];
     */
    public function __construct(array $fields) {
        $this->fields = $fields;
    }

    /**
     * Get the fields of the schema.
     *
     * @return array The fields of the schema
     */
    public function getFields(): array {
        return $this->fields;
    }

    /**
     * Convert the schema fields to Algolia's format if needed.
     *
     * @return array The schema fields in Algolia's format
     */
    public function toAlgoliaSchema(): array {
        // Convert schema fields to Algolia's format if needed
        return $this->fields; // Adjust as needed
    }

    /**
     * Convert the schema fields to Typesense's format.
     *
     * @return array The schema fields in Typesense's format
     */
    public function toTypesenseSchema(): array {
        // Convert schema fields to Typesense's format
        $typesenseFields = [];
        foreach ($this->fields as $field) {
            $typesenseFields[] = [
                'name' => $field['name'],
                'type' => $field['type']
            ];
        }
        return $typesenseFields;
    }
}
