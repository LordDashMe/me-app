<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use UserManagement\Domain\Exception\ManageUserFailedException;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\UseCase\DeleteUser;
use UserManagement\Domain\ValueObject\UserId;

class DeleteUserTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $userId = new UserId('');

        $userRepository = Mockery::mock(UserRepository::class);

        $useCase = new DeleteUser($userId, $userRepository);

        $this->assertInstanceOf(DeleteUser::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_throw_manage_user_failed_exception_when_user_id_is_empty()
    {
        $this->expectException(ManageUserFailedException::class);
        $this->expectExceptionCode(ManageUserFailedException::USER_ID_IS_EMPTY);
        
        $userId = new UserId('');

        $userRepository = Mockery::mock(UserRepository::class);

        $useCase = new DeleteUser($userId, $userRepository);
        $useCase->validate();
    }

    /**
     * @test
     */
    public function it_should_perform_delete_user()
    {
        $userId = new UserId('UUID001');

        $userRepository = Mockery::mock(UserRepository::class);

        $userRepository->shouldReceive('softDelete')
                       ->andReturn($userId->get());

        $useCase = new DeleteUser($userId, $userRepository);
        $useCase->validate();
        
        $this->assertEquals($userId->get(), $useCase->perform());
    }
}
