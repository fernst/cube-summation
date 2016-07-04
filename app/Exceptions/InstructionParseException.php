<?php

namespace App\Exceptions;

class InstructionParseException extends \RuntimeException {
    /**
     * InstructionParseException constructor.
     * @param null $lineNumber
     */
    public function __construct($lineNumber = null)
    {
        $message = 'Unable to parse the input instructions list.';

        $message .= $lineNumber? ' Error on line ' . $lineNumber . '.' : '';

        parent::__construct($message);
    }
}
