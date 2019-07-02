<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use UserManagement\Domain\Exception\LogoutFailedException;
use UserManagement\Domain\UseCase\UserLogoutAction;
use UserManagement\Domain\Service\UserSessionManager;

class UserLogoutActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new UserLogoutAction(Mockery::mock(UserSessionManager::class));

        $this->assertInstanceOf(UserLogoutAction::class, $useCase);
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

        $useCase = new UserLogoutAction($userSessionManager);
        
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

        $useCase = new UserLogoutAction($userSessionManager);

        $this->assertEquals(null, $useCase->perform());
    }
}
