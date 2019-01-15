<?php

namespace Tests\Integration\UserManagement\Presentation\Controller;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\UserRegistration;

class UserRegistrationTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_user_registration_service_class()
    {
        $userRepository = Mockery::mock(UserRepository::class);

        $this->assertInstanceOf(UserRegistration::class, new UserRegistration($userRepository));
    }

    /**
     * @test
     */
    public function it_should_register_user()
    {
        $userRepository = Mockery::mock(UserRepository::class);

        $userRepository->shouldReceive('create')
                       ->andReturn(1);

        $userRegistrationService = new UserRegistration($userRepository);
        $userRegistrationService->withUsername('myusername123')
                                ->withPassword('SecretPassword!')
                                ->withFirstname('John')
                                ->withLastname('Doe');
        
        $this->assertEquals(1, $userRegistrationService->execute());
    }
}
