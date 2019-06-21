<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use DomainCommon\Domain\Exception\RequiredFieldException;
use DomainCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\DataTransferObject\UserLoginData;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\Exception\LoginFailedException;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\UseCase\UserLogin;
use UserManagement\Domain\ValueObject\Role;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Status;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\FirstName;

class UserLoginTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $userLoginData = Mockery::mock(UserLoginData::class);
        $userRepository = Mockery::mock(UserRepository::class);
        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $useCase = new UserLogin(
            $userLoginData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );

        $this->assertInstanceOf(UserLogin::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_throw_required_field_exception_when_required_field_is_empty()
    {
        $this->expectException(RequiredFieldException::class);
        $this->expectExceptionCode(RequiredFieldException::REQUIRED_FIELD_IS_EMPTY);

        $userLoginData = new UserLoginData(
            new UserName(''),
            new Password('')
        );

        $userRepository = Mockery::mock(UserRepository::class);
        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $useCase = new UserLogin(
            $userLoginData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );
        $useCase->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_login_failed_exception_when_user_account_is_invalid()
    {
        $this->expectException(LoginFailedException::class);
        $this->expectExceptionCode(LoginFailedException::INVALID_ACCOUNT);

        $userLoginData = new UserLoginData(
            new UserName('invalid_username'),
            new Password('P@ss0wrd!')
        );

        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getByUserName')
                       ->andReturn(null);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $useCase = new UserLogin(
            $userLoginData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );
        $useCase->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_login_failed_exception_when_user_status_is_inactive()
    {
        $this->expectException(LoginFailedException::class);
        $this->expectExceptionCode(LoginFailedException::USER_STATUS_IS_NOT_ACTIVE);

        $userLoginData = new UserLoginData(
            new UserName('johndoe123'),
            new Password('P@ss0wrd!')
        );

        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getByUserName')
                       ->andReturn($this->mockUserEntity());
        $userRepository->shouldReceive('isApproved')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $passwordEncoder->shouldReceive('verifyEncodedText')
                       ->andReturn(true);

        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $useCase = new UserLogin(
            $userLoginData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );
        $useCase->validate();
    }

    /**
     * @test
     */
    public function it_should_login_user_account()
    {
        $userLoginData = new UserLoginData(
            new UserName('johndoe123'),
            new Password('P@ss0wrd!')
        );

        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getByUserName')
                       ->andReturn($this->mockUserEntity());
        $userRepository->shouldReceive('isApproved')
                       ->andReturn(true);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $passwordEncoder->shouldReceive('verifyEncodedText')
                       ->andReturn(true);

        $userSessionManager = Mockery::mock(UserSessionManager::class);
        $userSessionManager->shouldReceive('getUserEntitySessionName')
                           ->andReturn('sessionUserEntity');
        $userSessionManager->shouldReceive('set')
                           ->andReturn(null);

        $useCase = new UserLogin(
            $userLoginData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );
        $useCase->validate();

        $this->assertEquals(null, $useCase->perform());
    }

    private function mockUserEntity()
    {
        return new User(
            new UserId(),
            new FirstName('John'),
            new LastName('Doe'),
            new Email('john.doe@example.com'),
            new UserName('johndoe123'),
            new Password('P@ssw0rd!'),
            new Status(User::STATUS_ACTIVE),
            new Role(User::ROLE_MEMBER),
            new CreatedAt()
        );
    }
}
