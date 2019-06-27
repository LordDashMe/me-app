<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use UserManagement\Domain\Entity\User;
use UserManagement\Domain\Entity\ModifyUser;
use UserManagement\Domain\Exception\ManageUserFailedException;
use UserManagement\Domain\Message\EditUserData;
use UserManagement\Domain\Repository\ModifyUserRepository;
use UserManagement\Domain\UseCase\EditUser;

class EditUserTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new EditUser(
            Mockery::mock(EditUserData::class),
            Mockery::mock(ModifyUserRepository::class)
        );

        $this->assertInstanceOf(EditUser::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_user_edit()
    {
        $editUserData = new EditUserData(
            'UUID001',
            'John',
            'Doe',
            'john.doe@example.com',
            User::STATUS_ACTIVE
        );

        $modifyUserRepository = Mockery::mock(ModifyUserRepository::class);
        $modifyUserRepository->shouldReceive('save')
                             ->andReturn(null);

        $useCase = new EditUser($editUserData, $modifyUserRepository);
        
        $this->assertEquals(null, $useCase->perform());
    }
}
