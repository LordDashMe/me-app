<?php

namespace UserManagement\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppCommon\Application\Controller\Security\AuthenticatedController;
use AppCommon\Domain\Message\DataTable;

use UserManagement\Domain\Message\DeleteUserData;
use UserManagement\Domain\Message\EditUserData;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\Repository\UserListRepository;
use UserManagement\Domain\Repository\UserDeletionRepository;
use UserManagement\Domain\Repository\UserModificationRepository;
use UserManagement\Domain\UseCase\GetUserListAction;
use UserManagement\Domain\UseCase\DeleteUserAction;
use UserManagement\Domain\UseCase\EditUserAction;

class UserController extends Controller implements AuthenticatedController
{
    private $userListRepository;
    private $userDeletionRepository;
    private $userModificationRepository;
    private $userSessionManager;

    private $userEntity;

    public function __construct(
        UserListRepository $userListRepository,
        UserDeletionRepository $userDeletionRepository,
        UserModificationRepository $userModificationRepository,
        UserSessionManager $userSessionManager
    ) {
        $this->userListRepository = $userListRepository;
        $this->userDeletionRepository = $userDeletionRepository;
        $this->userModificationRepository = $userModificationRepository;
        $this->userSessionManager = $userSessionManager;

        $this->userEntity = $this->userSessionManager->get();
    }

    public function indexAction()
    {
        $userData = [
            'userName' => $this->userEntity->userName(),
            'firstName' => $this->userEntity->firstName(),
            'lastName' => $this->userEntity->lastName()
        ];

        // TODO: This is a temporary implementation of permission.
        if (! $this->isAdmin()) {
            return $this->redirectToRoute('expense_management'); 
        }

        return $this->render('@user_management_resources/user-list.html.twig', [
            'userData' => $userData
        ]);
    }

    public function getListAction(Request $request)
    {
        // TODO: This is a temporary implementation of permission.
        if (! $this->isAdmin()) {
            return $this->json(['message' => 'Not allowed.'], 403);  
        }

        $dataTable = new DataTable(
            $request->get('start'), 
            $request->get('length'), 
            $request->get('search')['value'], 
            $request->get('columns')[($request->get('order')[0]['column'] == 0 ? 1 : $request->get('order')[0]['column'])]['name'], 
            $request->get('order')[0]['dir']
        );

        $useCase = new GetUserListAction($dataTable, $this->userListRepository);

        $data = $useCase->perform();

        // TODO: Provide a transformer class or helper to fix the compatibility of data.
        $mergedData = \array_merge($data, [
            'recordsTotal' => $data['totalRecords'],
            'recordsFiltered' => $data['totalRecordsFiltered']
        ]);

        unset($mergedData['totalRecords']);
        unset($mergedData['totalRecordsFiltered']);

        return $this->json($mergedData);
    }

    public function deleteAction(Request $request)
    {
        // TODO: This is a temporary implementation of permission.
        if (! $this->isAdmin()) {
            return $this->json(['message' => 'Not allowed.'], 403);  
        }
        
        $useCase = new DeleteUserAction(
            new DeleteUserData($request->get('id')), 
            $this->userDeletionRepository
        );

        return $this->json(['id' => $useCase->perform()->get()]);
    }

    public function editAction(Request $request)
    {
        // TODO: This is a temporary implementation of permission.
        if (! $this->isAdmin()) {
            return $this->json(['message' => 'Not allowed.'], 403);  
        }

        $editUserData = new EditUserData(
            $request->get('id'),
            $request->get('first_name'),
            $request->get('last_name'),
            $request->get('email'),
            $request->get('status')
        );

        $useCase = new EditUserAction($editUserData, $this->userModificationRepository);

        return $this->json(['id' => $useCase->perform()->get()]);
    }

    // TODO: Refactor this to generic class or helper.
    private function isAdmin(): bool
    {
        return $this->userEntity->userName() === 'admin' ? true : false;
    }
}
