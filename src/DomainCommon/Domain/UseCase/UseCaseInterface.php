<?php

namespace DomainCommon\Domain\UseCase;

interface UseCaseInterface 
{
    public function validate();

    public function perform();
}
