<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;
use PHPUnit\Framework\TestCase;
use UserManagement\Domain\UseCase\UserDelete;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Exception\UserManageFailedException;

class UserDeleteTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_user_delete_class()
    {
        $userId = '';

        $userRepository = Mockery::mock(UserRepository::class);

        $this->assertInstanceOf(UserDelete::class, new UserDelete($userId, $userRepository));
    }

    /**
     * @test
     */
    public function it_should_throw_user_manage_failed_exception_when_user_id_is_empty()
    {
        $this->expectException(UserManageFailedException::class);
        $this->expectExceptionCode(UserManageFailedException::USER_ID_IS_EMPTY);
        
        $userId = '';

        $userRepository = Mockery::mock(UserRepository::class);

        $userDelete = new UserDelete($userId, $userRepository);
        $userDelete->validate();
    }

    /**
     * @test
     */
    public function it_should_perform_delete_user()
    {
        $userId = 'fhqwer1o5';

        $userRepository = Mockery::mock(UserRepository::class);

        $userRepository->shouldReceive('softDelete')
                       ->andReturn($userId);

        $userDelete = new UserDelete($userId, $userRepository);
        $userDelete->validate();
        
        $this->assertEquals($userId, $userDelete->perform());
    }
}
