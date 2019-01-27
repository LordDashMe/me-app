<?php

namespace UserManagement\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DomainCommon\Presentation\Controller\Security\AuthenticatedController;
use UserManagement\Domain\UseCase\UserLogout;
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
        return $this->render('@user_management_resources/home.html.twig', []);
    }

    public function logoutAction()
    {
        $userLogout = new UserLogout($this->userSessionManager);
        $userLogout->execute();
        
        return $this->redirectToRoute('user_management_home');
    }
}
