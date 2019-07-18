<?php

namespace Tests\Integration;

use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

use Tests\Integration\TruncateEntities;

class IntegrationTestBase extends KernelTestCase
{
    protected $entityManager;
    protected $isPersistenceNeeded = false;

    protected function setUp()
    {
        // Boot up the Symfony Kernel
        self::bootKernel();

        if (! $this->isPersistenceNeeded) { return; }

        // Lets get the entityManager from the container
        $this->entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();

        $metadatas = $this->entityManager->getMetadataFactory()->getAllMetadata();
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->updateSchema($metadatas);
    }

    protected function tearDown()
    {
        parent::tearDown();

        if (! $this->isPersistenceNeeded) { return; }

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    protected function truncateEntities(array $entities)
    {
        $truncate = new TruncateEntities($this->entityManager, $entities);
        $truncate->execute();
    }
}
