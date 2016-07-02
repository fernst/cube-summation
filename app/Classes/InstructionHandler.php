<?php

namespace App\Classes;

use App\Exceptions\InstructionParseException;

/**
 * Class InstructionHandler
 * @package App\Classes
 */
class InstructionHandler
{
    private $output;

    /**
     * InstructionHandler constructor.
     */
    public function __construct()
    {
        $this->output = array();
    }

    /**
     * @return array
     */
    public function getOutputAsArray()
    {
        return $this->output;
    }

    /**
     * @return string
     */
    public function getOutputAsString()
    {
        return implode(PHP_EOL, $this->output);
    }

    /**
     * Process an input string
     *
     * @param $instructions
     */
    public Function processInput($instructions) {
        $lines = $this->getLines($instructions);

        $numberOfTestCases = $this->getNumberOfTestCases(array_shift($lines));

        $dataMatrix = new DataMatrix();

        while ($numberOfTestCases>0) {
            $numberOfInstructions =
                $this->getSizeAndNumberOfInstructions(array_shift($lines), $dataMatrix);

            while ($numberOfInstructions>0) {
                $value = $this->processInstruction(array_shift($lines), $dataMatrix);

                if ($value !== null) {
                    $this->output[] = $value;
                }

                $numberOfInstructions--;
            }

            $numberOfTestCases--;
        }
    }

    /**
     * Split the input string into a list of lines
     *
     * @param $input
     * @return array
     */
    protected function getLines($input) {
        return preg_split("/\r\n|\n|\r/", trim($input));
    }

    /**
     * Get the number of test cases to be executed
     *
     * @param $line
     * @return int
     */
    protected function getNumberOfTestCases($line) {
        if ($line == null || $line === "") {
            throw new InstructionParseException();
        }

        $numberOfTestCases = 0;

        if (sscanf($line, "%d", $numberOfTestCases) !== 1) {
            throw new InstructionParseException();
        }

        return $numberOfTestCases;
    }

    /**
     * Get the size of the matrix and number of instructions to read
     *
     * @param $line
     * @param $dataMatrix
     * @return int
     */
    protected function getSizeAndNumberOfInstructions($line, DataMatrix $dataMatrix) {
        if ($line == null || $line === "") {
            throw new InstructionParseException();
        }

        $size = 0;
        $numberOfInstructions = 0;
        
        if (sscanf($line, "%d %d", $size, $numberOfInstructions) !== 2) {
            throw new InstructionParseException();
        }

        $dataMatrix->create($size);

        return $numberOfInstructions;
    }

    /**
     * Process instruction lines
     *
     * @param $line
     * @param DataMatrix $dataMatrix
     * @return int|null
     */
    protected function processInstruction($line, DataMatrix $dataMatrix) {
        if ($line == null || $line === "") {
            throw new InstructionParseException();
        }

        $val = null;

        if (str_contains($line, 'UPDATE')) {
            $this->processUpdate($line, $dataMatrix);
        } else if (str_contains($line, 'QUERY') ) {
            $val = $this->processQuery($line, $dataMatrix);
        } else {
            throw new InstructionParseException();
        }

        return $val;
    }

    /**
     * Process update instructions
     *
     * @param $line
     * @param DataMatrix $dataMatrix
     */
    protected function processUpdate($line, DataMatrix $dataMatrix) {
        $x = 0;
        $y = 0;
        $z = 0;
        $value = 0;

        if (sscanf($line, "UPDATE %d %d %d %d", $x, $y, $z, $value) !== 4) {
            throw new InstructionParseException();
        }

        $dataMatrix->update($x, $y, $z, $value);
    }

    /**
     * Process query instructions
     *
     * @param $line
     * @param DataMatrix $dataMatrix
     * @return int
     */
    protected function processQuery($line, DataMatrix $dataMatrix) {
        $x1 = 0;
        $y1 = 0;
        $z1 = 0;
        $x2 = 0;
        $y2 = 0;
        $z2 = 0;

        if (sscanf($line, "QUERY %d %d %d %d %d %d", $x1, $y1, $z1, $x2, $y2, $z2) !== 6) {
            throw new InstructionParseException();
        }

        return $dataMatrix->query($x1, $y1, $z1, $x2, $y2, $z2);
    }
}
