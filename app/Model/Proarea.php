<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Proarea extends Model
{
    protected $fillable = [
        'title', 'sort', 'status'
    ];
}
