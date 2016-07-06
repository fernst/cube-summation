<?php

class WebTest extends TestCase
{
    const SUBMIT_TEXT = 'Process instructions list';

    public function testWeb()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::VALID_TEST_CASE, 'instructions')
            ->press(self::SUBMIT_TEXT)
            ->see(4)
            ->see(27)
            ->see(0)
            ->see(1);
    }

    public function testEmpty()
    {
        $this->visit('/')
            ->press(self::SUBMIT_TEXT)
            ->see('The instructions field is required.');
    }

    public function testInvalidQuery()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::INVALID_QUERY, 'instructions')
            ->press(self::SUBMIT_TEXT)
            ->see('This instruction is not valid. Error on line 4.');
    }

    public function testInvalidQueryFormat()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::INVALID_QUERY_FORMAT, 'instructions')
            ->press(self::SUBMIT_TEXT)
            ->see('Unable to parse the input instructions list. Error on line 4.');
    }

    public function testInvalidUpdate()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::INVALID_UPDATE, 'instructions')
            ->press(self::SUBMIT_TEXT)
            ->see('This instruction is not valid. Error on line 3.');
    }

    public function testInvalidUpdateFormat()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::INVALID_UPDATE_FORMAT, 'instructions')
            ->press(self::SUBMIT_TEXT)
            ->see('Unable to parse the input instructions list. Error on line 3.');
    }

    public function testInvalidNumberOfTestCases()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::INVALID_NUMBER_OF_TEST_CASES, 'instructions')
            ->press(self::SUBMIT_TEXT)
            ->see('Unable to parse the input instructions list. Error on line 5.');
    }

    public function testInvalidNumberOfTestInstructions1()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::INVALID_NUMBER_OF_TEST_INSTRUCTIONS_1, 'instructions')
            ->press(self::SUBMIT_TEXT)
            ->see('Unable to parse the input instructions list. Error on line 5.');
    }

    public function testInvalidNumberOfTestInstructions2()
    {
        $this->visit('/')
            ->type(InstructionHandlerTest::INVALID_NUMBER_OF_TEST_INSTRUCTIONS_2, 'instructions')
            ->press(self::SUBMIT_TEXT)
            ->see('Unable to parse the input instructions list. Error on line 4.');
    }
}
