<?php

namespace App\Http\Controllers\admin\Profuel;

use App\Model\Profuel;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profuel\AdminProfuelRequest;
use Intervention\Image\Facades\Image;

class AdminProfuelController extends Controller
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
        $profuels=Profuel::orderBy('sort');
        $profuels=$profuels->paginate(10);
         //dd($profuels);
        return view('admin/profuel/profuel',compact('profuels'));
    }

    public function create(){
        return view('admin/profuel/profuel_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminProfuelRequest $request)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'profuel', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $profuel=Profuel::create($inputs);
        //writeLog('Create Profuel',$inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/profuel?bid='.$profuel->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Profuel $profuel)
    {
        return view('admin/profuel/profuel_edit',compact('profuel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminProfuelRequest $request, Profuel $profuel)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'profuel', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($profuel->image))
                unlink($profuel->image);
            $inputs['image'] = $upload_filename;
        }
        $profuel->update($inputs);
        //writeLog('Update Profuel',$inputs);
        Session::flash('success_message', '更新成功!');
        //flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/profuel?bid='.$profuel->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $profuel=Profuel::where('id',$id)->first();
        if(file_exists($profuel->image))
            unlink($profuel->image);
        $profuel->delete();

        //writeLog('Delete Profuel',$profuel->toArray());
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/profuel');
    }

    public function batch_update(Request $request){
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $profuel=Profuel::whereId($isdel)->first();

                if(file_exists($profuel->image))
                    unlink($profuel->image);
                $profuel->delete();
            }
        }

        Session::flash('success_message', '批次刪除成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/profuel');
    }

    public function status($id, $status){
        Profuel::where('id',$id)->update(['status'=>$status]);
        //writeLog('status Profuel','id:'.$id.'=>status:'.$status);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/profuel?bid='.$id);
    }

    public function del_img(Profuel $profuel)
    {
        if(file_exists($profuel->image))
            unlink($profuel->image);
        $profuel->image='';
        $profuel->update();
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('圖檔刪除成功!','系統訊息:');
        return redirect('/admin/profuel');
    }

}
