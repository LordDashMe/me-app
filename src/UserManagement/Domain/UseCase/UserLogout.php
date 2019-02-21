<?php

namespace UserManagement\Domain\UseCase;

use UserManagement\Domain\Service\UserSessionManager;

class UserLogout
{
    private $userSessionManager;

    public function __construct(UserSessionManager $userSessionManager) 
    {
        $this->userSessionManager = $userSessionManager;
    }

    public function perform()
    {
        $this->userSessionManager->forget();
    }
}
