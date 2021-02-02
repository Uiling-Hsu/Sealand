<?php

namespace App\Http\Controllers\admin\User;

use App\Exports\UserBackendExport;
use App\Exports\UserExport;
//use App\Mail\RegisterNotiyPlaced;
use App\Mail\OnlyUserSubscriberReviewRejectNotifyPlaced;
use App\Mail\RejectNotiyPlaced;
use App\Mail\ReviewNotiyPlaced;
use App\Mail\SendUserDataAndCateNotifyPlaced;
use App\Mail\UserSubscriberReviewOkNotifyPlaced;
use App\Mail\UserSubscriberReviewRejectNotifyPlaced;
use App\Mail\UserTempNotiyPlaced;
use App\Mail\UserTempRejectNotiyPlaced;
use App\Model\Cate;
use App\Model\frontend\User;
use App\Http\Requests;
use App\Model\Ssite;
use App\Model\Subscriber;
use App\Model\Usergate;
use App\Model\Whitepoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\User\AdminUserRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class AdminUserController extends Controller
{
    /*public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!has_permission('member'))
                abort(403);
            return $next($request);
        });
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$users=User::where('idcard_image01','!=','')
            ->where('idcard_image02','!=','')
            ->where('driver_image01','!=','')
            ->where('driver_image02','!=','')
            ->get();
        foreach($users as $user){
            $user->idcard_image01=$idcard_image01=str_replace('/storages/user/','',$user->idcard_image01);
            $user->idcard_image02=$idcard_image02=str_replace('/storages/user/','',$user->idcard_image02);
            $user->driver_image01=$driver_image01=str_replace('/storages/user/','',$user->driver_image01);
            $user->driver_image02=$driver_image02=str_replace('/storages/user/','',$user->driver_image02);
            $user->update();
        }

        $users=User::get();
        $path = storage_path('app/user');
        foreach($users as $key=>$user){
            $idcard_image01=$user->idcard_image01;
            if($user->idcard_image01 && file_exists(storage_path('app/user/').$idcard_image01)) {
                $upload_filename=$path.'/'.$idcard_image01;
                watermark($upload_filename, 'assets/images/water.png', $idcard_image01);
                //unlink(storage_path('app/user/').$idcard_image01);
            }
            $idcard_image02=$user->idcard_image02;
            if($user->idcard_image02 && file_exists(storage_path('app/user/').$idcard_image02)) {
                $upload_filename=$path.'/'.$idcard_image02;
                watermark($upload_filename, 'assets/images/water.png', $idcard_image02);
                //unlink(storage_path('app/user/').$idcard_image01);
            }
            $driver_image01=$user->driver_image01;
            if($user->driver_image01 && file_exists(storage_path('app/user/').$driver_image01)) {
                $upload_filename=$path.'/'.$driver_image01;
                watermark($upload_filename, 'assets/images/water.png', $driver_image01);
                //unlink(storage_path('app/user/').$idcard_image01);
            }
            $driver_image02=$user->driver_image02;
            if($user->driver_image02 && file_exists(storage_path('app/user/').$driver_image02)) {
                $upload_filename=$path.'/'.$driver_image02;
                watermark($upload_filename, 'assets/images/water.png', $driver_image02);
                //unlink(storage_path('app/user/').$idcard_image01);
            }
        }*/

        //$sql='UPDATE users SET is_mn1_1_email=1 WHERE `is_temp_notify_email`=1';

        if(!has_permission('member'))
            abort(403);
        //import_user();
        $users=User::where('id','>',0);

        $search_created_at=Request('search_created_at');
        if($search_created_at!='') {
            $users = $users->where('created_at', 'like', $search_created_at.'%');
        }

        $search_is_picok=Request('search_is_picok');
        if($search_is_picok!='') {
            $users = $users->where('idcard_image01', '!=','')->where('idcard_image02', '!=','')->where('driver_image01', '!=','')->where('driver_image02', '!=','');
        }

        $search_is_check=Request('search_is_check');
        if($search_is_check!='') {
            $users = $users->where('is_check', $search_is_check);
        }

        $search_is_activate=Request('search_is_activate');
        if($search_is_activate!='') {
            $users = $users->where('is_activate', $search_is_activate);
        }

        $search_status=Request('search_status');
        if($search_status!='') {
            $users = $users->where('status', $search_status);
        }

        $search_has_subscriber=Request('search_has_subscriber');
        if($search_has_subscriber==1) {
            $users = $users->has('subscribers');
        }

        $search_has_reject=Request('search_has_reject');
        if($search_has_reject==1) {
            $users = $users->whereHas('subscribers', function($q) {
                $q->where('memo','!=','');
            });
        }

        $search_start_date=Request('search_start_date');
        $search_end_date=Request('search_end_date');
        if($search_start_date && $search_end_date) {
            $search_date_field=Request('search_date_field');
            if(!$search_date_field)
                $search_date_field='created_at';
            if($search_start_date != '')
                $users = $users->whereDate($search_date_field, '>=', $search_start_date);
            if($search_end_date != '')
                $users = $users->whereDate($search_date_field, '<=', $search_end_date);
        }

        $search_company_no=Request('search_company_no');
        if($search_company_no!='') {
            if($search_company_no==1)
                $users = $users->where('company_no', '!=','');
            else
                $users = $users->where(function($q){
                    $q->where('company_no',null)
                        ->orWhere('company_no', '');
                });
        }

        $search_keyword=Request('search_keyword');
        if($search_keyword!='') {
            $users = $users->where(function ($q) use($search_keyword){
                $q->where('name', 'like', '%'.$search_keyword.'%')
                    ->orWhere('email', 'like', '%'.$search_keyword.'%')
                    ->orWhere('phone', 'like', '%'.$search_keyword.'%')
                    ->orWhere('telephone', 'like', '%'.$search_keyword.'%')
                    ->orWhere('address', 'like', '%'.$search_keyword.'%');
            });
        }

        $users=$users->orderBy('updated_at','DESC');
        if($users->count()>0 && Request('download')==1) {
            $users=$users->get();
            $user_file_name = 'User_export_'.date('Y_m_d_H_i_s').'.xlsx';
            return Excel::download(new UserBackendExport($users), $user_file_name);
        }
        else {
            $user_not_check_count = \App\Model\frontend\User::where('idcard_image01', '!=', '')->where('idcard_image02', '!=', '')->where('driver_image01', '!=', '')->where('driver_image02', '!=', '')->where('is_check', -1)->count();
            $user_not_pass_count = \App\Model\frontend\User::where('is_check', 0)->count();

            $list_ssites = Ssite::whereStatus(1)->orderBy('sort')->pluck('title', 'id')->prepend('選選擇', '');
            $users = $users->paginate(50);
            return view('admin/user/user', compact('users',
                'list_ssites',
                'search_is_picok',
                'search_is_check',
                'search_is_activate',
                'search_status',
                'search_company_no',
                'search_keyword',
                'search_start_date',
                'search_end_date',
                'search_start_updated_date',
                'search_end_updated_date',
                'user_not_check_count',
                'user_not_pass_count'));
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function u_subscriber()
    {
        if(!has_permission('member'))
            abort(403);
        //import_user();
        $users=User::where('id','!=',8);

        $search_created_at=Request('search_created_at');
        if($search_created_at!='') {
            $users = $users->where('created_at', 'like', $search_created_at.'%');
        }

        $search_is_picok=Request('search_is_picok');
        if($search_is_picok!='') {
            $users = $users->where('idcard_image01', '!=','')->where('idcard_image02', '!=','')->where('driver_image01', '!=','')->where('driver_image02', '!=','');
        }

        $search_is_check=Request('search_is_check');
        if($search_is_check!='') {
            $users = $users->where('is_check', $search_is_check);
        }

        $search_is_activate=Request('search_is_activate');
        if($search_is_activate!='') {
            $users = $users->where('is_activate', $search_is_activate);
        }

        $search_status=Request('search_status');
        if($search_status!='') {
            $users = $users->where('status', $search_status);
        }

        $search_has_subscriber=Request('search_has_subscriber');
        if($search_has_subscriber==1) {
            $users = $users->has('subscribers');
        }

        $search_has_reject=Request('search_has_reject');
        if($search_has_reject==1) {
            $users = $users->whereHas('subscribers', function($q) {
                $q->where('memo','!=','');
            });
        }

        $search_start_date=Request('search_start_date');
        if($search_start_date!='')
            $users=$users->where('created_at','>=',$search_start_date.' 00:00:01');
        $search_end_date=Request('search_end_date');
        if($search_end_date!='')
            $users=$users->where('created_at','<=',$search_end_date.' 23:59:59');

        $search_start_updated_date=Request('search_start_updated_date');
        if($search_start_updated_date!='')
            $users=$users->where('updated_at','>=',$search_start_updated_date.' 00:00:01');
        $search_end_updated_date=Request('search_end_updated_date');
        if($search_end_updated_date!='')
            $users=$users->where('updated_at','<=',$search_end_updated_date.' 23:59:59');

        $search_company_no=Request('search_company_no');
        if($search_company_no!='') {
            if($search_company_no==1)
                $users = $users->where('company_no', '!=','');
            else
                $users = $users->where(function($q){
                    $q->where('company_no',null)
                        ->orWhere('company_no', '');
                });
        }

        $search_keyword=Request('search_keyword');
        if($search_keyword!='') {
            $users = $users->where('name', 'like', '%'.$search_keyword.'%')
                ->orWhere('email', 'like', '%'.$search_keyword.'%')
                ->orWhere('phone', 'like', '%'.$search_keyword.'%')
                ->orWhere('telephone', 'like', '%'.$search_keyword.'%')
                ->orWhere('address', 'like', '%'.$search_keyword.'%');
        }
        $users=$users->orderBy('updated_at','DESC')->paginate(50);
        //未審核
        $user_not_check_count=\App\Model\frontend\User::where('idcard_image01', '!=','')->where('idcard_image02', '!=','')->where('driver_image01', '!=','')->where('driver_image02', '!=','')->where('is_check', -1)->count();
        $user_not_pass_count=\App\Model\frontend\User::where('is_check', 0)->count();
        return view('admin/user/u_subscriber',compact('users',
            'search_is_picok',
            'search_is_check',
            'search_is_activate',
            'search_status',
            'search_company_no',
            'search_keyword',
            'search_start_date',
            'search_end_date',
            'search_start_updated_date',
            'search_end_updated_date',
            'user_not_check_count',
            'user_not_pass_count'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function u_reject()
    {

        if(!has_permission('member'))
            abort(403);
        //import_user();
        $users=User::where('id','>',0);

        $search_created_at=Request('search_created_at');
        if($search_created_at!='') {
            $users = $users->where('created_at', 'like', $search_created_at.'%');
        }

        $search_is_picok=Request('search_is_picok');
        if($search_is_picok!='') {
            $users = $users->where('idcard_image01', '!=','')->where('idcard_image02', '!=','')->where('driver_image01', '!=','')->where('driver_image02', '!=','');
        }

        $search_is_check=Request('search_is_check');
        if($search_is_check!='') {
            $users = $users->where('is_check', $search_is_check);
        }

        $search_is_activate=Request('search_is_activate');
        if($search_is_activate!='') {
            $users = $users->where('is_activate', $search_is_activate);
        }

        $search_status=Request('search_status');
        if($search_status!='') {
            $users = $users->where('status', $search_status);
        }

        $search_has_subscriber=Request('search_has_subscriber');
        if($search_has_subscriber==1) {
            $users = $users->has('subscribers');
        }

        $search_has_reject=Request('search_has_reject');
        if($search_has_reject==1) {
            $users = $users->whereHas('subscribers', function($q) {
                $q->where('memo','!=','')
                ->orWhere('ret_code','>','1');
            });
        }

        $search_start_date=Request('search_start_date');
        if($search_start_date!='')
            $users=$users->where('created_at','>=',$search_start_date.' 00:00:01');
        $search_end_date=Request('search_end_date');
        if($search_end_date!='')
            $users=$users->where('created_at','<=',$search_end_date.' 23:59:59');

        $search_start_updated_date=Request('search_start_updated_date');
        if($search_start_updated_date!='')
            $users=$users->where('updated_at','>=',$search_start_updated_date.' 00:00:01');
        $search_end_updated_date=Request('search_end_updated_date');
        if($search_end_updated_date!='')
            $users=$users->where('updated_at','<=',$search_end_updated_date.' 23:59:59');

        $search_company_no=Request('search_company_no');
        if($search_company_no!='') {
            if($search_company_no==1)
                $users = $users->where('company_no', '!=','');
            else
                $users = $users->where(function($q){
                    $q->where('company_no',null)
                        ->orWhere('company_no', '');
                });
        }

        $search_keyword=Request('search_keyword');
        if($search_keyword!='') {
            $users = $users->where('name', 'like', '%'.$search_keyword.'%')
                ->orWhere('email', 'like', '%'.$search_keyword.'%')
                ->orWhere('phone', 'like', '%'.$search_keyword.'%')
                ->orWhere('telephone', 'like', '%'.$search_keyword.'%')
                ->orWhere('address', 'like', '%'.$search_keyword.'%');
        }
        $users=$users->orderBy('created_at','DESC')->paginate(50);
        //未審核
        $user_not_check_count=\App\Model\frontend\User::where('idcard_image01', '!=','')->where('idcard_image02', '!=','')->where('driver_image01', '!=','')->where('driver_image02', '!=','')->where('is_check', -1)->count();
        $user_not_pass_count=\App\Model\frontend\User::where('is_check', 0)->count();
        return view('admin/user/u_reject',compact('users',
            'search_is_picok',
            'search_is_check',
            'search_is_activate',
            'search_status',
            'search_company_no',
            'search_keyword',
            'search_start_date',
            'search_end_date',
            'search_start_updated_date',
            'search_end_updated_date',
            'user_not_check_count',
            'user_not_pass_count'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create(){
        if(!has_permission('member'))
            abort(403);
        return view('admin/user/user_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserRequest $request)
    {
        if(!has_permission('member'))
            abort(403);
        $inputs=$request->all();
        //dd($inputs);
        $user=User::create($inputs);
        writeLog('新增 使用者',$inputs,1);
        Session::flash('flash_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/user?bid='.$user->id.'#list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        /*$user_arr=[249,213,385,409,391,400,305,669,735,665,544,444,814,605,101,517,803];
        foreach($user_arr as $key=>$user_id){
            $cuser=User::whereId($user_id)->first();
            $cuser->samecartate_id=2;
            echo ($key+1).'.'.$cuser->name.'<br>';
            $cuser->update();
        }
        dd('');*/
        /*$samecartate_id=$user->samecartate_id;
        if(!$samecartate_id)
            $samecartate_id=1;
        $samecartate_id++;
        $user->samecartate_id=$samecartate_id;*/

        if(!has_permission('member'))
            abort(403);
        $cates=Cate::whereStatus(1)->orderBy('sort')->get();
        $list_ssites = Ssite::whereStatus(1)->orderBy('sort')->pluck('title', 'id')->prepend('選選擇', '');
        return view('admin/user/user_edit',compact('user','cates','list_ssites'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserRequest $request, User $user)
    {
        if(!has_permission('member'))
            abort(403);
        $inputs=$request->all();
        //dd($inputs);
        $image_width=1000;
        $image_height=null;
        if ($request->hasFile('imgFile_idcard_image01')){
            $upload_filename = upload_user_image_file($user->id.'aa1a', $request->file('imgFile_idcard_image01'), $image_width, $image_height);

            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $save_filename=explode('/',$upload_filename);
            $save_filename=watermark($upload_filename,'assets/images/water.png',end($save_filename));
            if($user->idcard_image01 && file_exists(storage_path('app/user/').$user->idcard_image01))
                unlink(storage_path('app/user/').$user->idcard_image01);
            $inputs['idcard_image01'] = $save_filename;
        }
        if ($request->hasFile('imgFile_idcard_image02')){
            $upload_filename = upload_user_image_file($user->id.'aa2a', $request->file('imgFile_idcard_image02'), $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $save_filename=explode('/',$upload_filename);
            $save_filename=watermark($upload_filename,'assets/images/water.png',end($save_filename));
            if($user->idcard_image02 && file_exists(storage_path('app/user/').$user->idcard_image02))
                unlink(storage_path('app/user/').$user->idcard_image02);
            $inputs['idcard_image02'] = $save_filename;
        }
        if ($request->hasFile('imgFile_driver_image01')){
            $upload_filename = upload_user_image_file($user->id.'aa3a', $request->file('imgFile_driver_image01'), $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $save_filename=explode('/',$upload_filename);
            $save_filename=watermark($upload_filename,'assets/images/water.png',end($save_filename));
            if($user->driver_image02 && file_exists(storage_path('app/user/').$user->driver_image02))
                unlink(storage_path('app/user/').$user->driver_image02);
            $inputs['driver_image01'] = $save_filename;
        }
        if ($request->hasFile('imgFile_driver_image02')){
            $upload_filename = upload_user_image_file($user->id.'aa4a', $request->file('imgFile_driver_image02'), $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $save_filename=explode('/',$upload_filename);
            $save_filename=watermark($upload_filename,'assets/images/water.png',end($save_filename));
            if($user->driver_image02 && file_exists(storage_path('app/user/').$user->driver_image02))
                unlink(storage_path('app/user/').$user->driver_image02);
            $inputs['driver_image02'] = $save_filename;
        }
        $user->update($inputs);
        writeLog('更新 使用者',$inputs,1);
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/user/'.$user->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(!has_permission('member'))
            abort(403);
        if(file_exists($user->image))
            unlink($user->image);
        $user->delete();
        writeLog('刪除 使用者',$user->toArray(),1);
        Session::flash('flash_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/user');
    }

    public function del_img(User $user, $image)
    {
        if(!has_permission('member'))
            abort(403);
        if(file_exists($user->image))
            unlink($user->image);
        $user->update([$image=>'','position'=>'0']);
        Session::flash('flash_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/user/'.$user->id.'/edit#list');
    }

    public function sort(Request $request){
        if(!has_permission('member'))
            abort(403);
        $sorts=$request->sort;
        foreach($request->user_id as $index => $user_id){
            if($sorts[$index]!=''){
                User::where('id',$user_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/user');
    }

    public function is_activate($id, $is_activate){
        if(!has_permission('member'))
            abort(403);
        $user=User::whereId($id)->first();
        $user->is_activate=$is_activate;
        $user->update();
        writeLog('啟用 使用者',$user->id,1);
        Session::flash('flash_message', '啟用更新成功!');
        return redirect('/admin/user?bid='.$user->id);
    }

    public function status($id, $status){
        if(!has_permission('member'))
            abort(403);
        User::where('id',$id)->update(['status'=>$status]);
        Session::flash('flash_message', '狀態更新成功!');
        return redirect('/admin/user');
    }

    public function grade($id, $grade){
        if(!has_permission('member'))
            abort(403);
        $user=User::whereId($id)->first();
        $user->grade=$grade;
        $user->update();
        Session::flash('flash_message', 'VIP會員更新成功!');
        return redirect('/admin/user?bid='.$user->id);
    }

    public function batch_update(User $user,$item='white', Request $request){
        if(!has_permission('member'))
            abort(403);
        if (!in_array($item, ['red','white','cash']))
            abort(404);

        $titles=$request->title;
        $memos=$request->memo;
        foreach($request->point_ids as $index => $point_id){
            $point=new Whitepoint();
            $point=$point->whereId($point_id);
            $point->update(['title'=>$titles[$index],'memo'=>$memos[$index]]);
        }
        Session::flash('flash_message', '批次更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/user/'.$user->id.'/point/'.$item);
    }

    public function user_temp_reject_notify_email(User $user)
    {
        $user->is_temp_notify_email=1;
        $user->update();
        writeLog('寄給會員補齊資料Email已成功送出',$user->id.' 姓名'.$user->name.' → is_temp_notify_email=1',1);
        Mail::send(new UserTempRejectNotiyPlaced($user));
        return redirect()->back()->with('success_message', '寄給會員補齊資料Email已成功送出。');
    }

    public function send_user_data_and_cate(User $user, Subscriber $subscriber) {
        //$user->subscriber_id=$subscriber->id;
        //$user->update();
        //Excel::export(new UserExport($user), $file_name);
        $car_plus_email01=setting('car_plus_email01');
        if($car_plus_email01) {
            Mail::send(new SendUserDataAndCateNotifyPlaced($user,$subscriber,$car_plus_email01));
            //Mail::send(new SendUserDataAndCateNotifyPlaced($user,$subscriber,'iris@eze23.com'));
            $subscriber->is_babysitter_send_email=1;
            $subscriber->update();
            writeLog('寄給格上 會員資料及需求單 已成功送出',$user->id.' 姓名'.$user->name.' → is_babysitter_send_email=1',1);
            return redirect()->back()->with('success_message', '寄給格上會員資料及需求單 已成功送出。');
        }
        else
            return redirect()->back()->with('failure_message', '請先設定寄給格上的Email後再繼續。');

    }

    public function user_subscriber_ok_email(Subscriber $subscriber)
    {
        $user=$subscriber->user;
        if($user)
            Mail::send(new UserSubscriberReviewOkNotifyPlaced($subscriber,$user->email,$user->name));
        $email01=setting('email01');
        $email02=setting('email02');
        $email03=setting('email03');
        $store_name=setting('store_name');
        if($email01)
            Mail::send(new UserSubscriberReviewOkNotifyPlaced($subscriber,$email01,$store_name));

        if($email02)
            Mail::send(new UserSubscriberReviewOkNotifyPlaced($subscriber,$email02,$store_name));

        if($email03)
            Mail::send(new UserSubscriberReviewOkNotifyPlaced($subscriber,$email03,$store_name));
        $subscriber->is_carplus_send_email=1;
        $subscriber->update();
        if($user)
            writeLog('寄給會員及保姆的Email已成功送出, 訂閱ID：',$subscriber->id.' → User ID:'.$user->id.' 姓名'.$user->name.' → is_carplus_send_email=1',1);
        return redirect()->back()->with('success_message', '寄給會員及保姆的Email已成功送出。');

    }

    public function user_subscriber_reject_email(Subscriber $subscriber)
    {
        $user=$subscriber->user;
        //Mail::send(new UserSubscriberReviewRejectNotifyPlaced($subscriber,$user->email,$user->name));
        $email01=setting('email01');
        $email02=setting('email02');
        $email03=setting('email03');
        $store_name=setting('store_name');
        if($email01)
            Mail::send(new UserSubscriberReviewRejectNotifyPlaced($subscriber,$email01,$store_name));

        if($email02)
            Mail::send(new UserSubscriberReviewRejectNotifyPlaced($subscriber,$email02,$store_name));

        if($email03)
            Mail::send(new UserSubscriberReviewRejectNotifyPlaced($subscriber,$email03,$store_name));
        $subscriber->is_carplus_send_email=1;
        $subscriber->update();
        if($user)
            writeLog('寄給保姆的拒絕訂閱Email已成功送出, 訂閱ID：',$subscriber->id.' → User ID:'.$user->id.' 姓名'.$user->name.' → is_carplus_send_email=1',1);
        return redirect()->back()->with('success_message', '寄給保姆的拒絕訂閱Email已成功送出。');

    }

    public function only_user_subscriber_reject_email(Subscriber $subscriber)
    {
        $user=$subscriber->user;
        $subscriber->is_babysitter_send_reject_to_user_email=1;
        $subscriber->update();
        if($user)
            writeLog('寄給會員的拒絕訂閱Email已成功送出, 訂閱ID：',$subscriber->id.' → User ID:'.$user->id.' 姓名'.$user->name.' → is_babysitter_send_reject_to_user_email=1');
        Mail::send(new OnlyUserSubscriberReviewRejectNotifyPlaced($subscriber));
        return redirect()->back()->with('success_message', '寄給會員的拒絕訂閱Email已成功送出。');

    }

    function licenceFileShow($field, $slug)
    {
        $storagePath = storage_path('app/user/'.$slug);
        return Image::make($storagePath)->response();
    }

    function user_idcard(User $user)
    {
        return view('admin/user/user_idcard',compact('user'));
    }

}
