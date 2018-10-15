<?php

namespace LordDashMe\MeApp\Tests\Unit\Foundation;

use PHPUnit\Framework\TestCase;
use LordDashMe\MeApp\Foundation\Application;

class ApplicationTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_application_class()
    {
        $this->assertInstanceOf(Application::class, new Application());  
    }

    /**
     * @test
     */
    public function it_should_register_application_default_paths()
    {
        $application = new Application(
            'dummy/application/dir'
        );

        $this->assertEquals('dummy/application/dir/config', $application->make('path.config'));
        $this->assertEquals('dummy/application/dir/resources', $application->make('path.resources'));
        $this->assertEquals('dummy/application/dir/routes', $application->make('path.routes'));
        $this->assertEquals('dummy/application/dir/storage', $application->make('path.storage'));
    }
}
