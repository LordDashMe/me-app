<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use UserManagement\Domain\Entity\Model\User;
use UserManagement\Domain\Message\EditUserData;
use UserManagement\Domain\Repository\UserModificationRepository;
use UserManagement\Domain\UseCase\EditUserAction;

class EditUserActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new EditUserAction(
            Mockery::mock(EditUserData::class),
            Mockery::mock(UserModificationRepository::class)
        );

        $this->assertInstanceOf(EditUserAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_edit_user()
    {
        $editUserData = new EditUserData(
            'UUID001',
            'John',
            'Doe',
            'john.doe@example.com',
            User::STATUS_ACTIVE
        );

        $userModificationRepository = Mockery::mock(UserModificationRepository::class);
        $userModificationRepository->shouldReceive('save')
                                  ->andReturn(null);

        $useCase = new EditUserAction($editUserData, $userModificationRepository);
        
        $this->assertEquals(null, $useCase->perform());
    }
}
