<?php

namespace LordDashMe\MeApp\Tests\Unit\Route;

use PHPUnit\Framework\TestCase;
use LordDashMe\MeApp\Route\Route;
use LordDashMe\MeApp\Exception\Route\RequestRouteNotResolvedException;

class RouteTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_route_class()
    {
        $this->assertInstanceOf(Route::class, new Route());
    }

    /**
     * @test
     */
    public function it_should_register_get_method_route_in_the_route_collection_bag()
    {
        $route = new Route();
        $routeInstance = $route->get('index/get', function () {
            return 'Hello, World!';
        });

        $this->assertInstanceOf(
            Route::class, 
            $routeInstance
        );
    }

    /**
     * @test
     */
    public function it_should_register_post_method_route_in_the_route_collection_bag()
    {
        $route = new Route();
        $routeInstance = $route->post('index/post', function () {
            return 'Hello, World!';
        });

        $this->assertInstanceOf(
            Route::class, 
            $routeInstance
        );
    }

    /**
     * @test
     */
    public function it_should_throw_exception_if_the_request_routes_not_set_in_the_route_collection_bag()
    {
        $this->expectException(RequestRouteNotResolvedException::class);
        $this->expectExceptionCode(1);

        $route = new Route();

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'index';

        $route->get('index/get', function () {
            print 'Not Registered!';
        });
        
        $route->register();    
    }

    /**
     * @test
     */
    public function it_should_throw_exception_if_the_request_routes_is_set_in_the_route_collection_bag_and_the_return_route_instance_value_is_not_valid()
    {
        $this->expectException(RequestRouteNotResolvedException::class);
        $this->expectExceptionCode(2);

        $route = new Route();

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'index/get';

        $route->get('index/get', 12345);
        
        $route->register();    
    }

    /**
     * @test
     */
    public function it_should_expect_output_regex_when_the_given_route_is_in_the_list_of_route_collection_bag_using_closure_type()
    {
        $this->expectOutputRegex('(Hello, World!)');

        $route = new Route();

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'index/get';

        $route->get('index/get', function () {
            print 'Hello, World!';
        });
        
        $route->register();   
    }

    /**
     * @test
     */
    public function it_should_expect_output_regex_when_the_given_route_is_in_the_list_of_route_collection_bag_using_namespace_method_string_type()
    {
        $this->expectOutputRegex('(Hello, World!)');

        $route = new Route();

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = 'index/get';

        $route->get('index/get', '\LordDashMe\MeApp\Tests\Mocks\Http\Controller\ControllerMock@index');
        
        $route->register();   
    }
}
