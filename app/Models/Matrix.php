<?php
/**
 * Created by IntelliJ IDEA.
 * User: fernando
 * Date: 7/5/16
 * Time: 10:47 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use MatrixSeeder;

/**
 * Matrix entity, containing size information.
 *
 * Class Matrix
 * @package App\Models
 */
class Matrix extends Model
{
    protected $fillable = ['size'];

    /**
     * Eloquent relation that maps all cells belonging to a Matrix
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cells()
    {
        return $this->hasMany('App\Models\Cell', 'matrix_id', 'id');
    }

    /**
     * Declaring the event handler for matrix deleting (deleting related cells)
     */
    protected static function boot() {
        parent::boot();

        static::deleting(function($matrix) {
            $matrix->cells()->delete();
        });
    }
}
