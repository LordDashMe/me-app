<?php

namespace UserManagement\Domain\UseCase;

use DomainCommon\Domain\UseCase\ValidateRequireFields;
use UserManagement\Domain\Repository\UserRepository;

class UsersDataTable
{
    private $usersDataTableOptionsDefault = [
        'start' => 0,
        'length' => 10,
        'search' => '',
        'order_column' => 'id',
        'order_by' => 'DESC'
    ];
    
    private $usersDataTableOptions;
    private $userRepository;

    public function __construct($usersDataTableOptions, UserRepository $userRepository) 
    {
        $this->usersDataTableOptions = $this->mergeOptionsDefault($usersDataTableOptions);
        $this->userRepository = $userRepository;
    }

    private function mergeOptionsDefault($usersDataTableOptions)
    {
        return array_merge($this->usersDataTableOptionsDefault, $usersDataTableOptions);
    }

    public function perform()
    {
        return $this->userRepository->getDataTable($this->usersDataTableOptions);   
    }
}
