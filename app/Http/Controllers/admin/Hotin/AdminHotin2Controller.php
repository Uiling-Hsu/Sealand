<?php

namespace App\Http\Controllers\admin\Hotin;

use App\Model\Hotin;
use App\Model\Hotin2;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Hotin\AdminHotin2Request;
use App\Http\Controllers\Controller;

class AdminHotin2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create($id){
        // if(Auth::guest()){
        //     return redirect('articles');
        // }
        $hotin=Hotin::where('id',$id)->first();
        // dd($hotin);
        return view('admin/hotin/hotin2_create',compact('id','hotin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminHotin2Request $request)
    {
        $inputs=$request->all();
        //dd($inputs);
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'hotin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        //if ($request->hasFile('video')){
        //    $file=$request->file('video');
        //    $file->move('uploads/hotin',$file->getClientOriginalName());
        //    $inputs['video'] = $file->getClientOriginalName();
        //}
        $hotin2=Hotin2::create($inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/hotin/'.$inputs['hotin_id'].'/edit?bid='.$hotin2->id.'#list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotin2 $hotin2)
    {
        $hotin=Hotin::where('id',$hotin2->hotin_id)->first();
        return view('admin/hotin/hotin2_edit',compact('hotin2','hotin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminHotin2Request $request, Hotin2 $hotin2)
    {
        $inputs=$request->except('hotin_id');
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'hotin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($hotin2->image))
                unlink($hotin2->image);
            $inputs['image'] = $upload_filename;
        }
        //if ($request->hasFile('video')){
        //    $file=$request->file('video');
        //    $file->move('uploads/hotin',$file->getClientOriginalName());
        //    $inputs['video'] = $file->getClientOriginalName();
        //}
        // dd($inputs);
        $hotin2->update($inputs);
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/hotin/'.$hotin2->hotin_id.'/edit?bid='.$hotin2->id.'#list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotin2 $hotin2)
    {
        if(file_exists($hotin2->image))
            unlink($hotin2->image);
        $hotin_id=$hotin2->hotin_id;
        $hotin2->delete();
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/hotin/'.$hotin_id.'/edit#list');
    }

    public function del_img(Hotin2 $hotin2, $image)
    {
        if(file_exists($hotin2->image))
            unlink($hotin2->image);
        $hotin2->update([$image=>'','position'=>'0']);
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/hotin2/'.$hotin2->id.'/edit#list');
    }

    public function sort(Request $request){
        $sorts=$request->sort;
        foreach($request->hotin2_id as $index => $hotin2_id){
            if($sorts[$index]!=''){
                Hotin2::where('id',$hotin2_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        $hotin_id=$request->hotin_id;
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/hotin/'.$hotin_id.'/edit#list');
    }

    public function status($id, $status, $hotin_id){
        Hotin2::where('id',$id)->update(['status'=>$status]);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/hotin/'.$hotin_id.'/edit#list');
    }

}
