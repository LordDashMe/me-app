<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use AppCommon\Domain\Message\DataTable;

use UserManagement\Domain\Repository\UserListRepository;
use UserManagement\Domain\UseCase\GetUserListAction;

class GetUserListActionTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new GetUserListAction(
            Mockery::mock(DataTable::class),
            Mockery::mock(UserListRepository::class)
        );

        $this->assertInstanceOf(GetUserListAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_users_data_table()
    {
        $dataTable = new DataTable(0, 10, 'id', 'DESC');

        $userListRepository = Mockery::mock(UserListRepository::class);
        $userListRepository->shouldReceive('start');
        $userListRepository->shouldReceive('length');
        $userListRepository->shouldReceive('search');
        $userListRepository->shouldReceive('orderColumn');
        $userListRepository->shouldReceive('orderBy');
        $userListRepository->shouldReceive('get')
                           ->andReturn([
                               'totalRecords' => 0,
                               'totalRecordsFiltered' => 0,
                               'data' => []
                           ]);

        $useCase = new GetUserListAction($dataTable, $userListRepository);

        $expectedResult = [
            'totalRecords' => 0,
            'totalRecordsFiltered' => 0,
            'data' => []
        ];

        $this->assertEquals($expectedResult, $useCase->perform());
    }
}
