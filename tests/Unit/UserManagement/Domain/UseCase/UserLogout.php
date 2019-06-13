<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use UserManagement\Domain\UseCase\UserLogout;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\Exception\LogoutFailedException;

class UserLogoutTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $this->assertInstanceOf(UserLogout::class, new UserLogout($userSessionManager));
    }

    /**
     * @test
     */
    public function it_should_throw_logout_failed_exception_when_no_user_session_found()
    {
        $this->expectException(LogoutFailedException::class);
        $this->expectExceptionCode(LogoutFailedException::NO_USER_SESSION_FOUND);

        $userSessionManager = Mockery::mock(UserSessionManager::class);
        $userSessionManager->shouldReceive('isUserSessionAvailable')
                           ->andReturn(false);

        $userLogout = new UserLogout($userSessionManager);
        $userLogout->validate();
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
