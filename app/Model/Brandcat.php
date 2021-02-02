<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Brandcat extends Model
{
    protected $fillable = [
        'cate_id',
        'title',
        'sort',
        'status'
    ];

    public function cate(){
        return $this->belongsTo('App\Model\Cate');
    }

    public function brandins(){
        return $this->hasMany('App\Model\Brandin');
    }

}
