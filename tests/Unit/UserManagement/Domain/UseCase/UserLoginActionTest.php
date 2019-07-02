<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Entity\UserLogin;
use UserManagement\Domain\Exception\LoginFailedException;
use UserManagement\Domain\Message\UserLoginData;
use UserManagement\Domain\Repository\UserLoginRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\UseCase\UserLoginAction;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;

class UserLoginActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new UserLoginAction(
            Mockery::mock(UserLoginData::class), 
            Mockery::mock(UserLoginRepository::class), 
            Mockery::mock(PasswordEncoder::class), 
            Mockery::mock(UserSessionManager::class)
        );

        $this->assertInstanceOf(UserLoginAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_throw_login_failed_exception_when_user_account_is_invalid()
    {
        $this->expectException(LoginFailedException::class);
        $this->expectExceptionCode(LoginFailedException::INVALID_ACCOUNT);

        $userLoginData = new UserLoginData('invalid_username', 'P@ss0wrd!');

        $userLoginRepository = Mockery::mock(UserLoginRepository::class);
        $userLoginRepository->shouldReceive('get')
                            ->andReturn(null);

        $useCase = new UserLoginAction(
            $userLoginData, 
            $userLoginRepository, 
            Mockery::mock(PasswordEncoder::class), 
            Mockery::mock(UserSessionManager::class)
        );

        $useCase->perform();
    }

    /**
     * @test
     */
    public function it_should_throw_login_failed_exception_when_user_status_is_inactive()
    {
        $this->expectException(LoginFailedException::class);
        $this->expectExceptionCode(LoginFailedException::USER_STATUS_IS_NOT_ACTIVE);

        $userLoginData = new UserLoginData('johndoe123', 'P@ss0wrd!');

        $mockUserLoginEntity = Mockery::mock($this->mockUserLoginEntity());
        $mockUserLoginEntity->shouldReceive('isApproved')
                            ->andReturn(false);
        $userLoginRepository = Mockery::mock(UserLoginRepository::class);
        $userLoginRepository->shouldReceive('get')
                            ->andReturn($mockUserLoginEntity);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $passwordEncoder->shouldReceive('verifyEncodedText')
                        ->andReturn(true);

        $useCase = new UserLoginAction(
            $userLoginData, 
            $userLoginRepository, 
            $passwordEncoder, 
            Mockery::mock(UserSessionManager::class)
        );
        
        $useCase->perform();
    }

    /**
     * @test
     */
    public function it_should_perform_user_login()
    {
        $userLoginData = new UserLoginData('johndoe123', 'P@ss0wrd!');

        $mockUserLoginEntity = Mockery::mock($this->mockUserLoginEntity());
        $mockUserLoginEntity->shouldReceive('isApproved')
                            ->andReturn(true);
        $userLoginRepository = Mockery::mock(UserLoginRepository::class);
        $userLoginRepository->shouldReceive('get')
                            ->andReturn($mockUserLoginEntity);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $passwordEncoder->shouldReceive('verifyEncodedText')
                        ->andReturn(true);

        $userSessionManager = Mockery::mock(UserSessionManager::class);
        $userSessionManager->shouldReceive('getUserEntitySessionName')
                           ->andReturn('sessionUserEntity');
        $userSessionManager->shouldReceive('set')
                           ->andReturn(null);

        $useCase = new UserLoginAction(
            $userLoginData, 
            $userLoginRepository, 
            $passwordEncoder, 
            $userSessionManager
        );

        $this->assertEquals(null, $useCase->perform());
    }

    private function mockUserLoginEntity()
    {
        return new UserLogin(
            new UserName('johndoe123'),
            new Password('P@ssw0rd!')
        );
    }
}
