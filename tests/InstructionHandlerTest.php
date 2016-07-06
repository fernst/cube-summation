<?php

/**
 * Created by IntelliJ IDEA.
 * User: fernando
 * Date: 7/2/16
 * Time: 12:05 PM
 */
class InstructionHandlerTest extends TestCase
{
    const VALID_TEST_CASE = <<<TEXT
2
4 5
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 3
UPDATE 1 1 1 23
QUERY 2 2 2 4 4 4
QUERY 1 1 1 3 3 3
2 4
UPDATE 2 2 2 1
QUERY 1 1 1 1 1 1
QUERY 1 1 1 2 2 2
QUERY 2 2 2 2 2 2
TEXT;

    const VALID_TEST_RESULT = <<<TEXT
4
4
27
0
1
1
TEXT;

    const INVALID_QUERY = <<<TEXT
2
4 2
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 5
TEXT;

    const INVALID_UPDATE = <<<TEXT
1
4 2
UPDATE 2 2 5 4
QUERY 1 1 1 3 3 3
TEXT;

    const INVALID_QUERY_FORMAT = <<<TEXT
2
4 2
UPDATE 2 2 2 4
QUERY 1 1 1 3 3
TEXT;

    const INVALID_UPDATE_FORMAT = <<<TEXT
1
4 2
UPDATE 2 2 5
QUERY 1 1 1 3 3 3
TEXT;

    const INVALID_NUMBER_OF_TEST_CASES = <<<TEXT
2
4 2
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 3
TEXT;

    const INVALID_NUMBER_OF_TEST_INSTRUCTIONS_1 = <<<TEXT
2
4 3
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 3
4 3
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 3
TEXT;

    const INVALID_NUMBER_OF_TEST_INSTRUCTIONS_2 = <<<TEXT
2
4 1
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 3
4 3
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 3
TEXT;

    public function test()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::VALID_TEST_CASE);

        $this->assertEquals(array(4, 4, 27, 0, 1, 1), $instructionHandler->getOutputAsArray());
        $this->assertEquals(trim(self::VALID_TEST_RESULT),
            trim($instructionHandler->getOutputAsString()));
    }

    /**
     * @expectedException \App\Exceptions\InvalidInstructionException
     */
    public function testInvalidQuery()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::INVALID_QUERY);
    }

    /**
     * @expectedException \App\Exceptions\InvalidInstructionException
     */
    public function testInvalidUpdate()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::INVALID_UPDATE);
    }

    /**
     * @expectedException \App\Exceptions\InstructionParseException
     */
    public function testInvalidQueryFormat()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::INVALID_QUERY_FORMAT);
    }

    /**
     * @expectedException \App\Exceptions\InstructionParseException
     */
    public function testInvalidUpdateFormat()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::INVALID_UPDATE_FORMAT);
    }

    /**
     * @expectedException \App\Exceptions\InstructionParseException
     */
    public function testInvalidNumberOfTestCases()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::INVALID_NUMBER_OF_TEST_CASES);
    }

    /**
     * @expectedException \App\Exceptions\InstructionParseException
     */
    public function testInvalidNumberOfTestInstructions1()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::INVALID_NUMBER_OF_TEST_INSTRUCTIONS_1);
    }

    /**
     * @expectedException \App\Exceptions\InstructionParseException
     */
    public function testInvalidNumberOfTestInstructions2()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::INVALID_NUMBER_OF_TEST_INSTRUCTIONS_2);
    }
}
