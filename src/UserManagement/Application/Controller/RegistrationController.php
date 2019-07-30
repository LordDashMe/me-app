<?php

namespace UserManagement\Application\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppCommon\Application\Controller\Security\UnauthenticatedController;
use AppCommon\Infrastructure\Service\UniqueIDResolverImpl;

use UserManagement\Domain\Message\UserRegistrationData;
use UserManagement\Domain\UseCase\UserRegistrationAction;
use UserManagement\Domain\Exception\RegistrationFailedException;
use UserManagement\Infrastructure\Service\PasswordEncoderImpl;
use UserManagement\Infrastructure\Persistence\Repository\Doctrine\UserRegistrationRepositoryImpl;

class RegistrationController extends Controller implements UnauthenticatedController
{
    private $userRegistrationRepositoryImpl;
    private $passwordEncoderImpl;
    private $uniqueIDResolverImpl;

    public function __construct(
        UserRegistrationRepositoryImpl $userRegistrationRepositoryImpl,
        PasswordEncoderImpl $passwordEncoderImpl,
        UniqueIDResolverImpl $uniqueIDResolverImpl
    ) {
        $this->userRegistrationRepositoryImpl = $userRegistrationRepositoryImpl;
        $this->passwordEncoderImpl = $passwordEncoderImpl;
        $this->uniqueIDResolverImpl = $uniqueIDResolverImpl;
    }

    public function indexAction(Request $request)
    {
        return $this->render('@user_management_resources/registration.html.twig');
    }

    public function createAction(Request $request)
    {
        try {

            $userRegistrationData = new UserRegistrationData(
                $request->get('first_name'), 
                $request->get('last_name'), 
                $request->get('email'), 
                $request->get('username'), 
                $request->get('password'), 
                $request->get('confirm_password')
            );

            $useCase = new UserRegistrationAction(
                $userRegistrationData, 
                $this->userRegistrationRepositoryImpl, 
                $this->passwordEncoderImpl,
                $this->uniqueIDResolverImpl
            );

            $useCase->perform();

        } catch (RegistrationFailedException $exception) {
            
            $this->get('logger')->error($exception->getMessage());

            return $this->render('@user_management_resources/registration.html.twig', [
                'exception' => $exception->getMessage(),
                'old' => $userRegistrationData
            ]);
        }
        
        return $this->render('@user_management_resources/registration.html.twig', [
            'message' => 'Request for account has been sent! Please wait for the Admin to approve the request.'
        ]);
    }
}
