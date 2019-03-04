<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use DomainCommon\Domain\ValueObject\CreatedAt;
use UserManagement\Domain\Entity\User;
use UserManagement\Domain\UseCase\UserEdit;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\Username;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Exception\UserManageFailedException;

class UserEditTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_user_edit_class()
    {
        $userId = '';
        $userData = [];

        $userRepository = Mockery::mock(UserRepository::class);

        $this->assertInstanceOf(UserEdit::class, new UserEdit($userId, $userData, $userRepository));
    }

    /**
     * @test
     */
    public function it_should_throw_user_manage_failed_exception_when_user_id_is_empty()
    {
        $this->expectException(UserManageFailedException::class);
        $this->expectExceptionCode(UserManageFailedException::USER_ID_IS_EMPTY);
        
        $userId = '';
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe'
        ];

        $userRepository = Mockery::mock(UserRepository::class);

        $userEdit = new UserEdit($userId, $userData, $userRepository);
        $userEdit->validate();
    }

    /**
     * @test
     */
    public function it_should_perform_user_edit()
    {
        $userId = 'fhqwer1o5';
        $userData = [
            'first_name' => 'Johnny',
            'last_name' => 'Doe',
            'status' => User::STATUS_ACTIVE
        ];

        $userRepository = Mockery::mock(UserRepository::class);

        $userRepository->shouldReceive('find')
                       ->andReturn($this->mockUserEntity());

        $userRepository->shouldReceive('update')
                       ->andReturn($userId);

        $userEdit = new UserEdit($userId, $userData, $userRepository);
        $userEdit->validate();
        
        $this->assertEquals($userId, $userEdit->perform());
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
