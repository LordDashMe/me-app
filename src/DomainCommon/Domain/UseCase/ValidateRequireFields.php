<?php

namespace DomainCommon\Domain\UseCase;

use DomainCommon\Domain\Exception\RequiredFieldException;

class ValidateRequireFields
{
    private $requiredFields = [];
    private $requestData;

    public function __construct($requiredFields, $requestData) 
    {
        $this->requiredFields = $requiredFields;
        $this->requestData = $requestData;
    }

    public function perform()
    {
        foreach ($this->requiredFields as $requiredField => $requiedFieldLabel) {
            if (empty($this->requestData[$requiredField])) {
                throw RequiredFieldException::requiredFieldIsEmpty($requiedFieldLabel);
            }
        }
    }
}
