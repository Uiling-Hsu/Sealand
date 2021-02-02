<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Flowin extends Model
{
    protected $fillable = [
        'flowcat_id',
        'title',
        'descript',
        'image',
        'sort',
        'status',
    ];

}
