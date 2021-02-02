<?php

namespace App\Http\Controllers\admin\Hotin;

use App\Model\Hotin;
use App\Model\Hotcat;
use App\Model\Hotin2;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Hotin\AdminHotinRequest;
use App\Http\Controllers\Controller;

class AdminHotinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hotins=Hotin::orderBy('published_at','DESC')->paginate(10);
        return view('admin/hotin/hotin',compact('hotins'));
    }

    public function show_list($id)
    {
        $hotins=orderBy('title_tw','DESC')->paginate(10);
        return view('admin/hotin/hotin',compact('hotins'));
    }

    public function create(){
        return view('admin/hotin/hotin_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminHotinRequest $request)
    {
        $inputs=$request->all();
        $image_width=640;
        $image_height=362;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'hotin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $hotin=Hotin::create($inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/hotin'.'?bid='.$hotin->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotin $hotin)
    {
        $hotin2s=Hotin2::where('hotin_id',$hotin->id)->orderBy('sort','asc')->get();
        return view('admin/hotin/hotin_edit',compact('hotin','hotin2s'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminHotinRequest $request, Hotin $hotin)
    {
        $inputs=$request->all();
        $image_width=640;
        $image_height=362;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'hotin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($hotin->image))
                unlink($hotin->image);
            $inputs['image'] = $upload_filename;
        }
        $hotin->update($inputs);
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/hotin/'.$hotin->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotin $hotin)
    {
        if(file_exists($hotin->image))
            unlink($hotin->image);
        $hotin2s=Hotin2::where('hotin_id',$hotin->id);
        $hotin2s->delete();
        $hotin->delete();
        Session::flash('success_message', '刪除成功!');
        return redirect('/admin/hotin');
    }

    public function del_img(Hotin $hotin)
    {
        if(file_exists($hotin->image))
            unlink($hotin->image);
        $hotin->image='';
        $hotin->update();
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/hotin/'.$hotin->id.'/edit');
    }

    public function batch_update(Request $request){
        $sorts=$request->sort;
        foreach($request->hotin_id as $index => $hotin_id){
            if($sorts[$index]!=''){
                Hotin::where('id',$hotin_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $hotin=Hotin::whereId($isdel)->first();
                if(file_exists($hotin->image))
                    unlink($hotin->image);
                $hotin->delete();
            }
        }

        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/hotin');
    }


    public function status($id, $status){
        Hotin::where('id',$id)->update(['status'=>$status]);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/hotin');
    }

}
