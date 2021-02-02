<?php

namespace App\Http\Controllers\frontend_carplus;

use App\Model\frontend\User;
use App\Model\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders=Slider::where('status','1')->orderBy('sort')->get();
        return view('frontend_carplus.index',compact('sliders'));
    }
    
    //public function dashboard()
    //{
    //
    //
    //    return view('frontend_carplus.dashboard');
    //
    //}
    
}
