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
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\UseCase\UserLoginAction;
use UserManagement\Infrastructure\Service\PasswordEncoderImpl;
use UserManagement\Infrastructure\Service\UserSessionManagerImpl;
use UserManagement\Infrastructure\Persistence\Repository\Doctrine\UserLoginRepositoryImpl;

class LoginController extends Controller implements UnauthenticatedController
{
    private $userLoginRepositoryImpl;
    private $passwordEncoderImpl;
    private $userSessionManagerImpl;

    public function __construct(
        UserLoginRepositoryImpl $userLoginRepositoryImpl,
        PasswordEncoderImpl $passwordEncoderImpl,
        UserSessionManagerImpl $userSessionManagerImpl
    ) {
        $this->userLoginRepositoryImpl = $userLoginRepositoryImpl;
        $this->passwordEncoderImpl = $passwordEncoderImpl;
        $this->userSessionManagerImpl = $userSessionManagerImpl;
    }

    public function indexAction(Request $request)
    {
        return $this->render('@user_management_resources/login.html.twig', []);
    }
    
    public function submitAction(Request $request)
    {
        try {

            $userLoginData = new UserLoginData($request->get('username'), $request->get('password'));

            $useCase = new UserLoginAction(
                $userLoginData, 
                $this->userLoginRepositoryImpl, 
                $this->passwordEncoderImpl, 
                $this->userSessionManagerImpl
            );

            $useCase->perform();

        } catch (LoginFailedException | PasswordException $exception) {
            
            $this->get('logger')->error($exception->getMessage());

            return $this->render('@user_management_resources/login.html.twig', [
                'exception' => $exception->getMessage()
            ]);
        }

        return $this->redirectToRoute('user_management_home');
    }
}
