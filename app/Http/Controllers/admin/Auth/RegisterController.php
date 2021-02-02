<?php

namespace App\Http\Controllers\admin\Auth;

use App\Model\admin\Admin;
use App\Notifications\AdminRegisteredSuccessfully;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | Register Controller
     |--------------------------------------------------------------------------
     |
     | This controller handles the registration of new users as well as their
     | validation and creation. By default this controller uses a trait to
     | provide this functionality without requiring any additional code.
     |
     */
    
    use RegistersUsers;
    
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function getRegisterForm()
    {
        if(isAdminLogin())
            return redirect('/admin');
        //->with('success_message','您已經登入系統')
        return view('admin/auth/register');
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  request  $request
     * @return User
     */
    protected function saveRegisterForm(Request $request)
    {
        $messages = array(
            'name.required' => '請輸入姓名',
            'email.required' => '請輸入姓名 Email',
            'email.unique' => '此信箱已經註冊過了，請改用其它信箱，或您已經是會員，可直接登入系統',
            'password.required' => '請輸入密碼',
            'password.min' => '密碼長度至少需要輸入8碼或以上',
        );
        
        $rules = array(
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:admins', // table name for check already exist or not
            'password' => 'required|min:6|confirmed',
        );
        
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('admin/register')
            ->withErrors($validator)
            ->withInput();
        }

        $input = $request->all();
        $admin = Admin::registeruser($input);

        if($admin->id){
            //Add by Eric
            $admin->notify(new AdminRegisteredSuccessfully($admin));
            //$this->guard('admin')->login($admin);
            return redirect( '/admin/register')->with('modal_success_message', '您已註冊成功，請至您註冊的Emai信箱收取驗證信。');
        }else{
            return redirect(route('admin.register'))->with('failure_message', '會員註冊失敗');
        }
        
    }

    /**
     * Activate user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Admin
     */
    protected function activateAdmin(string $activationCode)
    {
        try {

            $admin = Admin::where('activation_code', $activationCode)->first();
            if (!$admin) {
                return redirect('/admin/register')->with('modal_failure_message', '帳號驗證失敗，請確認連結是否失效或再申請重寄驗證信，或者您之前已驗証過此帳號。');
            }
            $admin->status= 1;
            $admin->is_activate= 1;
            $admin->activation_code = null;
            $admin->save();
            auth()->guard('admin')->login($admin);
            //Session::flash('success_message', '您已經順利啟用帳號，並成功登入系統。');
            return redirect()->to('/admin')->with('success_message', '您已經順利啟用帳號，並成功登入系統。');
        } catch (\Exception $exception) {
            logger()->error($exception);
            return redirect('/admin')->with('modal_failure_message', '帳號驗證失敗，請確認連結是否失效或再申請重寄驗證信。');
        }
    }
}