<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Cate extends Model
{
    //protected $table = 'category';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'deposit',
        'basic_fee',
        'mile_fee',
        'mile_pre_month',
        'image',
        'image_xs',
        'image_temp',
        'is_display',
        'status',
        'sort',
    ];

    public function products()
    {
        return $this->hasMany('App\Model\Product');
    }

}
