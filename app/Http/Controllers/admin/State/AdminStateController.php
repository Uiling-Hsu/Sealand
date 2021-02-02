<?php

namespace App\Http\Controllers\admin\State;

use App\Http\Requests;
use App\Model\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AdminStateController extends Controller
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
        $states=State::orderBy('sort')->get();
        return view('admin/state/state',compact('states'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create(){
        return view('admin/state/state_create');
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
            $upload_filename = upload_file($request->file('imgFile'), 'state', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $state=State::create($inputs);
        writeLog('新增 訂單狀態',$inputs,1);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/state?bid='.$state->id.'#list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        return view('admin/state/state_edit',compact('state'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'state', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($state->image))
                unlink($state->image);
            $inputs['image'] = $upload_filename;
        }

        $state->update($inputs);
        writeLog('更新 訂單狀態',$inputs,1);
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/state?bid='.$state->id.'#list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        if(file_exists($state->image))
            unlink($state->image);
        $state->delete();
        writeLog('刪除 訂單狀態',$state->toArray(),1);
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/state');
    }

    public function del_img(State $state, $image)
    {
        if(file_exists($state->image))
            unlink($state->image);
        $state->update([$image=>'','position'=>'0']);
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/state/'.$state->id.'/edit#list');
    }

    public function sort(Request $request){
        $sorts=$request->sort;
        foreach($request->state_id as $index => $state_id){
            if($sorts[$index]!=''){
                State::where('id',$state_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/state');
    }

    public function status($id, $status){
        State::where('id',$id)->update(['status'=>$status]);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/state');
    }

}
