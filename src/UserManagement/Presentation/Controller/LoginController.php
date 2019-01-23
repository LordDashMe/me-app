<?php

namespace UserManagement\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UserManagement\Domain\UseCase\UserLogin;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\Exception\LoginFailedException;
use UserManagement\Presentation\Controller\Security\UnauthenticatedController;

class LoginController extends Controller implements UnauthenticatedController
{
    private $userRepository;
    private $passwordEncoder;
    private $userSessionManager;

    public function __construct(
        UserRepository $userRepository, 
        PasswordEncoder $passwordEncoder, 
        UserSessionManager $userSessionManager
    ) {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->userSessionManager = $userSessionManager;
    }

    public function indexAction(Request $request)
    {
        return $this->render('@user_management_resources/login.html.twig', []);
    }
    
    public function submitAction(Request $request)
    {
        $loginData = [
            'username' => $request->get('username'),
            'password' => $request->get('password')
        ];

        try {
            
            $userLogin = new UserLogin(
                $loginData, 
                $this->userRepository, 
                $this->passwordEncoder,
                $this->userSessionManager
            );

            $userLogin->validate();
            $userLogin->execute();

        } catch (LoginFailedException $exception) {
            
            $this->get('logger')->error($exception->getMessage());

            return $this->render('@user_management_resources/login.html.twig', [
                'exception' => $exception->getMessage()
            ]);
        }

        return $this->redirectToRoute('user_management_home');
    }
}
