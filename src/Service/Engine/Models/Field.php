<?php

namespace Appcheap\SearchEngine\Service\Engine\Models;

use Appcheap\SearchEngine\App\Exception\FieldException;

/**
 * Field class.
 *
 * Represents a field in a document.
 *
 */
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
    private $facet = false;

    /**
     * @var bool When set to true, the field can have empty, null or missing values.
     */
    private $optional = false;

    /**
     * @var bool When set to false, the field will not be indexed in any in-memory index.
     */
    private $index = true;

    /**
     * @var bool When set to false, the field value will not be stored on disk.
     */
    private $store = true;

    /**
     * @var bool When set to true, the field will be sortable.
     */
    private $sort = false;

    /**
     * @var bool When set to true, the field value can be infix-searched.
     */
    private $infix = false;

    /**
     * @var string For configuring language specific tokenization.
     */
    private $locale = '';

    /**
     * @var int Set this to a non-zero value to treat a field of type float[] as a vector field.
     */
    private $num_dim = 0;

    /**
     * @var string The distance metric to be used for vector search.
     */
    private $vec_dist = 'cosine';

    /**
     * @var string Name of a field in another collection that should be linked to this collection.
     */
    private $reference = '';

    /**
     * @var bool Enables an index optimized for range filtering on numerical fields.
     */
    private $range_index = false;

    /**
     * @var bool Values are stemmed before indexing in-memory.
     */
    private $stem = false;

    /**
     * Magic method to get the value of a private property.
     *
     * @param string $name The name of the property.
     * @return mixed The value of the property.
     * @throws \Exception If the property does not exist.
     */
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        throw new FieldException("Property {$name} does not exist");
    }

    /**
     * Magic method to set the value of a private property.
     *
     * @param string $name  The name of the property.
     * @param mixed  $value The value to set.
     * @return void Nothing.
     * @throws \Exception If the property does not exist.
     */
    public function __set(string $name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        } else {
            throw new FieldException("Property {$name} does not exist");
        }
    }

    /**
     * Creates a new Field instance.
     *
     * @param array $field The array of field attributes.
     * @return self The newly created Field instance.
     */
    public static function create(array $field)
    {

        self::validate($field);

        $obj = new self();
        foreach ($field as $key => $value) {
            $obj->$key = $value;
        }

        return $obj;
    }

    /**
     * Validates input for the Field instance.
     * @param array $fields The array of fields to validate.
     * @return void Nothing.
     * @throws \Exception If the input is invalid.
     */
    public static function validate(array $fields)
    {
        $valid_fields = [
            'name' => 'string|required',
            'type' => 'string|required|in:Type::getAllTypes',
            'facet' => 'boolean|optional',
            'optional' => 'boolean|optional',
            'index' => 'boolean|optional',
            'store' => 'boolean|optional',
            'sort' => 'boolean|optional',
            'infix' => 'boolean|optional',
            'locale' => 'string|optional',
            'num_dim' => 'integer|optional',
            'vec_dist' => 'string|optional',
            'reference' => 'string|optional',
            'range_index' => 'boolean|optional',
            'stem' => 'boolean|optional',
        ];

        foreach ($valid_fields as $key => $value) {
            $types = explode('|', $value);
            // Check missing required fields
            if (in_array('required', $types) && !array_key_exists($key, $fields)) {
                throw new FieldException("Field: {$key} is required");
            }
        }

        foreach ($fields as $key => $value) {
            if (!array_key_exists($key, $valid_fields)) {
                throw new FieldException("Invalid field: {$key}");
            }

            $types = explode('|', $valid_fields[$key]);

            $valid = false;
            foreach ($types as $type) {
                if ($type === 'required' && empty($value)) {
                    throw new FieldException("Field: {$key} is required");
                    break;
                }

                if ($type === 'in:Type::getAllTypes' && !in_array($value, Type::getAllTypes())) {
                    throw new FieldException("Invalid type for field: {$key} with value: {$value}");
                    break;
                }

                if ($type === 'optional' && $value === null) {
                    $valid = true;
                }

                if ($value !== null && in_array($type, ['boolean', 'integer', 'string', 'array']) && gettype($value) === $type) {
                    $valid = true;
                }
            }

            if (!$valid) {
                throw new FieldException("Invalid value for field: {$key} with value: {$value}");
            }
        }
    }

    /**
     * To array method.
     *
     * @return array The array representation of the Field instance.
     */
    public function toArray()
    {
        $array = [
            'name' => $this->name,
            'type' => $this->type,
        ];

        // Add optional fields if they are set and not the default value
        if ($this->facet !== false) {
            $array['facet'] = $this->facet;
        }

        if ($this->optional !== false) {
            $array['optional'] = $this->optional;
        }

        if ($this->index !== true) {
            $array['index'] = $this->index;
        }

        if ($this->store !== true) {
            $array['store'] = $this->store;
        }

        if ($this->sort !== false) {
            $array['sort'] = $this->sort;
        }

        if ($this->infix !== false) {
            $array['infix'] = $this->infix;
        }

        if ($this->locale !== '') {
            $array['locale'] = $this->locale;
        }

        if ($this->num_dim !== 0) {
            $array['num_dim'] = $this->num_dim;
        }

        if ($this->vec_dist !== 'cosine') {
            $array['vec_dist'] = $this->vec_dist;
        }

        if ($this->reference !== '') {
            $array['reference'] = $this->reference;
        }

        if ($this->range_index !== false) {
            $array['range_index'] = $this->range_index;
        }

        if ($this->stem !== false) {
            $array['stem'] = $this->stem;
        }

        return $array;
    }

    /**
     * Get all fields.
     *
     * @return array The array of all fields.
     */
    public static function getAllFields()
    {
        return [
            'name' => [
                'json_data_type' => 'string',
                'description' => 'The name of the field.',
                'optional' => false,
                'default' => '',
            ],
            'type' => [
                'json_data_type' => 'string',
                'description' => 'The type of the field.',
                'optional' => false,
                'default' => '',
            ],
            'facet' => [
                'json_data_type' => 'boolean',
                'description' => 'Enables faceting on the field.',
                'optional' => true,
                'default' => false,
            ],
            'optional' => [
                'json_data_type' => 'boolean',
                'description' => 'When set to true, the field can have empty, null or missing values.',
                'optional' => true,
                'default' => true,
            ],
            'index' => [
                'json_data_type' => 'boolean',
                'description' => 'When set to false, the field will not be indexed in any in-memory index.',
                'optional' => true,
                'default' => true,
            ],
            'store' => [
                'json_data_type' => 'boolean',
                'description' => 'When set to false, the field value will not be stored on disk.',
                'optional' => true,
                'default' => true,
            ],
            'sort' => [
                'json_data_type' => 'boolean',
                'description' => 'When set to true, the field will be sortable.',
                'optional' => true,
                'default' => false,
            ],
            'infix' => [
                'json_data_type' => 'boolean',
                'description' => 'When set to true, the field value can be infix-searched.',
                'optional' => true,
                'default' => false,
            ],
            'locale' => [
                'json_data_type' => 'string',
                'description' => 'For configuring language specific tokenization.',
                'optional' => true,
                'default' => '',
            ],
            'num_dim' => [
                'json_data_type' => 'integer',
                'description' => 'Set this to a non-zero value to treat a field of type float[] as a vector field.',
                'optional' => true,
                'default' => 0,
            ],
            'vec_dist' => [
                'json_data_type' => 'string',
                'description' => 'The distance metric to be used for vector search.',
                'optional' => true,
                'default' => 'cosine',
            ],
            'reference' => [
                'json_data_type' => 'string',
                'description' => 'Name of a field in another collection that should be linked to this collection.',
                'optional' => true,
                'default' => '',
            ],
            'range_index' => [
                'json_data_type' => 'boolean',
                'description' => 'Enables an index optimized for range filtering on numerical fields.',
                'optional' => true,
                'default' => false,
            ],
            'stem' => [
                'json_data_type' => 'boolean',
                'description' => 'Values are stemmed before indexing in-memory.',
                'optional' => true,
                'default' => false,
            ],
        ];
    }
}
