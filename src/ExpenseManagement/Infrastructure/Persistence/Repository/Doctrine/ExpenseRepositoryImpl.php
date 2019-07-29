<?php

namespace ExpenseManagement\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use DomainCommon\Domain\ValueObject\CreatedAt;
use UserManagement\Domain\ValueObject\UserId;
use ExpenseManagement\Domain\Entity\Model\Expense;
use ExpenseManagement\Domain\ValueObject\ExpenseId;

class ExpenseRepositoryImpl
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Expense $expenseEntity)
    {
        $this->entityManager->persist($expenseEntity);
        $this->entityManager->flush();
    }

    public function update(Expense $expenseEntity)
    {
        $this->entityManager->merge($expenseEntity);
        $this->entityManager->flush();   
    }

    public function get(ExpenseId $expenseId)
    {
        $criteria = [
            'deletedAt' => '',
            'id' => $id->get()
        ];
        
        $userEntity = $this->entityManager->getRepository(Expense::class)->findBy($criteria);
        
        return $userEntity[0];
    }

    public function getDataTable(UserId $userId, $options)
    {
        $total = $this->entityManager->getRepository(Expense::class)->createQueryBuilder('ue')
            ->select('COUNT(ue.ID)')
            ->getQuery()
            ->getSingleScalarResult();

        $queryBuilder = $this->entityManager->getRepository(Expense::class)->createQueryBuilder('ue');
        $queryBuilder->where("ue.DeletedAt = '' AND ue.UserID = :userId");
        $queryBuilder->andWhere("ue.ID LIKE :id OR ue.Label LIKE :label");
        $queryBuilder->setParameter('userId', "'{$userId->get()}'");
        $queryBuilder->setParameter('id', "%{$options['search']}%");
        $queryBuilder->setParameter('label', "%{$options['search']}%");
        $queryBuilder->orderBy("ue.{$options['orderColumn']}", \strtoupper($options['orderBy']));
        
        if ($options['length'] > 0) {
            $queryBuilder->setMaxResults($options['length']);
        }
        
        $queryBuilder->setFirstResult($options['start']);
        
        $data = $queryBuilder->getQuery()->getResult();
        
        return [
            'totalRecords' => $total,
            'totalRecordsFiltered' => \count($data),
            'data' => $data
        ];   
    }

    public function softDelete(ExpenseId $expenseId)
    {
        $criteria = [
            'id' => $id->get()
        ];

        $expenseEntity = $this->entityManager->getRepository(Expense::class)->findBy($criteria);
        $expenseEntity[0]->setDeletedAt((new CreatedAt())->get());

        $this->entityManager->flush();

        return $id->get();
    }

    public function getUserTotalDaysEntries(UserId $userId)
    {
        return $this->entityManager->getRepository(Expense::class)->createQueryBuilder('ue')
            ->select('COUNT(ue.ID)')
            ->where("ue.UserID = :userId")
            ->setParameter('userId', "'{$userId->get()}'")
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getUserTotalExpenses(UserId $userId)
    {
        return $this->entityManager->getRepository(Expense::class)->createQueryBuilder('ue')
            ->select('SUM(ue.Cost)')
            ->where("ue.UserID = :userId")
            ->setParameter('userId', "'{$userId->get()}'")
            ->getQuery()
            ->getSingleScalarResult();
    }
}
