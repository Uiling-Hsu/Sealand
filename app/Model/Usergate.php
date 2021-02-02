<?php

namespace App\Model;

use App\Model\Brandcat;
use Illuminate\Database\Eloquent\Model;

class Usergate extends Model
{
    protected $fillable = [
        'subscriber_id',
        'user_id',
        'is_send_email',
        'status',
    ];

    public function subscriber(){
        return $this->belongsTo('App\Model\Subscriber');
    }

    public function user(){
        return $this->belongsTo('App\Model\User');
    }

}
