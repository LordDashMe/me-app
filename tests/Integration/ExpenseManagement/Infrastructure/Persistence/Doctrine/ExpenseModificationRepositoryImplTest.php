<?php

namespace Tests\Integration\UserManagement\Infrastructure\Persistence\Doctrine;

use Tests\Integration\IntegrationTestBase;

use AppCommon\Infrastructure\Service\UniqueIDResolverImpl;
use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\ValueObject\UserId;

use ExpenseManagement\Domain\Entity\SubmitExpense;
use ExpenseManagement\Domain\Entity\ExpenseModification;
use ExpenseManagement\Domain\ValueObject\ExpenseId;
use ExpenseManagement\Domain\ValueObject\Type;
use ExpenseManagement\Domain\ValueObject\Label;
use ExpenseManagement\Domain\ValueObject\Cost;
use ExpenseManagement\Domain\ValueObject\Date;
use ExpenseManagement\Infrastructure\Persistence\Repository\Doctrine\SubmitExpenseRepositoryImpl;
use ExpenseManagement\Infrastructure\Persistence\Repository\Doctrine\ExpenseModificationRepositoryImpl;

class ExpenseModificationRepositoryImplTest extends IntegrationTestBase
{
    protected $isPersistenceNeeded = true;

    private $expenseId;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        $this->truncateEntities([
            \ExpenseManagement\Domain\Entity\Model\Expense::class  
        ]);

        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_should_persist_expense_modification()
    {
        $this->mockSubmitExpenseEntity();

        $persistence = new ExpenseModificationRepositoryImpl($this->entityManager);

        $entity = new ExpenseModification(
            $this->expenseId,
            new UserId('UUID01') 
        );

        $entity->changeType(new Type(1));
        $entity->changeLabel(new Label('Globe Load I'));
        $entity->changeCost(new Cost(125));
        $entity->changeDate(new Date('2019-07-29'));

        $persistence->save($entity);

        $criteria = [
            'deletedAt' => '',
            'id' => $this->expenseId->get()
        ];

        $repository = $this->entityManager->getRepository(ExpenseModification::class);
        $expense = $repository->findOneBy($criteria);

        $this->assertEquals($expense->label(), 'Globe Load I');
    }

    private function mockSubmitExpenseEntity()
    {
        $persistence = new SubmitExpenseRepositoryImpl($this->entityManager);

        $entity = new SubmitExpense(
            new UserId('UUID01'),
            new Type(1),
            new Label('Globe Load'),
            new Cost(120),
            new Date('2019-07-29'),
            new CreatedAt()
        );

        $uuid = new UniqueIDResolverImpl();
        $this->expenseId = new ExpenseId($uuid->generate());
        
        $entity->provideUniqueId($this->expenseId);
        
        $persistence->save($entity);
    }
}
