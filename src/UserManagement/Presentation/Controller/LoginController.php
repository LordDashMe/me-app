<?php

namespace UserManagement\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends Controller
{
    public function indexAction(Request $request)
    {
        $data = [
            'message' => 'Hello, World!'
        ];

        return $this->render('@user_management_resources/login/index.html.twig', $data);
    }
}
