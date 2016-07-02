<?php

namespace App\Exceptions;

class InstructionParseException extends \RuntimeException {
    /**
     * InstructionParseException constructor.
     */
    public function __construct()
    {
        parent::__construct("Unable to parse the input instructions list");
    }
}
