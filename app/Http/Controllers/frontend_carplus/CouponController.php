<?php

namespace App\Http\Controllers\frontend_carplus;

use App\Model\Coupon;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart_type=$request->cart_type;
        $coupon = Coupon::where('coupon_code', $request->coupon_code)->first();
        if(!$coupon){
            return redirect()->back()->withErrors('您輸入錯誤的 企業代號/折價券序號, 請再試一次！');
        }

        //$cart_type=session()->get('cart_type');
        session()->put('coupon',[
           'coupon_name'=>$coupon->coupon_name,
           'coupon_type'=>$coupon->coupon_type,
           'coupon_code'=>$coupon->coupon_code,
           'discount'=>$coupon->discount(getNumbers($cart_type)->get('newTotal')),
        ]);
        //dd(getNumbers($cart_type)->get('newTotal'));
        //dispatch_now(new UpdateCoupon($coupon));

        return redirect()->back()->with('success_message','企業代號/折價券序號 已可開始享用折扣優惠');
    }

   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        session()->forget('coupon');
        return redirect()->route('checkout.index')->with('success_message', '企業代號/折價券序號 已取消');
    }
}
