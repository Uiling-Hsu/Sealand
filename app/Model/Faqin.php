<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Faqin extends Model
{
    protected $fillable = [
        'faqcat_id',
        'title_tw',
        'descript_tw',
        'image',
        'youtube',
        'video',
        'sort',
        'status',
        'published_at',
    ];

    public function faqin2s(){
        return $this->hasMany('App\Model\Faqin2')->orderBy('sort');
    }
}
