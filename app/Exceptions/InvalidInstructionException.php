<?php

namespace App\Exceptions;

class InvalidInstructionException extends \RuntimeException {
    /**
     * InvalidInstructionException constructor.
     * @param null $lineNumber
     */
    public function __construct($lineNumber = null)
    {
        $message = 'This instruction is not valid.';

        $message .= $lineNumber? ' Error on line ' . $lineNumber . '.' : '';

        parent::__construct($message);
    }
}
