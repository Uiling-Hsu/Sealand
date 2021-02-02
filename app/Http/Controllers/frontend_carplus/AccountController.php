<?php

namespace App\Http\Controllers\frontend_carplus;

use App\Mail\SendMail\SendUserEmail;
use App\Mail\UserUpdateNotifyPlaced;
use App\Model\frontend\User;
use App\Model\Ssite;
use App\Notifications\UserRegisteredSuccessfully;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user=Auth::guard('user')->user();
        $list_ssites=Ssite::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('選選擇','');
        return view('frontend_carplus.user_update', compact('user','list_ssites'));
    }

    public function update(Request $request)
    {
        /*error_reporting(E_ALL);
        ini_set("display_errors", 1);*/
        $inputs=$request->all();
        //if($request->is_newsletter=='on')
        //	$inputs['is_newsletter']=1;
        //else
        //	$inputs['is_newsletter']=0;
        //dd($request->all());
        $user=getLoginUser();
        $image_width=1000;
        $image_height=null;
        if ($request->hasFile('imgFile_idcard_image01')){
            $upload_filename = upload_user_image_file($user->id.'aa1a', $request->file('imgFile_idcard_image01'), $image_width, $image_height);

            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $save_filename=explode('/',$upload_filename);
            $save_filename=watermark($upload_filename,'assets/images/water.png',end($save_filename));
            if($user->idcard_image01 && file_exists(storage_path('app/user/').$user->idcard_image01))
                unlink(storage_path('app/user/').$user->idcard_image01);
            $inputs['idcard_image01'] = $save_filename;
            $inputs['upload_at'] = date('Y-m-d H:i:s');
        }
        if ($request->hasFile('imgFile_idcard_image02')){
            $upload_filename = upload_user_image_file($user->id.'aa2a', $request->file('imgFile_idcard_image02'), $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $save_filename=explode('/',$upload_filename);
            $save_filename=watermark($upload_filename,'assets/images/water.png',end($save_filename));
            if($user->idcard_image02 && file_exists(storage_path('app/user/').$user->idcard_image02))
                unlink(storage_path('app/user/').$user->idcard_image02);
            $inputs['idcard_image02'] = $save_filename;
            $inputs['upload_at'] = date('Y-m-d H:i:s');
        }
        if ($request->hasFile('imgFile_driver_image01')){
            $upload_filename = upload_user_image_file($user->id.'aa3a', $request->file('imgFile_driver_image01'), $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $save_filename=explode('/',$upload_filename);
            $save_filename=watermark($upload_filename,'assets/images/water.png',end($save_filename));
            if($user->driver_image02 && file_exists(storage_path('app/user/').$user->driver_image02))
                unlink(storage_path('app/user/').$user->driver_image02);
            $inputs['driver_image01'] = $save_filename;
            $inputs['upload_at'] = date('Y-m-d H:i:s');
        }
        if ($request->hasFile('imgFile_driver_image02')){
            $upload_filename = upload_user_image_file($user->id.'aa4a', $request->file('imgFile_driver_image02'), $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $save_filename=explode('/',$upload_filename);
            $save_filename=watermark($upload_filename,'assets/images/water.png',end($save_filename));
            if($user->driver_image02 && file_exists(storage_path('app/user/').$user->driver_image02))
                unlink(storage_path('app/user/').$user->driver_image02);
            $inputs['driver_image02'] = $save_filename;
            $inputs['upload_at'] = date('Y-m-d H:i:s');
        }
        $user->update($inputs);
        $submit_send_email=$request->submit_send_email;
        if($submit_send_email=='通知保姆') {
            send_babysitter_user_email($user,  $user->name.'/會員資料審查通知', 'cy1');
            session()->flash('modal_success_message', '資料更新成功，SeaLand確認資料後為您開通訂閱功能，並Email通知您。');
            //writeLog('更新 使用者, 並送出給保姆',$inputs,0);
        }
        else
            session()->flash('modal_success_message', '基本資料更新成功。');
        $list_ssites=Ssite::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('選選擇','');
        return view('frontend_carplus.user_update', compact('user','list_ssites'));
    }

    public function recipient_edit()
    {
        $user=Auth::guard('user')->user();
        return view('recipient', compact('user'));
    }

    public function recipient_update(Request $request)
    {
        //dd($request->all());
        $inputs=$request->all();
        $user=Auth::guard('user')->user();
        $user->update($inputs);
        session()->flash('success_message', '收件人資訊更新成功。');
        return view('recipient', compact('user'));
    }

    public function newsletter_edit()
    {
        $user=Auth::guard('user')->user();
        return view('newsletter', compact('user'));
    }

    public function newsletter_update($isNewsletter)
    {
        $user=Auth::guard('user')->user();
        if($isNewsletter=='true') {
            $user->isNewsletter = 1;
            $user->update();
        }
        elseif($isNewsletter=='false') {
            $user->isNewsletter = 0;
            $user->update();
        }
        return redirect()->route('newsletter.edit');
    }

    public function showChangePasswordForm(){
        return view('frontend_carplus.changepassword');
    }

    public function changePassword(Request $request){
        //dd($request->all());
        /*if (!(Hash::check($request->get('current-password'), Auth::guard('user')->user()->password))) {
            // The passwords matches
            session()->flash('error_message', '原始密碼錯誤，請再試一次。');
            return redirect()->back();
        }*/
        /*if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            session()->flash('error_message', '新密碼不能和舊密碼一樣，請輸入不同的密碼。');
            return redirect()->back();
        }*/
        if(strlen($request->get('new-password'))<6){
            //Current password and new password are same
            session()->flash('error_message', '新密碼的長度不可少於6。');
            return redirect()->back();
        }
        if(strcmp($request->get('new-password'), $request->get('new-password-confirm')) != 0){
            //Current password and new password are same
            session()->flash('error_message', '新密碼和確認密碼輸入的值不相同。');
            return redirect()->back();
        }
        //Change Password
        $user = Auth::guard('user')->user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        session()->flash('modal_success_message', '新密碼更新成功。');
        return redirect('/');
    }

    public function resent()
    {
        return view('frontend_carplus.user_resent');
    }

    public function resent_post(Request $request)
    {
        $email=$request->email;
        $user=User::whereEmail($email)->first();
        if($user){
            if($user->is_activate==1)
                return redirect()->back()->with('modal_success_message','此帳號已經啟用過了，可正常登入網站');
            else{
                if(count($user->socialProvider)>0)
                    return redirect()->back()->with('modal_failure_message', '請使用Facebook帳號登入!');
                else{
                    $user->activation_code=str_random(30).time();
                    $user->update();
                    $user->notify(new UserRegisteredSuccessfully($user));
                    return redirect('/')->with('modal_success_message','帳戶啟用信函已寄到您的Email信箱! 請至您的郵件信箱取得帳戶啟用信連結。 ( 請注意: 此連結只限24小時內有效 )');
                }
            }
        }
        else{
            return redirect()->back()->with('modal_success_message','您所提供的電子郵件信箱錯誤, 請重新輸入您所註冊的電子郵件信箱, 或您還未加入會員。');
        }
    }

    public function point($item='white')
    {
        if (!in_array($item, ['red','white','cash']))
            abort(404);
        $user=getLoginUser();
        $points=$user->{$item.'points'};
        $item_name='R點';
        return view('frontend_carplus.point',compact('points','item','item_name'));
    }
}
