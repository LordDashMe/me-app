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
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\UserRole;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\UserStatus;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\Exception\LoginFailedException;

class UserLoginTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_user_login_class()
    {
        $loginRequestData = [
            'username' => '',
            'password' => ''
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $userLogin = new UserLogin(
            $loginRequestData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );

        $this->assertInstanceOf(UserLogin::class, $userLogin);
    }

    /**
     * @test
     */
    public function it_should_throw_required_field_exception_when_required_field_is_empty()
    {
        $this->expectException(RequiredFieldException::class);
        $this->expectExceptionCode(RequiredFieldException::REQUIRED_FIELD_IS_EMPTY);

        $loginRequestData = [
            'username' => '',
            'password' => ''
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $userLogin = new UserLogin(
            $loginRequestData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );

        $userLogin->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_login_failed_exception_when_user_account_is_invalid()
    {
        $this->expectException(LoginFailedException::class);
        $this->expectExceptionCode(LoginFailedException::INVALID_ACCOUNT);

        $loginRequestData = [
            'username' => 'null',
            'password' => 'P@ss0wrd!'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getByUsername')
                       ->andReturn(null);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $userLogin = new UserLogin(
            $loginRequestData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );

        $userLogin->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_login_failed_exception_when_user_status_is_inactive()
    {
        $this->expectException(LoginFailedException::class);
        $this->expectExceptionCode(LoginFailedException::USER_STATUS_IS_NOT_ACTIVE);

        $loginRequestData = [
            'username' => 'johhdoe123',
            'password' => 'P@ss0wrd!'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getByUsername')
                       ->andReturn($this->mockUserEntity());
        $userRepository->shouldReceive('isApproved')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $passwordEncoder->shouldReceive('verifyEncodedText')
                       ->andReturn(true);

        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $userLogin = new UserLogin(
            $loginRequestData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );

        $userLogin->validate();
    }

    /**
     * @test
     */
    public function it_should_login_user_account()
    {
        $loginRequestData = [
            'username' => 'johndoe123',
            'password' => 'P@ss0wrd!'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getByUsername')
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

        $userLogin = new UserLogin(
            $loginRequestData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );

        $userLogin->validate();

        $this->assertEquals(null, $userLogin->perform());
    }

    private function mockUserEntity()
    {
        return new User(
            new UserId(),
            new FirstName('John'),
            new LastName('Doe'),
            new Email('john.doe@provider.com'),
            new UserName('johndoe123'),
            new Password('P@ssw0rd!'),
            new UserStatus(User::STATUS_ACTIVE),
            new UserRole(User::ROLE_MEMBER),
            new CreatedAt
        );
    }
}
