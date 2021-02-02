<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title_tw',
        'title_en',
        'descript_tw',
        'descript_en',
        'image',
        'url',
        'btn_title',
        'btn_title_tw',
        'sort',
        'status',
    ];
}
