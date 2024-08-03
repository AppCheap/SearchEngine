<?php
namespace Appcheap\SearchEngine\Service\Engine\Models;

class Schema {
    /**
     * @var Field[] $fields The fields of the schema
     */
    private $fields;

    /**
     * Schema constructor.
     *
     * @param Field[] $fields The fields of the schema
     */
    public function __construct(array $fields) {
        $this->fields = $fields;
    }

    /**
     * Get the fields of the schema.
     *
     * @return Field[] The fields of the schema
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
    public function toTypesenseSchema(): array {
        // Convert schema fields to Typesense's format
        $typesenseFields = [];
        foreach ($this->fields as $field) {
            $typesenseFields[] = [
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
        return $typesenseFields;
    }

    /**
     * Convert the schema fields to Elasticsearch's format.
     * 
     * @return array The schema fields in Elasticsearch's format
     */
    public function toElasticsearchSchema(): array {
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
    public function toMeiliSearchSchema(): array {
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
}