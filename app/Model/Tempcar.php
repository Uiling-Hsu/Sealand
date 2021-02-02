<?php

namespace App\Model;

use App\Model\Brandcat;
use Illuminate\Database\Eloquent\Model;

class Tempcar extends Model
{
    protected $fillable = [
        'cate_id',
        'user_id',
        'subscriber_id',
        'brandcat_id',
        'brandin_id',
        'sort',
    ];

    public function temp(){
        return $this->belongsTo('App\Model\Temp');
    }

}
