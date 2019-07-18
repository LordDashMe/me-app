<?php

namespace Tests\Integration\UserManagement\Infrastructure\Persistence\Doctrine;

use Tests\Integration\IntegrationTestBase;

use AppCommon\Infrastructure\Service\UniqueIDResolverImpl;
use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Entity\UserRegistration;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Infrastructure\Persistence\Repository\Doctrine\UserRegistrationRepositoryImpl;

class UserRegistrationRepositoryImplTest extends IntegrationTestBase
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

    protected function getUserRegistrationRepositoryImpl()
    {
        return new UserRegistrationRepositoryImpl($this->entityManager);
    }

    protected function mockUserRegistrationEntity()
    {
        return new UserRegistration(
            new FirstName('John'),
            new LastName('Doe'),
            new Email('john.doe@example.com'),
            new UserName('johndoe123'),
            new Password('P@ssw0rd!'),
            new CreatedAt()
        );
    }

    /**
     * @test
     */
    public function it_should_validate_if_username_already_persisted()
    {
        $persistence = $this->getUserRegistrationRepositoryImpl();
        
        $entity = $this->mockUserRegistrationEntity();

        $result = $persistence->isUserNameAlreadyRegistered($entity);

        $this->assertEquals(false, $result);
    }

    /**
     * @test
     */
    public function it_should_persist_user_registration()
    {
        $persistence = $this->getUserRegistrationRepositoryImpl();
        
        $entity = $this->mockUserRegistrationEntity();

        $uuid = new UniqueIDResolverImpl();
        $entity->provideUniqueId(new UserId($uuid->generate()));

        $persistence->save($entity);

        $entityPropertyCriteria = [
            'deletedAt' => '',
            'userName' => 'johndoe123'
        ];

        $repository = $this->entityManager->getRepository(UserRegistration::class);
        $user = $repository->findOneBy($entityPropertyCriteria);

        $this->assertEquals('John', $user->firstname());
    }
}
