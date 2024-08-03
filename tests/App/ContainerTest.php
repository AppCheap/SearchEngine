<?php

use PHPUnit\Framework\TestCase;
use Appcheap\SearchEngine\App\Container;
use Appcheap\SearchEngine\App\Proxy\MemoryProxy;

class AtHome {
    public function doSomething() {
        return "If I hear that word again...";
    }
}

class ContainerTest extends TestCase {
    public function testCanRegisterAndResolveService() {
        $container = new Container();

        $container->set(AtHome::class, function() {
            return new AtHome();
        });

        $resolved = $container->get(AtHome::class);

        // The resolved instance should be a MemoryProxy instance
        $this->assertInstanceOf(MemoryProxy::class, $resolved);

        // Call a method on the resolved instance
        $result = $resolved->doSomething();
        $this->assertEquals("If I hear that word again...", $result);

        // The resolved instance should be an instance of AtHome
        $this->assertInstanceOf(AtHome::class, $resolved->getInstance());
    }

    public function testCanRegisterAndResolveServiceWithClosure() {
        $container = new Container();

        $container->set('bar', function() use ($container) {
            return new \DateTime();
        });

        $resolved = $container->get('bar');

        $this->assertInstanceOf(\DateTime::class, $resolved->getInstance());
    }

    public function testSingletonResolution() {
        $container = new Container();

        $container->set('baz', function() use ($container) {
            return new \stdClass();
        });

        $firstInstance = $container->get('baz');
        $secondInstance = $container->get('baz');

        $this->assertSame($firstInstance, $secondInstance);
    }

    public function testThrowsExceptionWhenServiceNotFound() {
        $container = new Container();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('No binding found for non_existent_service');

        $container->get('non_existent_service');
    }

    public function testHasMethod() {
        $container = new Container();

        $container->set('bar', \stdClass::class);

        $this->assertTrue($container->has('bar'));
        $this->assertFalse($container->has('non_bar'));
    }
}
