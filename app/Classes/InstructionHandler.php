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
    public Function processInput($instructions)
    {
        $lines = $this->getLines($instructions);

        $lineNumber = 1;

        $numberOfTestCases = $this->getNumberOfTestCases(array_shift($lines), $lineNumber++);

        $dataMatrix = new DataMatrix();

        while ($numberOfTestCases > 0) {
            $numberOfInstructions =
                $this->getSizeAndNumberOfInstructions(array_shift($lines), $dataMatrix,
                    $lineNumber++);

            while ($numberOfInstructions > 0) {
                $value = $this->processInstruction(array_shift($lines), $dataMatrix, $lineNumber++);

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
    protected function getLines($input)
    {
        return preg_split("/\r\n|\n|\r/", trim($input));
    }

    /**
     * Get the number of test cases to be executed
     *
     * @param $line
     * @param $lineNumber
     * @return int
     */
    protected function getNumberOfTestCases($line, $lineNumber)
    {
        if ($line == null || $line === "") {
            throw new InstructionParseException($lineNumber);
        }

        $numberOfTestCases = 0;

        if (sscanf($line, "%d", $numberOfTestCases) !== 1) {
            throw new InstructionParseException($lineNumber);
        }

        return $numberOfTestCases;
    }

    /**
     * Get the size of the matrix and number of instructions to read
     *
     * @param $line
     * @param DataMatrix $dataMatrix
     * @param $lineNumber
     * @return int
     */
    protected function getSizeAndNumberOfInstructions($line, DataMatrix $dataMatrix, $lineNumber)
    {
        if ($line == null || $line === "") {
            throw new InstructionParseException($lineNumber);
        }

        $size = 0;
        $numberOfInstructions = 0;

        if (sscanf($line, "%d %d", $size, $numberOfInstructions) !== 2) {
            throw new InstructionParseException($lineNumber);
        }

        $dataMatrix->create($size);

        return $numberOfInstructions;
    }

    /**
     * Process instruction lines
     *
     * @param $line
     * @param DataMatrix $dataMatrix
     * @param $lineNumber
     * @return int|null
     */
    protected function processInstruction($line, DataMatrix $dataMatrix, $lineNumber)
    {
        if ($line == null || $line === "") {
            throw new InstructionParseException($lineNumber);
        }

        $val = null;

        if (str_contains($line, 'UPDATE')) {
            $this->processUpdate($line, $dataMatrix, $lineNumber);
        } else if (str_contains($line, 'QUERY')) {
            $val = $this->processQuery($line, $dataMatrix, $lineNumber);
        } else {
            throw new InstructionParseException($lineNumber);
        }

        return $val;
    }

    /**
     * Process update instructions
     *
     * @param $line
     * @param DataMatrix $dataMatrix
     * @param $lineNumber
     */
    protected function processUpdate($line, DataMatrix $dataMatrix, $lineNumber)
    {
        $x = 0;
        $y = 0;
        $z = 0;
        $value = 0;

        if (sscanf($line, "UPDATE %d %d %d %d", $x, $y, $z, $value) !== 4) {
            throw new InstructionParseException($lineNumber);
        }

        $dataMatrix->update($x, $y, $z, $value, $lineNumber);
    }

    /**
     * Process query instructions
     *
     * @param $line
     * @param DataMatrix $dataMatrix
     * @param $lineNumber
     * @return int
     */
    protected function processQuery($line, DataMatrix $dataMatrix, $lineNumber)
    {
        $x1 = 0;
        $y1 = 0;
        $z1 = 0;
        $x2 = 0;
        $y2 = 0;
        $z2 = 0;

        if (sscanf($line, "QUERY %d %d %d %d %d %d", $x1, $y1, $z1, $x2, $y2, $z2) !== 6) {
            throw new InstructionParseException($lineNumber);
        }

        return $dataMatrix->query($x1, $y1, $z1, $x2, $y2, $z2, $lineNumber);
    }
}
