<?php

namespace App\Http\Controllers\admin\Aboutin;

use App\Model\Aboutin;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AdminAboutinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aboutins=Aboutin::orderBy('sort')->paginate(10);
        return view('admin/aboutin/aboutin',compact('aboutins'));
    }

    public function show_list($id)
    {
        $aboutins=orderBy('title','DESC')->paginate(10);
        return view('admin/aboutin/aboutin',compact('aboutins'));
    }

    public function create(){
        return view('admin/aboutin/aboutin_create');
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
        if ($request->hasFile('imgFile1')){
            $upload_filename = upload_file($request->file('imgFile1'), 'aboutin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            //dd($upload_filename);
            $inputs['image'] = $upload_filename;
        }
        /*if ($request->hasFile('imgFile2')){
            $upload_filename = upload_file($request->file('imgFile2'), 'mediain', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image02'] = $upload_filename;
        }
        if ($request->hasFile('imgFile3')){
            $upload_filename = upload_file($request->file('imgFile3'), 'mediain', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image03'] = $upload_filename;
        }*/
        $aboutin=Aboutin::create($inputs);
        Session::flash('flash_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/aboutin'.'?bid='.$aboutin->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Aboutin $aboutin)
    {
        return view('admin/aboutin/aboutin_edit',compact('aboutin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aboutin $aboutin)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile1')){
            $upload_filename = upload_file($request->file('imgFile1'), 'aboutin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($aboutin->image))
                unlink($aboutin->image);
            $inputs['image'] = $upload_filename;
        }
        $aboutin->update($inputs);
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/aboutin/'.$aboutin->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aboutin $aboutin)
    {
        if(file_exists($aboutin->image))
            unlink($aboutin->image);

        $aboutin->delete();
        Session::flash('flash_message', '刪除成功!');
        return redirect('/admin/aboutin');
    }

    public function del_img(Aboutin $aboutin)
    {
        if(file_exists($aboutin->image))
            unlink($aboutin->image);
        $aboutin->image='';
        $aboutin->update();
        Session::flash('flash_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/aboutin/'.$aboutin->id.'/edit');
    }

    public function batch_update(Request $request){
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $aboutin=Aboutin::whereId($isdel)->first();
                if(file_exists($aboutin->image))
                    unlink($aboutin->image);
                $aboutin->delete();
            }
        }

        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/aboutin');
    }


    public function status($id, $status){
        Aboutin::where('id',$id)->update(['status'=>$status]);
        Session::flash('flash_message', '狀態更新成功!');
        return redirect('/admin/aboutin');
    }

}
