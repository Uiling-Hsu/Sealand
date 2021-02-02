<?php

namespace App\Model;

use App\Aboutin;
use Illuminate\Database\Eloquent\Model;

class Aboutin2 extends Model
{
    protected $fillable = [
        'aboutin_id', 'title', 'title_tw', 'content', 'content_tw', 'image', 'image_tw', 'position', 'youtube', 'video', 'is_shadow', 'sort'
    ];


    public function aboutin(){
        return $this->belongsTo('App\Model\Aboutin');
    }
}
