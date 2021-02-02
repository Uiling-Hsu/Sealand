<?php

namespace App\Http\Controllers\admin\Permission;

use App\Model\Permission;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Permission\AdminPermissionRequest;
use App\Http\Controllers\Controller;

class AdminPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions=Permission::orderBy('sort')->get();
        // dd($permissions);
        return view('admin.permission.permission',compact('permissions'));
    }

    public function create(){
        return view('admin.permission.permission_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminPermissionRequest $request)
    {
        $inputs=$request->all();
        if ($request->hasFile('imgFile')){
            $file=$request->file('imgFile');
            $file->move('uploads/permission',$file->getClientOriginalName());
            $inputs['image_name'] = $file->getClientOriginalName();
        }
        Permission::create($inputs);
        //writeLog('Create Permission',$inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/permission');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        return view('admin.permission.permission_edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminPermissionRequest $request, Permission $permission)
    {
        $inputs=$request->all();
        if ($request->hasFile('imgFile')){
            $file=$request->file('imgFile');
            $file->move('uploads/permission',$file->getClientOriginalName());
            $inputs['image_name'] = $file->getClientOriginalName();
        }
        $cat_id=$request->cat_id;
        $permission->update($inputs);
        //writeLog('Update Permission',$inputs);
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/permission?bid='.$permission->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        // dd($permission->toArray());
        $cat_id=$permission->cat_id;
        $permission->delete();
        //writeLog('Delete Permission',$permission->toArray());
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/permission');
    }

    public function sort(Request $request){
        $sorts=$request->sort;
        foreach($request->permission_id as $index => $permission_id){
            if($sorts[$index]!=''){
                Permission::where('id',$permission_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        $cat_id=$request->cat_id;
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/permission');
    }

    public function status($id, $status){
        Permission::where('id',$id)->update(['status'=>$status]);
        //writeLog('status Permission','id:'.$id.'=>status:'.$status);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/permission?bid='.$id);
    }

    public function del_img(Permission $permission)
    {
        $permission->image_name='';
        $permission->update();
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('圖檔刪除成功!','系統訊息:');
        return redirect('/admin/permission');
    }

}
