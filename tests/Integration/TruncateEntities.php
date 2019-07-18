<?php

namespace Tests\Integration;

use Doctrine\ORM\EntityManagerInterface;

class TruncateEntities
{
    protected $entityManager;
    protected $entities;

    public function __construct(EntityManagerInterface $entityManager, array $entities) 
    {
        $this->entityManager = $entityManager;
        $this->entities = $entities;
    }

    public function execute()
    {
        $connection = $this->entityManager->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();

        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
        }

        foreach ($this->entities as $entity) {
            $query = $databasePlatform->getTruncateTableSQL(
                $this->entityManager->getClassMetadata($entity)->getTableName()
            );
            $connection->executeUpdate($query);
        }
        
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
