<?php

namespace App\Model;


use  App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoinType extends Model
{


    const TABLE = 'coin_type';

    /**
     * {@inheritdoc}
     */
    protected $table = self::TABLE;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label', 'name'
    ];

}
