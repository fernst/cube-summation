<?php
/**
 * Created by IntelliJ IDEA.
 * User: fernando
 * Date: 7/5/16
 * Time: 10:47 PM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Cell entity, containing cell position and value information
 *
 * Class Cell
 * @package App\Models
 */
class Cell extends Model
{
    protected $fillable = ['matrix_id', 'x', 'y', 'z', 'value'];
}
