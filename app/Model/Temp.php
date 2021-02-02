<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Temp extends Model
{
    protected $fillable = [
        'cate_id',
        'user_id',
        'proarea_id',
        'sub_date',
    ];

    public function cate(){
        return $this->belongsTo('App\Model\Cate');
    }

    public function tempcars(){
        return $this->hasMany('App\Model\Tempcar');
    }
}
