<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use UserManagement\Domain\UseCase\DeleteUser;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Exception\ManageUserFailedException;

class DeleteUserTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $userId = '';

        $userRepository = Mockery::mock(UserRepository::class);

        $this->assertInstanceOf(DeleteUser::class, new DeleteUser($userId, $userRepository));
    }

    /**
     * @test
     */
    public function it_should_throw_manage_user_failed_exception_when_user_id_is_empty()
    {
        $this->expectException(ManageUserFailedException::class);
        $this->expectExceptionCode(ManageUserFailedException::USER_ID_IS_EMPTY);
        
        $userId = '';

        $userRepository = Mockery::mock(UserRepository::class);

        $deleteUser = new DeleteUser($userId, $userRepository);
        $deleteUser->validate();
    }

    /**
     * @test
     */
    public function it_should_perform_delete_user()
    {
        $userId = 'UUID001';

        $userRepository = Mockery::mock(UserRepository::class);

        $userRepository->shouldReceive('softDelete')
                       ->andReturn($userId);

        $deleteUser = new DeleteUser($userId, $userRepository);
        $deleteUser->validate();
        
        $this->assertEquals($userId, $deleteUser->perform());
    }
}
