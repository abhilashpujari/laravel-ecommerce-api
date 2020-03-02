<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    const BILLING = 'billing';
    const SHIPPING = 'shipping';
}
