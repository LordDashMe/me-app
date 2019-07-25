<?php

namespace Tests\Integration\UserManagement\Infrastructure\Persistence\Doctrine;

use Tests\Integration\IntegrationTestBase;

use AppCommon\Infrastructure\Service\UniqueIDResolverImpl;
use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Entity\Model\User;
use UserManagement\Domain\Entity\UserDeletion;
use UserManagement\Domain\Entity\UserRegistration;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Infrastructure\Persistence\Repository\Doctrine\UserDeletionRepositoryImpl;
use UserManagement\Infrastructure\Persistence\Repository\Doctrine\UserRegistrationRepositoryImpl;

class UserDeletionRepositoryImplTest extends IntegrationTestBase
{
    protected $isPersistenceNeeded = true;

    private $userId;

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

    protected function mockCreateUserEntity()
    {
        $persistence = new UserRegistrationRepositoryImpl($this->entityManager);
        
        $entity = new UserRegistration(
            new FirstName('John'),
            new LastName('Doe'),
            new Email('john.doe@example.com'),
            new UserName('johndoe123'),
            new Password('P@ssw0rd!'),
            new CreatedAt()
        );

        $uuid = new UniqueIDResolverImpl();
        $this->userId = new UserId($uuid->generate());
        $entity->provideUniqueId($this->userId);

        $persistence->save($entity);
    }

    protected function getUserDeletionRepositoryImpl()
    {
        return new UserDeletionRepositoryImpl($this->entityManager);
    }

    /**
     * @test
     */
    public function it_should_persist_delete_user()
    {
        $this->mockCreateUserEntity();

        $persistence = $this->getUserDeletionRepositoryImpl();

        $entity = new UserDeletion($this->userId);
        $entity->softDelete(new CreatedAt());

        $response = $persistence->save($entity);

        $criteria = [
            'deletedAt' => '',
            'id' => $this->userId->get()
        ];

        $repository = $this->entityManager->getRepository(UserDeletion::class);
        $user = $repository->findOneBy($criteria);

        $this->assertEquals(null, $user);
    }
}
