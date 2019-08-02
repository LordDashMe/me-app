<?php

namespace UserManagement\Application\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppCommon\Application\Controller\Security\UnauthenticatedController;
use AppCommon\Domain\Service\UniqueIDResolver;

use UserManagement\Domain\Message\UserRegistrationData;
use UserManagement\Domain\Exception\RegistrationFailedException;
use UserManagement\Domain\Repository\UserRegistrationRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\UseCase\UserRegistrationAction;

class RegistrationController extends Controller implements UnauthenticatedController
{
    private $userRegistrationRepository;
    private $passwordEncoder;
    private $uniqueIDResolver;

    public function __construct(
        UserRegistrationRepository $userRegistrationRepository,
        PasswordEncoder $passwordEncoder,
        UniqueIDResolver $uniqueIDResolver
    ) {
        $this->userRegistrationRepository = $userRegistrationRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->uniqueIDResolver = $uniqueIDResolver;
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
                $this->userRegistrationRepository, 
                $this->passwordEncoder,
                $this->uniqueIDResolver
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
