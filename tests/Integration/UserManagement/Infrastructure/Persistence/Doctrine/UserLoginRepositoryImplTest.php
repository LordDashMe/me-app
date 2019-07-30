<?php

namespace Tests\Integration\UserManagement\Infrastructure\Persistence\Doctrine;

use Tests\Integration\IntegrationTestBase;

use UserManagement\Domain\Entity\UserLogin;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Infrastructure\Persistence\Repository\Doctrine\UserLoginRepositoryImpl;

class UserLoginRepositoryImplTest extends IntegrationTestBase
{
    protected $isPersistenceNeeded = true;

    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        $this->truncateEntities([
            \UserManagement\Domain\Entity\Model\User::class  
        ]);

        parent::tearDown();
    }

    /**
     * @test
     */
    public function it_should_get_persisted_user_via_username()
    {
        $persistence = new UserLoginRepositoryImpl($this->entityManager);

        $entity = new UserLogin(
            new UserName('johndoe123'),
            new Password('P@ssw0rd!')
        );

        $result = $persistence->get($entity);

        $this->assertTrue(empty($result));
    }
}
