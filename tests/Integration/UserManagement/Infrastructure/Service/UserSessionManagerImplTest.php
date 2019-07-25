<?php

namespace Tests\Integration\UserManagement\Infrastructure\Persistence\Doctrine;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

use Tests\Integration\IntegrationTestBase;

use AppCommon\Domain\ValueObject\CreatedAt;

use UserManagement\Domain\Entity\Model\User;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\FirstName;
use UserManagement\Domain\ValueObject\LastName;
use UserManagement\Domain\ValueObject\Email;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Infrastructure\Service\UserSessionManagerImpl;

class UserSessionManagerImplTest extends IntegrationTestBase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    protected function getUserSessionManagerImpl()
    {
        return new UserSessionManagerImpl(new Session(new MockFileSessionStorage()));
    }

    protected function mockUserEntity()
    {
        return new User(
            new UserId('UUID-0001'),
            new FirstName('John'),
            new LastName('Doe'),
            new Email('john.doe@example.com'),
            new UserName('johndoe123'),
            new Password('P@ssw0rd!'),
            User::STATUS_ACTIVE,
            new CreatedAt('2019-07-18 17:00:00')
        );
    }

    /**
     * @test
     */
    public function it_should_set_and_get_user_session()
    {
        $entity = $this->mockUserEntity();

        $userSessionManager = $this->getUserSessionManagerImpl();
        $userSessionManager->set($entity);

        $this->assertEquals($entity, $userSessionManager->get());
    }

    /**
     * @test
     */
    public function it_should_forget_user_session()
    {
        $entity = $this->mockUserEntity();

        $userSessionManager = $this->getUserSessionManagerImpl();
        $userSessionManager->set($entity);
        $userSessionManager->forget();

        $this->assertEquals(null, $userSessionManager->get());   
    }

    /**
     * @test
     */
    public function it_should_validate_if_user_session_already_available()
    {
        $userSessionManager = $this->getUserSessionManagerImpl(); 
        
        $this->assertEquals(false, $userSessionManager->isUserSessionAvailable());
    }
}
