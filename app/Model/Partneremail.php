<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Partneremail extends Model
{
    //protected $table = 'category';

    protected $fillable = [
        'partner_id',
        'email',
        'sort',
        'status',
    ];

    public function partner()
    {
        return $this->belongsTo('App\Model\Partner');
    }

}
