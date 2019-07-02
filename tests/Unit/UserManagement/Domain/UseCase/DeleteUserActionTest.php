<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use UserManagement\Domain\Message\DeleteUserData;
use UserManagement\Domain\Repository\UserDeletionRepository;
use UserManagement\Domain\UseCase\DeleteUserAction;

class DeleteUserActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new DeleteUserAction(
            Mockery::mock(DeleteUserData::class), 
            Mockery::mock(UserDeletionRepository::class)
        );

        $this->assertInstanceOf(DeleteUserAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_delete_user()
    {
        $deleteUserData = new DeleteUserData('UUID001');

        $userDeletionRepository = Mockery::mock(UserDeletionRepository::class);
        $userDeletionRepository->shouldReceive('save')
                               ->andReturn($deleteUserData->userId);

        $useCase = new DeleteUserAction(
            $deleteUserData, 
            $userDeletionRepository
        );
        
        $this->assertEquals($deleteUserData->userId, $useCase->perform());
    }
}
