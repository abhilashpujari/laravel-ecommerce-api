<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function payment()
    {
        return $this->hasOne('App\Payment');
    }

    public function orderItems()
    {
        return $this->hasMany('App\Order_Item');
    }

    public function addresses()
    {
        return $this->belongsToMany('App\Address', 'order_address');
    }
}
