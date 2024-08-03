<?php
namespace Appcheap\SearchEngine\App\Proxy;

/**
 * Represents a memory lazy loading proxy class.
 */
class MemoryProxy
{
    private $initializer;
    private $instance;

    /**
     * Initializes a new instance of the MemoryProxy class.
     *
     * @param callable $initializer The initializer function that will be called to create the instance.
     */
    public function __construct(callable $initializer)
    {
        $this->initializer = $initializer;
    }

    /**
     * Forwards the method call to the actual instance, creating it if necessary.
     *
     * @param string $name      The name of the method being called.
     * @param array  $arguments The arguments passed to the method.
     *
     * @return mixed The result of the method call.
     */
    public function __call($name, $arguments)
    {
        if ($this->instance === null) {
            $this->instance = ($this->initializer)();
        }
        return call_user_func_array([$this->instance, $name], $arguments);
    }

    /**
     * Get the actual instance.
     * 
     * @return mixed The actual instance.
     */
    public function getInstance() {
        if ($this->instance === null) {
            $this->instance = ($this->initializer)();
        }
        return $this->instance;
    }
}