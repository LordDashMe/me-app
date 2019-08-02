<?php

namespace UserManagement\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppCommon\Application\Controller\Security\AuthenticatedController;

use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\UseCase\UserLogoutAction;

class LogoutController extends Controller implements AuthenticatedController
{
    private $userSessionManager;

    public function __construct(UserSessionManager $userSessionManager)
    {
        $this->userSessionManager = $userSessionManager;
    }

    public function logoutAction()
    {
        $useCase = new UserLogoutAction($this->userSessionManager);
        $useCase->perform();
        
        return $this->redirectToRoute('user_management_login');
    }
}
