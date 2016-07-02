<?php

/**
 * Created by IntelliJ IDEA.
 * User: fernando
 * Date: 7/2/16
 * Time: 12:05 PM
 */
class InstructionHandlerTest extends TestCase
{
    static $validTestCase = <<<TEXT
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

    static $validTestResult = <<<TEXT
4
4
27
0
1
1
TEXT;

    static $invalidQuery = <<<TEXT
2
4 2
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 5
TEXT;

    static $invalidUpdate = <<<TEXT
1
4 2
UPDATE 2 2 5 4
QUERY 1 1 1 3 3 3
TEXT;

    static $invalidQueryFormat = <<<TEXT
2
4 2
UPDATE 2 2 2 4
QUERY 1 1 1 3 3
TEXT;

    static $invalidUpdateFormat = <<<TEXT
1
4 2
UPDATE 2 2 5
QUERY 1 1 1 3 3 3
TEXT;

    static $invalidNumberOfTestCases = <<<TEXT
2
4 2
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 3
TEXT;

    static $invalidNumberOfTestInstructions1 = <<<TEXT
2
4 3
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 3
4 3
UPDATE 2 2 2 4
QUERY 1 1 1 3 3 3
TEXT;

    static $invalidNumberOfTestInstructions2 = <<<TEXT
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

        $instructionHandler->processInput(self::$validTestCase);

        $this->assertEquals(array(4, 4, 27, 0, 1, 1), $instructionHandler->getOutputAsArray());
        $this->assertEquals(trim(self::$validTestResult),
            trim($instructionHandler->getOutputAsString()));
    }

    /**
     * @expectedException \App\Exceptions\InvalidInstructionException
     */
    public function testInvalidQuery()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::$invalidQuery);
    }

    /**
     * @expectedException \App\Exceptions\InvalidInstructionException
     */
    public function testInvalidUpdate()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::$invalidUpdate);
    }

    /**
     * @expectedException \App\Exceptions\InstructionParseException
     */
    public function testInvalidQueryFormat()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::$invalidQueryFormat);
    }

    /**
     * @expectedException \App\Exceptions\InstructionParseException
     */
    public function testInvalidUpdateFormat()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::$invalidUpdateFormat);
    }

    /**
     * @expectedException \App\Exceptions\InstructionParseException
     */
    public function testInvalidNumberOfTestCases()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::$invalidNumberOfTestCases);
    }

    /**
     * @expectedException \App\Exceptions\InstructionParseException
     */
    public function testInvalidNumberOfTestInstructions1()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::$invalidNumberOfTestInstructions1);
    }

    /**
     * @expectedException \App\Exceptions\InstructionParseException
     */
    public function testInvalidNumberOfTestInstructions2()
    {
        $instructionHandler = new \App\Classes\InstructionHandler();

        $instructionHandler->processInput(self::$invalidNumberOfTestInstructions2);
    }
}
