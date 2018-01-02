<?php



namespace Genv\Otc\Models;

use Illuminate\Database\Eloquent\Model;

class GoldType extends Model
{
    public $table = 'gold_types';

    public $fillable = ['name', 'unit', 'status'];
}
