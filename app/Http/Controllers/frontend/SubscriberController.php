<?php

namespace App\Http\Controllers\frontend;

use App\Mail\SubscriberPlaced;
use App\Model\Brandcat;
use App\Model\Brandin;
use App\Model\Cate;
use App\Model\Proarea;
use App\Model\Subcar;
use App\Model\Subscriber;
use App\Model\Temp;
use App\Model\Tempcar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscriber_list(){
        $user=getLoginUser();
        $subscribers=Subscriber::where('user_id',$user->id)->where('is_history',0)->orderBy('cate_id')->get();
        return view('frontend.subscriber_list',compact('subscribers'));
    }

    function subscriber(Subscriber $subscriber) {
        if(!$subscriber)
            abort(404);
        if($subscriber->is_history==1)
            abort(404);

        $user=getLoginUser();
        if($subscriber->user_id!=$user->id)
            abort(404);
        $cate=$subscriber->cate;
        $proarea=$subscriber->proarea;
        $subcars=$subscriber->subcars;

        return view('frontend.subscriber',compact('subscriber','cate','proarea','subcars','user'));
    }

}
