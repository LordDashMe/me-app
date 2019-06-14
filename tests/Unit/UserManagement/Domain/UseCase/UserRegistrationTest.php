<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use DomainCommon\Domain\Exception\RequiredFieldException;
use DomainCommon\Domain\Service\UniqueIDResolver;

use UserManagement\Domain\Aggregate\UserRegistrationData;
use UserManagement\Domain\Exception\EmailException;
use UserManagement\Domain\Exception\UserNameException;
use UserManagement\Domain\Exception\PasswordException;
use UserManagement\Domain\Exception\ConfirmPasswordException;
use UserManagement\Domain\Exception\RegistrationFailedException;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\UseCase\UserRegistration;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\ConfirmPassword;

class UserRegistrationTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $userRegistrationData = Mockery::mock(UserRegistrationData::class);

        $userRepository = Mockery::mock(UserRepository::class);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);

        $useCase = new UserRegistration(
            $userRegistrationData, 
            $userRepository, 
            $passwordEncoder,
            $uniqueIDResolver
        );

        $this->assertInstanceOf(UserRegistration::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_throw_required_field_exception_when_required_field_is_empty()
    {
        $this->expectException(RequiredFieldException::class);
        $this->expectExceptionCode(RequiredFieldException::REQUIRED_FIELD_IS_EMPTY);
        
        $userRegistrationData = new UserRegistrationData(
            new FirstName(''),
            new LastName(''),
            new Email(''),
            new UserName(''),
            new Password(''),
            new ConfirmPassword(new Password(''), '')
        );

        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);

        $useCase = new UserRegistration(
            $userRegistrationData, 
            $userRepository, 
            $passwordEncoder,
            $uniqueIDResolver
        );
        $useCase->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_email_exception_when_invalid_email_format_given()
    {
        $this->expectException(EmailException::class);
        $this->expectExceptionCode(EmailException::INVALID_FORMAT);

        $userRegistrationData = new UserRegistrationData(
            new FirstName('John'),
            new LastName('Doe'),
            new Email('invalid_format'),
            new UserName('johndoe123'),
            new Password('P@ssw0rd!'),
            new ConfirmPassword(new Password('P@ssw0rd!'), 'P@ssw0rd!')
        );
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);

        $useCase = new UserRegistration(
            $userRegistrationData, 
            $userRepository, 
            $passwordEncoder,
            $uniqueIDResolver
        );
        $useCase->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_registration_failed_exception_when_username_already_registered()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::USERNAME_ALREADY_REGISTERED);

        $userRegistrationData = new UserRegistrationData(
            new FirstName('John'),
            new LastName('Doe'),
            new Email('john.doe@example.com'),
            new UserName('johndoe123_already_registered'),
            new Password('P@ssw0rd!'),
            new ConfirmPassword(new Password('P@ssw0rd!'), 'P@ssw0rd!')
        );
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(true);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);

        $useCase = new UserRegistration(
            $userRegistrationData, 
            $userRepository, 
            $passwordEncoder,
            $uniqueIDResolver
        );
        $useCase->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_password_exception_when_invalid_password_format_given()
    {
        $this->expectException(PasswordException::class);
        $this->expectExceptionCode(PasswordException::INVALID_FORMAT);

        $userRegistrationData = new UserRegistrationData(
            new FirstName('John'),
            new LastName('Doe'),
            new Email('john.doe@example.com'),
            new UserName('johndoe123'),
            new Password('weak_format'),
            new ConfirmPassword(new Password('weak_format'), 'weak_format')
        );
        
        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);

        $useCase = new UserRegistration(
            $userRegistrationData, 
            $userRepository, 
            $passwordEncoder,
            $uniqueIDResolver
        );
        $useCase->validate();
    }

    /**
     * @test
     */
    public function it_should_throw_confirm_password_exception_when_password_not_matched()
    {
        $this->expectException(ConfirmPasswordException::class);
        $this->expectExceptionCode(ConfirmPasswordException::NOT_MATCHED);

        $userRegistrationData = new UserRegistrationData(
            new FirstName('John'),
            new LastName('Doe'),
            new Email('john.doe@example.com'),
            new UserName('johndoe123'),
            new Password('P@ssw0rd!'),
            new ConfirmPassword(new Password('P@ssw0rd!'), 'wrong_confirmPassword')
        );

        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);

        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);

        $useCase = new UserRegistration(
            $userRegistrationData, 
            $userRepository, 
            $passwordEncoder,
            $uniqueIDResolver
        );
        $useCase->validate();
    }

    /**
     * @test
     */
    public function it_should_register_user()
    {
        $userRegistrationData = new UserRegistrationData(
            new FirstName('John'),
            new LastName('Doe'),
            new Email('john.doe@example.com'),
            new UserName('johndoe123'),
            new Password('P@ssw0rd!'),
            new ConfirmPassword(new Password('P@ssw0rd!'), 'P@ssw0rd!')
        );

        $userRepository = Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('isRegistered')
                       ->andReturn(false);
        $userRepository->shouldReceive('create')
                       ->andReturn(null);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $passwordEncoder->shouldReceive('encodePlainText')
                       ->andReturn('This are some hashed content!');

        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);
        $uniqueIDResolver->shouldReceive('generate')
                        ->andReturn('UUID001');

        $useCase = new UserRegistration(
            $userRegistrationData, 
            $userRepository, 
            $passwordEncoder,
            $uniqueIDResolver
        );
        $useCase->validate();

        $this->assertEquals(null, $useCase->perform());
    }
}
