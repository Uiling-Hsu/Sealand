<?php

namespace App\Http\Controllers\admin\Renewtate;

use App\Http\Requests;
use App\Model\Renewtate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AdminRenewtateController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!has_permission('setting'))
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
        $renewtates=Renewtate::orderBy('sort')->get();
        return view('admin/renewtate/renewtate',compact('renewtates'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create(){
        return view('admin/renewtate/renewtate_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs=$request->all();
        //dd($inputs);
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'renewtate', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $renewtate=Renewtate::create($inputs);
        writeLog('新增 訂單狀態',$inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/renewtate?bid='.$renewtate->id.'#list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Renewtate $renewtate)
    {
        return view('admin/renewtate/renewtate_edit',compact('renewtate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Renewtate $renewtate)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'renewtate', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($renewtate->image))
                unlink($renewtate->image);
            $inputs['image'] = $upload_filename;
        }

        $renewtate->update($inputs);
        writeLog('更新 訂單狀態',$inputs);
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/renewtate?bid='.$renewtate->id.'#list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Renewtate $renewtate)
    {
        if(file_exists($renewtate->image))
            unlink($renewtate->image);
        $renewtate->delete();
        writeLog('刪除 訂單狀態',$renewtate->toArray());
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/renewtate');
    }

    public function del_img(Renewtate $renewtate, $image)
    {
        if(file_exists($renewtate->image))
            unlink($renewtate->image);
        $renewtate->update([$image=>'','position'=>'0']);
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/renewtate/'.$renewtate->id.'/edit#list');
    }

    public function sort(Request $request){
        $sorts=$request->sort;
        foreach($request->renewtate_id as $index => $renewtate_id){
            if($sorts[$index]!=''){
                Renewtate::where('id',$renewtate_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/renewtate');
    }

    public function status($id, $status){
        Renewtate::where('id',$id)->update(['status'=>$status]);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/renewtate');
    }

}
