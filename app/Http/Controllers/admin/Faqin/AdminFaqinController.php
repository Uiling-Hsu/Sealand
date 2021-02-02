<?php

namespace App\Http\Controllers\admin\Faqin;

use App\Model\Faqcat;
use App\Model\Faqin;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Faqin\AdminFaqinRequest;
use App\Http\Controllers\Controller;

class AdminFaqinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_faqcat_id=Request('search_faqcat_id');
        $list_faqcats = Faqcat::whereStatus(1)->orderBy('sort')->get()->pluck('title_tw', 'id');
        $first_faqcat = Faqcat::whereStatus(1)->orderBy('sort')->first();
        $faqins=Faqin::where('faqcat_id',$search_faqcat_id?$search_faqcat_id:$first_faqcat->id)->orderBy('sort')->get();

        return view('admin/faqin/faqin',compact('faqins','list_faqcats', 'search_faqcat_id'));
    }

    public function show_list($id)
    {
        $faqins=orderBy('title','DESC')->paginate(10);
        return view('admin/faqin/faqin',compact('faqins'));
    }

    public function create($id){
        $list_faqcats = Faqcat::whereStatus(1)->get()->pluck('title_tw', 'id');
        return view('admin/faqin/faqin_create',compact('list_faqcats','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminFaqinRequest $request)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'faqin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        if ($request->hasFile('video')){
            $file=$request->file('video');
            $file->move('storages/faqin',$file->getClientOriginalName());
            $inputs['video'] = '/storages/faqin/'.$file->getClientOriginalName();
        }
        $faqin=Faqin::create($inputs);
        Session::flash('flash_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/faqin?search_faqcat_id='.$request->faqcat_id.'&bid='.$faqin->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Faqin $faqin)
    {
        $list_faqcats = Faqcat::whereStatus(1)->get()->pluck('title_tw', 'id');
        return view('admin/faqin/faqin_edit',compact('faqin','list_faqcats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminFaqinRequest $request, Faqin $faqin)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'faqin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        if ($request->hasFile('video')){
            $file=$request->file('video');
            $file->move('storages/faqin',$file->getClientOriginalName());
            $inputs['video'] = '/storages/faqin/'.$file->getClientOriginalName();
        }
        $faqin->update($inputs);
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/faqin/'.$faqin->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faqin $faqin)
    {
        if(file_exists($faqin->image))
            unlink($faqin->image);
        $faqin->delete();
        Session::flash('flash_message', '刪除成功!');
        return redirect('/admin/faqin?search_faqcat_id='.$faqin->faqcat_id);
    }

    public function del_img(Faqin $faqin)
    {
        if(file_exists($faqin->image))
            unlink($faqin->image);
        $faqin->image='';
        $faqin->update();
        Session::flash('flash_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/faqin/'.$faqin->id.'/edit');
    }

    public function batch_update(Request $request){
        $sorts=$request->sort;
        foreach($request->faqin_id as $index => $faqin_id){
            if($sorts[$index]!=''){
                Faqin::where('id',$faqin_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $faqin=Faqin::whereId($isdel)->first();
                if(file_exists($faqin->image))
                    unlink($faqin->image);
                $faqin->delete();
            }
        }

        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/faqin?search_faqcat_id='.$request->search_faqcat_id);
    }


    public function status($id, $status){
        Faqin::where('id',$id)->update(['status'=>$status]);
        $faqin=Faqin::where('id',$id)->first();
        Session::flash('flash_message', '狀態更新成功!');
        return redirect('/admin/faqin?search_faqcat_id='.$faqin->faqcat_id.'&bid='.$id);
    }

}
