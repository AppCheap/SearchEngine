<?php
use PHPUnit\Framework\TestCase;
use Appcheap\SearchEngine\App\Proxy\MemoryProxy;

class ExampleService {
    public function doSomething() {
        return "I'm very lazy! I'll do something later.";
    }
}

class MemoryProxyTest extends TestCase
{
    public function testProxyInitialization()
    {
        $initializerCalled = false;

        $initializer = function() use (&$initializerCalled) {
            $initializerCalled = true;
            return new ExampleService();
        };

        $proxy = new MemoryProxy($initializer);

        // Assert that the initializer has not been called yet
        $this->assertFalse($initializerCalled);

        // Call a method on the proxy
        $result = $proxy->doSomething();

        // Assert that the initializer has been called
        $this->assertTrue($initializerCalled);

        // Assert that the method on the real object was called correctly
        $this->assertEquals("I'm very lazy! I'll do something later.", $result);
    }

    public function testProxyMultipleMethodCalls() {
        $initializerCallCount = 0;
        $initializer = function() use (&$initializerCallCount) {
            $initializerCallCount++;
            return new ExampleService();
        };

        $proxy = new MemoryProxy($initializer);

        // Call a method on the proxy multiple times
        $proxy->doSomething();
        $proxy->doSomething();

        // Assert that the initializer was called only once
        $this->assertEquals(1, $initializerCallCount);
    }

    public function testProxyExceptionHandling() {
        $initializer = function() {
            return new ExampleService();
        };

        $proxy = new MemoryProxy($initializer);

        // Use a method that throws an exception
        $this->expectException(\Error::class);

        // Trigger the exception
        $proxy->nonExistentMethod();
    }
}