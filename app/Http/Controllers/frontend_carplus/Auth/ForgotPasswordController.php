<?php

namespace App\Http\Controllers\frontend_carplus\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Password;

class ForgotPasswordController extends Controller
{
    /*
     |--------------------------------------------------------------------------
     | Password Reset Controller
     |--------------------------------------------------------------------------
     |
     | This controller is responsible for handling password reset emails and
     | includes a trait which assists in sending these notifications from
     | your application to your users. Feel free to explore this trait.
     |
     */
    
    use SendsPasswordResetEmails;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:user');
    }
    
    protected function broker()
    {
        return Password::broker('users');
    }
    
    public function showLinkRequestForm()
    {
        return view('frontend_carplus.auth.passwords.email');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return back()->with('modal_status', '密碼重置信件已寄出');
    }
}