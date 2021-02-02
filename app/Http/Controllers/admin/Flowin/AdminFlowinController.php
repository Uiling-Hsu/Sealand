<?php

namespace App\Http\Controllers\admin\Flowin;

use App\Model\Flowcat;
use App\Model\Flowin;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Flowin\AdminFlowinRequest;
use App\Http\Controllers\Controller;

class AdminFlowinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_flowcat_id=Request('search_flowcat_id');
        $list_flowcats = Flowcat::whereStatus(1)->orderBy('sort')->get()->pluck('title', 'id');
        $first_flowcat = Flowcat::whereStatus(1)->orderBy('sort')->first();
        $flowins=Flowin::where('flowcat_id',$search_flowcat_id?$search_flowcat_id:$first_flowcat->id)->orderBy('sort')->get();

        return view('admin/flowin/flowin',compact('flowins','list_flowcats', 'search_flowcat_id'));
    }

    public function show_list($id)
    {
        $flowins=orderBy('title','DESC')->paginate(10);
        return view('admin/flowin/flowin',compact('flowins'));
    }

    public function create($id){
        $list_flowcats = Flowcat::whereStatus(1)->get()->pluck('title', 'id');
        return view('admin/flowin/flowin_create',compact('list_flowcats','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminFlowinRequest $request)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'flowin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        if ($request->hasFile('video')){
            $file=$request->file('video');
            $file->move('storages/flowin',$file->getClientOriginalName());
            $inputs['video'] = '/storages/flowin/'.$file->getClientOriginalName();
        }
        $flowin=Flowin::create($inputs);
        Session::flash('flash_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/flowin?search_flowcat_id='.$request->flowcat_id.'&bid='.$flowin->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Flowin $flowin)
    {
        $list_flowcats = Flowcat::whereStatus(1)->get()->pluck('title', 'id');
        return view('admin/flowin/flowin_edit',compact('flowin','list_flowcats'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminFlowinRequest $request, Flowin $flowin)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'flowin', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        if ($request->hasFile('video')){
            $file=$request->file('video');
            $file->move('storages/flowin',$file->getClientOriginalName());
            $inputs['video'] = '/storages/flowin/'.$file->getClientOriginalName();
        }
        $flowin->update($inputs);
        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/flowin/'.$flowin->id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Flowin $flowin)
    {
        if(file_exists($flowin->image))
            unlink($flowin->image);
        $flowin->delete();
        Session::flash('flash_message', '刪除成功!');
        return redirect('/admin/flowin?search_flowcat_id='.$flowin->flowcat_id);
    }

    public function del_img(Flowin $flowin)
    {
        if(file_exists($flowin->image))
            unlink($flowin->image);
        $flowin->image='';
        $flowin->update();
        Session::flash('flash_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/flowin/'.$flowin->id.'/edit');
    }

    public function batch_update(Request $request){
        $sorts=$request->sort;
        foreach($request->flowin_id as $index => $flowin_id){
            if($sorts[$index]!=''){
                Flowin::where('id',$flowin_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        $ids=$request->id;
        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $flowin=Flowin::whereId($isdel)->first();
                if(file_exists($flowin->image))
                    unlink($flowin->image);
                $flowin->delete();
            }
        }

        Session::flash('flash_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/flowin?search_flowcat_id='.$request->search_flowcat_id);
    }


    public function status($id, $status){
        Flowin::where('id',$id)->update(['status'=>$status]);
        $flowin=Flowin::where('id',$id)->first();
        Session::flash('flash_message', '狀態更新成功!');
        return redirect('/admin/flowin?search_flowcat_id='.$flowin->flowcat_id.'&bid='.$id);
    }

}
