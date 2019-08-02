<?php

namespace UserManagement\Application\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppCommon\Application\Controller\Security\UnauthenticatedController;

use UserManagement\Domain\Message\UserLoginData;
use UserManagement\Domain\Exception\LoginFailedException;
use UserManagement\Domain\Exception\PasswordException;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Repository\UserLoginRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\UseCase\UserLoginAction;

class LoginController extends Controller implements UnauthenticatedController
{
    private $userRepository;
    private $userLoginRepository;
    private $passwordEncoder;
    private $userSessionManager;

    public function __construct(
        UserRepository $userRepository,
        UserLoginRepository $userLoginRepository,
        PasswordEncoder $passwordEncoder,
        UserSessionManager $userSessionManager
    ) {
        $this->userRepository = $userRepository;
        $this->userLoginRepository = $userLoginRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->userSessionManager = $userSessionManager;
    }

    public function indexAction(Request $request)
    {
        return $this->render('@user_management_resources/login.html.twig', []);
    }
    
    public function submitAction(Request $request)
    {
        try {

            $userLoginData = new UserLoginData(
                $request->get('username'), 
                $request->get('password')
            );

            $useCase = new UserLoginAction(
                $userLoginData, 
                $this->userRepository,
                $this->userLoginRepository, 
                $this->passwordEncoder, 
                $this->userSessionManager
            );

            $useCase->perform();

        } catch (LoginFailedException $exception) {
            
            $this->get('logger')->error($exception->getMessage());

            return $this->render('@user_management_resources/login.html.twig', [
                'exception' => $exception->getMessage()
            ]);
        }

        return $this->redirectToRoute('expense_management');
    }
}
