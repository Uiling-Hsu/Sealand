<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Progeartype extends Model
{
    protected $fillable = [
        'title', 'sort', 'status'
    ];
}
