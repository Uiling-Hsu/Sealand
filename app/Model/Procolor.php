<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Procolor extends Model
{
    protected $fillable = [
        'title', 'sort', 'status'
    ];
}
