<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\Exception\LogoutFailedException;
use UserManagement\Domain\Service\UserSessionManager;

class UserLogout implements UseCaseInterface
{
    private $userSessionManager;

    public function __construct(UserSessionManager $userSessionManager) 
    {
        $this->userSessionManager = $userSessionManager;
    }

    public function perform()
    {
        $this->validateUserSessionExistence();

        $this->userSessionManager->forget();
    }

    private function validateUserSessionExistence()
    {
        if (! $this->userSessionManager->isUserSessionAvailable()) {
            throw LogoutFailedException::noUserSessionFound();     
        }
    }
}
