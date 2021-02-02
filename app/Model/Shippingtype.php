<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shippingtype extends Model
{
    protected $fillable=[
        'store_no',
        'region_id',
        'name',
        'spec',
        'store_text',
        'info_text',
        'image',
        'address',
        'tel',
        'opentime_title',
        'opentime_1',
        'opentime_2',
        'opentime_3',
        'ship_area',
        'is_web_ship',
        'is_rapid_ship',
        'sort',
        'status',
    ];

    //public function shippingtype2s(){
    //    return $this->hasMany('App\Model\Shippingtype2')->orderBy('sort');
    //}
}
