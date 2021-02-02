<?php

namespace App\Http\Controllers\admin\Faqcat;

use App\Model\Faqcat;
use App\Http\Requests;
use App\Model\Faqin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Faqcat\AdminFaqcatRequest;
use Intervention\Image\Facades\Image;

class AdminFaqcatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqcats=Faqcat::orderBy('sort');
        $faqcats=$faqcats->paginate(10);
         //dd($faqcats);
        return view('admin/faqcat/faqcat',compact('faqcats'));
    }

    public function create(){
        return view('admin/faqcat/faqcat_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminFaqcatRequest $request)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'faqcat', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $faqcat=Faqcat::create($inputs);
        //writeLog('Create Faqcat',$inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/faqcat?bid='.$faqcat->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Faqcat $faqcat)
    {
        return view('admin/faqcat/faqcat_edit',compact('faqcat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminFaqcatRequest $request, Faqcat $faqcat)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'faqcat', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($faqcat->image))
                unlink($faqcat->image);
            $inputs['image'] = $upload_filename;
        }
        $faqcat->update($inputs);
        //writeLog('Update Faqcat',$inputs);
        Session::flash('success_message', '更新成功!');
        //flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/faqcat?bid='.$faqcat->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faqins=Faqin::where('faqcat_id',$id)->get();
        foreach ($faqins as $faqin) {
            if(file_exists($faqin->image))
                unlink($faqin->image);
            $faqin->delete();
        }
        $faqcat=Faqcat::where('id',$id)->first();
        if(file_exists($faqcat->image))
            unlink($faqcat->image);
        $faqcat->delete();

        //writeLog('Delete Faqcat',$faqcat->toArray());
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/faqcat');
    }

    public function batch_update(Request $request){
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $faqcat=Faqcat::whereId($isdel)->first();
                $faqins=Faqin::where('faqcat_id',$isdel)->get();
                foreach($faqins as $faqin){
                    if(file_exists($faqin->image))
                        unlink($faqin->image);
                    $faqin->delete();
                }
                if(file_exists($faqcat->image))
                    unlink($faqcat->image);
                $faqcat->delete();
            }
        }

        Session::flash('success_message', '批次刪除成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/faqcat');
    }

    public function status($id, $status){
        Faqcat::where('id',$id)->update(['status'=>$status]);
        //writeLog('status Faqcat','id:'.$id.'=>status:'.$status);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/faqcat?bid='.$id);
    }

    public function del_img(Faqcat $faqcat)
    {
        if(file_exists($faqcat->image))
            unlink($faqcat->image);
        $faqcat->image='';
        $faqcat->update();
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('圖檔刪除成功!','系統訊息:');
        return redirect('/admin/faqcat');
    }

}
