<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'cate_id',
        'user_id',
        'ord_id',
        'proarea_id',
        'partner_id',
        'order_from',
        'sub_date',
        'pick_up_time',
        'product_id',
        'delivery_address',
        'return_delivery_address',
        'is_history',
        'is_cancel',
        'can_order_car',
        'is_babysitter_send_email',
        'is_carplus_send_email',
        'is_my2_email',
        'is_mn2_email',
        'is_mn2_baby_email',
        'ret_code',
        'ret_message',
        'memo',
    ];

    public function cate(){
        return $this->belongsTo('App\Model\Cate');
    }

    public function ord(){
        return $this->belongsTo('App\Model\Ord');
    }

    public function product(){
        return $this->belongsTo('App\Model\Product');
    }

    public function user() {
        return $this->belongsTo('App\Model\frontend\User');
    }

    public function proarea() {
        return $this->belongsTo('App\Model\Proarea');
    }

    public function partner() {
        return $this->belongsTo('App\Model\Partner');
    }

    public function subcars(){
        return $this->hasMany('App\Model\Subcar');
    }

}
