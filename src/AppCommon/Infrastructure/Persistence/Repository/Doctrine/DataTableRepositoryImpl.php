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

    public function entityNamespace(): string { return ''; }

    protected function customCondition($queryBuilder) { return $queryBuilder; }

    public function get(): array 
    {
        $data = $this->getData();
        
        return [
            'totalRecords' => \count($data),
            'totalRecordsFiltered' => $this->getTotalRecords(),
            'data' => $data
        ];
    }

    private function getData()
    {
        $queryBuilder = $this->entityManager->getRepository($this->entityNamespace())->createQueryBuilder('u');

        $selectString = '';
        foreach ($this->tableDefinition as $definition) {
            $selectString .= "u.{$definition['db_name']} as {$definition['app_name']},";
        }
        $queryBuilder->select(\substr($selectString, 0, -1));
        $queryBuilder->where("u.deletedAt = ''");

        $queryBuilder = $this->customCondition($queryBuilder);

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
        
        return $queryBuilder->getQuery()->getResult();
    }

    private function getTotalRecords()
    {
        $totalQueryBuilder = $this->entityManager->getRepository($this->entityNamespace())->createQueryBuilder('u');
        $totalQueryBuilder->select('COUNT(u.id)');
        $totalQueryBuilder->where("u.deletedAt = ''");

        $totalQueryBuilder = $this->customCondition($totalQueryBuilder);
        
        $totalSearchString = '';
        foreach ($this->tableDefinition as $definition) {
            if ($definition['search']) {
                $totalSearchString .= "u.{$definition['db_name']} LIKE :{$definition['app_name']} OR ";
                $totalQueryBuilder->setParameter($definition['app_name'], "%{$this->search}%");
            }
        }

        if ($totalSearchString !== '') {
            $totalQueryBuilder->andWhere(\substr($totalSearchString, 0, -4));
        }

        return $totalQueryBuilder->getQuery()->getSingleScalarResult();
    }
}
