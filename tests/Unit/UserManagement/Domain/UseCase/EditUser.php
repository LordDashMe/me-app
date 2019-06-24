<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use DomainCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\DataTransferObject\EditUserData;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\Exception\ManageUserFailedException;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\UseCase\EditUser;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Role;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\Status;

class EditUserTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $userId = new UserId('');

        $editUserData = new EditUserData(
            new FirstName(''),
            new LastName(''),
            new Status(''),
            new Role('')
        );

        $userRepository = Mockery::mock(UserRepository::class);

        $useCase = new EditUser($userId, $editUserData, $userRepository);

        $this->assertInstanceOf(EditUser::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_throw_manage_user_failed_exception_when_user_id_is_empty()
    {
        $this->expectException(ManageUserFailedException::class);
        $this->expectExceptionCode(ManageUserFailedException::USER_ID_IS_EMPTY);
        
        $userId = new UserId('');

        $editUserData = new EditUserData(
            new FirstName('John'),
            new LastName('Doe'),
            new Status(),
            new Role()
        );

        $userRepository = Mockery::mock(UserRepository::class);

        $useCase = new EditUser($userId, $editUserData, $userRepository);
        $useCase->validate();
    }

    /**
     * @test
     */
    public function it_should_perform_user_edit()
    {
        $userId = new UserId('UUID001');

        $editUserData = new EditUserData(
            new FirstName('John'),
            new LastName('Doe'),
            new Status(User::STATUS_ACTIVE),
            new Role(User::ROLE_MEMBER)
        );

        $userRepository = Mockery::mock(UserRepository::class);

        $userRepository->shouldReceive('get')
                       ->andReturn($this->mockUserEntity());

        $userRepository->shouldReceive('update')
                       ->andReturn(null);

        $useCase = new EditUser($userId, $editUserData, $userRepository);
        $useCase->validate();
        
        $this->assertEquals(null, $useCase->perform());
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
            new Status(User::STATUS_ACTIVE),
            new Role(User::ROLE_MEMBER),
            new CreatedAt()
        );
    }
}
