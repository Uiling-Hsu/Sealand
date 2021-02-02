<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Productimage extends Model
{

    protected $fillable = [
        'product_id',
        'image',
        'image_spec_tw',
        'image_spec_en',
        'status',
        'sort',
    ];

    public function product() {
        return $this->belongsTo('App\Model\Product');
    }
}
