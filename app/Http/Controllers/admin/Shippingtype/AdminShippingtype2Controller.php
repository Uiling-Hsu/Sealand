<?php

namespace App\Http\Controllers\admin\Shippingtype;

use App\Model\Shippingtype;
use App\Model\Shippingtype2;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Shippingtype\AdminShippingtype2Request;
use App\Http\Controllers\Controller;

class AdminShippingtype2Controller extends Controller
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
        $shippingtype=Shippingtype::where('id',$id)->first();
        // dd($shippingtype);
        return view('admin/shippingtype/shippingtype2_create',compact('id','shippingtype'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminShippingtype2Request $request)
    {
        $inputs=$request->all();
        //dd($inputs);
        $image_width=953;
        $image_height=630;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'shippingtype', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        //if ($request->hasFile('video')){
        //    $file=$request->file('video');
        //    $file->move('uploads/shippingtype',$file->getClientOriginalName());
        //    $inputs['video'] = $file->getClientOriginalName();
        //}
        $shippingtype2=Shippingtype2::create($inputs);
        Session::flash('flash_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/shippingtype/'.$inputs['shippingtype_id'].'/edit?bid='.$shippingtype2->id.'#list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Shippingtype2 $shippingtype2)
    {
        $shippingtype=Shippingtype::where('id',$shippingtype2->shippingtype_id)->first();
        return view('admin/shippingtype/shippingtype2_edit',compact('shippingtype2','shippingtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminShippingtype2Request $request, Shippingtype2 $shippingtype2)
    {
        $inputs=$request->except('shippingtype_id');
        $image_width=953;
        $image_height=630;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'shippingtype', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($shippingtype2->image))
                unlink($shippingtype2->image);
            $inputs['image'] = $upload_filename;
        }
        //if ($request->hasFile('video')){
        //    $file=$request->file('video');
        //    $file->move('uploads/shippingtype',$file->getClientOriginalName());
        //    $inputs['video'] = $file->getClientOriginalName();
        //}
        // dd($inputs);
        $shippingtype2->update($inputs);
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/shippingtype/'.$shippingtype2->shippingtype_id.'/edit?bid='.$shippingtype2->id.'#list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shippingtype2 $shippingtype2)
    {
        if(file_exists($shippingtype2->image))
            unlink($shippingtype2->image);
        $shippingtype_id=$shippingtype2->shippingtype_id;
        $shippingtype2->delete();
        Session::flash('flash_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/shippingtype/'.$shippingtype_id.'/edit#list');
    }

    public function del_img(Shippingtype2 $shippingtype2, $image)
    {
        if(file_exists($shippingtype2->image))
            unlink($shippingtype2->image);
        $shippingtype2->update([$image=>'','position'=>'0']);
        Session::flash('flash_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/shippingtype2/'.$shippingtype2->id.'/edit#list');
    }

    public function sort(Request $request){
        $sorts=$request->sort;
        foreach($request->shippingtype2_id as $index => $shippingtype2_id){
            if($sorts[$index]!=''){
                Shippingtype2::where('id',$shippingtype2_id)->update([ 'sort' =>$sorts[$index]]);
            }
        }
        $shippingtype_id=$request->shippingtype_id;
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/shippingtype/'.$shippingtype_id.'/edit#list');
    }

    public function status($id, $status, $shippingtype_id){
        Shippingtype2::where('id',$id)->update([ 'status' =>$status]);
        Session::flash('flash_message', '狀態更新成功!');
        return redirect('/admin/shippingtype/'.$shippingtype_id.'/edit#list');
    }

}
