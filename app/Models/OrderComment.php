<?php

namespace Genv\Otc\Models;
use  Genv\Otc\Models\User;


class OrderComment extends Model
{
    // Attributes.
     protected $table = 'order_comment';
    protected $fillable = [
        'id', 'order_id', 'message','created_at', 'updated_at'
    ];
    protected $guarded = [];

    /* ---- Everything after this line will be preserved. ---- */

    public function order()
    {
        return $this->belongsTo(Order::class);
    }



}
