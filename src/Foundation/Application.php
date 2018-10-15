<?php

namespace LordDashMe\MeApp\Foundation;

use LordDashMe\MeApp\Container\Container;

class Application extends Container
{
    protected $path;

    public function __construct($path = '')
    {
        $this->path = rtrim($path, '\/');

        $this->registerPathBindings();

        static::setInstance($this);
    }

    protected function registerPathBindings()
    {
        $this->instance('path.config', $this->configPath());
        $this->instance('path.resources', $this->resourcesPath());
        $this->instance('path.routes', $this->routesPath());
        $this->instance('path.storage', $this->storagePath());
    }

    protected function getPath()
    {
        return $this->path;
    }

    protected function configPath()
    {
        return $this->getPath() . DIRECTORY_SEPARATOR . 'config';
    }

    protected function resourcesPath()
    {
        return $this->getPath() . DIRECTORY_SEPARATOR . 'resources';   
    }

    protected function routesPath()
    {
        return $this->getPath() . DIRECTORY_SEPARATOR . 'routes';
    }

    protected function storagePath()
    {
        return $this->getPath() . DIRECTORY_SEPARATOR . 'storage';    
    }
}
