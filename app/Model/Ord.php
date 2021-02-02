<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ord extends Model
{
    protected $fillable = [
        'user_id',
        'state_id',
        'renewtate_id',
        'renewtate_date',
        'is_renewtate_setting_finish',
        'ord_no',
        'checkout_no',
        'checkout_no2',
        'checkout_no3',
        'is_renew_order',
        'renew_month',
        'renew_ord_id',
        'renew_ord_no',
        'deposit',
        'payment_total',
        'subscriber_id',
        'cate_id',
        'cate_title',
        'rent_month',
        'partner_id',
        'partner2_id',
        'partner3_id',
        'order_from',
        'is_carplus',
        'product_id',
        'model',
        'plate_no',
        'milage',
        'back_milage',
        'mile_fee_total',
        'e_tag',
        'damage_fee',
        'business_loss_title',
        'business_loss',
        'delay_fee',
        'over_milage',
        'fuel_cost',
        'service_charge',
        'other_fee_total',
        'payment_backcar_total',
        'proarea_id',
        'sub_date',
        'pick_up_time',
        'real_sub_date',
        'real_sub_time',
        'expiry_date',
        'expiry_time',
        'real_back_date',
        'real_back_time',
        'delivery_address',
        'return_delivery_address',
        'brandcat_name',
        'brandin_name',
        'coupon_name',
        'coupon_type',
        'discount',
        'coupon_code',
        'total',
        'is_cancel',
        'cancel_date',
        'cancel_reason',
        'is_paid_send_email',
        'is_paid',
        'paid_date',
        'is_creditpay_success',
        'creditpay_return_code',
        'creditpay_return_message',
        'is_paid2_send_email',
        'is_paid2',
        'paid2_date',
        'is_creditpay_success2',
        'creditpay_return_code2',
        'creditpay_return_message2',
        'is_paid3_send_email',
        'is_paid3',
        'paid3_date',
        'is_creditpay_success3',
        'creditpay_return_code3',
        'creditpay_return_message3',
        'name',
        'phone',
        'telephone',
        'email',
        'address',
        'paymenttype_id',
        'shippingtype_id',
        'memo',
        'is_car_renewal',
        'is_ord_renewal',
        'is_partner_renewal_notify_email',
        'is_partner_remind_delivery_car_email',
        'is_user_renewal_notify_email',
        'close_date',
        'close_time',
        'is_pass_by_api',
        'upload_5code',
        'upload_total',
        'upload_date',
        'upload_memo',
        'created_at',
    ];

    public function user() {
        return $this->belongsTo('App\Model\frontend\User');
    }

    public function partner() {
        return $this->belongsTo('App\Model\Partner');
    }

    public function partner2() {
        return $this->belongsTo('App\Model\Partner','partner2_id');
    }

    public function state() {
        return $this->belongsTo('App\Model\State');
    }

    public function renewtate() {
        return $this->belongsTo('App\Model\Renewtate');
    }

    public function product() {
        return $this->belongsTo('App\Model\Product');
    }

    public function subscriber() {
        return $this->belongsTo('App\Model\Subscriber');
    }

    public function cate() {
        return $this->belongsTo('App\Model\Cate');
    }

    public function proarea() {
        return $this->belongsTo('App\Model\Proarea');
    }

    public function paymenttype() {
        return $this->belongsTo('App\Model\Paymenttype');
    }

    public function shippingtype() {
        return $this->belongsTo('App\Model\Shippingtype');
    }
}
