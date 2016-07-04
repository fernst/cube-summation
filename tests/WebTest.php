<?php

/**
 * Created by IntelliJ IDEA.
 * User: fernando
 * Date: 7/4/16
 * Time: 1:53 PM
 */
class WebTest extends TestCase
{
    static $submitText = 'Process instructions list';

    public function testWeb()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::$validTestCase, 'instructions')
            ->press(self::$submitText)
            ->see(4)
            ->see(27)
            ->see(0)
            ->see(1);
    }

    public function testEmpty()
    {
        $this->visit('/')
            ->press(self::$submitText)
            ->see('The instructions field is required.');
    }

    public function testInvalidQuery()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::$invalidQuery, 'instructions')
            ->press(self::$submitText)
            ->see('This instruction is not valid. Error on line 4.');
    }

    public function testInvalidQueryFormat()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::$invalidQueryFormat, 'instructions')
            ->press(self::$submitText)
            ->see('Unable to parse the input instructions list. Error on line 4.');
    }

    public function testInvalidUpdate()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::$invalidUpdate, 'instructions')
            ->press(self::$submitText)
            ->see('This instruction is not valid. Error on line 3.');
    }

    public function testInvalidUpdateFormat()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::$invalidUpdateFormat, 'instructions')
            ->press(self::$submitText)
            ->see('Unable to parse the input instructions list. Error on line 3.');
    }

    public function testInvalidNumberOfTestCases()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::$invalidNumberOfTestCases, 'instructions')
            ->press(self::$submitText)
            ->see('Unable to parse the input instructions list. Error on line 5.');
    }

    public function testInvalidNumberOfTestInstructions1()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::$invalidNumberOfTestInstructions1, 'instructions')
            ->press(self::$submitText)
            ->see('Unable to parse the input instructions list. Error on line 5.');
    }

    public function testInvalidNumberOfTestInstructions2()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::$invalidNumberOfTestInstructions2, 'instructions')
            ->press(self::$submitText)
            ->see('Unable to parse the input instructions list. Error on line 4.');
    }
}
