<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use UserManagement\Domain\UseCase\UserRegistration;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Exception\RegistrationFailedException;

class UserRegistrationTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_user_registration_class()
    {
        $userData = [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'username' => '',
            'password' => ''
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration($userData, $userRepository, $passwordEncoder);

        $this->assertInstanceOf(UserRegistration::class, $userRegistration);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_required_field_is_empty()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::REQUIRED_FIELD_IS_EMPTY);

        $userData = [
            'first_name' => '',
            'last_name' => '',
            'email' => 'john.doe@provider.com',
            'username' => 'johndoe123',
            'password' => '',
            'confirm_password' => ''
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration($userData, $userRepository, $passwordEncoder);
        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_invalid_email_format_given()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::INVALID_EMAIL_FORMAT);

        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'invalid',
            'username' => 'johndoe123',
            'password' => 'weak',
            'confirm_password' => 'weak'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration($userData, $userRepository, $passwordEncoder);
        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_username_already_registered()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::USERNAME_ALREADY_REGISTERED);

        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@provider.com',
            'username' => 'registered',
            'password' => 'P@ssw0rd!',
            'confirm_password' => 'P@ssw0rd!'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(true);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration($userData, $userRepository, $passwordEncoder);
        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_invalid_password_format_given()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::INVALID_PASSWORD_FORMAT);

        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@provider.com',
            'username' => 'johndoe123',
            'password' => 'weak',
            'confirm_password' => 'weak'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration($userData, $userRepository, $passwordEncoder);
        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_password_not_matched()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::CONFIRMATION_PASSWORD_NOT_MATCHED);

        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@provider.com',
            'username' => 'johndoe123',
            'password' => 'P@ssw0rd!',
            'confirm_password' => 'wrong'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration($userData, $userRepository, $passwordEncoder);
        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_register_user()
    {
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@provider.com',
            'username' => 'johndoe123',
            'password' => 'P@ssw0rd!',
            'confirm_password' => 'P@ssw0rd!'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);
        $userRepository->shouldReceive('create')
                       ->andReturn(true);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $passwordEncoder->shouldReceive('encodePlainText')
                       ->andReturn('xxxxxxxxxxxxx');

        $userRegistration = new UserRegistration($userData, $userRepository, $passwordEncoder);
        $userRegistration->validate();

        $this->assertEquals(true, $userRegistration->execute());
    }
}
