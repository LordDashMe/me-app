<?php

namespace UserManagement\Presentation\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UserManagement\Domain\UseCase\UserLogin;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Exception\LoginFailedException;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use UserManagement\Presentation\Controller\Security\UnauthenticatedController;

class LoginController extends Controller implements UnauthenticatedController
{
    private $userRepository;
    private $passwordEncoder;

    public function __construct(UserRepository $userRepository, PasswordEncoder $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function indexAction(Request $request)
    {
        return $this->render('@user_management_resources/login.html.twig', []);
    }
    
    public function submitAction(Request $request, SessionInterface $session)
    {
        $loginData = [
            'username' => $request->get('username'),
            'password' => $request->get('password')
        ];

        try {
            
            $userLogin = new UserLogin(
                $loginData, $this->userRepository, $this->passwordEncoder
            );

            $userLogin->validate();

        } catch (LoginFailedException $exception) {
            
            $this->get('logger')->error($exception->getMessage());

            return $this->render('@user_management_resources/login.html.twig', [
                'exception' => $exception->getMessage()
            ]);
        }

        $session->set('user_entity', $userLogin->execute());

        return $this->redirectToRoute('user_management_home');

        // return $this->render('@user_management_resources/login.html.twig', []);
    }
}
