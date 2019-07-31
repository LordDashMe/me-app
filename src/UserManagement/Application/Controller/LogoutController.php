<?php

namespace UserManagement\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppCommon\Application\Controller\Security\AuthenticatedController;

use UserManagement\Domain\UseCase\UserLogoutAction;
use UserManagement\Infrastructure\Service\UserSessionManagerImpl;

class LogoutController extends Controller implements AuthenticatedController
{
    private $userSessionManagerImpl;

    public function __construct(UserSessionManagerImpl $userSessionManagerImpl)
    {
        $this->userSessionManagerImpl = $userSessionManagerImpl;
    }

    public function logoutAction()
    {
        $useCase = new UserLogoutAction($this->userSessionManagerImpl);
        $useCase->perform();
        
        return $this->redirectToRoute('user_management_login');
    }
}
