<?php

namespace UserManagement\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('@user_management_resources/home.html.twig', []);
    }
}
