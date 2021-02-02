<?php

namespace App\Model\frontend;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\UserResetPasswordNotification;


class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'line_user_id',
        'line_picture_url',
        'name',
        'email',
        'phone',
        'telephone',
        'birthday',
        'id_type',
        'idno',
        'id_year',
        'id_month',
        'id_day',
        'idcard_image01',
        'idcard_image02',
        'driver_image01',
        'driver_image02',
        'driver_no',
        'applyreason',
        'ssite_id',
        'address',
        'emergency_contact',
        'emergency_phone',
        'company_name',
        'company_no',
        'lineid',
        'company',
        'company_phone',
        'company_address',
        'company_no',
        'bank_name',
        'bank_branch',
        'bank_no',
        'white_point',
        'delivery_name',
        'delivery_email',
        'delivery_phone',
        'delivery_telephone',
        'delivery_address',
        'edm',
        'gender',
        'password',
        'activation_code',
        'is_activate',
        'is_newsletter',
        'is_check',
        'check_date',
        'is_temp_notify_email',
        'is_review_email',
        'is_reject_email',
        'reject_reason',
        'is_send_user_data_and_cate_email',
        'is_my1_1_email',
        'is_mn1_1_email',
        'is_review_email',
        'is_change_car',
        'before_renew_change_car_ord_id',
        'before_renew_change_car_ord_no',
        'samecartate_id',
        'subscriber_id',
        'fee_title',
        'e_tag',
        'park_fee',
        'ticket',
        'maintain_fee',
        'custom_title',
        'custom_fee',
        'total',
        'status',
        'upload_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public static function registeruser($input = array()) {
		return User::create([
		    'name' => $input['name'],
		    'email' => $input['email'],
		    'phone' => $input['phone'],
		    /*'birthday' => $input['birthday'],
		    'idno' => $input['idno'],
		    'emergency_contact' => $input['emergency_contact'],
		    'emergency_phone' => $input['emergency_phone'],
		    'is_newsletter' => $input['is_newsletter'],
		    'idcard_image01' => $input['idcard_image01'],
		    'idcard_image02' => $input['idcard_image02'],
		    'driver_image01' => $input['driver_image01'],
		    'driver_image02' => $input['driver_image02'],
		    'driver_no' => $input['driver_no'],*/
		    'password' => bcrypt($input['password']),
		    'activation_code' => str_random(30).time(),
		]);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function socialProvider()
    {
        return $this->hasMany('App\Model\frontend\SocialProvider');
    }

    public function usergates(){
        return $this->hasMany('App\Model\Usergate')->whereStatus(1);
    }

    public function ssite(){
        return $this->belongsTo('App\Model\Ssite');
    }

    public function samecartate(){
        return $this->belongsTo('App\Model\Samecartate');
    }

    public function subscriber(){
        return $this->belongsTo('App\Model\Subscriber');
    }

    public function subscribers(){
        return $this->hasMany('App\Model\Subscriber');
    }
}
