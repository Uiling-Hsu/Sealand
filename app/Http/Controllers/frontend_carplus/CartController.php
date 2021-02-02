<?php

namespace App\Http\Controllers\frontend_carplus;

use App\Model\Optionin;
use App\Model\Prodaddition;
use App\Model\Product;
use App\Model\ProductStock;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mightAlsoLike = Product::mightAlsoLike()->get();
        session()->forget('shippingtype_id');
        return view('frontend_carplus.cart');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        //$duplicates = Cart::search(function ($cartItem, $rowId) use ($request) {
        //    return $cartItem->id === $request->id;
        //});
        //檢查 cart_type
        $cart_type=$request->cart_type;

        //dd($request->optionin_id);
        $productstock=ProductStock::whereId($request->stock_id)->first();
        $optionin_title='';
        if($productstock && $productstock->optionin)
            $optionin_title=$productstock->optionin->title_tw;

        $product_name=$request->name.' / '.$optionin_title;
        $duplicates = Cart::instance($cart_type)->search(function($cartItem, $rowId) use ($product_name) {
            return $cartItem->name === $product_name;
        });

        //加購ID
        $prodaddition_id=$request->prodaddition_id;

        //如果主產品已購買過了
        if ($duplicates->isNotEmpty()) {
            //if($prodaddition_id){
            //    //加購
            //    $addition_product=Product::whereId($prodaddition_id)->first();
            //    if(!$addition_product || !$addition_product->productstocks)
            //        return redirect()->back()->with('modal_failure_message', '此加購商品發生問題，目前無法購買請見諒!');
            //
            //    $addition_product_name=$request->name.' / '.$optionin_title.' // '.$addition_product->title_tw;
            //    $duplicates_2 = Cart::instance($cart_type)->search(function($cartItem, $rowId) use ($addition_product_name) {
            //        return $cartItem->name === $addition_product_name;
            //    });
            //    if ($duplicates_2->isNotEmpty()) {
            //        session()->flash('success_message', '此加購商品之前已經加入購物車了!');
            //        return redirect()->back();
            //    }
            //    else{
            //        $prodaddition_optionin_id=$addition_product->productstocks? $addition_product->productstocks->first()->id:'';
            //        Cart::instance($cart_type)->add($prodaddition_id, $addition_product_name, 1, $addition_product->productstocks->first()->price, [ 'prod_name' => $addition_product->title_tw,'main_prod_rowId'=>$duplicates->first()->rowId,'type'=>'addition', 'productstock_id'=>$prodaddition_optionin_id])
            //            ->associate('App\Model\Product');
            //
            //        //return redirect()->route('cart.index')->with('success_message', 'Item was added to your cart!');
            //        if($request->direct_buy==1)
            //            return redirect('/checkout?cart_type='.$cart_type);
            //        else {
            //            session()->flash('success_message', '加購產品已成功加入購物車!');
            //            return redirect()->back();
            //        }
            //    }
            //
            //
            //}
            //else {
                if($request->direct_buy==1)
                    return redirect('/checkout?cart_type='.$cart_type);
                else {
                    session()->flash('success_message', '此商品之前已經加入購物車了!');
                    return redirect()->back();
                }
            //}
        }
        else {
            //主產品尚未購買，則加入購物車
            $cart=Cart::instance($cart_type)->add($request->id, $product_name, $request->qty, $request->price, [ 'prod_name' => $product_name,'type'=>'main', 'productstock_id'=>$productstock->id])
                ->associate('App\Model\Product');
            //加購
            //if($prodaddition_id) {
            //    $addition_product=Product::whereId($prodaddition_id)->first();
            //    if(!$addition_product || !$addition_product->productstocks)
            //        return redirect()->back()->with('modal_failure_message', '此加購商品發生問題，目前無法購買請見諒!');
            //
            //    $addition_product_name=$request->name.' / '.$optionin_title.' // '.$addition_product->title_tw;
            //
            //    $prodaddition_optionin_id=$addition_product->productstocks? $addition_product->productstocks->first()->id:'';
            //    Cart::instance($cart_type)->add($prodaddition_id, $addition_product_name, 1, $addition_product->productstocks->first()->price, [ 'prod_name' => $addition_product->title_tw,'main_prod_rowId'=>$cart->rowId,'type'=>'addition', 'productstock_id'=>$prodaddition_optionin_id])
            //        ->associate('App\Model\Product');
            //
            //    //return redirect()->route('cart.index')->with('success_message', 'Item was added to your cart!');
            //    if($request->direct_buy==1)
            //        return redirect('/checkout?cart_type='.$cart_type);
            //    else {
            //        session()->flash('success_message', '商品及加購產品已成功加入購物車!');
            //        return redirect()->back();
            //    }
            //}

            //if($request->direct_buy==1)
            //    return redirect('/checkout?cart_type='.$cart_type);
            //else {
                //return redirect()->route('cart.index')->with('success_message', 'Item was added to your cart!');
                session()->flash('success_message', '已成功加入購物車!');
                return redirect()->back();
            //}
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|between:1,30'
        ]);

        if ($validator->fails()) {
            session()->flash('errors', collect(['數量須介於1～30']));
            return response()->json(['success' => false], 400);
        }
        //Cart::instance($cart_type)->update($id, $request->quantity);
        Cart::instance('default')->update($id, $request->quantity);
        session()->flash('success_update', '數量已更新成功!');
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //dd($request->all());
        //dd(Cart::instance($cart_type)->content());
        //$type=$request->type;
        //dd($type);
        echo '<pre>';
        //if($type=='addition') {
        //    Cart::instance($cart_type)->remove($id);
        //}
        //else {
            foreach(Cart::instance('default')->content() as $item){
                $item_name_arr = explode(' // ', $item->name);
                if($item_name_arr && $item_name_arr[0] == $request->prod_name) {
                    Cart::instance('default')->remove($item->rowId);
                }
            }
        //}
        return back()->with('success_message', '商品已成功移除');
    }

    /**
     * Switch item for shopping cart to Save for Later.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function switchToSaveForLater($id)
    {
        $item = Cart::instance($cart_type)->get($id);

        Cart::instance($cart_type)->remove($id);

        $duplicates = Cart::instance('saveForLater')->search(function ($cartItem, $rowId) use ($id) {
            return $rowId === $id;
        });

        if ($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success_message', 'Item is already Saved For Later!');
        }

        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Product');

        return redirect()->route('cart.index')->with('success_message', 'Item has been Saved For Later!');
    }
}
