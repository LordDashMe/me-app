<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\UseCase\UserRegistration;
use UserManagement\Domain\Exception\RegistrationFailedException;

class UserRegistrationTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_user_registration_class()
    {
        $registrationData = [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'username' => '',
            'password' => ''
        ];

        $userRepository = Mockery::mock(UserRepository::class);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationData, $userRepository, $passwordEncoder
        );

        $this->assertInstanceOf(UserRegistration::class, $userRegistration);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_required_field_is_empty()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::REQUIRED_FIELD_IS_EMPTY);

        $registrationData = [
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'username' => '',
            'password' => '',
            'confirm_password' => ''
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationData, $userRepository, $passwordEncoder
        );
        
        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_invalid_email_format_given()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::INVALID_EMAIL_FORMAT);

        $registrationData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'invalid_format',
            'username' => 'johndoe123',
            'password' => 'weak',
            'confirm_password' => 'weak'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationData, $userRepository, $passwordEncoder
        );

        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_username_already_registered()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::USERNAME_ALREADY_REGISTERED);

        $registrationData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@provider.com',
            'username' => 'johndoe123_already_registered',
            'password' => 'P@ssw0rd!',
            'confirm_password' => 'P@ssw0rd!'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(true);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationData, $userRepository, $passwordEncoder
        );
        
        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_invalid_password_format_given()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::INVALID_PASSWORD_FORMAT);

        $registrationData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@provider.com',
            'username' => 'johndoe123',
            'password' => 'weak_format',
            'confirm_password' => 'weak_format'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationData, $userRepository, $passwordEncoder
        );

        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_exception_when_password_not_matched()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::CONFIRMATION_PASSWORD_NOT_MATCHED);

        $registrationData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@provider.com',
            'username' => 'johndoe123',
            'password' => 'P@ssw0rd!',
            'confirm_password' => 'wrong_confirm_password'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationData, $userRepository, $passwordEncoder
        );

        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_register_user()
    {
        $registrationData = [
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
                       ->andReturn('This are some hashed content!');

        $userRegistration = new UserRegistration(
            $registrationData, $userRepository, $passwordEncoder
        );
        
        $userRegistration->validate();

        $this->assertEquals(true, $userRegistration->execute());
    }
}
