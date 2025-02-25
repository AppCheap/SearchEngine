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
     * @var array The array of resolved instances.
     */
    private $instances = [];

    /**
     * @var array The array of factory bindings.
     */
    private $factories = [];

    /**
     * Set a binding in the container.
     *
     * @param string $abstract The abstract key.
     * @param mixed  $concrete The concrete value.
     * @return void
     */
    public function set($abstract, $concrete)
    {
        $this->bindings[$abstract] = $concrete;
    }

    /**
     * Register a factory in the container.
     *
     * @param string          $abstract The abstract key.
     * @param callable|string $factory  The factory callable or string.
     *
     * @return void
     */
    public function factory(string $abstract, $factory)
    {
        $this->factories[$abstract] = $factory;
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
        // Return already resolved instance if available
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // Check if a factory is registered
        if (isset($this->factories[$abstract])) {
            // Check if the factory is a callable
            if (is_callable($this->factories[$abstract])) {
                return $this->instances[$abstract] = $this->factories[$abstract]();
            }

            // Check if the factory is a class name
            if (class_exists($this->factories[$abstract])) {
                return $this->instances[$abstract] = new $this->factories[$abstract]();
            }

            throw new \Exception("Invalid factory for $abstract");
        }

        // Check if binding exists
        if (!isset($this->bindings[$abstract])) {
            throw new \Exception("No binding found for $abstract");
        }

        $concrete = $this->bindings[$abstract];

        // Create a MemoryProxy if binding is callable
        if (is_callable($concrete)) {
            $this->instances[$abstract] = new MemoryProxy($concrete);
        } else {
            $this->instances[$abstract] = $concrete;
        }

        return $this->instances[$abstract];
    }

    /**
     * Checks if the container has a binding for the given identifier.
     *
     * @param string $id The identifier to check.
     * @return boolean Returns true if the container has a binding for the identifier, false otherwise.
     */
    public function has(string $id)
    {
        return isset($this->bindings[$id]) || isset($this->instances[$id]);
    }
}
