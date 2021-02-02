<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Flowcat extends Model
{
    protected $fillable = [
        'title',
        'status',
        'sort',
    ];

    public function flowins(){
        return $this->hasMany('App\Model\Flowin')->orderBy('sort');
    }
}
