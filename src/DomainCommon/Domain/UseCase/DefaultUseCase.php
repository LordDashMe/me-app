<?php

namespace DomainCommon\Domain\UseCase;

use DomainCommon\Domain\Exception\RequiredFieldException;

class DefaultUseCase
{
    protected $requiredFields = [];

    protected function validateRequiredFields($requestData)
    {
        foreach ($this->requiredFields as $requiredField => $requiedFieldLabel) {
            if (empty($requestData[$requiredField])) {
                throw RequiredFieldException::requiredFieldIsEmpty($requiedFieldLabel);
            }
        }
    }
}
