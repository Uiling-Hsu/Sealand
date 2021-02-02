<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'ftitle',
        'title',
        'sort',
        'status',
    ];

}
