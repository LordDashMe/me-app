<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\UseCaseInterface;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\Exception\LogoutFailedException;

class UserLogout implements UseCaseInterface
{
    private $userSessionManager;

    public function __construct(UserSessionManager $userSessionManager) 
    {
        $this->userSessionManager = $userSessionManager;
    }

    public function validate()
    {
        if (! $this->userSessionManager->isUserSessionAvailable()) {
            throw LogoutFailedException::noUserSessionFound();     
        }
    }

    public function perform()
    {
        $this->userSessionManager->forget();
    }
}
