<?php

namespace Tests\Integration\UserManagement\Infrastructure\Persistence\Doctrine;

use Tests\Integration\IntegrationTestBase;

use AppCommon\Domain\ValueObject\CreatedAt;
use AppCommon\Infrastructure\Service\UniqueIDResolverImpl;

use UserManagement\Domain\Entity\UserRegistration;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Infrastructure\Persistence\Repository\Doctrine\UserListRepositoryImpl;
use UserManagement\Infrastructure\Persistence\Repository\Doctrine\UserRegistrationRepositoryImpl;

class UserListRepositoryImplTest extends IntegrationTestBase
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

    /**
     * @test
     */
    public function it_should_load_user_list_datatable()
    {
        $this->mockCreateUserEntity();

        $persistence = new UserListRepositoryImpl($this->entityManager);
        $persistence->start(0);
        $persistence->length(10);
        $persistence->search('');
        $persistence->orderColumn('id');
        $persistence->orderBy('DESC');

        $result = $persistence->get();

        $this->assertEquals('John', $result['data'][0]['first_name']);
    }
}
