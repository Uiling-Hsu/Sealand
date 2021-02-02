<?php

namespace App\Http\Controllers\frontend_carplus\Auth;

use App\Model\frontend\SocialProvider;
use App\Model\frontend\User;
use App\Services\LineService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Hash;
use Socialite;

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
    protected $redirectTo = '/temp/20';

	protected $lineService;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LineService $lineService)
    {
	    $this->lineService = $lineService;
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function getLoginForm()
    {
        if(isUserLogin())
            return redirect('/temp/20');
        session()->put('previousUrl', url()->previous());
	    $line_url = $this->lineService->getLoginBaseUrl();
	    $remember_me=null;
	    $email=null;
	    $password=null;
	    if(isset($_COOKIE["cookie"])) {
            $cookie = $_COOKIE["cookie"];
            if(isset($cookie) && isset($cookie['remember_me']) && isset($cookie['email']) && isset($cookie['password'])) {
                $remember_me = $cookie['remember_me'];
                $email = $cookie['email'];
                $password = $cookie['password'];
            }
        }
        /*setcookie("cookie[remember_me]","1");
        setcookie("cookie[email]","sun.easy@msa.hinet.net");
        setcookie("cookie[password]","@Xx,80398501");*/
        return view('frontend_carplus/auth/login',compact('remember_me','email','password'));
        //return view('frontend_carplus/auth/login',compact('line_url'));
    }

	public function lineLoginCallBack(Request $request)
	{
		try {
			$error = $request->input('error', false);
			if ($error) {
				throw new Exception($request->all());
			}
			$code = $request->input('code', '');
			$response = $this->lineService->getLineToken($code);
			$user_profile = $this->lineService->getUserProfile($response['access_token']);
			if($user_profile) {
				$line_user_id = $user_profile['userId'];
				$line_display_name = $user_profile['displayName'];
				$line_picture_url = $user_profile['pictureUrl'];

				$socialProvider=SocialProvider::where('provider_id',$line_user_id)->where('provider','line')->first();
				if(!$socialProvider){
					$user=User::where('line_user_id',$line_user_id)->first();
					if(!$user) {
						$user = User::firstOrCreate([
							'line_user_id' => $line_user_id,
							'name'  => $line_display_name,
							'line_picture_url'  => $line_picture_url
						]);
					}
					$user->socialProvider()->create([
						'user_id' => $line_user_id,
						'provider_id' => $line_user_id,
						'provider' => 'line',
					]);
				}
				else {
					$user = $socialProvider->user;
				}
				auth()->guard('user')->login($user);
				return redirect('/temp/20')->with('modal_success_message','登入成功');
			}
			else{
				return redirect('/user/login')->with('modal_failure_message','登入失敗');
			}

			//echo "<pre>"; print_r($user_profile); echo "</pre>";

		} catch (Exception $ex) {
			Log::error($ex);
		}
	}

    //public function redirectTo()
    //{
    //    return str_replace(url('/'), '', session()->get('previousUrl','/'));
    //}


    public function authenticate(Request $request)
    {
        //dd($request->all());
        $email = $request->email;

        $password = $request->password;
        $user=User::where('email',$email)->first();
        $remember_me = $request->has('remember_me') ? true : false;
        if($remember_me){
            setcookie("cookie[remember_me]","1",time() + (86400 * 15));
            setcookie("cookie[email]",$request->email,time() + (86400 * 15));
            setcookie("cookie[password]",$request->password,time() + (86400 * 15));
        }
        else {
            setcookie("cookie[remember_me]", "", time() - (86400 * 30));
            setcookie("cookie[email]", "", time() - (86400 * 30));
            setcookie("cookie[password]", "", time() - (86400 * 30));
        }

        if(!$user){
            return redirect()->intended( route('carplus.user.login'))->with('modal_failure_message', '您輸入的帳號或密碼錯誤 !');
        }
        elseif($user->is_activate!=1){
            return redirect()->back()->with('modal_failure_message', '您必須先啟用您的帳號才能繼續登入網站，請至您的註冊信箱啟用帳號!');
        }
        elseif($user->status!=1){
            return redirect()->back()->with('modal_failure_message', '您的帳號目前無法使用，請洽網站管理人員');
        }
        /*elseif($login_field=='phone'){
            $p='@Xx,80398501';
            $h=Hash::make('@Xx,80398501');
            dd(Hash::check($p, $user->password));
            if(Hash::check($p, $user->password)) {
                auth()->guard('user')->login($user);
                return redirect()->intended('/temp/20')->with('modal_success_message', '登入成功!');
            }
            else
                dd('not');
        }*/
        elseif (auth()->guard('user')->attempt(['email' => $email, 'password' => $password ],$remember_me))
        {
            return redirect()->intended('/temp/20')->with('modal_success_message', '登入成功!');
            //return redirect()->intended('/temp/20')->with('modal_success_message', '登入成功!');
        }
        else
        {
            return redirect()->intended( route('carplus.user.login'))->with('modal_failure_message', '您輸入的帳號或密碼錯誤 !');
        }
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        try{
            $userinfo = Socialite::driver($provider)->user();
        }
        catch(\Exception $e){
            return redirect('/');
        }

        $socialProvider=SocialProvider::where('provider_id',$userinfo->getId())->first();
        if(!$socialProvider){
            $email=$userinfo->getEmail();
            $user=User::whereEmail($email)->first();
            if(!$user) {
                $user = User::firstOrCreate([
                    'email' => $userinfo->getEmail(),
                    'name'  => $userinfo->getName()
                ]);
            }
            $user->socialProvider()->create([
                'provider_id' => $userinfo->getId(),
                'provider' => $provider,
            ]);
        }
        else {
            $user = $socialProvider->user;
        }
        auth()->guard('user')->login($user);
        //session()->flash('success_message', '您已成功登入系統！。');
        //return redirect()->back();
        return redirect('/')->with('status', trans('page.login_message'));
    }
    
    public function getLogout()
    {
        auth()->guard('user')->logout();
        return redirect('/');
    }
    
}