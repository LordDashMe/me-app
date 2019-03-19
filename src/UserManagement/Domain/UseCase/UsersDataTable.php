<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\ValidateRequireFields;
use UserManagement\Domain\Repository\UserRepository;

class UsersDataTable
{
    private $dataTableOptionsDefault = [
        'start' => 0,
        'length' => 10,
        'search' => '',
        'orderColumn' => 'ID',
        'orderBy' => 'DESC'
    ];
    
    private $usersDataTableData;
    private $userRepository;

    public function __construct($usersDataTableData, UserRepository $userRepository) 
    {
        $this->usersDataTableData = $this->mergeOptionsDefault($usersDataTableData);
        $this->userRepository = $userRepository;
    }

    private function mergeOptionsDefault($usersDataTableData)
    {
        return \array_merge($this->dataTableOptionsDefault, $usersDataTableData);
    }

    public function perform()
    {
        return $this->userRepository->getDataTable($this->usersDataTableData);   
    }
}
