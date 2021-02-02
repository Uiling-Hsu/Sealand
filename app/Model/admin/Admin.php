<?php

namespace App\Model\admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\AdminResetPasswordNotification;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;

 
class Admin extends Authenticatable
{
    use Notifiable, HasRoleAndPermission;
    
    protected $guard = 'admin';
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'partner_id',
        'name',
        'email',
        'phone',
        'address',
        'lineid',
        'company',
        'company_phone',
        'company_ext',
        'company_email',
        'company_address',
        'usertype',
        'password',
        'activation_code',
        'is_activate',
        'sort',
        'status',

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
            return Admin::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => bcrypt($input['password']),
                    'activation_code' => str_random(30).time(),
                ]);
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    public function roles()
    {
        return $this->belongsToMany('App\Model\Role')->whereStatus(1)->orderBy('sort');
    }

    public function partner()
    {
        return $this->belongsTo('App\Model\Partner');
    }
    
}
