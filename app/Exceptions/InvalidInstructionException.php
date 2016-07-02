<?php

namespace App\Exceptions;

class InvalidInstructionException extends \RuntimeException {
    /**
     * InvalidInstructionException constructor.
     */
    public function __construct()
    {
        parent::__construct("This instruction is not valid");
    }
}
