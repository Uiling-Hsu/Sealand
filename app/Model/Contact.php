<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{

    protected $fillable = [
        'name',
        'company',
        'contact_demand',
        'phone',
        'email',
        'message',
        'reply_message',
        'isreply',
        'isread',
    ];
}