<?php

class DataMatrixTest extends TestCase {

    public function testDataMatrix()
    {
        $dataMatrix = new \App\Classes\DataMatrix();

        $dataMatrix->create(4);
        $dataMatrix->update(2,2,2,4);
        $this->assertEquals(4,$dataMatrix->query(1,1,1,3,3,3));
        $dataMatrix->update(1,1,1,23);
        $this->assertEquals(4,$dataMatrix->query(2,2,2,4,4,4));
        $this->assertEquals(27,$dataMatrix->query(1,1,1,3,3,3));

        $dataMatrix->create(2);
        $dataMatrix->update(2,2,2,1);
        $this->assertEquals(0,$dataMatrix->query(1,1,1,1,1,1));
        $this->assertEquals(1,$dataMatrix->query(1,1,1,2,2,2));
        $this->assertEquals(1,$dataMatrix->query(2,2,2,2,2,2));
    }

    /**
     * @expectedException \App\Exceptions\InvalidInstructionException
     */
    public function testDataMatrixUpdateException() {
        $dataMatrix = new \App\Classes\DataMatrix();

        $dataMatrix->create(1);

        //Throws exception
        $dataMatrix->update(2,2,2,1);
    }

    /**
     * @expectedException \App\Exceptions\InvalidInstructionException
     */
    public function testDataMatrixQueryException() {
        $dataMatrix = new \App\Classes\DataMatrix();

        $dataMatrix->create(1);
        $dataMatrix->update(1,1,1,999);
        $this->assertEquals(999,$dataMatrix->query(1,1,1,1,1,1));

        //Throws exception
        $dataMatrix->query(2,2,2,2,2,2);
    }
}
