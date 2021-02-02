<?php

namespace App\Http\Controllers\frontend;

use App\Model\Coupon;
use App\Model\Whitepoint;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WhitepointController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$whitepoint = Whitepoint::where('coupon_code', $request->coupon_code)->first();
        //if(!$coupon){
        //    return redirect()->back()->withErrors('您輸入錯誤的 企業代號/折價券序號, 請再試一次！');
        //}
        $whitepoint=getPoints('white');
        if($request->white_point>$whitepoint)
            return redirect()->back()->with('success_message','您輸入的點數超過額度');

        session()->put('white_point',$request->white_point);

        //dd(getNumbers('default')->get('newTotal'));
        //dispatch_now(new UpdateCoupon($coupon));

        return redirect()->back()->with('success_message','R點點數抵用成功');
    }

   /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        session()->forget('white_point');
        return redirect()->route('cart.index')->with('success_message', '使用R點點 已取消');
    }
}
