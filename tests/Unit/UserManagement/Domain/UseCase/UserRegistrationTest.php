<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use DomainCommon\Domain\Exception\RequiredFieldException;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\UseCase\UserRegistration;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Exception\RegistrationFailedException;

class UserRegistrationTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $registrationRequestData = [
            'firstName' => '',
            'lastName' => '',
            'email' => '',
            'username' => '',
            'password' => ''
        ];

        $userRepository = Mockery::mock(UserRepository::class);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationRequestData, $userRepository, $passwordEncoder
        );

        $this->assertInstanceOf(UserRegistration::class, $userRegistration);
    }

    /**
     * @test
     */
    public function it_should_throw_required_field_exception_when_required_field_is_empty()
    {
        $this->expectException(RequiredFieldException::class);
        $this->expectExceptionCode(RequiredFieldException::REQUIRED_FIELD_IS_EMPTY);

        $registrationRequestData = [
            'firstName' => '',
            'lastName' => '',
            'email' => '',
            'username' => '',
            'password' => '',
            'confirmPassword' => ''
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationRequestData, $userRepository, $passwordEncoder
        );
        
        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_registration_failed_exception_when_invalid_email_format_given()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::INVALID_EMAIL_FORMAT);

        $registrationRequestData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'invalid_format',
            'username' => 'johndoe123',
            'password' => 'weak',
            'confirmPassword' => 'weak'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationRequestData, $userRepository, $passwordEncoder
        );

        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_registration_failed_exception_when_username_already_registered()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::USERNAME_ALREADY_REGISTERED);

        $registrationRequestData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@provider.com',
            'username' => 'johndoe123_already_registered',
            'password' => 'P@ssw0rd!',
            'confirmPassword' => 'P@ssw0rd!'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(true);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationRequestData, $userRepository, $passwordEncoder
        );
        
        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_registration_failed_exception_when_invalid_password_format_given()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::INVALID_PASSWORD_FORMAT);

        $registrationRequestData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@provider.com',
            'username' => 'johndoe123',
            'password' => 'weak_format',
            'confirmPassword' => 'weak_format'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationRequestData, $userRepository, $passwordEncoder
        );

        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_registration_failed_exception_when_password_not_matched()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::CONFIRMATION_PASSWORD_NOT_MATCHED);

        $registrationRequestData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@provider.com',
            'username' => 'johndoe123',
            'password' => 'P@ssw0rd!',
            'confirmPassword' => 'wrong_confirmPassword'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $userRegistration = new UserRegistration(
            $registrationRequestData, $userRepository, $passwordEncoder
        );

        $userRegistration->validate();
    }

    /**
     * @test
     */
    public function it_should_register_user()
    {
        $registrationRequestData = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'email' => 'john.doe@provider.com',
            'username' => 'johndoe123',
            'password' => 'P@ssw0rd!',
            'confirmPassword' => 'P@ssw0rd!'
        ];
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);
        $userRepository->shouldReceive('create')
                       ->andReturn(null);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $passwordEncoder->shouldReceive('encodePlainText')
                       ->andReturn('This are some hashed content!');

        $userRegistration = new UserRegistration(
            $registrationRequestData, $userRepository, $passwordEncoder
        );
        
        $userRegistration->validate();

        $this->assertEquals(null, $userRegistration->perform());
    }
}
