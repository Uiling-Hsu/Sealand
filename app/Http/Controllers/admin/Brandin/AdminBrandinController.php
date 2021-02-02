<?php

namespace App\Http\Controllers\admin\Brandin;

use App\Model\Brandcat;
use App\Model\Brandin;
use App\Http\Requests;
use App\Model\Cate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Brandin\AdminBrandinRequest;
use App\Http\Controllers\Controller;

class AdminBrandinController extends Controller
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

        $list_brandcats = Brandcat::whereStatus(1)->where('cate_id',$search_cate_id)->orderBy('sort')->get()->pluck('title', 'id')->prepend('請選擇','');
        $search_brandcat_id=Request('search_brandcat_id');
	    $brandins=null;
        if(!$search_brandcat_id) {
            $first_brandcat = Brandcat::whereStatus(1)->where('cate_id',$search_cate_id)->orderBy('sort')->first();
            if($first_brandcat)
                $search_brandcat_id = $first_brandcat->id;
        }

        $brandins = Brandin::where('cate_id', $search_cate_id)
            ->where('brandcat_id', $search_brandcat_id)
            ->orderBy('sort')
            ->get();

        return view('admin/brandin/brandin',compact('brandins','list_cates','list_brandcats', 'search_cate_id', 'search_brandcat_id'));
    }

    public function create(Cate $cate, Brandcat $brandcat){
        /*$brandin_query=str_replace(Request()->url(), '',Request()->fullUrl());*/

        return view('admin/brandin/brandin_create',compact('cate', 'brandcat'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminBrandinRequest $request)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'brandin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        /*if ($request->hasFile('video')){
            $file=$request->file('video');
            $file->move('storages/brandin',$file->getClientOriginalName());
            $inputs['video'] = '/storages/brandin/'.$file->getClientOriginalName();
        }*/
        $brandin=Brandin::create($inputs);
        Session::flash('flash_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/brandin?search_cate_id='.$request->cate_id.'&search_brandcat_id='.$request->brandcat_id.'&bid='.$brandin->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Brandin $brandin)
    {
        $list_brandcats = Brandcat::whereStatus(1)->get()->pluck('title', 'id');
        return view('admin/brandin/brandin_edit',compact('brandin','list_brandcats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminBrandinRequest $request, Brandin $brandin)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'brandin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        /*if ($request->hasFile('video')){
            $file=$request->file('video');
            $file->move('storages/brandin',$file->getClientOriginalName());
            $inputs['video'] = '/storages/brandin/'.$file->getClientOriginalName();
        }*/
        $brandin->update($inputs);
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/brandin/'.$brandin->id.'/edit?search_cate_id='.$brandin->cate_id.'&search_brandcat_id='.$brandin->brandcat_id.'&bid='.$brandin->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brandin $brandin)
    {
        if(file_exists($brandin->image))
            unlink($brandin->image);
        $brandin->delete();
        Session::flash('flash_message', '刪除成功!');
        return redirect('/admin/brandin?search_cate_id='.$brandin->cate_id.'&search_brandcat_id='.$brandin->brandcat_id);
    }

    public function del_img(Brandin $brandin)
    {
        if(file_exists($brandin->image))
            unlink($brandin->image);
        $brandin->image='';
        $brandin->update();
        Session::flash('flash_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/brandin/'.$brandin->id.'/edit');
    }

    public function batch_update(Request $request){
        $sorts=$request->sort;
        foreach($request->brandin_id as $index => $brandin_id){
            if($sorts[$index]!=''){
                Brandin::where('id',$brandin_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $brandin=Brandin::whereId($isdel)->first();
                if(file_exists($brandin->image))
                    unlink($brandin->image);
                $brandin->delete();
            }
        }

        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/brandin?search_brandcat_id='.$request->search_brandcat_id);
    }


    public function status($id, $status){
        Brandin::where('id',$id)->update(['status'=>$status]);
        $brandin=Brandin::where('id',$id)->first();
        Session::flash('flash_message', '狀態更新成功!');
        return redirect('/admin/brandin?search_brandcat_id='.$brandin->brandcat_id.'&bid='.$id);
    }

}
