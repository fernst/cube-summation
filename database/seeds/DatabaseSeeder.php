<?php

use Illuminate\Database\Seeder;
use App\Models\Matrix;
use App\Models\Cell;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('MatrixSeeder');

        $this->command->info('Matrix and cells seeded!');
    }
}

class MatrixSeeder extends Seeder
{
    static $size = 5;

    /**
     * Create the first Matrix record
     */
    public function run()
    {
        DB::table('matrices')->delete();
        DB::table('cells')->delete();

        $matrix = Matrix::create(['size' => self::$size]);

        for ($x=1; $x <= self::$size; $x++) {
            for ($y=1; $y <= self::$size; $y++) {
                for ($z=1; $z <= self::$size; $z++) {
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
}
