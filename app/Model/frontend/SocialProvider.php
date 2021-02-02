<?php

namespace App\Model\frontend;

use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
    protected $fillable = [
        'provider_id',
        'provider'
    ];

    public function user() {
        return $this->belongsTo('App\Model\frontend\User');
    }
}
