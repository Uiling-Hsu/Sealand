<?php

namespace App\Http\Controllers\admin\Shippingtype;

use App\Model\Shippingtype;
use App\Model\Shippingtype2;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Shippingtype\AdminShippingtypeRequest;
use App\Http\Controllers\Controller;

class AdminShippingtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shippingtypes=Shippingtype::orderBy('sort')->paginate(10);
        return view('admin/shippingtype/shippingtype',compact('shippingtypes'));
    }

    public function show_list($id)
    {
        $shippingtypes=orderBy('title_tw','DESC')->paginate(10);
        return view('admin/shippingtype/shippingtype',compact('shippingtypes'));
    }

    public function create(){
        return view('admin/shippingtype/shippingtype_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminShippingtypeRequest $request)
    {
        $inputs=$request->all();
        $image_width=640;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'shippingtype', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $shippingtype=Shippingtype::create($inputs);
        Session::flash('flash_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/shippingtype'.'?bid='.$shippingtype->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Shippingtype $shippingtype)
    {
        return view('admin/shippingtype/shippingtype_edit',compact('shippingtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminShippingtypeRequest $request, Shippingtype $shippingtype)
    {
        $inputs=$request->all();
        $image_width=950;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'shippingtype', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($shippingtype->image))
                unlink($shippingtype->image);
            $inputs['image'] = $upload_filename;
        }
        $shippingtype->update($inputs);
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/shippingtype/'.$shippingtype->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shippingtype $shippingtype)
    {
        if(file_exists($shippingtype->image))
            unlink($shippingtype->image);
        $shippingtype->delete();
        Session::flash('flash_message', '刪除成功!');
        return redirect('/admin/shippingtype');
    }

    public function del_img(Shippingtype $shippingtype)
    {
        if(file_exists($shippingtype->image))
            unlink($shippingtype->image);
        $shippingtype->image='';
        $shippingtype->update();
        Session::flash('flash_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/shippingtype/'.$shippingtype->id.'/edit');
    }

    public function batch_update(Request $request){
        $sorts=$request->sort;
        foreach($request->shippingtype_id as $index => $shippingtype_id){
            if($sorts[$index]!=''){
                Shippingtype::where('id',$shippingtype_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $shippingtype=Shippingtype::whereId($isdel)->first();
                if(file_exists($shippingtype->image))
                    unlink($shippingtype->image);
                $shippingtype->delete();
            }
        }

        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/shippingtype');
    }


    public function status($id, $status){
        Shippingtype::where('id',$id)->update(['status'=>$status]);
        Session::flash('flash_message', '狀態更新成功!');
        return redirect('/admin/shippingtype');
    }

}
