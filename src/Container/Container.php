<?php

namespace LordDashMe\MeApp\Container;

use LordDashMe\MeApp\Exception\Container\InvalidInstanceTypeException;

class Container
{
    protected static $container;

    protected $instanceBag = [];

    public static function setInstance($container)
    {
        static::$container = $container;
    }

    public static function getInstance()
    {
        return static::$container;
    }
    
    public function instance($abstract, $instance)
    {
        $this->instanceBag[$abstract] = $instance;

        return $this;
    }

    public function register($abstract, $instance)
    {
        return $this->instance($abstract, $instance);
    }

    public function make($abstract)
    {
        return $this->instanceBag[$abstract];
    }

    public function makeClosure($abstract)
    {
        $instance = $this->instanceBag[$abstract];

        if (! $instance instanceof \Closure) {
            throw InvalidInstanceTypeException::isNotClosure();  
        }

        return $instance();
    }
}
