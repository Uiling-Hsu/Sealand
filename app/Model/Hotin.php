<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;

class Hotin extends Model
{
    protected $fillable = [
        'title_tw',
        'title_en',
        'descript_tw',
        'descript_en',
        'image',
        'youtube',
        'quote',
        'quote_tw',
        'quote_url',
        'sort',
        'status',
        'published_at'
    ];

    public function hotin2s(){
        return $this->hasMany('App\Model\Hotin2')->orderBy('sort');
    }
}
