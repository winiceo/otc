<?php

namespace Genv\Otc\Models;

use Illuminate\Database\Eloquent\Model;

class CoinType extends Model
{
    const TABLE = 'coin_types';

    protected $table = self::TABLE;

    public $fillable = ['name', 'label', 'status'];
}
