<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use DomainCommon\Domain\ValueObject\CreatedAt;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\UseCase\EditUser;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\UserRole;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\UserStatus;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Exception\ManageUserFailedException;

class EditUserTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $userId = '';
        $editUserRequestData = [];

        $userRepository = Mockery::mock(UserRepository::class);

        $this->assertInstanceOf(EditUser::class, new EditUser($userId, $editUserRequestData, $userRepository));
    }

    /**
     * @test
     */
    public function it_should_throw_manage_user_failed_exception_when_user_id_is_empty()
    {
        $this->expectException(ManageUserFailedException::class);
        $this->expectExceptionCode(ManageUserFailedException::USER_ID_IS_EMPTY);
        
        $userId = '';
        $editUserRequestData = [
            'firstName' => 'John',
            'lastName' => 'Doe'
        ];

        $userRepository = Mockery::mock(UserRepository::class);

        $editUser = new EditUser($userId, $editUserRequestData, $userRepository);
        $editUser->validate();
    }

    /**
     * @test
     */
    public function it_should_perform_user_edit()
    {
        $userId = 'UUID001';
        $editUserRequestData = [
            'firstName' => 'Johnny',
            'lastName' => 'Doe',
            'status' => User::STATUS_ACTIVE,
            'role' => User::ROLE_MEMBER
        ];

        $userRepository = Mockery::mock(UserRepository::class);

        $userRepository->shouldReceive('get')
                       ->andReturn($this->mockUserEntity());

        $userRepository->shouldReceive('update')
                       ->andReturn($userId);

        $editUser = new EditUser($userId, $editUserRequestData, $userRepository);
        $editUser->validate();
        
        $this->assertEquals($userId, $editUser->perform());
    }

    private function mockUserEntity()
    {
        return new User(
            new UserId('UUID001'),
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
