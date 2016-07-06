<?php

class WebTestDB extends TestCase
{
    const CREATE_NEW_MATRIX_TEST = 'Create new Matrix';
    const UPDATED_VALUE = 'Update value';
    const QUERY = 'Query';

    public function testWebDB1x1x1()
    {
        $size = 1;

        $this->visit('/db')
            ->type($size, 'size')
            ->press(self::CREATE_NEW_MATRIX_TEST)
            ->see("Create new Matrix of size $size X $size X $size successfully.")
            ->see("The current matrix size is $size X $size X $size");
    }

    public function testWebDB10x10x10()
    {
        $size = 10;

        $this->visit('/db')
            ->type($size, 'size')
            ->press(self::CREATE_NEW_MATRIX_TEST)
            ->see("Create new Matrix of size $size X $size X $size successfully.")
            ->see("The current matrix size is $size X $size X $size");
    }

    public function testWebDB21x21x21()
    {
        $size = 21;

        $this->visit('/db')
            ->type($size, 'size')
            ->press(self::CREATE_NEW_MATRIX_TEST)
            ->see("Create new Matrix of size $size X $size X $size successfully.")
            ->see("The current matrix size is $size X $size X $size");
    }

    public function testWebDB0x0x0()
    {
        $this->visit('/db')
            ->type(0, 'size')
            ->press(self::CREATE_NEW_MATRIX_TEST)
            ->see("The size must be at least 1.");
    }

    public function testWebDB22x22x22()
    {
        $this->visit('/db')
            ->type(22, 'size')
            ->press(self::CREATE_NEW_MATRIX_TEST)
            ->see("The size may not be greater than 21.");
    }

    public function testWebDBCase1()
    {
        $size = 4;

        $this->visit('/db')
            ->type($size, 'size')
            ->press(self::CREATE_NEW_MATRIX_TEST)
            ->see("Create new Matrix of size $size X $size X $size successfully.")
            ->see("The current matrix size is $size X $size X $size");

        $this->visit('/db')
            ->type(2, 'x')
            ->type(2, 'y')
            ->type(2, 'z')
            ->type(4, 'value')
            ->press(self::UPDATED_VALUE)
            ->see("Updated cell 2,2,2 to 4");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(1, 'y1')
            ->type(1, 'z1')
            ->type(3, 'x2')
            ->type(3, 'y2')
            ->type(3, 'z2')
            ->press(self::QUERY)
            ->see("The sum of cells between 1,1,1 and 3,3,3 is 4");

        $this->visit('/db')
            ->type(1, 'x')
            ->type(1, 'y')
            ->type(1, 'z')
            ->type(23, 'value')
            ->press(self::UPDATED_VALUE)
            ->see("Updated cell 1,1,1 to 23");

        $this->visit('/db')
            ->type(2, 'x1')
            ->type(2, 'y1')
            ->type(2, 'z1')
            ->type(4, 'x2')
            ->type(4, 'y2')
            ->type(4, 'z2')
            ->press(self::QUERY)
            ->see("The sum of cells between 2,2,2 and 4,4,4 is 4");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(1, 'y1')
            ->type(1, 'z1')
            ->type(3, 'x2')
            ->type(3, 'y2')
            ->type(3, 'z2')
            ->press(self::QUERY)
            ->see("The sum of cells between 1,1,1 and 3,3,3 is 27");
    }

    public function testWebDBCase2()
    {
        $size = 2;

        $this->visit('/db')
            ->type($size, 'size')
            ->press(self::CREATE_NEW_MATRIX_TEST)
            ->see("Create new Matrix of size $size X $size X $size successfully.")
            ->see("The current matrix size is $size X $size X $size");

        $this->visit('/db')
            ->type(2, 'x')
            ->type(2, 'y')
            ->type(2, 'z')
            ->type(1, 'value')
            ->press(self::UPDATED_VALUE)
            ->see("Updated cell 2,2,2 to 1");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(1, 'y1')
            ->type(1, 'z1')
            ->type(1, 'x2')
            ->type(1, 'y2')
            ->type(1, 'z2')
            ->press(self::QUERY)
            ->see("The sum of cells between 1,1,1 and 1,1,1 is 0");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(1, 'y1')
            ->type(1, 'z1')
            ->type(2, 'x2')
            ->type(2, 'y2')
            ->type(2, 'z2')
            ->press(self::QUERY)
            ->see("The sum of cells between 1,1,1 and 2,2,2 is 1");

        $this->visit('/db')
            ->type(2, 'x1')
            ->type(2, 'y1')
            ->type(2, 'z1')
            ->type(2, 'x2')
            ->type(2, 'y2')
            ->type(2, 'z2')
            ->press(self::QUERY)
            ->see("The sum of cells between 2,2,2 and 2,2,2 is 1");
    }

    public function testWebDBQueryUpdateErrors()
    {
        $size = 2;

        $this->visit('/db')
            ->type($size, 'size')
            ->press(self::CREATE_NEW_MATRIX_TEST)
            ->see("Create new Matrix of size $size X $size X $size successfully.")
            ->see("The current matrix size is $size X $size X $size");

        $this->visit('/db')
            ->type(0, 'x')
            ->type(2, 'y')
            ->type(2, 'z')
            ->type(1, 'value')
            ->press(self::UPDATED_VALUE)
            ->see("The x must be at least 1.");

        $this->visit('/db')
            ->type(2, 'x')
            ->type(0, 'y')
            ->type(2, 'z')
            ->type(1, 'value')
            ->press(self::UPDATED_VALUE)
            ->see("The y must be at least 1.");

        $this->visit('/db')
            ->type(2, 'x')
            ->type(2, 'y')
            ->type(0, 'z')
            ->type(1, 'value')
            ->press(self::UPDATED_VALUE)
            ->see("The z must be at least 1.");

        $this->visit('/db')
            ->type(3, 'x')
            ->type(2, 'y')
            ->type(2, 'z')
            ->type(1, 'value')
            ->press(self::UPDATED_VALUE)
            ->see("The x may not be greater than 2.");

        $this->visit('/db')
            ->type(2, 'x')
            ->type(3, 'y')
            ->type(2, 'z')
            ->type(1, 'value')
            ->press(self::UPDATED_VALUE)
            ->see("The y may not be greater than 2.");

        $this->visit('/db')
            ->type(2, 'x')
            ->type(2, 'y')
            ->type(3, 'z')
            ->type(1, 'value')
            ->press(self::UPDATED_VALUE)
            ->see("The z may not be greater than 2.");

        $this->visit('/db')
            ->type(0, 'x1')
            ->type(1, 'y1')
            ->type(1, 'z1')
            ->type(1, 'x2')
            ->type(1, 'y2')
            ->type(1, 'z2')
            ->press(self::QUERY)
            ->see("The x1 must be at least 1.");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(0, 'y1')
            ->type(1, 'z1')
            ->type(1, 'x2')
            ->type(1, 'y2')
            ->type(1, 'z2')
            ->press(self::QUERY)
            ->see("The y1 must be at least 1.");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(1, 'y1')
            ->type(0, 'z1')
            ->type(1, 'x2')
            ->type(1, 'y2')
            ->type(1, 'z2')
            ->press(self::QUERY)
            ->see("The z1 must be at least 1.");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(1, 'y1')
            ->type(1, 'z1')
            ->type(3, 'x2')
            ->type(1, 'y2')
            ->type(1, 'z2')
            ->press(self::QUERY)
            ->see("The x2 may not be greater than 2.");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(1, 'y1')
            ->type(1, 'z1')
            ->type(1, 'x2')
            ->type(3, 'y2')
            ->type(1, 'z2')
            ->press(self::QUERY)
            ->see("The y2 may not be greater than 2.");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(1, 'y1')
            ->type(1, 'z1')
            ->type(1, 'x2')
            ->type(1, 'y2')
            ->type(3, 'z2')
            ->press(self::QUERY)
            ->see("The z2 may not be greater than 2.");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(1, 'y1')
            ->type(1, 'z1')
            ->type(1, 'x2')
            ->type(1, 'y2')
            ->type(3, 'z2')
            ->press(self::QUERY)
            ->see("The z2 may not be greater than 2.");

        $this->visit('/db')
            ->type(2, 'x1')
            ->type(1, 'y1')
            ->type(1, 'z1')
            ->type(1, 'x2')
            ->type(1, 'y2')
            ->type(1, 'z2')
            ->press(self::QUERY)
            ->see("The x1 must be less than or equal to the x2.")
            ->see("The x2 must be greater than or equal to the x1.");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(2, 'y1')
            ->type(1, 'z1')
            ->type(1, 'x2')
            ->type(1, 'y2')
            ->type(1, 'z2')
            ->press(self::QUERY)
            ->see("The y1 must be less than or equal to the y2.")
            ->see("The y2 must be greater than or equal to the y1.");

        $this->visit('/db')
            ->type(1, 'x1')
            ->type(1, 'y1')
            ->type(2, 'z1')
            ->type(1, 'x2')
            ->type(1, 'y2')
            ->type(1, 'z2')
            ->press(self::QUERY)
            ->see("The z1 must be less than or equal to the z2.")
            ->see("The z2 must be greater than or equal to the z1.");

        $this->visit('/db')
            ->type(2, 'x1')
            ->type(2, 'y1')
            ->type(2, 'z1')
            ->type(1, 'x2')
            ->type(2, 'y2')
            ->type(2, 'z2')
            ->press(self::QUERY)
            ->see("The x1 must be less than or equal to the x2.")
            ->see("The x2 must be greater than or equal to the x1.");

        $this->visit('/db')
            ->type(2, 'x1')
            ->type(2, 'y1')
            ->type(2, 'z1')
            ->type(2, 'x2')
            ->type(1, 'y2')
            ->type(2, 'z2')
            ->press(self::QUERY)
            ->see("The y1 must be less than or equal to the y2.")
            ->see("The y2 must be greater than or equal to the y1.");

        $this->visit('/db')
            ->type(2, 'x1')
            ->type(2, 'y1')
            ->type(2, 'z1')
            ->type(2, 'x2')
            ->type(2, 'y2')
            ->type(1, 'z2')
            ->press(self::QUERY)
            ->see("The z1 must be less than or equal to the z2.")
            ->see("The z2 must be greater than or equal to the z1.");
        

    }
}
