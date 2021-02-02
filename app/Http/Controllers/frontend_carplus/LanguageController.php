<?php

namespace App\Http\Controllers\frontend_carplus;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Redirect;

class LanguageController extends Controller
{
    public function index($lang) {
        if($lang=='en' || $lang=='tw') {
            if(! Session::has('locale'))
                Session::put('locale', $lang);
            else
                session(['locale'=> $lang]);
        }
        return redirect()->back();
    }
}

