<?php

namespace UserManagement\Application\Command;

use DomainCommon\Application\Exception\RequiredFieldException;

class UserRegistrationCommand
{
    private $firstName;
    private $lastName;
    private $email;
    private $userName;
    private $password;
    private $confirmPassword;

    public function withFirstName(string $firstName): UserRegistrationCommand
    {
        if (empty($firstName)) {
            throw RequiredFieldException::requiredFieldIsEmpty('First Name');
        }

        $this->firstName = $firstName;

        return $this;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function withLastName(string $lastName): UserRegistrationCommand
    {
        if (empty($lastName)) {
            throw RequiredFieldException::requiredFieldIsEmpty('Last Name');
        }

        $this->lastName = $lastName;

        return $this;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function withEmail(string $email): UserRegistrationCommand
    {
        if (empty($email)) {
            throw RequiredFieldException::requiredFieldIsEmpty('Email');
        }

        $this->email = $email;

        return $this;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function withUserName(string $userName): UserRegistrationCommand
    {
        if (empty($userName)) {
            throw RequiredFieldException::requiredFieldIsEmpty('Username');
        }

        $this->userName = $userName;

        return $this;
    }

    public function userName(): string
    {
        return $this->userName;
    }

    public function withPassword(string $password): UserRegistrationCommand
    {
        if (empty($password)) {
            throw RequiredFieldException::requiredFieldIsEmpty('Password');
        }

        $this->password = $password;

        return $this;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function withConfirmPassword(string $confirmPassword): UserRegistrationCommand
    {
        if (empty($confirmPassword)) {
            throw RequiredFieldException::requiredFieldIsEmpty('Confirm Password');
        }

        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    public function confirmPassword(): string
    {
        return $this->confirmPassword;
    }
}
