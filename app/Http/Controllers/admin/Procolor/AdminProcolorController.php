<?php

namespace App\Http\Controllers\admin\Procolor;

use App\Model\Procolor;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Procolor\AdminProcolorRequest;
use Intervention\Image\Facades\Image;

class AdminProcolorController extends Controller
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
        $procolors=Procolor::orderBy('sort');
        $procolors=$procolors->paginate(100);
         //dd($procolors);
        return view('admin/procolor/procolor',compact('procolors'));
    }

    public function create(){
        return view('admin/procolor/procolor_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminProcolorRequest $request)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'procolor', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $procolor=Procolor::create($inputs);
        //writeLog('Create Procolor',$inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/procolor?bid='.$procolor->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Procolor $procolor)
    {
        return view('admin/procolor/procolor_edit',compact('procolor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminProcolorRequest $request, Procolor $procolor)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'procolor', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($procolor->image))
                unlink($procolor->image);
            $inputs['image'] = $upload_filename;
        }
        $procolor->update($inputs);
        //writeLog('Update Procolor',$inputs);
        Session::flash('success_message', '更新成功!');
        //flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/procolor?bid='.$procolor->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $procolor=Procolor::where('id',$id)->first();
        if(file_exists($procolor->image))
            unlink($procolor->image);
        $procolor->delete();

        //writeLog('Delete Procolor',$procolor->toArray());
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/procolor');
    }

    public function batch_update(Request $request){
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $procolor=Procolor::whereId($isdel)->first();

                if(file_exists($procolor->image))
                    unlink($procolor->image);
                $procolor->delete();
            }
        }

        Session::flash('success_message', '批次刪除成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/procolor');
    }

    public function status($id, $status){
        Procolor::where('id',$id)->update(['status'=>$status]);
        //writeLog('status Procolor','id:'.$id.'=>status:'.$status);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/procolor?bid='.$id);
    }

    public function del_img(Procolor $procolor)
    {
        if(file_exists($procolor->image))
            unlink($procolor->image);
        $procolor->image='';
        $procolor->update();
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('圖檔刪除成功!','系統訊息:');
        return redirect('/admin/procolor');
    }

}
