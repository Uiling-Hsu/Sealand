<?php

namespace App\Http\Controllers\admin\Flowcat;

use App\Model\Flowcat;
use App\Http\Requests;
use App\Model\Flowin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Flowcat\AdminFlowcatRequest;
use Intervention\Image\Facades\Image;

class AdminFlowcatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //chk_change_ord_state_7();
        //chk_user_renewal_notify_email();
        $flowcats=Flowcat::orderBy('sort');
        $flowcats=$flowcats->paginate(10);
         //dd($flowcats);
        return view('admin/flowcat/flowcat',compact('flowcats'));
    }

    public function create(){
        return view('admin/flowcat/flowcat_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminFlowcatRequest $request)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'flowcat', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $flowcat=Flowcat::create($inputs);
        //writeLog('Create Flowcat',$inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/flowcat?bid='.$flowcat->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Flowcat $flowcat)
    {
        return view('admin/flowcat/flowcat_edit',compact('flowcat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminFlowcatRequest $request, Flowcat $flowcat)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'flowcat', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($flowcat->image))
                unlink($flowcat->image);
            $inputs['image'] = $upload_filename;
        }
        $flowcat->update($inputs);
        //writeLog('Update Flowcat',$inputs);
        Session::flash('success_message', '更新成功!');
        //flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/flowcat?bid='.$flowcat->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flowins=Flowin::where('flowcat_id',$id)->get();
        foreach ($flowins as $flowin) {
            if(file_exists($flowin->image))
                unlink($flowin->image);
            $flowin->delete();
        }
        $flowcat=Flowcat::where('id',$id)->first();
        if(file_exists($flowcat->image))
            unlink($flowcat->image);
        $flowcat->delete();

        //writeLog('Delete Flowcat',$flowcat->toArray());
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/flowcat');
    }

    public function batch_update(Request $request){
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $flowcat=Flowcat::whereId($isdel)->first();
                $flowins=Flowin::where('flowcat_id',$isdel)->get();
                foreach($flowins as $flowin){
                    if(file_exists($flowin->image))
                        unlink($flowin->image);
                    $flowin->delete();
                }
                if(file_exists($flowcat->image))
                    unlink($flowcat->image);
                $flowcat->delete();
            }
        }

        Session::flash('success_message', '批次刪除成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/flowcat');
    }

    public function status($id, $status){
        Flowcat::where('id',$id)->update(['status'=>$status]);
        //writeLog('status Flowcat','id:'.$id.'=>status:'.$status);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/flowcat?bid='.$id);
    }

    public function del_img(Flowcat $flowcat)
    {
        if(file_exists($flowcat->image))
            unlink($flowcat->image);
        $flowcat->image='';
        $flowcat->update();
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('圖檔刪除成功!','系統訊息:');
        return redirect('/admin/flowcat');
    }

}
