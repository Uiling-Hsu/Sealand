<?php

namespace App\Http\Controllers\admin\Role;

use App\Model\PermissionRole;
use App\Model\Role;
use App\Model\Permission;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Role\AdminRoleRequest;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AdminRoleController extends Controller
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
        $roles=Role::orderBy('sort')->get();
        return view('admin.role.role',compact('roles'));
    }

    public function create(){
        return view('admin.role.role_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRoleRequest $request)
    {
        $inputs=$request->all();
        Role::create($inputs);
        writeLog('新增 角色',$inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/role');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions=Permission::where('status',1)->orderBy('sort')->get();
        
        $permission_roles=DB::table('permission_role')->where('role_id',$role->id)->get();
        // dd($permission_roles);
        $roleid_arr=array();
        foreach($permission_roles as $permission_role)
            $roleid_arr[]=$permission_role->permission_id;

        return view('admin.role.role_edit',compact('role', 'permissions', 'roleid_arr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRoleRequest $request, Role $role)
    {
        $inputs=$request->all();

        $permission_ids=$request->permission_id;
        if($permission_ids){
            $role->detachAllPermissions();
            foreach($permission_ids as $permission_id){
                $permission = Permission::findOrFail($permission_id);
                if($permission){
                    $permissionRole=new PermissionRole();
                    $permissionRole->role_id=$role->id;
                    $permissionRole->permission_id=$permission->id;
                    $permissionRole->save();
                }
                //$role->attachPermission($permission);
            }
        }

        $role->update($inputs);
        writeLog('更新 角色',$inputs);
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/role?bid='.$role->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //dd($role->toArray());
        $role->detachAllPermissions();
        $role->delete();
        writeLog('刪除 角色',$role->toArray());
        Session::flash('flash_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/role');
    }

    public function sort(Request $request){
        $sorts=$request->sort;
        foreach($request->role_id as $index => $role_id){
            if($sorts[$index]!=''){
                Role::where('id',$role_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        $cat_id=$request->cat_id;
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/role');
    }

    public function status($id, $status){
        Role::where('id',$id)->update(['status'=>$status]);
        //writeLog('status Role','id:'.$id.'=>status:'.$status);
        Session::flash('flash_message', '狀態更新成功!');
        return redirect('/admin/role?bid='.$id);
    }

    public function del_img(Role $role)
    {
        $role->image_name='';
        $role->update();
        Session::flash('flash_message', '圖檔刪除成功!');
        // flash()->overlay('圖檔刪除成功!','系統訊息:');
        return redirect('/admin/role');
    }

}
