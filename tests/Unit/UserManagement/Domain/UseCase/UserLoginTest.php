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
use UserManagement\Domain\ValueObject\FirstName;
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
        $loginData = [
            'username' => '',
            'password' => ''
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $userLogin = new UserLogin(
            $loginData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );

        $this->assertInstanceOf(UserLogin::class, $userLogin);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_required_field_is_empty()
    {
        $this->expectException(RequiredFieldException::class);
        $this->expectExceptionCode(RequiredFieldException::REQUIRED_FIELD_IS_EMPTY);

        $loginData = [
            'username' => '',
            'password' => ''
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $userLogin = new UserLogin(
            $loginData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );

        $userLogin->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_user_account_is_invalid()
    {
        $this->expectException(LoginFailedException::class);
        $this->expectExceptionCode(LoginFailedException::INVALID_ACCOUNT);

        $loginData = [
            'username' => 'null',
            'password' => 'P@ss0wrd!'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getByUsername')
                       ->andReturn(null);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $userSessionManager = Mockery::mock(UserSessionManager::class);

        $userLogin = new UserLogin(
            $loginData, 
            $userRepository, 
            $passwordEncoder, 
            $userSessionManager
        );

        $userLogin->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_user_status_is_inactive()
    {
        $this->expectException(LoginFailedException::class);
        $this->expectExceptionCode(LoginFailedException::USER_STATUS_IS_NOT_ACTIVE);

        $loginData = [
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
            $loginData, 
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
        $loginData = [
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
                           ->andReturn('session_user_entity');
        $userSessionManager->shouldReceive('set')
                           ->andReturn(null);

        $userLogin = new UserLogin(
            $loginData, 
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
            User::STATUS_ACTIVE,
            new CreatedAt
        );
    }
}
