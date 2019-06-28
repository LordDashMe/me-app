<?php

namespace UserManagement\Presentation\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppCommon\Presentation\Controller\Security\AuthenticatedController;

use UserManagement\Domain\UseCase\UserLogoutAction;
use UserManagement\Domain\Service\UserSessionManager;

class HomeController extends Controller implements AuthenticatedController
{
    private $userSessionManager;

    public function __construct(UserSessionManager $userSessionManager)
    {
        $this->userSessionManager = $userSessionManager;
    }

    public function indexAction(Request $request)
    {
        $userEntity = $this->userSessionManager->get(
            $this->userSessionManager->getUserEntitySessionName()
        );

        $userData = [
            'userFirstName' => $userEntity->getFirstName()
        ];

        return $this->render('@user_management_resources/home.html.twig', [
            'userData' => $userData
        ]);
    }

    public function logoutAction()
    {
        $userLogout = new UserLogout($this->userSessionManager);
        $userLogout->validate();
        $userLogout->perform();
        
        return $this->redirectToRoute('user_management_home');
    }
}
