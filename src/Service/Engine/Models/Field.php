<?php

namespace Appcheap\SearchEngine\Service\Engine\Models;

class Field
{
    /**
     * @var string The name of the field.
     */
    private $name;

    /**
     * @var string The type of the field.
     */
    private $type;

    /**
     * @var bool Enables faceting on the field.
     */
    private $facet;

    /**
     * @var bool When set to true, the field can have empty, null or missing values.
     */
    private $optional;

    /**
     * @var bool When set to false, the field will not be indexed in any in-memory index.
     */
    private $index;

    /**
     * @var bool When set to false, the field value will not be stored on disk.
     */
    private $store;

    /**
     * @var bool When set to true, the field will be sortable.
     */
    private $sort;

    /**
     * @var bool When set to true, the field value can be infix-searched.
     */
    private $infix;

    /**
     * @var string For configuring language specific tokenization.
     */
    private $locale;

    /**
     * @var int Set this to a non-zero value to treat a field of type float[] as a vector field.
     */
    private $num_dim;

    /**
     * @var string The distance metric to be used for vector search.
     */
    private $vec_dist;

    /**
     * @var string Name of a field in another collection that should be linked to this collection.
     */
    private $reference;

    /**
     * @var bool Enables an index optimized for range filtering on numerical fields.
     */
    private $range_index;

    /**
     * @var bool Values are stemmed before indexing in-memory.
     */
    private $stem;

    /**
     * Field constructor.
     *
     * @param string $name The name of the field.
     * @param string $type The type of the field.
     * @param bool $facet Enables faceting on the field. Default: false.
     * @param bool $optional When set to true, the field can have empty, null or missing values. Default: false.
     * @param bool $index When set to false, the field will not be indexed in any in-memory index. Default: true.
     * @param bool $store When set to false, the field value will not be stored on disk. Default: true.
     * @param bool $sort When set to true, the field will be sortable. Default: false.
     * @param bool $infix When set to true, the field value can be infix-searched. Default: false.
     * @param string $locale For configuring language specific tokenization. Default: 'en'.
     * @param int $num_dim Set this to a non-zero value to treat a field of type float[] as a vector field. Default: 0.
     * @param string $vec_dist The distance metric to be used for vector search. Default: 'cosine'.
     * @param string $reference Name of a field in another collection that should be linked to this collection.
     * @param bool $range_index Enables an index optimized for range filtering on numerical fields. Default: false.
     * @param bool $stem Values are stemmed before indexing in-memory. Default: false.
     */
    public function __construct(
        string $name,
        string $type,
        bool $facet = false,
        bool $optional = false,
        bool $index = true,
        bool $store = true,
        bool $sort = false,
        bool $infix = false,
        string $locale = 'en',
        int $num_dim = 0,
        string $vec_dist = 'cosine',
        string $reference = '',
        bool $range_index = false,
        bool $stem = false
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->facet = $facet;
        $this->optional = $optional;
        $this->index = $index;
        $this->store = $store;
        $this->sort = $sort;
        $this->infix = $infix;
        $this->locale = $locale;
        $this->num_dim = $num_dim;
        $this->vec_dist = $vec_dist;
        $this->reference = $reference;
        $this->range_index = $range_index;
        $this->stem = $stem;
    }

    /**
     * Get the name of the field.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the type of the field.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    // Add getter methods for the new properties

    public function isFacet(): bool
    {
        return $this->facet;
    }

    public function isOptional(): bool
    {
        return $this->optional;
    }

    public function isIndex(): bool
    {
        return $this->index;
    }

    public function isStore(): bool
    {
        return $this->store;
    }

    public function isSort(): bool
    {
        return $this->sort;
    }

    public function isInfix(): bool
    {
        return $this->infix;
    }

    public function getLocale(): string
    {
        return $this->locale;
    }

    public function getNumDim(): int
    {
        return $this->num_dim;
    }

    public function getVecDist(): string
    {
        return $this->vec_dist;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function isRangeIndex(): bool
    {
        return $this->range_index;
    }

    public function isStem(): bool
    {
        return $this->stem;
    }

    // Setters

    public function setFacet(bool $facet): self
    {
        $this->facet = $facet;
        return $this;
    }

    public function setOptional(bool $optional): self
    {
        $this->optional = $optional;
        return $this;
    }

    public function setIndex(bool $index): self
    {
        $this->index = $index;
        return $this;
    }

    public function setStore(bool $store): self
    {
        $this->store = $store;
        return $this;
    }

    public function setSort(bool $sort): self
    {
        $this->sort = $sort;
        return $this;
    }

    public function setInfix(bool $infix): self
    {
        $this->infix = $infix;
        return $this;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;
        return $this;
    }

    public function setNumDim(int $num_dim): self
    {
        $this->num_dim = $num_dim;
        return $this;
    }

    public function setVecDist(string $vec_dist): self
    {
        $this->vec_dist = $vec_dist;
        return $this;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;
        return $this;
    }

    public function setRangeIndex(bool $range_index): self
    {
        $this->range_index = $range_index;
        return $this;
    }

    public function setStem(bool $stem): self
    {
        $this->stem = $stem;
        return $this;
    }
}
