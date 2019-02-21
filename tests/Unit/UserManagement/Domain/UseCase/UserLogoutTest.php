<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use UserManagement\Domain\UseCase\UserLogout;
use UserManagement\Domain\Service\UserSessionManager;

class UserLogoutTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_user_logout_class()
    {
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $this->assertInstanceOf(UserLogout::class, new UserLogout($userSessionManager));
    }

    /**
     * @test
     */
    public function it_should_perform_user_logout()
    {
        $userSessionManager = Mockery::mock(UserSessionManager::class);
        $userSessionManager->shouldReceive('forget')
                           ->andReturn(null);

        $userLogout = new UserLogout($userSessionManager);

        $this->assertEquals(null, $userLogout->perform());
    }
}
