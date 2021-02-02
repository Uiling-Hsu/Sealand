<?php

namespace App\Http\Controllers\admin\Admin;

use App\Model\admin\Admin;
use App\Notifications\AdminRegisteredSuccessfully;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    public function resent()
    {
        return view('admin.auth.resent_email');
    }

    public function resent_post(Request $request)
    {
        $email=$request->email;
        $admin=Admin::whereEmail($email)->first();
        if($admin){
            if($admin->is_activate==1)
                return redirect()->back()->with('success_message','此帳號已經啟用過了，可正常登入網站');
            else{
                if(count($admin->socialProvider)>0)
                    return redirect()->back()->with('failure_message', '請使用Facebook帳號登入!');
                else{
                    $admin->activation_code=str_random(30).time();
                    $admin->update();
                    $admin->notify(new AdminRegisteredSuccessfully($admin));
                    return redirect('/admin/resent')->with('success_message','帳戶啟用信函已寄到您的Email信箱! 請至您的郵件信箱取得帳戶啟用信連結。 ( 請注意: 此連結只限24小時內有效 )');
                }
            }
        }
        else{
            return redirect()->back()->with('success_message','您所提供的電子郵件信箱錯誤, 請重新輸入您所註冊的電子郵件信箱, 或您還未加入會員。');
        }
    }

    public function showChangePasswordForm(){
        return view('admin.admin.changePassword');
    }

    public function changePassword(Request $request){
        //dd($request->all());
        if (!(Hash::check($request->get('current-password'), Auth::guard('admin')->user()->password))) {
            // The passwords matches
            session()->flash('failure_message', '原始密碼錯誤，請再試一次。');
            return redirect()->back();
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            session()->flash('failure_message', '新密碼不能和舊密碼一樣，請輸入不同的密碼。');
            return redirect()->back();
        }
        if(strlen($request->get('new-password'))<6){
            //Current password and new password are same
            session()->flash('failure_message', '新密碼的長度不可少於6。');
            return redirect()->back();
        }
        if(strcmp($request->get('new-password'), $request->get('new-password-confirm')) != 0){
            //Current password and new password are same
            session()->flash('failure_message', '新密碼和確認密碼輸入的值不相同。');
            return redirect()->back();
        }
        //Change Password
        $admin = Auth::guard('admin')->user();
        $admin->password = bcrypt($request->get('new-password'));
        $admin->save();
        session()->flash('success_message', '新密碼設定成功。');
        return redirect('/admin/changePassword');
    }

}
