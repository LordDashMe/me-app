<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use AppCommon\Domain\Service\UniqueIDResolver;

use UserManagement\Domain\Exception\EmailException;
use UserManagement\Domain\Exception\PasswordException;
use UserManagement\Domain\Exception\ConfirmPasswordException;
use UserManagement\Domain\Exception\RegistrationFailedException;
use UserManagement\Domain\Message\UserRegistrationData;
use UserManagement\Domain\Repository\UserRegistrationRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\UseCase\UserRegistrationAction;

class UserRegistrationActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new UserRegistrationAction(
            Mockery::mock(UserRegistrationData::class), 
            Mockery::mock(UserRegistrationRepository::class), 
            Mockery::mock(PasswordEncoder::class),
            Mockery::mock(UniqueIDResolver::class)
        );

        $this->assertInstanceOf(UserRegistrationAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_throw_email_exception_when_invalid_email_format_was_given()
    {
        $this->expectException(EmailException::class);
        $this->expectExceptionCode(EmailException::INVALID_FORMAT);

        $userRegistrationData = new UserRegistrationData(
            'John', 'Doe', 'invalid_format', 'johndoe123', 'P@ssw0rd!', 'P@ssw0rd!'
        );
        
        $userRegistrationRepository = Mockery::mock(UserRegistrationRepository::class);
        $userRegistrationRepository->shouldReceive('isUserNameAlreadyRegistered')
                                   ->andReturn(false);

        $useCase = new UserRegistrationAction(
            $userRegistrationData, 
            $userRegistrationRepository, 
            Mockery::mock(PasswordEncoder::class),
            Mockery::mock(UniqueIDResolver::class)
        );

        $useCase->perform();
    }

    /**
     * @test
     */
    public function it_should_throw_password_exception_when_invalid_password_format_given()
    {
        $this->expectException(PasswordException::class);
        $this->expectExceptionCode(PasswordException::INVALID_FORMAT);

        $userRegistrationData = new UserRegistrationData(
            'John', 'Doe', 'registered@example.com', 'johndoe123', 'tooweak', 'tooweak'
        );
        
        $userRegistrationRepository = Mockery::mock(UserRegistrationRepository::class);
        $userRegistrationRepository->shouldReceive('isUserNameAlreadyRegistered')
                                   ->andReturn(false);

        $useCase = new UserRegistrationAction(
            $userRegistrationData, 
            $userRegistrationRepository, 
            Mockery::mock(PasswordEncoder::class),
            Mockery::mock(UniqueIDResolver::class)
        );

        $useCase->perform();
    }

    /**
     * @test
     */
    public function it_should_throw_confirm_password_exception_when_password_not_matched()
    {
        $this->expectException(ConfirmPasswordException::class);
        $this->expectExceptionCode(ConfirmPasswordException::NOT_MATCHED);

        $userRegistrationData = new UserRegistrationData(
            'John', 'Doe', 'registered@example.com', 'johndoe123', 'P@ssw0rd!', 'Password!'
        );
        
        $userRegistrationRepository = Mockery::mock(UserRegistrationRepository::class);
        $userRegistrationRepository->shouldReceive('isUserNameAlreadyRegistered')
                                   ->andReturn(false);

        $useCase = new UserRegistrationAction(
            $userRegistrationData, 
            $userRegistrationRepository, 
            Mockery::mock(PasswordEncoder::class),
            Mockery::mock(UniqueIDResolver::class)
        );

        $useCase->perform();
    }

    /**
     * @test
     */
    public function it_should_throw_registration_failed_exception_when_username_already_registered()
    {
        $this->expectException(RegistrationFailedException::class);
        $this->expectExceptionCode(RegistrationFailedException::USERNAME_ALREADY_REGISTERED);

        $userRegistrationData = new UserRegistrationData(
            'John', 'Doe', 'registered@example.com', 'johndoe123', 'P@ssw0rd!', 'P@ssw0rd!'
        );
        
        $userRegistrationRepository = Mockery::mock(UserRegistrationRepository::class);
        $userRegistrationRepository->shouldReceive('isUserNameAlreadyRegistered')
                                   ->andReturn(true);

        $useCase = new UserRegistrationAction(
            $userRegistrationData, 
            $userRegistrationRepository, 
            Mockery::mock(PasswordEncoder::class),
            Mockery::mock(UniqueIDResolver::class)
        );

        $useCase->perform();
    }

    /**
     * @test
     */
    public function it_should_register_user()
    {
        $userRegistrationData = new UserRegistrationData(
            'John', 'Doe', 'registered@example.com', 'johndoe123', 'P@ssw0rd!', 'P@ssw0rd!'
        );

        $userRegistrationRepository = Mockery::mock(UserRegistrationRepository::class);
        $userRegistrationRepository->shouldReceive('isUserNameAlreadyRegistered')
                                   ->andReturn(false);
        $userRegistrationRepository->shouldReceive('save')
                                   ->andReturn(null);

        $passwordEncoder = Mockery::mock(PasswordEncoder::class);
        $passwordEncoder->shouldReceive('encodePlainText')
                        ->andReturn('an encrypted content!');

        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);
        $uniqueIDResolver->shouldReceive('generate')
                         ->andReturn('UUID001');

        $useCase = new UserRegistrationAction(
            $userRegistrationData, 
            $userRegistrationRepository, 
            $passwordEncoder,
            $uniqueIDResolver
        );

        $this->assertEquals(null, $useCase->perform());
    }
}
