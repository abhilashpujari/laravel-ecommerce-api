<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App
 */
class Product extends Model
{
    public function attachments()
    {
        return $this->belongsToMany('App\Attachment', 'product_attachment');
    }
}
