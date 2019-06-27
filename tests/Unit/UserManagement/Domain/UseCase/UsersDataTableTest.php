<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use AppCommon\Domain\Message\DataTable;

use UserManagement\Domain\Repository\UserDataTableRepository;
use UserManagement\Domain\UseCase\UsersDataTable;

class UsersDataTableTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $useCase = new UsersDataTable(
            Mockery::mock(DataTable::class),
            Mockery::mock(UserDataTableRepository::class)
        );

        $this->assertInstanceOf(UsersDataTable::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_users_data_table()
    {
        $dataTable = new DataTable(0, 10, 'id', 'DESC');

        $userDataTableRepository = Mockery::mock(UserDataTableRepository::class);
        $userDataTableRepository->shouldReceive('start');
        $userDataTableRepository->shouldReceive('length');
        $userDataTableRepository->shouldReceive('search');
        $userDataTableRepository->shouldReceive('orderColumn');
        $userDataTableRepository->shouldReceive('orderBy');
        $userDataTableRepository->shouldReceive('get')
                            ->andReturn([
                                'totalRecords' => 0,
                                'totalRecordsFiltered' => 0,
                                'data' => []
                            ]);

        $useCase = new UsersDataTable($dataTable, $userDataTableRepository);

        $expectedResult = [
            'totalRecords' => 0,
            'totalRecordsFiltered' => 0,
            'data' => []
        ];

        $this->assertEquals($expectedResult, $useCase->perform());
    }
}
