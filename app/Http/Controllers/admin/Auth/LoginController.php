<?php

namespace App\Http\Controllers\admin\Auth;
use App\Model\admin\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    public function getLoginForm()
    {
        if(isAdminLogin())
            return redirect('/admin');
        session()->put('previousUrl', url()->previous());
        return view('admin/auth/login');
    }

    //public function redirectTo()
    //{
    //    return str_replace(url('/'), '', session()->get('previousUrl','/'));
    //}
    
    public function authenticate(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $admin=Admin::where('email',$email)->whereStatus(1)->first();
        if(!$admin)
            return redirect()->intended('admin/login')->with('modal_failure_message', '帳號或密碼錯誤，或您沒有權限訪問後台，請洽網站管理人員 !');

        if (auth()->guard('admin')->attempt(['email' => $email, 'password' => $password ])){
            $previousUrl=session()->get('previousUrl');
            if(strpos($previousUrl, 'admin/login'))
                return redirect()->intended('/admin/dashboard')->with('success_message', '您已成功登入系統 !');
            else
                return redirect()->intended(session()->get('previousUrl','/admin/ord'))->with('success_message', '您已成功登入系統 !');
        }
        else
            return redirect()->intended('admin/login')->with('modal_failure_message', '帳號或密碼錯誤 !');
    }


    public function getLogout()
    {
        auth()->guard('admin')->logout();
        return redirect()->intended('admin/login');
    }

}
