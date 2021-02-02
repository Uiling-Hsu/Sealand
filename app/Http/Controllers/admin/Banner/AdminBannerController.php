<?php

namespace App\Http\Controllers\admin\Banner;

use App\Model\Banner;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\AdminBannerRequest;
use Intervention\Image\Facades\Image;

class AdminBannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners=Banner::orderBy('sort');
        $banners=$banners->paginate(10);
         //dd($banners);
        return view('admin/banner/banner',compact('banners'));
    }

    public function create(){
        return view('admin/banner/banner_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminBannerRequest $request)
    {
        $inputs=$request->all();
        $image_width=1920;
        $image_height=270;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'banner', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg  或 *.png 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $banner=Banner::create($inputs);
        //writeLog('Create Banner',$inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/banner?bid='.$banner->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        return view('admin/banner/banner_edit',compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminBannerRequest $request, Banner $banner)
    {
        $inputs=$request->all();
        $image_width=1920;
        $image_height=270;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'banner', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg  或 *.png 格式');
                return redirect()->back();
            }
            if($banner->image && file_exists( public_path() .$banner->image))
                unlink( public_path() . $banner->image);
            $inputs['image'] = $upload_filename;
        }
        $banner->update($inputs);
        //writeLog('Update Banner',$inputs);
        Session::flash('success_message', '更新成功!');
        //flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/banner?bid='.$banner->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        if($banner->image && file_exists( public_path() .$banner->image))
            unlink( public_path() . $banner->image);
        $banner->delete();
        //writeLog('Delete Banner',$banner->toArray());
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/banner');
    }

    public function batch_update(Request $request){
        $sorts=$request->sort;
        foreach($request->banner_id as $index => $banner_id){
            if($sorts[$index]!=''){
                Banner::where('id',$banner_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $banner=Banner::whereId($isdel)->first();
                if($banner->image && file_exists( public_path() .$banner->image))
                    unlink( public_path() . $banner->image);
                $banner->delete();
            }
        }

        Session::flash('flash_message', '批次刪除及更新排序!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/banner');
    }

    public function status($id, $status){
        Banner::where('id',$id)->update(['status'=>$status]);
        //writeLog('status Banner','id:'.$id.'=>status:'.$status);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/banner?bid='.$id);
    }

    public function del_img(Banner $banner)
    {
        if($banner->image && file_exists( public_path() .$banner->image))
            unlink( public_path() . $banner->image);
        $banner->image='';
        $banner->update();
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('圖檔刪除成功!','系統訊息:');
        return redirect('/admin/banner');
    }

}
