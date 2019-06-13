<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use DomainCommon\Domain\ValueObject\CreatedAt;
use DomainCommon\Domain\Exception\RequiredFieldException;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\UseCase\UserLogin;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\UserRole;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\UserStatus;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Exception\LoginFailedException;

class UserLoginTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $userRepository = Mockery::mock(UserRepository::class);
        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $useCase = new UserLogin($userRepository, $passwordEncoder, $userSessionManager);

        $this->assertInstanceOf(UserLogin::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_throw_required_field_exception_when_required_field_is_empty()
    {
        $this->expectException(RequiredFieldException::class);
        $this->expectExceptionCode(RequiredFieldException::REQUIRED_FIELD_IS_EMPTY);

        $userRepository = Mockery::mock(UserRepository::class);
        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $useCase = new UserLogin($userRepository, $passwordEncoder, $userSessionManager);
        $useCase->build(
            new UserName(''),
            new Password('')
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

        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getByUserName')
                       ->andReturn(null);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $useCase = new UserLogin($userRepository, $passwordEncoder, $userSessionManager);
        $useCase->build(
            new UserName('null'),
            new Password('P@ss0wrd!')
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

        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getByUserName')
                       ->andReturn($this->mockUserEntity());
        $userRepository->shouldReceive('isApproved')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $passwordEncoder->shouldReceive('verifyEncodedText')
                       ->andReturn(true);

        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $useCase = new UserLogin($userRepository, $passwordEncoder, $userSessionManager);
        $useCase->build(
            new UserName('johndoe123'),
            new Password('P@ss0wrd!')
        );
        $useCase->validate();
    }

    /**
     * @test
     */
    public function it_should_login_user_account()
    {
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

        $useCase = new UserLogin($userRepository, $passwordEncoder, $userSessionManager);
        $useCase->build(
            new UserName('johndoe123'),
            new Password('P@ss0wrd!')
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
            new UserStatus(User::STATUS_ACTIVE),
            new UserRole(User::ROLE_MEMBER),
            new CreatedAt()
        );
    }
}
