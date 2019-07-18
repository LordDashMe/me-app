<?php

namespace UserManagement\Application\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppCommon\Application\Controller\Security\UnauthenticatedController;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\UseCase\UserRegistration;
use UserManagement\Domain\Exception\RegistrationFailedException;

class RegistrationController extends Controller implements UnauthenticatedController
{
    private $passwordEncoder;

    public function __construct(PasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function indexAction(Request $request)
    {
        return $this->render('@user_management_resources/registration.html.twig');
    }

    public function createAction(Request $request)
    {
        $userRegistrationData = [
            'firstName' => $request->get('first_name'),
            'lastName' => $request->get('last_name'),
            'email' => $request->get('email'),
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'confirmPassword' => $request->get('confirm_password')
        ];

        try {
            
            $userRegistration = new UserRegistration(
                $userRegistrationData, 
                $this->userRepository, 
                $this->passwordEncoder
            );

            $userRegistration->validate();
            $userRegistration->perform();

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
