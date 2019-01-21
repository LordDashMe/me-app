<?php

namespace UserManagement\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UserManagement\Presentation\Controller\Security\AuthenticatedController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends Controller implements AuthenticatedController
{
    public function indexAction(Request $request, SessionInterface $session)
    {
        return $this->render('@user_management_resources/home.html.twig', []);
    }

    public function logoutAction(SessionInterface $session)
    {
        $session->clear();
        
        return $this->redirectToRoute('user_management_home');
    }
}
