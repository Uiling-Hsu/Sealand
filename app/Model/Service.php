<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title_tw', 'title_en', 'content_tw', 'content_en', 'image', 'image_tw', 'position', 'youtube', 'video', 'is_shadow', 'sort'
    ];

}
