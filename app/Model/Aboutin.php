<?php

namespace App\Model;

use App\Aboutcat;
use App\Aboutin2;
use Illuminate\Database\Eloquent\Model;

class Aboutin extends Model
{
    protected $fillable = [
        'name',
        'title_tw',
        'title_en',
        'descript_tw',
        'descript_en',
        'content_tw',
        'quote',
        'quote_tw',
        'quote_url',
        'image',
        'youtube',
        'sort',
        'status',
        'published_at',
    ];

}
