<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use UserManagement\Domain\Message\DeleteUserData;
use UserManagement\Domain\Repository\ModifyUserRepository;
use UserManagement\Domain\UseCase\DeleteUser;

class DeleteUserTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new DeleteUser(
            Mockery::mock(DeleteUserData::class), 
            Mockery::mock(ModifyUserRepository::class)
        );

        $this->assertInstanceOf(DeleteUser::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_delete_user()
    {
        $deleteUserData = new DeleteUserData('UUID001');

        $modifyUserRepository = Mockery::mock(ModifyUserRepository::class);
        $modifyUserRepository->shouldReceive('softDelete')
                             ->andReturn($deleteUserData->userId);

        $useCase = new DeleteUser(
            $deleteUserData, 
            $modifyUserRepository
        );
        
        $this->assertEquals($deleteUserData->userId, $useCase->perform());
    }
}
