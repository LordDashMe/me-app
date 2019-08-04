<?php

namespace UserManagement\Application\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppCommon\Application\Controller\Security\UnauthenticatedController;
use AppCommon\Domain\Service\UniqueIDResolver;

use UserManagement\Domain\Message\EditUserData;
use UserManagement\Domain\Message\UserRegistrationData;
use UserManagement\Domain\Exception\RegistrationFailedException;
use UserManagement\Domain\Repository\UserRegistrationRepository;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Repository\UserModificationRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\UseCase\EditUserAction;
use UserManagement\Domain\UseCase\UserRegistrationAction;
use UserManagement\Domain\ValueObject\UserName;

class RegistrationController extends Controller implements UnauthenticatedController
{
    private $userRegistrationRepository;
    private $userRepository;
    private $passwordEncoder;
    private $uniqueIDResolver;

    public function __construct(
        UserRegistrationRepository $userRegistrationRepository,
        UserRepository $userRepository,
        UserModificationRepository $userModificationRepository,
        PasswordEncoder $passwordEncoder,
        UniqueIDResolver $uniqueIDResolver
    ) {
        $this->userRegistrationRepository = $userRegistrationRepository;
        $this->useRepository = $userRepository;
        $this->userModificationRepository = $userModificationRepository;
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

    public function enableAdminAction()
    {
        $record = $this->useRepository->getByUserName(new UserName('admin'));

        $editUserData = new EditUserData(
            $record->id(),
            $record->firstName(),
            $record->lastName(),
            $record->email(),
            '1'
        );

        $useCase = new EditUserAction($editUserData, $this->userModificationRepository);
    
        if ($useCase->perform()->get()) {
            return $this->json(['message' => 'admin account successfully enabled.']);
        }

        return $this->json(['message' => 'failed enabling admin account.']);
    }
}
