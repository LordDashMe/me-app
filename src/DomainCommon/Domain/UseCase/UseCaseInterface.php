<?php

namespace DomainCommon\Domain\UseCase;

interface UseCaseInterface 
{
    public function validate(): void;

    public function perform();
}
