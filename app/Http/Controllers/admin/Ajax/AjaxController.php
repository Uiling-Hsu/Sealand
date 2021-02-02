<?php

namespace App\Http\Controllers\admin\Ajax;

use App\Model\Brandcat;
use App\Model\Brandin;
use App\Model\frontend\User;
use App\Model\Ord;
use App\Model\Product;
use App\Model\Slider;
use App\Model\Subscriber;
use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax_sort(Request $request)
    {
        $datas=$request->data;
        if($datas){
            foreach($datas as $key=>$id){
                $slider=DB::table($request->db)->where('id',$id)->update(['sort'=>str_pad(($key+1),2,'0',STR_PAD_LEFT)]);
            }
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax_switch(Request $request)
    {
        $db=$request->db;
        if($db){
            $id=$request->id;
            $field=$request->field;
            if(!$field)
                $field='status';
            $value=$request->value;
            if($value=='true')
                $value=1;
            else
                $value=0;
            DB::table($request->db)->where('id',$id)->update([$field=>$value]);
            writeLog('狀態切換','資料表：'.$db.' ID：'.$id.' → 欄位:'.$field.' → 值：'.$value,1);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ajax_subscriber_switch(Request $request)
    {
        $db=$request->db;
        if($db){
            $id=$request->id;
            $field=$request->field;
            if(!$field)
                $field='status';
            $value=$request->value;

            if($value=='true') {
                $value = 1;
                $subscriber = Subscriber::whereId($id)->first();
                if($subscriber){
                    $subscriber->is_history=0;
                    $subscriber->update();
                }
            }
            else {
                $value = 0;
                $subscriber = Subscriber::whereId($id)->first();
                if($subscriber){
                    $subscriber->is_history=1;
                    $subscriber->update();
                }
            }
            DB::table($request->db)->where('id',$id)->update([$field=>$value]);
            writeLog('狀態訂閱單切換','資料表：'.$db.' ID：'.$id.' → 欄位:'.$field.' → 值：'.$value,1);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax_product_select(Request $request)
    {
        $db=$request->db;
        if($db){
            $id=$request->id;
            $field=$request->field;
            if(!$field)
                $field='status';
            $value=$request->value;
            $product=Product::whereId($id)->first();
            $mediate_times=0;
            $off_times=0;
            if($product){
                if($value==3) {
                    $product->auto_online_date = '';
                    $product->online_date = date('Y-m-d');
                }
                elseif($value==4) {
                    $product->auto_online_date=date('Y-m-d',strtotime(date('Y-m-d').' +3 day'));
                    $product->mediate_date=date('Y-m-d H:i:s');
                    $product->mediate_times++;
                    $mediate_times=$product->mediate_times;
                }
                elseif($value==5) {
                    $product->auto_online_date = '';
                    $product->off_date=date('Y-m-d H:i:s');
                    $product->off_times++;
                    $off_times=$product->off_times;
                }
                $product->update();
            }
            DB::table($request->db)->where('id',$id)->update([$field=>$value]);

            writeLog('車輛狀態切換','資料表：'.$db.' ID：'.$id.' → 欄位:'.$field.' → 值：'.$value,1);
            return response()->json(['value'=>$value,'auto_online_date'=>$product->auto_online_date,'mediate_times'=>$mediate_times,'off_times'=>$off_times]);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_table_field(Request $request)
    {
        $db=$request->db;
        if($db){
            $id=$request->id;
            $field=$request->field;
            $value=$request->value;
            DB::table($request->db)->where('id',$id)->update([$field=>$value]);
            //如果是訂單續約設定，則記錄日期
            if($db='ords' && $field=='renewtate_id'){
                $ord=Ord::whereId($id)->first();
                $ord->renewtate_date=date('Y-m-d H:i:s');
                $ord->is_renewtate_setting_finish=1;
                $ord->update();
            }
            writeLog('更新欄位資料 → ','資料表：'.$db.' ID：'.$id.' → 欄位:'.$field.' → 值：'.$value,1);
            return $value;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_user_table_field(Request $request)
    {
        $db=$request->db;
        if($db){
            $id=$request->id;
            $field=$request->field;
            $value=$request->value;

            $user=User::whereId($id)->first();
            if($value==0)
                $user->check_date=null;
            elseif($value==1)
                $user->check_date=date('Y-m-d H:i:s');
            $user->update();
            DB::table($request->db)->where('id',$id)->update([$field=>$value]);
            writeLog('更新欄位資料 → ','資料表：'.$db.' ID：'.$id.' → 欄位:'.$field.' → 值：'.$value,1);
            return $value;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_subscriber_table_field(Request $request)
    {
        $db=$request->db;
        if($db){
            $id=$request->id;
            $field=$request->field;
            $value=$request->value;
            if($value==0){
                $subscriber = Subscriber::whereId($id)->first();
                if($subscriber){
                    $subscriber->is_history=1;
                    $subscriber->update();
                    $product=$subscriber->product;
                    if($product){
                        $product->ptate_id=3;
                        $product->update();
                    }
                }
            }
            elseif($value==1){
                $subscriber = Subscriber::whereId($id)->first();
                if($subscriber){
                    $subscriber->is_history=0;
                    $subscriber->update();
                }
            }
            DB::table($request->db)->where('id',$id)->update([$field=>$value]);
            writeLog('更新欄位資料 → ','資料表：'.$db.' ID：'.$id.' → 欄位:'.$field.' → 值：'.$value,1);
            return $value;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update_product_table_field(Request $request)
    {
        $db=$request->db;
        if($db){
            $id=$request->id;
            $field=$request->field;
            $value=$request->value;
            $product=DB::table($request->db)->where('id',$id)->first();
            $old_partner_id=$product->partner_id;
            if($old_partner_id!=$value) {
                DB::table($request->db)->where('id', $id)->update([ $field => $value, 'partner2_id' => $old_partner_id ]);
                writeLog('更新車輛欄位資料 → ','資料表：'.$db.' ID：'.$id.' → 欄位：'.$field.' 值：'.$value.'；partner2_id='.$old_partner_id,1);
            }
            else {
                DB::table($request->db)->where('id', $id)->update([ $field => $value ]);
                writeLog('更新車輛欄位資料 → ','資料表：'.$db.' ID：'.$id.' → 欄位：'.$field.' 值：'.$value,1);
            }
        }
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ajax_remove_file(Request $request)
	{
		//dd($request->all());
		$table=$request->db;
		if($table){
			$id=$request->id;
			$file=$request->file;
			$db=DB::table($table)->where('id',$id)->first();
			if(file_exists( public_path().$file))
				unlink( public_path() . $file);
			$db=DB::table($table)->where('id',$id)->delete();
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ajax_delete_record(Request $request)
	{
		//dd($request->all());
		$table=$request->db;
		if($table){
			$id=$request->id;
			DB::table($table)->where('id',$id)->delete();
            writeLog('刪除資料 → ','資料表：'.$table.' ID：'.$id,1);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ajax_remove_image(Request $request)
	{
		$table=$request->db;
		if($table){
			$id=$request->id;
			$field=$request->field;
			$db=DB::table($table)->where('id',$id)->first();
			if($db->{$field} && file_exists( public_path().$db->{$field}))
				unlink( public_path() . $db->{$field});
			$db=DB::table($table)->where('id',$id)->update([$field=>'']);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ajax_brandcat(Request $request)
	{
		$cate_id=$request->cate;
		$brandcats=Brandcat::whereStatus(1)->where('cate_id',$cate_id)->get();
		if($cate_id!='all') {
			$res = '<option value="">請選擇</option>';
			foreach($brandcats as $brandcat) {
				$res .= '<option value="'.$brandcat->id.'">'.$brandcat->title.'</option>';
			}
		}
		else
			$res='';
		echo $res;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ajax_brandin(Request $request)
	{
		$brandcat_id=$request->brandcat;
		$brandins=Brandin::whereStatus(1)->where('brandcat_id',$brandcat_id)->get();
		if($brandcat_id!='all') {
			$res = '<option value="">請選擇</option>';
			foreach($brandins as $brandin) {
				$res .= '<option value="'.$brandin->id.'">'.$brandin->title.'</option>';
			}
		}
		else
			$res='';
		echo $res;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function ajax_remove_image_and_delete(Request $request)
	{
		$table=$request->db;
		if($table){
			$id=$request->id;
			$field=$request->field;
			$db=DB::table($table)->where('id',$id)->first();
			if($db->{$field} && file_exists( public_path().$db->{$field}))
				unlink( public_path() . $db->{$field});
			$db=DB::table($table)->where('id',$id)->delete();
		}
	}


}
