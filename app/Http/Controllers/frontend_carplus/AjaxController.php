<?php

namespace App\Http\Controllers\frontend_carplus;

use App\Database\OTF;
use App\Model\Aboutcat;
use App\Model\Aboutin;
use App\Model\admin\Admin;
use App\Model\Brandcat;
use App\Model\Brandin;
use App\Model\Cate;
use App\Model\Counter;
use App\Model\Department;
use App\Model\Faqin;
use App\Model\frontend\User;
use App\Model\Homeblk;
use App\Model\Hotin;
use App\Model\Lang;
use App\Model\Menublk;
use App\Model\Partner;
use App\Model\Period;
use App\Model\Photocat;
use App\Model\Pricecat;
use App\Model\Proarea;
use App\Model\Product;
use App\Model\Service;
use App\Model\Slider;
use App\Model\Team;
use App\Model\Temp;
use App\Model\Tempcar;
use App\Model\Testimon;
use App\Model\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class AjaxController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function chkIsUseEmailPost(Request $request)
    {
        //$input = $request->all();
        $email=$request->email;
        $user=User::where('email',$email)->first();
        $is_used=0;
        if($user)
            $is_used=1;

        return response()->json(['is_used'=>$is_used]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function ajax_temp_proarea(Request $request)
    {
        $cate_id=$request->cate_id;
        $proarea_id=$request->proarea_id;
        $cate=Cate::whereStatus(1)->whereId($cate_id)->first();
        if(!$cate)
            abort(404);

        $products = Product::where('ptate_id',3)
            ->where('cate_id', $cate->id)
            ->where(function($q) use ($proarea_id) {
                $q->where('proarea_id', $proarea_id)
                    ->orWhere('proarea2_id', $proarea_id);
            })
            ->select('brandin_id')
            ->groupby('brandin_id')
            ->get();
        $res='';
        if($products->count()>0) {
            $res = '<option value="">請選擇</option>';
            foreach($products as $product) {
                $brandin = $product->brandin;
                if($brandin)
                    $res .= '<option value="'.$brandin->id.'">'.$brandin->title.'</option>';
            }
            $msg = '<span style="color: green">( 請選擇車型 )</span>';
        }
        else{
            $msg='<span style="color: red">( 此交車區域暫時沒有車輛 )</span>';
        }
        return response()->json(['res'=>$res,'show_msg'=>$msg]);
    }/**
     * Display a listing of the resource.
     *
     * @return string
     */
    public function ajax_temp_brandin(Request $request)
    {
        $user=getLoginUser();
        $cate_id=$request->cate_id;
        $proarea_id=$request->proarea_id;
        //$brandin_id=$request->brandin_id;
        $cate=Cate::whereStatus(1)->whereId($cate_id)->first();
        if(!$cate)
            abort(404);

        $brandin_products = Product::where('ptate_id',3)
            ->where('cate_id', $cate->id)
            ->where(function($q) use ($proarea_id) {
                $q->where('proarea_id', $proarea_id)
                    ->orWhere('proarea2_id', $proarea_id);
            })
            ->select('brandin_id')
            ->groupby('brandin_id')
            ->get();

        $html='';

        if($brandin_products->count()>0) {

            foreach($brandin_products as $brandin_product) {
                $brandin = $brandin_product->brandin;
                if($brandin) {
                    $brandin_id=$brandin->id;
                    $year = Product::where('ptate_id', 3)
                        ->where('cate_id', $cate->id)
                        ->where('brandin_id', $brandin_id)
                        ->where(function($q) use ($proarea_id) {
                            $q->where('proarea_id', $proarea_id)
                                ->orWhere('proarea2_id', $proarea_id);
                        })
                        ->select('brandcat_id', 'brandin_id', 'year')
                        ->groupby('brandcat_id', 'brandin_id', 'year')
                        ->orderBy('year', 'DESC')
                        ->first();

                    if($year) {
                        $products = Product::where('ptate_id', 3)
                            ->where('cate_id', $cate->id)
                            ->where('brandcat_id', $year->brandcat_id)
                            ->where('brandin_id', $year->brandin_id)
                            ->where('year', $year->year)
                            ->where(function($q) use ($proarea_id) {
                                $q->where('proarea_id', $proarea_id)
                                    ->orWhere('proarea2_id', $proarea_id);
                            })
                            ->select('id', 'brandcat_id', 'brandin_id', 'year', 'milage', 'procolor_id', 'displacement', 'equipment')
                            ->orderBy('milage')
                            ->take(1)
                            ->get();
                        if($products) {
                            foreach($products as $key => $product) {
                                $brandcat_name = '';
                                $brandcat = $product->brandcat;
                                if($brandcat)
                                    $brandcat_name = $brandcat->title;

                                $brandin_name = '';
                                $brandin = $product->brandin;
                                if($brandin)
                                    $brandin_name = $brandin->title;

                                $procolor_name = '';
                                $procolor = $product->procolor;
                                if($procolor)
                                    $procolor_name = $procolor->title;

                                $milage = $product->milage;
                                if(! $milage)
                                    $milage = 0;
                                $milage = (int) number_format(floor($milage / 1000)) * 1000;
                                $html .= '
                                    <div class="form-group col-md-6" style="padding: 10px">
                                        <table class="temp_table">
                                            <tr>
                                                <td colspan="2" class="temp_top_td">'.$brandin_name.'</td>
                                            </tr>
                                            <tr>
                                                <td class="temp_title_td">廠牌</td>
                                                <td class="temp_content_td">'.$brandcat_name.'</td>
                                            </tr>
                                            <tr>
                                                <td class="temp_title_td">顏色</td>
                                                <td class="temp_content_td">'.$procolor_name.'</td>
                                            </tr>
                                            <tr>
                                                <td class="temp_title_td">排氣量</td>
                                                <td class="temp_content_td">'.number_format($product->displacement).'</td>
                                            </tr>
                                            <tr>
                                                <td class="temp_title_td">年份</td>
                                                <td class="temp_content_td">'.$product->year.'</td>
                                            </tr>
                                            <tr>
                                                <td class="temp_title_td">里程</td>
                                                <td class="temp_content_td">'.number_format($milage).'</td>
                                            </tr>';
                                if($product->equipment)
                                    $html .= '<tr>
                                                    <td class="temp_title_td">配備</td>
                                                    <td class="temp_content_td">'.$product->equipment.'</td>
                                                </tr>';
                                $html .= '<tr>
                                                <td colspan="2" class="temp_button_td">
                                                    <button type="submit" onclick="$(\'#product_id\').val(\''.$product->id.'\');'.($user && $user->is_check != 1 ? 'alert(\'尚未開通訂閱功能，請至會員中心>修改基本資料，填寫完整的會員資料。SeaLand會在確認後，開通您的訂閱功能。\');return false;' : 'return chk_form();').'" class="btn btn-primary">我要訂閱</button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>';
                            }
                        }
                    }
                }
            }
        }

        $msg='<span style="color: green">( 符合您條件搜尋共 '.$brandin_products->count().' 台車型 )</span>';
        if(!$html)
            $msg='<span style="color: red">( 此交車區域暫時沒有相關車型 )</span>';
        return response()->json(['html'=>$html,'show_msg'=>$msg]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax_sub_date(Request $request)
    {
        $temp_id=$request->temp_id;
        $sub_date=$request->sub_date;
        $temp=Temp::whereId($temp_id)->first();
        if($temp){
            $temp->sub_date=$sub_date;
            $temp->update();
        }

        echo true;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ajax_brandcat(Request $request)
	{
		$tempcar_id=$request->tempcar_id;
		$brandcat_id=$request->brandcat_id;
        $tempcar=Tempcar::whereId($tempcar_id)
            ->first();
	    if($tempcar){
	        $tempcar->brandcat_id=$brandcat_id;
	        $tempcar->brandin_id=null;
	        $tempcar->update();
        }
		$brandins=Brandin::whereStatus(1)->where('brandcat_id',$brandcat_id)->get();
		$res='<option value="">請選擇</option>';
		foreach($brandins as $brandin){
		    $products=Product::where('brandcat_id',$brandcat_id)
                ->where('brandin_id',$brandin->id)
                ->whereStatus(1)
                ->get();
		    if($products && $products->count()>0)
			    $res .= '<option value="'.$brandin->id.'">'.$brandin->title.'</option>';
		}
		echo $res;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ajax_brandcat2(Request $request)
	{
		$tempcar_id=$request->tempcar_id;
		$brandcat_id=$request->brandcat_id;
        $tempcar=Tempcar::whereId($tempcar_id)
            ->first();
	    if($tempcar){
	        $tempcar->brandcat_id=$brandcat_id;
	        $tempcar->brandin_id=null;
	        $tempcar->update();
        }
		$brandins=Brandin::whereStatus(1)->where('brandcat_id',$brandcat_id)->get();
		$res='<option value="">請選擇</option>';
		foreach($brandins as $brandin){
		    $products=Product::where('brandcat_id',$brandcat_id)
                ->where('brandin_id',$brandin->id)
                ->whereStatus(1)
                ->get();
		    if($products && $products->count()>0)
			    $res .= '<option value="'.$brandin->id.'">'.$brandin->title.'</option>';
		}
		echo $res;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ajax_brandin(Request $request)
	{
        $tempcar_id=$request->tempcar_id;
        $brandcat_id=$request->brandcat_id;
        $brandin_id=$request->brandin_id;
        $tempcar=Tempcar::whereId($tempcar_id)->first();
        if($tempcar){
            $tempcar->brandcat_id=$brandcat_id;
            $tempcar->brandin_id=$brandin_id;
            $tempcar->update();
        }

		echo true;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ajax_price(Request $request)
	{
		$period_id=$request->period_id;
		$period=Period::whereId($period_id)->first();
		$res='0';
		if($period){
			$price=$request->price;
			$months=$period->months;
			$discount=$period->discount;
			echo $price * $months * $discount / 100;
		}
		else
			echo $res;
	}

}
