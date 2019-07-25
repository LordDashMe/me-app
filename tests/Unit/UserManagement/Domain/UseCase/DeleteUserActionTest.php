<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use UserManagement\Domain\Message\DeleteUserData;
use UserManagement\Domain\Repository\UserDeletionRepository;
use UserManagement\Domain\UseCase\DeleteUserAction;
use UserManagement\Domain\ValueObject\UserId;

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

        $userId = new UserId($deleteUserData->userId);

        $userDeletionRepository = Mockery::mock(UserDeletionRepository::class);
        $userDeletionRepository->shouldReceive('save')
                               ->andReturn($userId);

        $useCase = new DeleteUserAction(
            $deleteUserData, 
            $userDeletionRepository
        );
        
        $this->assertEquals($userId, $useCase->perform());
    }
}
