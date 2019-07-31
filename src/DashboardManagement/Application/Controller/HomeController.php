<?php

namespace DashboardManagement\Application\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppCommon\Application\Controller\Security\AuthenticatedController;

use UserManagement\Infrastructure\Service\UserSessionManagerImpl;

class HomeController extends Controller implements AuthenticatedController
{
    private $userSessionManagerImpl;

    public function __construct(UserSessionManagerImpl $userSessionManagerImpl)
    {
        $this->userSessionManagerImpl = $userSessionManagerImpl;
    }

    public function indexAction(Request $request)
    {
        $userEntity = $this->userSessionManagerImpl->get();

        $userData = [
            'userFirstName' => $userEntity->firstName()
        ];

        return $this->render('@dashboard_management_resources/home.html.twig', [
            'userData' => $userData
        ]);
    }
}
