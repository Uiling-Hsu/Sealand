<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    protected $fillable = [
        'title',
        'rate_carplus',
        'rate_sealand',
        'rate_carplus_commission',
        'sort',
        'status',
    ];

}
