<?php

namespace App\Persistence;

use App\Models\Cell;
use App\Models\Matrix;

class DataMatrixService
{
    public function createMatrix($size) {
        //Delete the current matrix
        Matrix::first()->delete();

        //Create a new matrix with the specified size
        $matrix = Matrix::create(['size' => $size]);

        //Create all cells for matrix
        for ($x = 1; $x <= $size; $x++) {
            for ($y = 1; $y <= $size; $y++) {
                for ($z = 1; $z <= $size; $z++) {
                    Cell::create([
                        'x' => $x,
                        'y' => $y,
                        'z' => $z,
                        'value' => 0,
                        'matrix_id' => $matrix->id
                    ]);
                }
            }
        }
    }

    public function updateCell($matrix_id, $x, $y, $z, $value) {
        //Find cell in X,Y,Z position, assign new value and save
        $cell = Cell::where('matrix_id', $matrix_id)
            ->where('x', $x)
            ->where('y', $y)
            ->where('z', $z)
            ->firstOrFail();

        $cell->value = $value;

        $cell->save();
    }

    public function queryMatrix($matrix_id, $x1, $y1, $z1, $x2, $y2, $z2) : int {
        //Sum all cel values between X1,Y1,Z1 and X2,Y2,Z2
        return Cell::where('matrix_id', $matrix_id)
            ->where('x', '>=', $x1)
            ->where('x', '<=', $x2)
            ->where('y', '>=', $y1)
            ->where('y', '<=', $y2)
            ->where('z', '>=', $z1)
            ->where('z', '<=', $z2)
            ->sum('value');
    }
}
