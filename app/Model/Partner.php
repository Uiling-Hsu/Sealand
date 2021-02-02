<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class Partner extends Model
{
    //protected $table = 'category';

    protected $fillable = [
        'dealer_id',
        'proarea_id',
        'title',
        'email',
        'phone',
        'cell_phone',
        'address',
        'contact_person',
        'rate',
        'sort',
        'status',
    ];

    public function partneremails()
    {
        return $this->hasMany('App\Model\Partneremail');
    }

    public function proarea()
    {
        return $this->belongsTo('App\Model\Proarea');
    }

    public function dealer()
    {
        return $this->belongsTo('App\Model\Dealer');
    }

}
