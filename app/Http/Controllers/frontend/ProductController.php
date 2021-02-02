<?php

namespace App\Http\Controllers\frontend;

use App\Model\Brandcat;
use App\Model\Brandin;
use App\Model\Cate;
use App\Model\CategoryProduct;
use App\Model\Department;
use App\Model\Period;
use App\Model\Proarea;
use App\Model\ProddailyStock;
use App\Model\Product;
use App\Model\Category;
use App\Model\Productimage;
use App\Model\ProductStock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{

    public function list()
    {
		$price=Request('price');
		if(!$price)
			$price='6800';
		$brandcat_arr=array();
		$products=Product::whereStatus(1)->where('price',$price)->groupBy('brandcat_id')->select('id','brandcat_id')->get();
		if($products)
			foreach($products as $product)
				$brandcat_arr[]=$product->brandcat_id;

	    $list_brandcats=Brandcat::whereStatus(1)->where('status','1')
		    ->whereIn('id',$brandcat_arr)
		    ->orderBy('sort')
		    ->pluck('title','id')
		    ->prepend('請選擇','');

	    $list_proareas=Proarea::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
	    //$first_brandcat=Brandcat::where('status','1')->orderBy('sort')->first();
	    $list_brandins=[];
        $products=Product::whereStatus(1)->orderBy('sort')->paginate(30);
	    /*if($first_brandcat)
	        $list_brandins=Brandin::where('status','1')->where('brandcat_id',$first_brandcat->id)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');*/
        return view('frontend.product_list',compact('products','list_brandcats','list_brandins','list_proareas'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
		if(!$product)
			abort(404);
		$list_periods=Period::whereStatus(1)->orderBy('sort')->pluck('title','id');
	    //session()->put('checkout',1);
        return view('/frontend/product', compact('product','list_periods'));
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function fetch_data(Request $request)
    {
		$action=$request->action;
		if($action=='fetch_data'){
			//$minimum_price=$request->minimum_price;
			//$maximum_price=$request->maximum_price;
			//$products=Product::where('price','>=',$minimum_price)->where('price','<=',$maximum_price);
			$price=$request->price;
			$products=Product::where('price',$price);
			$brandcat_id=$request->brandcat_id;
			if($brandcat_id) {
				$products=$products->where('brandcat_id',$brandcat_id);
				$brandin_id=$request->brandin_id;
				if($brandin_id)
					$products=$products->where('brandin_id',$brandin_id);
				//$products = $products->where(function($q) use($brands) {
				//	foreach($brands as $brand){
				//		$q->orWhere('brandcat_name', $brand);
				//	}
				//});
			}
			$proarea_id=$request->proarea_id;
			if($proarea_id) {
				$products=$products->where('proarea_id',$proarea_id);
			}
			$products=$products->get();
			$output='';
			if($products->count()>0) {
				foreach($products as $product) {
					$output.='	
						<div class="col-sm-4 product">
                            <span class="product-thumb-info border-0">
                                <a href="/product/'.$product->id.'" class="add-to-cart-product bg-color-primary">
                                    <span class="text-uppercase text-4">前往訂閱</span>
                                </a>
                                <a href="/product/'.$product->id.'">
                                    <span class="product-thumb-info-image">
                                        <img alt="" class="img-fluid" src="'.$product->image.'">
                                    </span>
                                </a>
                                <span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
                                    <a href="/product/'.$product->id.'">
                                        <h4 class="text-4 text-primary">'.$product->name.'</h4>
                                        <span class="price">
                                            <ins><span class="amount text-dark font-weight-semibold">'.$product->price.'</span></ins>
                                        </span>
                                    </a>
                                </span>
                            </span>
                        </div>';
				}
			}
			else
				$output='<h4 style="color: #777">沒有找到相關車輛</h4>';
			echo $output;
		}
    }

    public function search(Request $request)
    {
        //$request->validate([
        //    'query' => 'required|min:4',
        //]);

        $query = $request->input('query');
        //dd($query);
        $search_products=Product::whereId('99999999')->paginate(8);
        if($query)
            $search_products = Product::search($query)->paginate(8);

        return view('frontend.search_result', compact('search_products','query'));
    }

    public function searchAlgolia(Request $request)
    {
        return view('search-results-algolia');
    }
}
