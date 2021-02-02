<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ssite extends Model
{
    protected $fillable = [
        'title',
        'code',
        'sort',
        'status',
    ];

}
