<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use UserManagement\Domain\Exception\LogoutFailedException;
use UserManagement\Domain\UseCase\UserLogout;
use UserManagement\Domain\Service\UserSessionManager;

class UserLogoutTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new UserLogout(Mockery::mock(UserSessionManager::class));

        $this->assertInstanceOf(UserLogout::class, $useCase);
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

        $useCase = new UserLogout($userSessionManager);
        
        $useCase->perform();
    }

    /**
     * @test
     */
    public function it_should_perform_user_logout()
    {
        $userSessionManager = Mockery::mock(UserSessionManager::class);
        $userSessionManager->shouldReceive('isUserSessionAvailable')
                           ->andReturn(true);
        $userSessionManager->shouldReceive('forget')
                           ->andReturn(null);

        $useCase = new UserLogout($userSessionManager);

        $this->assertEquals(null, $useCase->perform());
    }
}
