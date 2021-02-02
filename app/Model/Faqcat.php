<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Faqcat extends Model
{
    protected $fillable = [
        'title_tw',
        'status',
        'sort',
    ];

    public function faqins(){
        return $this->hasMany('App\Model\Faqin')->orderBy('sort');
    }
}
