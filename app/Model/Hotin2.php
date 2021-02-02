<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Hotin2 extends Model
{
    protected $fillable = [
        'hotin_id', 'title_tw', 'title_en', 'content_tw', 'content_en', 'image', 'image_tw', 'position', 'youtube', 'video', 'is_shadow', 'sort'
    ];


    public function hotin(){
        return $this->belongsTo('App\Model\Hotin');
    }
}
