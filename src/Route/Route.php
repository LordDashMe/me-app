<?php

namespace LordDashMe\MeApp\Route;

use LordDashMe\MeApp\Exception\Route\RequestRouteNotResolvedException;

class Route
{
    protected $routeCollectionBag = [];

    public function get($route, $controller)
    {
        return $this->action('GET', $route, $controller);
    }

    public function post($route, $controller)
    {
        return $this->action('POST', $route, $controller);
    }

    protected function action($method, $route, $controller) 
    {
        $this->routeCollectionBag[$method][$route] = $controller;

        return $this;
    }

    public function register()
    {
        $requestMethod = $this->serverRequestMethod();
        $requestRoute = $this->serverRequestRoute();

        $controller = $this->resolver(
            $requestMethod, $requestRoute
        );

        return $controller;      
    }

    protected function serverRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    protected function serverRequestRoute()
    {
        return $_SERVER['REQUEST_URI'];
    }

    protected function resolver($requestMethod, $requestRoute)
    {
        if (! isset($this->routeCollectionBag[$requestMethod][$requestRoute])) {
            throw RequestRouteNotResolvedException::isNotListedInRouteCollectionBag();
        }

        $controller = $this->routeCollectionBag[$requestMethod][$requestRoute];

        if ($controller instanceof \Closure) {
            return $controller();
        }
        
        if (is_string($controller)) {
            $controller = explode('@', $controller);
            return (new $controller[0]())->{$controller[1]}();
        }

        throw RequestRouteNotResolvedException::isNotValidReturnInstance();
    }
}
