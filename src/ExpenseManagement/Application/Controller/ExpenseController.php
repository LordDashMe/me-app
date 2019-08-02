<?php

namespace ExpenseManagement\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppCommon\Application\Controller\Security\AuthenticatedController;
use AppCommon\Domain\Service\UniqueIDResolver;

use UserManagement\Domain\Service\UserSessionManager;

use ExpenseManagement\Domain\Message\ExpenseDataTable;
use ExpenseManagement\Domain\Message\DeleteExpenseData;
use ExpenseManagement\Domain\Message\EditExpenseData;
use ExpenseManagement\Domain\Message\SubmitExpenseData;
use ExpenseManagement\Domain\Message\CalculateUserExpenseDetailsData;
use ExpenseManagement\Domain\Repository\ExpenseListRepository;
use ExpenseManagement\Domain\Repository\ExpenseDeletionRepository;
use ExpenseManagement\Domain\Repository\ExpenseModificationRepository;
use ExpenseManagement\Domain\Repository\SubmitExpenseRepository;
use ExpenseManagement\Domain\Repository\CalculateUserTotalExpensesRepository;
use ExpenseManagement\Domain\Repository\CalculateUserTotalDaysRepository;
use ExpenseManagement\Domain\UseCase\GetExpenseListAction;
use ExpenseManagement\Domain\UseCase\DeleteExpenseAction;
use ExpenseManagement\Domain\UseCase\EditExpenseAction;
use ExpenseManagement\Domain\UseCase\SubmitExpenseAction;
use ExpenseManagement\Domain\UseCase\CalculateUserTotalExpensesAction;
use ExpenseManagement\Domain\UseCase\CalculateUserTotalDaysAction;

class ExpenseController extends Controller implements AuthenticatedController
{
    private $expenseListRepository;
    private $expenseDeletionRepository;
    private $expenseModificationRepository;
    private $submitExpenseRepository;
    private $calculateUserTotalExpensesRepository;
    private $calculateUserTotalDaysRepository;
    private $uniqueIDResolver;
    private $userSessionManager;

    private $userEntity;

    public function __construct(
        ExpenseListRepository $expenseListRepository,
        ExpenseDeletionRepository $expenseDeletionRepository,
        ExpenseModificationRepository $expenseModificationRepository,
        SubmitExpenseRepository $submitExpenseRepository,
        CalculateUserTotalExpensesRepository $calculateUserTotalExpensesRepository,
        CalculateUserTotalDaysRepository $calculateUserTotalDaysRepository,
        UniqueIDResolver $uniqueIDResolver,
        UserSessionManager $userSessionManager
    ) {
        $this->expenseListRepository = $expenseListRepository;
        $this->expenseDeletionRepository = $expenseDeletionRepository;
        $this->expenseModificationRepository = $expenseModificationRepository;
        $this->submitExpenseRepository = $submitExpenseRepository;
        $this->calculateUserTotalExpensesRepository = $calculateUserTotalExpensesRepository;
        $this->calculateUserTotalDaysRepository = $calculateUserTotalDaysRepository;
        $this->uniqueIDResolver = $uniqueIDResolver;
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

        return $this->render('@expense_management_resources/expense-list.html.twig', [
            'userData' => $userData
        ]);
    }

    public function getListAction(Request $request)
    {
        $expenseDataTable = new ExpenseDataTable(
            $this->userEntity->id(),
            $request->get('start'), 
            $request->get('length'), 
            $request->get('search')['value'], 
            $request->get('columns')[$request->get('order')[0]['column']]['name'], 
            $request->get('order')[0]['dir']
        );

        $useCase = new GetExpenseListAction($expenseDataTable, $this->expenseListRepository);

        $data = $useCase->perform();

        // TODO: Provide a transformer class or helper to fix the compatibility of data.
        $mergedData = \array_merge($data, [
            'draw' => (int) $request->get('draw'),
            'recordsTotal' => (int) $data['totalRecords'],
            'recordsFiltered' => (int) $data['totalRecordsFiltered']
        ]);

        unset($mergedData['totalRecords']);
        unset($mergedData['totalRecordsFiltered']);

        return $this->json($mergedData);
    }

    public function deleteAction(Request $request)
    {
        $useCase = new DeleteExpenseAction(
            new DeleteExpenseData($request->get('id'), $this->userEntity->id()), 
            $this->expenseDeletionRepository
        );

        return $this->json(['id' => $useCase->perform()->get()]);
    }

    public function editAction(Request $request)
    {

        $editExpenseData = new EditExpenseData(
            $request->get('id'),
            $this->userEntity->id(),
            $request->get('type'),
            $request->get('label'),
            $request->get('cost'),
            $request->get('date')
        );

        $useCase = new EditExpenseAction($editExpenseData, $this->expenseModificationRepository);

        return $this->json(['id' => $useCase->perform()->get()]);
    }

    public function addAction(Request $request)
    {
        $submitExpenseData = new SubmitExpenseData(
            $this->userEntity->id(),
            $request->get('type'),
            $request->get('label'),
            $request->get('cost'),
            $request->get('date')
        );

        $useCase = new SubmitExpenseAction(
            $submitExpenseData, 
            $this->submitExpenseRepository,
            $this->uniqueIDResolver
        );

        return $this->json(['id' => $useCase->perform()->get()]);
    }

    public function getTotalExpensesAction()
    {
        $calculateUserExpenseDetailsData = new CalculateUserExpenseDetailsData($this->userEntity->id());

        $useCase = new CalculateUserTotalExpensesAction(
            $calculateUserExpenseDetailsData,
            $this->calculateUserTotalExpensesRepository
        );
        
        return $this->json(['total' => $useCase->perform()]);
    }

    public function getTotalDaysAction()
    {
        $calculateUserExpenseDetailsData = new CalculateUserExpenseDetailsData($this->userEntity->id());

        $useCase = new CalculateUserTotalDaysAction(
            $calculateUserExpenseDetailsData,
            $this->calculateUserTotalDaysRepository
        );
        
        return $this->json(['total' => $useCase->perform()]);
    }
}
