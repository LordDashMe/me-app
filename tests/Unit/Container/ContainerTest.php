<?php

namespace LordDashMe\MeApp\Tests\Unit\Container;

use PHPUnit\Framework\TestCase;
use LordDashMe\MeApp\Container\Container;
use LordDashMe\MeApp\Exception\Container\InvalidInstanceTypeException;

class ContainerTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_container_class()
    {
        $this->assertInstanceOf(Container::class, new Container()); 
    }

    /**
     * @test
     */
    public function it_should_register_class_instance_to_the_container_instance_bag()
    {
        $container = new Container();

        $this->assertInstanceOf(
            Container::class, 
            $container->instance('Dummy\NamespaceOf\ClassName', 'Dummy Class Instance!')
        );
    }

    /**
     * @test
     */
    public function it_should_register_class_instance_to_the_container_instance_bag_using_alias_method_register()
    {
        $container = new Container();

        $this->assertInstanceOf(
            Container::class, 
            $container->register('Dummy\NamespaceOf\ClassName', 'Dummy Class Instance!')
        );
    }

    /**
     * @test
     */
    public function it_should_make_class_instance_of_the_given_namespace()
    {
        $container = new Container();
        $container->instance('Dummy\NamespaceOf\ClassNameOne', 'Dummy Class Instance One!');
        $container->register('Dummy\NamespaceOf\ClassNameTwo', 'Dummy Class Instance Two!');

        $this->assertEquals(
            'Dummy Class Instance One!', $container->make('Dummy\NamespaceOf\ClassNameOne')
        );

        $this->assertEquals(
            'Dummy Class Instance Two!', $container->make('Dummy\NamespaceOf\ClassNameTwo')
        );
    }

    /**
     * @test
     */
    public function it_should_retrieve_the_last_container_instance_using_get_instance_method()
    {
        $container = new Container();
        $container->instance('Dummy\NamespaceOf\ClassName', 'Dummy Class Instance!');
        
        Container::setInstance($container);

        $oldContainer = Container::getInstance();

        $this->assertEquals(
            'Dummy Class Instance!',
            $oldContainer->make('Dummy\NamespaceOf\ClassName')
        );
    }

    /**
     * @test
     */
    public function it_should_throw_exception_if_the_make_closure_detected_a_not_closure_type_instance()
    {
        $this->expectException(InvalidInstanceTypeException::class);
        $this->expectExceptionCode(1);

        $container = new Container();
        $container->instance('Dummy\Closure', 'Not a Closure!');
        $container->makeClosure('Dummy\Closure');
    }

    /**
     * @test
     */
    public function it_should_automatically_execute_if_the_given_instance_is_closure_type_and_trigger_method_called_after_make()
    {
        $container = new Container();
        $container->instance('Dummy\Closure', function () {
            return 'Dummy Closure!';
        });

        $this->assertEquals('Dummy Closure!', $container->makeClosure('Dummy\Closure'));
    }
}
