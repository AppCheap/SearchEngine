<?php

namespace Appcheap\SearchEngine\App;

use Appcheap\SearchEngine\App\Proxy\MemoryProxy;

/**
 * Class Container
 * 
 * DI container.
 */
class Container
{
    /**
     * @var array The array of bindings.
     */
    private $bindings = [];

    /**
     * Set a binding in the container.
     *
     * @param string $abstract The abstract key.
     * @param mixed $concrete The concrete value.
     * @return void
     */
    public function set($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * Get a binding from the container.
     *
     * @param string $abstract The abstract key.
     * @return mixed The concrete value.
     * @throws \Exception If no binding is found for the abstract key.
     */
    public function get($abstract)
    {
        if (!isset($this->bindings[$abstract])) {
            throw new \Exception("No binding found for $abstract");
        }

        $concrete = $this->bindings[$abstract];

        if (is_callable($concrete)) {
            return new MemoryProxy($concrete);
        }

        return $concrete;
    }
}