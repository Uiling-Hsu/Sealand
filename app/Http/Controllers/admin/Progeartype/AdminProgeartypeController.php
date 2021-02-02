<?php

namespace App\Http\Controllers\admin\Progeartype;

use App\Model\Progeartype;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Progeartype\AdminProgeartypeRequest;
use Intervention\Image\Facades\Image;

class AdminProgeartypeController extends Controller
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
        $progeartypes=Progeartype::orderBy('sort');
        $progeartypes=$progeartypes->paginate(10);
         //dd($progeartypes);
        return view('admin/progeartype/progeartype',compact('progeartypes'));
    }

    public function create(){
        return view('admin/progeartype/progeartype_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminProgeartypeRequest $request)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'progeartype', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $progeartype=Progeartype::create($inputs);
        //writeLog('Create Progeartype',$inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/progeartype?bid='.$progeartype->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Progeartype $progeartype)
    {
        return view('admin/progeartype/progeartype_edit',compact('progeartype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminProgeartypeRequest $request, Progeartype $progeartype)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'progeartype', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($progeartype->image))
                unlink($progeartype->image);
            $inputs['image'] = $upload_filename;
        }
        $progeartype->update($inputs);
        //writeLog('Update Progeartype',$inputs);
        Session::flash('success_message', '更新成功!');
        //flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/progeartype?bid='.$progeartype->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $progeartype=Progeartype::where('id',$id)->first();
        if(file_exists($progeartype->image))
            unlink($progeartype->image);
        $progeartype->delete();

        //writeLog('Delete Progeartype',$progeartype->toArray());
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/progeartype');
    }

    public function batch_update(Request $request){
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $progeartype=Progeartype::whereId($isdel)->first();

                if(file_exists($progeartype->image))
                    unlink($progeartype->image);
                $progeartype->delete();
            }
        }

        Session::flash('success_message', '批次刪除成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/progeartype');
    }

    public function status($id, $status){
        Progeartype::where('id',$id)->update(['status'=>$status]);
        //writeLog('status Progeartype','id:'.$id.'=>status:'.$status);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/progeartype?bid='.$id);
    }

    public function del_img(Progeartype $progeartype)
    {
        if(file_exists($progeartype->image))
            unlink($progeartype->image);
        $progeartype->image='';
        $progeartype->update();
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('圖檔刪除成功!','系統訊息:');
        return redirect('/admin/progeartype');
    }

}
