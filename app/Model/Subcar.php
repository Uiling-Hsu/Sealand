<?php

namespace App\Model;

use App\Model\Brandcat;
use Illuminate\Database\Eloquent\Model;

class Subcar extends Model
{
    protected $fillable = [
        'cate_id',
        'user_id',
        'subscriber_id',
        'brandcat_id',
        'brandin_id',
        'sort',
    ];

    public function subscriber(){
        return $this->belongsTo('App\Model\Subscriber');
    }

    public function brandcat(){
        return $this->belongsTo('App\Model\Brandcat');
    }

    public function brandin(){
        return $this->belongsTo('App\Model\Brandin');
    }

}
