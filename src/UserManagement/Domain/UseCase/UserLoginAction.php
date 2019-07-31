<?php

namespace UserManagement\Domain\UseCase;

use AppCommon\Domain\UseCase\UseCaseInterface;

use UserManagement\Domain\Entity\UserLogin;
use UserManagement\Domain\Exception\LoginFailedException;
use UserManagement\Domain\Message\UserLoginData;
use UserManagement\Domain\Repository\UserRepository;
use UserManagement\Domain\Repository\UserLoginRepository;
use UserManagement\Domain\Service\PasswordEncoder;
use UserManagement\Domain\Service\UserSessionManager;
use UserManagement\Domain\ValueObject\UserId;
use UserManagement\Domain\ValueObject\UserName;
use UserManagement\Domain\ValueObject\Password;
use UserManagement\Domain\ValueObject\MatchPassword;

class UserLoginAction implements UseCaseInterface
{   
    const ENABLE_PASSWORD_VALIDATION = false;

    private $userLoginData;
    private $userRepository;
    private $userLoginRepository;
    private $passwordEncoder;
    private $userSessionManager;

    private $userLoginEntity;
    private $storedUserEntity;

    public function __construct(
        UserLoginData $userLoginData,
        UserRepository $userRepository, 
        UserLoginRepository $userLoginRepository,
        PasswordEncoder $passwordEncoder,
        UserSessionManager $userSessionManager
    ) {
        $this->userLoginData = $userLoginData;
        $this->userRepository = $userRepository;
        $this->userLoginRepository = $userLoginRepository;
        $this->passwordEncoder = $passwordEncoder;
        $this->userSessionManager = $userSessionManager;
    }

    public function perform()
    {
        $this->prepareUserLoginEntity();
        $this->prepareStoredUserLoginEntity();
        
        $this->validateUserAccount();
        $this->validateUserCredentials();
        $this->validateUserStatus();

        $this->storeUserEntityUsingSession();
    }

    private function prepareUserLoginEntity()
    {
        $this->userLoginEntity = new UserLogin(
            new UserName($this->userLoginData->userName),
            new Password($this->userLoginData->password, self::ENABLE_PASSWORD_VALIDATION) 
        );
    }

    private function prepareStoredUserLoginEntity()
    {
        $this->storedUserLoginEntity = $this->userLoginRepository->get($this->userLoginEntity);
    }

    private function validateUserAccount()
    {
        if (! $this->storedUserLoginEntity) {
            throw LoginFailedException::invalidAccount();
        }
    }

    private function validateUserCredentials()
    {
        $matchPassword = new MatchPassword(
            $this->passwordEncoder, 
            $this->storedUserLoginEntity->password(), 
            $this->userLoginEntity->password()
        );

        if (! $matchPassword->isMatch()) {
            throw LoginFailedException::invalidAccount();
        }
    }

    private function validateUserStatus()
    {
        if (! $this->storedUserLoginEntity->isApproved()) {
            throw LoginFailedException::userStatusIsNotActive();
        }
    }

    private function storeUserEntityUsingSession()
    {
        $this->userSessionManager->set(
            $this->userRepository->getById(
                new UserId($this->storedUserLoginEntity->id())
            )
        );
    }
}
