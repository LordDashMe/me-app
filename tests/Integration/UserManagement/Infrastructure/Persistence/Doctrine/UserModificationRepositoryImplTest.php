<?php

namespace Tests\Integration\UserManagement\Infrastructure\Persistence\Doctrine;

use Tests\Integration\IntegrationTestBase;

use AppCommon\Domain\ValueObject\CreatedAt;
use AppCommon\Infrastructure\Service\UniqueIDResolverImpl;

use UserManagement\Domain\Entity\Model\User;
use UserManagement\Domain\Entity\UserRegistration;
use UserManagement\Domain\Entity\UserModification;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\Status;
use UserManagement\Infrastructure\Persistence\Repository\Doctrine\UserRegistrationRepositoryImpl;
use UserManagement\Infrastructure\Persistence\Repository\Doctrine\UserModificationRepositoryImpl;

class UserModificationRepositoryImplTest extends IntegrationTestBase
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

    /**
     * @test
     */
    public function it_should_persist_update_user_details()
    {
        $this->mockUserRegistrationEntity();

        $persistence = new UserModificationRepositoryImpl($this->entityManager);

        $entity = new UserModification($this->userId);
        $entity->changeFirstName(new FirstName('John I'));
        $entity->changeLastName(new LastName('Doe'));
        $entity->changeEmail(new Email('john.doe@example.com'));
        $entity->changeStatus(new Status(User::STATUS_ACTIVE));

        $response = $persistence->save($entity);

        $criteria = [
            'deletedAt' => '',
            'id' => $this->userId->get()
        ];

        $repository = $this->entityManager->getRepository(UserModification::class);
        $user = $repository->findOneBy($criteria);

        $this->assertEquals($response, new UserId($user->id()));
    }

    private function mockUserRegistrationEntity()
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
}
