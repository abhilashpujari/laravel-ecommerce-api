<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function attachments()
    {
        return $this->belongsToMany('App\Attachment', 'product_attachment');
    }
}
