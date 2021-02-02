<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wlog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'platform',
        'title',
        'content',
    ];

    public function user() {
        return $this->belongsTo('App\Model\frontend\User');
    }

}
