<?php

namespace AppCommon\Infrastructure\Persistence\Repository\Doctrine;

use Doctrine\ORM\EntityManagerInterface;

class DataTableRepositoryImpl
{
    protected $entityManager;
    protected $start;
    protected $length;
    protected $search;
    protected $orderColumn;
    protected $orderBy;
    protected $tableDefinition = [];
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function start(int $start): void 
    {
        $this->start = $start;
    }

    public function length(int $length): void 
    {
        $this->length = $length;
    }

    public function search(string $search): void 
    {
        $this->search = $search;
    }

    public function orderColumn(string $orderColumn): void 
    {
        $this->orderColumn = $orderColumn;
    }

    public function orderBy(string $orderBy): void 
    {
        $this->orderBy = $orderBy;
    }

    public function entityNamespace(): string {}

    public function get(): array 
    {
        $total = $this->entityManager->getRepository($this->entityNamespace())->createQueryBuilder('u')
            ->select('COUNT(u.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $queryBuilder = $this->entityManager->getRepository($this->entityNamespace())->createQueryBuilder('u');

        $selectString = '';

        foreach ($this->tableDefinition as $definition) {
            $selectString .= "u.{$definition['db_name']} as {$definition['app_name']},";
        }
        $queryBuilder->select(\substr($selectString, 0, -1));
        $queryBuilder->where("u.deletedAt = ''");

        $searchString = '';

        foreach ($this->tableDefinition as $definition) {
            if ($definition['search']) {
                $searchString .= "u.{$definition['db_name']} LIKE :{$definition['app_name']} OR ";
                $queryBuilder->setParameter($definition['app_name'], "%{$this->search}%");
            }
        }
        
        if ($searchString !== '') {
            $queryBuilder->andWhere(\substr($searchString, 0, -4));
        }
        
        $queryBuilder->orderBy("u.{$this->orderColumn}", \strtoupper($this->orderBy));
        
        if ($this->length > 0) {
            $queryBuilder->setMaxResults($this->length);
        }
        
        $queryBuilder->setFirstResult($this->start);
        
        $data = $queryBuilder->getQuery()->getResult();
        
        return [
            'totalRecords' => $total,
            'totalRecordsFiltered' => \count($data),
            'data' => $data
        ];
    }
}
