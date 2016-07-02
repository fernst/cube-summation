<?php

namespace App\Classes;

use App\Exceptions\InvalidInstructionException;

/**
 * Class DataMatrix
 * @package App\Classes
 */
class DataMatrix{
    private $size;
    private $array;

    /**
     * Create a new DataMatrix of NxNxN dimensions
     *
     * @param $n
     */
    public function create($n) {
        //NOTE: arrays are 1-based for convenience while reading the value.
        $this->size = $n;
        $this->array = array_fill(1, $n, array_fill(1, $n, array_fill(1, $n, 0)));
    }

    /**
     * Update the cell located in X,Y,Z with the desired value
     *
     * @param $x
     * @param $y
     * @param $z
     * @param $value
     * @return mixed
     */
    public function update($x, $y, $z, $value) {
        if ($x < 1 || $y < 1 || $z < 1 || 
            $x > $this->size || $y > $this->size || $z > $this->size) {
            throw new InvalidInstructionException();
        }

        //Set the cell value
        $this->array[$x][$y][$z] = $value;

        return $value;
    }

    /**
     * Sum all cells located between X1,Y1,Z1 and X2, Y2, Z2
     *
     * @param $x1
     * @param $y1
     * @param $z1
     * @param $x2
     * @param $y2
     * @param $z2
     * @return int
     */
    public function query($x1, $y1, $z1, $x2, $y2, $z2) {
        //bound checking for parameters
        if (
            $x1 < 1 || $y1 < 1 || $z1 < 1 || $x2 < 1 || $y2 < 1 || $z2 < 1 ||
            $x1 > $this->size || $y1 > $this->size || $z1 > $this->size || 
            $x2 > $this->size || $y2 > $this->size || $z2 > $this->size ||
            $x1 > $x2 || $y1 > $y2 || $z1 > $z2
        ) {
            throw new InvalidInstructionException();
        }

        $sum = 0;

        //Add all elements within the array bounds
        for ($i = $x1 ; $i <= $x2 ; $i++) {
            for ($j = $y1 ; $j <= $y2 ; $j++) {
                for ($k = $z1 ; $k <= $z2 ; $k++) {
                    $sum += $this->array[$i][$j][$k];
                }
            }
        }

        return $sum;
    }

}

