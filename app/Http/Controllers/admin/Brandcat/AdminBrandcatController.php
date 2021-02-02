<?php

namespace App\Http\Controllers\admin\Brandcat;

use App\Model\Brandcat;
use App\Http\Requests;
use App\Model\Brandin;
use App\Model\Cate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\Brandcat\AdminBrandcatRequest;
use Intervention\Image\Facades\Image;

class AdminBrandcatController extends Controller
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
        $list_cates=Cate::whereStatus(1)->orderBy('sort')->pluck('title','id');
        $search_cate_id=Request('search_cate_id');
        $first_cate=Cate::whereStatus(1)->orderBy('sort')->first();
        if(!$search_cate_id && $first_cate)
            $search_cate_id=$first_cate->id;

        $brandcats=new Brandcat;
        if($search_cate_id && $search_cate_id!='all') {
            $brandcats = $brandcats->where('cate_id', $search_cate_id);
        }
        $brandcats = $brandcats->orderBy('sort')->get();
         //dd($brandcats);
        return view('admin/brandcat/brandcat',compact('brandcats','list_cates','search_cate_id'));
    }

    public function create(Cate $cate){
        $search_cate_id=Request('search_cate_id');
        if($search_cate_id)
            session()->put('search_cate_id',$search_cate_id);

        return view('admin/brandcat/brandcat_create',compact('list_cates','cate','search_cate_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminBrandcatRequest $request)
    {

        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'brandcat', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $brandcat=Brandcat::create($inputs);
        //writeLog('Create Brandcat',$inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/brandcat?bid='.$brandcat->id.'&search_cate_id='.session()->get('search_cate_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Brandcat $brandcat)
    {
        $search_cate_id=Request('search_cate_id');
        if($search_cate_id)
            session()->put('search_cate_id',$search_cate_id);
        return view('admin/brandcat/brandcat_edit',compact('brandcat','search_cate_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminBrandcatRequest $request, Brandcat $brandcat)
    {
        $inputs=$request->all();
        $image_width=1200;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'brandcat', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($brandcat->image))
                unlink($brandcat->image);
            $inputs['image'] = $upload_filename;
        }
        $brandcat->update($inputs);
        //writeLog('Update Brandcat',$inputs);
        Session::flash('success_message', '更新成功!');
        //flash()->overlay('更新成功!','系統訊息:');

        return redirect('/admin/brandcat?bid='.$brandcat->id.'&search_cate_id='.session()->get('search_cate_id'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brandins=Brandin::where('brandcat_id',$id)->get();
        foreach ($brandins as $brandin) {
            if(file_exists($brandin->image))
                unlink($brandin->image);
            $brandin->delete();
        }
        $brandcat=Brandcat::where('id',$id)->first();
        if(file_exists($brandcat->image))
            unlink($brandcat->image);
        $brandcat->delete();

        //writeLog('Delete Brandcat',$brandcat->toArray());
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/brandcat?search_cate_id='.session()->get('search_cate_id'));
    }

    public function batch_update(Request $request){
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $brandcat=Brandcat::whereId($isdel)->first();
                $brandins=Brandin::where('brandcat_id',$isdel)->get();
                foreach($brandins as $brandin){
                    if(file_exists($brandin->image))
                        unlink($brandin->image);
                    $brandin->delete();
                }
                if(file_exists($brandcat->image))
                    unlink($brandcat->image);
                $brandcat->delete();
            }
        }

        Session::flash('success_message', '批次刪除成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/brandcat');
    }

    public function status($id, $status){
        Brandcat::where('id',$id)->update(['status'=>$status]);
        //writeLog('status Brandcat','id:'.$id.'=>status:'.$status);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/brandcat?bid='.$id);
    }

    public function del_img(Brandcat $brandcat)
    {
        if(file_exists($brandcat->image))
            unlink($brandcat->image);
        $brandcat->image='';
        $brandcat->update();
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('圖檔刪除成功!','系統訊息:');
        return redirect('/admin/brandcat');
    }

}
