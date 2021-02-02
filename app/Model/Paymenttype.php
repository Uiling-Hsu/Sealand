<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Paymenttype extends Model
{
    protected $fillable=[
        'name',
        'spec',
        'bank_info',
        'bank_account',
        'info_text',
        'status',
        'sort',
    ];
}
