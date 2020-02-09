<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package App
 */
class Category extends Model
{
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
