<?php

namespace Appcheap\SearchEngine\Service\Engine\Models;

class Schema
{
    /**
     * @var string $name The name of the collection
     */
    private $name;

    /**
     * @var Field[] $fields The fields of the schema
     */
    private $fields;

    /**
     * @var string $defaultSortingField The default sorting field
     */
    private $defaultSortingField;

    /**
     * Schema constructor.
     *
     * @param string  $name   The name of the collection
     * @param Field[] $fields The fields of the schema
     */
    public function __construct(string $name, array $fields)
    {
        $this->name = $name;
        $this->fields = $fields;
    }

    // Setters (with fluent interface for optional parameters)

    /**
     * Set the default sorting field.
     *
     * @param string $defaultSortingField The default sorting field
     * @return Schema The schema object
     */
    public function setDefaultSortingField(string $defaultSortingField)
    {
        $this->defaultSortingField = $defaultSortingField;
        return $this;
    }

    /**
     * Get the name of the collection.
     *
     * @return string The name of the collection
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the fields of the schema.
     *
     * @return Field[] The fields of the schema
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Convert the schema fields to Algolia's format if needed.
     *
     * @return array The schema fields in Algolia's format
     */
    public function toAlgoliaSchema()
    {
        // Convert schema fields to Algolia's format if needed
        $algoliaFields = [];
        foreach ($this->fields as $field) {
            $algoliaFields[] = [
                'name' => $field->getName(),
                'type' => $field->getType(),
                'facet' => $field->isFacet(),
                'optional' => $field->isOptional(),
                'index' => $field->isIndex(),
                'store' => $field->isStore(),
                'sort' => $field->isSort(),
                'infix' => $field->isInfix(),
                'locale' => $field->getLocale(),
                'num_dim' => $field->getNumDim(),
                'vec_dist' => $field->getVecDist(),
                'reference' => $field->getReference(),
                'range_index' => $field->isRangeIndex(),
                'stem' => $field->isStem(),
            ];
        }
        return $algoliaFields;
    }

    /**
     * Convert the schema fields to Typesense's format.
     *
     * @return array The schema fields in Typesense's format
     */
    public function toTypesenseSchema()
    {
        $schema = [
            'name' => $this->name,
        ];

        $typesenseFields = [];
        foreach ($this->fields as $field) {
            $typesenseFields[] = $field->toArray();
        }

        $schema['fields'] = $typesenseFields;

        if ($this->defaultSortingField) {
            $schema['default_sorting_field'] = $this->defaultSortingField;
        }

        return $schema;
    }

    /**
     * Convert the schema fields to Elasticsearch's format.
     *
     * @return array The schema fields in Elasticsearch's format
     */
    public function toElasticsearchSchema()
    {
        // Convert schema fields to Elasticsearch's format
        $elasticsearchFields = [];
        foreach ($this->fields as $field) {
            $elasticsearchFields[$field->getName()] = [
                'type' => $field->getType(),
                'index' => $field->isIndex(),
                'store' => $field->isStore(),
                'sort' => $field->isSort(),
                'infix' => $field->isInfix(),
                'locale' => $field->getLocale(),
                'num_dim' => $field->getNumDim(),
                'vec_dist' => $field->getVecDist(),
                'reference' => $field->getReference(),
                'range_index' => $field->isRangeIndex(),
                'stem' => $field->isStem(),
            ];
        }
        return $elasticsearchFields;
    }

    /**
     * Convert the schema fields to MeiliSearch's format.
     *
     * @return array The schema fields in MeiliSearch's format
     */
    public function toMeiliSearchSchema()
    {
        // Convert schema fields to MeiliSearch's format
        $meilisearchFields = [];
        foreach ($this->fields as $field) {
            $meilisearchFields[$field->getName()] = [
                'type' => $field->getType(),
                'facet' => $field->isFacet(),
                'optional' => $field->isOptional(),
                'index' => $field->isIndex(),
                'store' => $field->isStore(),
                'sort' => $field->isSort(),
                'infix' => $field->isInfix(),
                'locale' => $field->getLocale(),
                'num_dim' => $field->getNumDim(),
                'vec_dist' => $field->getVecDist(),
                'reference' => $field->getReference(),
                'range_index' => $field->isRangeIndex(),
                'stem' => $field->isStem(),
            ];
        }
        return $meilisearchFields;
    }

    /**
     * Convert the schema fields to the specified service's format.
     *
     * @param string $serviceType The service type
     * @return array The schema fields in the specified service's format
     */
    public function toArray($serviceType)
    {
        switch ($serviceType) {
            case 'elasticsearch':
                return $this->toElasticsearchSchema();
            case 'typesense':
                return $this->toTypesenseSchema();
            case 'algolia':
                return $this->toAlgoliaSchema();
            case 'meilisearch':
                return $this->toMeiliSearchSchema();
            default:
                return [];
        }
    }
}
