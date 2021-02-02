<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'coupon_name',
        'start_date',
        'end_date',
        'coupon_type',
        'discount',
        'minus',
        'product_id',
        'coupon_code',
        'used',
        'used_date',
        'memo',
        'reuse',
    ];

    public static function findByCode($code)
    {
        return self::where('code', $code)->first();
    }

    public function discount($total)
    {
        if ($this->coupon_type == 'fixed') {
            return $this->minus;
        } elseif ($this->coupon_type == 'percent') {
            return round(((100-$this->discount) / 100) * $total);
        } else {
            return 0;
        }
    }
}
