<?php

namespace Tests\Unit\ExpenseManagement\Domain\UseCase;

use Mockery as Mockery;

use PHPUnit\Framework\TestCase;

use AppCommon\Domain\Service\UniqueIDResolver;

use ExpenseManagement\Domain\Message\AddExpenseData;
use ExpenseManagement\Domain\Repository\AddExpenseRepository;
use ExpenseManagement\Domain\UseCase\AddExpenseAction;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\ValueObject\Type;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;

class AddExpenseTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_load_main_class()
    {
        $useCase = new AddExpenseAction(
            Mockery::mock(AddExpenseData::class), 
            Mockery::mock(AddExpenseRepository::class),
            Mockery::mock(UniqueIDResolver::class)
        );

        $this->assertInstanceOf(AddExpenseAction::class, $useCase);
    }

    /**
     * @test
     */
    public function it_should_perform_add_expense()
    {
        $addExpenseData = new AddExpenseData('UUID001', '4', 'Brewed Coffee', 22, '2019-07-01');

        $addExpenseRepository = Mockery::mock(AddExpenseRepository::class);
        $addExpenseRepository->shouldReceive('save')
                             ->andReturn(true);

        $uniqueIDResolver = Mockery::mock(UniqueIDResolver::class);
        $uniqueIDResolver->shouldReceive('generate')
                         ->andReturn('UUID001');

        $useCase = new AddExpenseAction(
            $addExpenseData, 
            $addExpenseRepository,
            $uniqueIDResolver
        );
        
        $this->assertEquals(null, $useCase->perform());
    }
}
