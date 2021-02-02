<?php

namespace App\Http\Controllers\admin\Proarea;

use App\Model\Proarea;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Proarea\AdminProareaRequest;
use Intervention\Image\Facades\Image;

class AdminProareaController extends Controller
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
        $proareas=Proarea::orderBy('sort');
        $proareas=$proareas->paginate(30);
         //dd($proareas);
        return view('admin/proarea/proarea',compact('proareas'));
    }

    public function create(){
        return view('admin/proarea/proarea_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminProareaRequest $request)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'proarea', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $proarea=Proarea::create($inputs);
        //writeLog('Create Proarea',$inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/proarea?bid='.$proarea->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Proarea $proarea)
    {
        return view('admin/proarea/proarea_edit',compact('proarea'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminProareaRequest $request, Proarea $proarea)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'proarea', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($proarea->image))
                unlink($proarea->image);
            $inputs['image'] = $upload_filename;
        }
        $proarea->update($inputs);
        //writeLog('Update Proarea',$inputs);
        Session::flash('success_message', '更新成功!');
        //flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/proarea?bid='.$proarea->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $proarea=Proarea::where('id',$id)->first();
        if(file_exists($proarea->image))
            unlink($proarea->image);
        $proarea->delete();

        //writeLog('Delete Proarea',$proarea->toArray());
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/proarea');
    }

    public function batch_update(Request $request){
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $proarea=Proarea::whereId($isdel)->first();
                if(file_exists($proarea->image))
                    unlink($proarea->image);
                $proarea->delete();
            }
        }

        Session::flash('success_message', '批次刪除成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/proarea');
    }

    public function status($id, $status){
        Proarea::where('id',$id)->update(['status'=>$status]);
        //writeLog('status Proarea','id:'.$id.'=>status:'.$status);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/proarea?bid='.$id);
    }

    public function del_img(Proarea $proarea)
    {
        if(file_exists($proarea->image))
            unlink($proarea->image);
        $proarea->image='';
        $proarea->update();
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('圖檔刪除成功!','系統訊息:');
        return redirect('/admin/proarea');
    }

}
