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
     * Field constructor.
     *
     * @param string $name The name of the field.
     * @param string $type The type of the field.
     */
    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
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
}