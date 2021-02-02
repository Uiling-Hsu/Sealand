<?php

namespace App\Http\Controllers\admin\Ptate;

use App\Http\Requests;
use App\Model\Ptate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AdminPtateController extends Controller
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
        $ptates=Ptate::orderBy('sort')->get();
        return view('admin/ptate/ptate',compact('ptates'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create(){
        return view('admin/ptate/ptate_create');
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
            $upload_filename = upload_file($request->file('imgFile'), 'ptate', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $ptate=Ptate::create($inputs);
        writeLog('新增 訂單狀態',$inputs,1);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/ptate?bid='.$ptate->id.'#list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Ptate $ptate)
    {
        return view('admin/ptate/ptate_edit',compact('ptate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ptate $ptate)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'ptate', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($ptate->image))
                unlink($ptate->image);
            $inputs['image'] = $upload_filename;
        }

        $ptate->update($inputs);
        writeLog('更新 訂單狀態',$inputs,1);
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/ptate?bid='.$ptate->id.'#list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ptate $ptate)
    {
        if($ptate->image && file_exists($ptate->image))
            unlink($ptate->image);
        $ptate->delete();
        writeLog('刪除 訂單狀態',$ptate->toArray(),1);
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/ptate');
    }

    public function del_img(Ptate $ptate, $image)
    {
        if(file_exists($ptate->image))
            unlink($ptate->image);
        $ptate->update([$image=>'','position'=>'0']);
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/ptate/'.$ptate->id.'/edit#list');
    }

    public function sort(Request $request){
        $sorts=$request->sort;
        foreach($request->ptate_id as $index => $ptate_id){
            if($sorts[$index]!=''){
                Ptate::where('id',$ptate_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/ptate');
    }

    public function status($id, $status){
        Ptate::where('id',$id)->update(['status'=>$status]);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/ptate');
    }

}
