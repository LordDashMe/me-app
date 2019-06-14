<?php

namespace Tests\Unit\UserManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\UseCase\UsersDataTable;
use DomainCommon\Domain\ValueObject\DataTable;

class UsersDataTableTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_the_main_class()
    {
        $userDataTable = new DataTable();

        $userRepository = Mockery::mock(UserRepository::class);

        $useCase = new UsersDataTable($userDataTable, $userRepository);

        $this->assertInstanceOf(UsersDataTable::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_users_data_table()
    {
        $userDataTable = new DataTable();
        $userDataTable->setStart(0);
        $userDataTable->setLength(10);
        $userDataTable->setOrderColumn('id');
        $userDataTable->setOrderBy('DESC');
        
        $userRepository = Mockery::mock(UserRepository::class);

        $userRepository->shouldReceive('getDataTable')
                       ->andReturn([
                           'totalRecords' => 0,
                           'totalRecordsFiltered' => 0,
                           'data' => []
                       ]);

        $useCase = new UsersDataTable($userDataTable, $userRepository);

        $this->assertEquals(
            [
                'totalRecords' => 0,
                'totalRecordsFiltered' => 0,
                'data' => []
            ], 
        $useCase->perform());
    }
}
