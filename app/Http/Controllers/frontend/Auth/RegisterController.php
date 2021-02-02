<?php

namespace App\Http\Controllers\frontend\Auth;

use App\Exports\UserExport;
use App\Mail\RegisterNotiyPlaced;
use App\Model\frontend\User;
use App\Notifications\UserRegisteredSuccessfully;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\RegistersUsers;
use Maatwebsite\Excel\Facades\Excel;

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
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /* Show register form*/
    public function getRegisterForm()
    {
        return view('frontend/auth/register');
    }	
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  request  $request
     * @return User
     */
    protected function saveRegisterForm(Request $request)
    {
	    $client = new \GuzzleHttp\Client();
	    $result = $client->post('https://www.google.com/recaptcha/api/siteverify', [
		    'form_params' => [
			    'secret'   => env('INVISIBLE_RECAPTCHA_SECRETKEY'),
			    'response' => $request->get('g-recaptcha-response')
		    ]
	    ]);
	    $result = json_decode($result->getBody(), true);
	    if(isset($result['success']) && $result['success']) {

		    $messages = array(
			    'name.required'     => '請輸入姓名',
			    'email.required'    => '請輸入姓名 Email',
			    'email.unique'      => '此信箱已經註冊過了，請改用其它信箱，或您已經是會員，可直接登入系統',
			    'password.required' => '請輸入密碼',
		    );

		    $rules = array(
			    //'name'     => 'required|max:255',
			    'email'    => 'required|email|max:255|unique:users',
			    'phone'    => 'required',
			    'password' => 'required|min:6|confirmed'
		    );

		    $validator = Validator::make(Input::all(), $rules, $messages);
		    if($validator->fails()) {
			    return redirect(route('user.register'))
				    ->withErrors($validator)
				    ->withInput();
		    }
		    $input = $request->all();
            /*if($request->is_newsletter=='on')
                $input['is_newsletter']=1;
            else
                $input['is_newsletter']=0;
            $image_width=800;
            $image_height=null;
            if ($request->hasFile('imgFile_idcard_image01')){
                $upload_filename = upload_file($request->file('imgFile_idcard_image01'), 'user', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg 、 *.jpeg 或 *.png 格式');
                    return redirect()->back();
                }
                $input['idcard_image01'] = $upload_filename;
            }
            if ($request->hasFile('imgFile_idcard_image02')){
                $upload_filename = upload_file($request->file('imgFile_idcard_image02'), 'user', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg 、 *.jpeg 或 *.png 格式');
                    return redirect()->back();
                }
                $input['idcard_image02'] = $upload_filename;
            }
            if ($request->hasFile('imgFile_driver_image01')){
                $upload_filename = upload_file($request->file('imgFile_driver_image01'), 'user', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg 、 *.jpeg 或 *.png 格式');
                    return redirect()->back();
                }
                $input['driver_image01'] = $upload_filename;
            }
            if ($request->hasFile('imgFile_driver_image02')){
                $upload_filename = upload_file($request->file('imgFile_driver_image02'), 'user', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg 、 *.jpeg 或 *.png 格式');
                    return redirect()->back();
                }
                $input['driver_image02'] = $upload_filename;
            }*/
		    $user = User::registeruser($input);
		    if($user->id) {
			    //Add by Eric
                //$file_name='UserExport'.date('YmdHis').'.xlsx';
                //Excel::store(new UserExport($user), $file_name,'public');
			    $user->notify(new UserRegisteredSuccessfully($user,''));


			    //$this->guard('user')->login($user);
			    return redirect('/')->with('modal_success_message', '您已註冊成功，請至您註冊的Emai信箱收取驗證信。');
		    } else {
			    return redirect(route('user.register'))->with('modal_failure_message', '會員註冊失敗');
		    }
	    }
	    else{
		    return redirect()->back()->with('modal_failure_message', '表單驗証錯誤');
	    }
        
    }

    /**
     * Activate user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function activateUser(string $activationCode)
    {
        $user=getLoginUser();
        if($user)
            return redirect('/activate_success')->with('modal_success_message', '您之前已成功驗證並登入網站了。');
        try {
            $user = User::where('activation_code', $activationCode)->first();
            if (!$user)
                return redirect('/')->with('modal_failure_message', '帳號驗證失敗，請確認連結是否失效或再申請重寄驗證信，或您之前已經驗證過了。');

            $user->status= 1;
            $user->is_activate= 1;
            $user->activation_code = null;
            $user->save();

            //$file_name='UserExport'.date('YmdHis').'.xlsx';
            //Excel::store(new UserExport($user), $file_name,'public');

            auth()->guard('user')->login($user);
            Session::flash('success_message', '您已經成功啟用帳號，目前已登入系統。');
            return redirect('/activate_success');
        } catch (\Exception $exception) {
            logger()->error($exception);
            return redirect('/')->with('modal_failure_message', '帳號驗證失敗，請確認連結是否失效或再申請重寄驗證信。');
        }
    }
    
}
