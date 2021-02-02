<?php

namespace App\Http\Controllers\admin\Admin;

use App\Model\admin\Admin;
use App\Model\Partner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Role;
use App\Model\frontend\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\AdminUserRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!has_permission('admin'))
                abort(403);
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins=Admin::paginate(30);
        return view('admin.admin.admin',compact('admins'));
    }

    public function create(){
        $list_partners=Partner::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('無','');
        return view('admin.admin.admin_create',compact('list_partners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserRequest $request)
    {
        $inputs=$request->all();
        $inputs['password']=bcrypt($inputs['password']);;
        $inputs['is_activate']=1;
        $inputs['status']=1;

        $admin=Admin::create($inputs);
        $inputs['password_confirmation']='';
        writeLog('新增 Admin',$inputs,1);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/admin?bid='.$admin->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        if($admin->id==1)
            abort(404);
        $list_partners=Partner::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('無','');
        return view('admin.admin.admin_edit',compact('admin','list_partners'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserRequest $request, Admin $admin)
    {
        // dd($request->role_id);
        $role_ids=$request->role_id;
        if($role_ids){
            $admin->detachAllRoles();
            foreach($role_ids as $role_id){
                $role = Role::findOrFail($role_id);
                $admin->attachRole($role);
            }
        }
        $admin->update($request->all());
        writeLog('更新Admin',$admin->toArray(),1);
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/admin?bid='.$admin->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        writeLog('刪除Admin',$admin->toArray(),1);
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/admin?bid=');
    }

    public function status($id, $status){
        Admin::where('id',$id)->update(['status'=>$status]);
        //writeLog('status User','id:'.$id.'=>status:'.$status);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/admin?bid='.$id);
    }

    public function password(Admin $admin){

        return view('admin.admin.admin_password',compact('admin'));
    }

    public function password_update(AdminUserRequest $request, Admin $admin){
        $inputs=$request->toArray();
        //if (Hash::check($inputs['password'], $admin->password)){
        $inputs['password']=bcrypt($inputs['newpassword']);
        $admin->update($inputs);
        writeLog('修改Admin密碼 → ',$admin->toArray(),1);
        Session::flash('success_message', '密碼修改成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/admin?bid='.$admin->id);
        //}
        //else{
        //    Session::flash('flash_message', '密碼更新失敗! 原始密碼輸入錯誤, 請重新再試一次!');
             //flash()->overlay('密碼更新失敗! 原始密碼輸入錯誤, 請重新再試一次!','系統訊息:');
            //return redirect('/admin/admin?bid=/'.$admin->id.'/password');
        //}
    }

    public function profile() {
        $profile=getAdminUser();
        return view('admin.admin.profile',compact('profile'));
    }

    public function profile_post(Request $request) {
        $profile=getAdminUser();
        if(!$profile)
            abort(404);
        $profile->update($request->all());
        Session::flash('success_message', '基本資料更新成功!');
        return redirect('/admin/profile');
    }

}
