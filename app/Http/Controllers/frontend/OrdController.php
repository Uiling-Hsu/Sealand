<?php

namespace App\Http\Controllers\frontend;

use App\Mail\OrdPlaced;
use App\Model\Ord;
use App\Http\Controllers\Controller;
use App\Model\Renewtate;
use App\Model\Subscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class OrdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=getLoginUser();
        $subscribers=Subscriber::where('user_id', $user->id)
            ->where('is_history', 0)
            ->orderBy('created_at','DESC')->get();
        $ords = Ord::where('user_id', $user->id)
            ->orderBy('created_at','DESC')->get();

        return view('frontend.ord_list', compact('subscribers','ords'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ord_no_paid_list()
    {
        $user=getLoginUser();
        $ords = Ord::where('user_id', $user->id)
            ->where('is_cancel',0)
            ->where('is_paid',0)
            ->orderBy('created_at','DESC')->get();
        return view('frontend.ord_list', compact('ords'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ord_no_paid2_list()
    {
        $user=getLoginUser();
        $ords = Ord::where('user_id', $user->id)
            ->where('is_cancel',0)
            ->where('is_paid',1)
            ->where('is_paid2',0)
            ->orderBy('created_at','DESC')->get();

        return view('frontend.ord_list', compact('ords'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ord_no_paid3_list()
    {
        $user=getLoginUser();
        $ords = Ord::where('user_id', $user->id)
            ->where('is_cancel',0)
            ->where('is_paid',1)
            ->where('is_paid2',1)
            ->where('is_paid3',0)
            ->orderBy('created_at','DESC')->get();

        return view('frontend.ord_list', compact('ords'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subscriber(Subscriber $subscriber)
    {
        $user=getLoginUser();
        if($subscriber->user_id!=$user->id)
            abort(403);
        $cate=$subscriber->cate;
        $product=$subscriber->product;
        $proarea=$subscriber->proarea;
        return view('frontend.subscriber', compact('subscriber','cate','product','proarea'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ord(Ord $ord)
    {
        $user=getLoginUser();
        if($ord->user_id!=$user->id && $user->id!=8 && $user->id!=25)
            abort(403);
        $cate=$ord->cate;
        $product=$ord->product;
        $proarea=$ord->proarea;

        $is_car_renewal=$ord->is_car_renewal;
        if($is_car_renewal==0)
            $list_renewtates=Renewtate::whereStatus(1)->whereIn('id',[2,3])->orderBy('sort')->pluck('ftitle','id');
        else
            $list_renewtates=Renewtate::whereStatus(1)->whereIn('id',[1,2,3,4])->orderBy('sort')->pluck('ftitle','id');
        if(!$ord->renewtate_id)
            $list_renewtates=$list_renewtates->prepend('請選擇','');

        $renewtate_id=Request('renewtate_id');
        if($renewtate_id!=''){
            $ord->renewtate_id=$renewtate_id;
            $ord->renewtate_date=date('Y-m-d H:i:s');
            $ord->update();
            $msg='';
            $renewtate=$ord->renewtate;
            if($renewtate)
                $msg='您已設定：'.$renewtate->ftitle;
            if($renewtate_id==2) {
                //更新此會員接下來的訂閱為不同方案換車續約階段
                $user->is_change_car=1;
                $user->before_renew_change_car_ord_id=$ord->id;
                $user->before_renew_change_car_ord_no=$ord->ord_no;
                $user->update();
                Session::flash('modal_success_message',$msg.'，請前往首頁下訂您要替换的車輛。');
                return redirect('/#list');
            }
            else {
                if($renewtate_id==1){
                    $ord->renew_month=3;
                    $ord->update();
                }
                $user->is_change_car=0;
                $user->before_renew_change_car_ord_id=null;
                $user->before_renew_change_car_ord_no=null;
                $user->update();
                Session::flash('modal_success_message', $msg);
            }
        }

        return view('frontend.ord', compact('ord','cate','product','proarea','list_renewtates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function order_cancel($ord_id)
    {
        if(!$ord_id)
            abort(404);
        $user=Auth::user();
        $ord =  Ord::whereId($ord_id)->first();
        if($ord){
            $ord->isCancel=1;
            $ord->updated_at=date('Y-m-d H:i:s');
            $ord->update();
            return redirect()->route('orders.index')->with('modal_success_message', '訂單已成功刪除！');
        }
        else{
            return redirect()->route('orders.index')->withErrors('刪除訂單失敗！');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_fee()
    {
        $user=getLoginUser();
        return view('frontend.user_fee', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user_fee_post(Request $request)
    {
        if(!$ord_id)
            abort(404);
        $user=Auth::user();
        $ord =  Ord::whereId($ord_id)->first();
        if($ord){
            $ord->isCancel=1;
            $ord->updated_at=date('Y-m-d H:i:s');
            $ord->update();
            return redirect()->route('orders.index')->with('modal_success_message', '訂單已成功刪除！');
        }
        else{
            return redirect()->route('orders.index')->withErrors('刪除訂單失敗！');
        }
    }
}
