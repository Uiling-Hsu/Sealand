<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    protected $fillable = [
        'title', 'months', 'discount', 'sort', 'status'
    ];
}
