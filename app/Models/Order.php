<?php

namespace Genv\Otc\Models;

class Order extends Model
{
    // Attributes.
    protected $table = 'orders';
    protected $fillable = [
        'id', 'order_code', 'ad_id', 'ad_code', 'ad_user_id', 'user_id', 'ad_price', 'amount', 'qty', 'payterm',
        'finish_time', 'status', 'order_desc', 'buyer_estimate', 'seller_estimate', 'created_at', 'updated_at', 'coin_type'
    ];
    protected $guarded = [];

    /* ---- Everything after this line will be preserved. ---- */

    public function user()
    {
        return $this->belongsTo(User ::class);
    }

    public function aduser(){
        return $this->hasOne('Genv\Otc\Models\User','id','ad_user_id');

    }

    public function comments()
    {

        return $this->hasMany(OrderComment::class)->orderBy('created_at', 'desc');

        //return $this->hasOne(' Genv\Otc\Models\User', 'id', 'ad_user_id');

    }


    public function advertiser(){

        return $this->hasOne('Genv\Otc\Models\User', 'id', 'ad_user_id');

    }

}
