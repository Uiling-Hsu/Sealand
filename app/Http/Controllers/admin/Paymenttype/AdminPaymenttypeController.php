<?php

namespace App\Http\Controllers\admin\Paymenttype;

use App\Http\Requests;
use App\Model\Paymenttype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;

class AdminPaymenttypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymenttypes=Paymenttype::orderBy('sort')->paginate(10);
        return view('admin/paymenttype/paymenttype',compact('paymenttypes'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create(){
        return view('admin/paymenttype/paymenttype_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs=$request->all();
        //dd($inputs);
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'paymenttype', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
       $paymenttype=Paymenttype::create($inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/paymenttype?bid='.$paymenttype->id.'#list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Paymenttype $paymenttype)
    {
        return view('admin/paymenttype/paymenttype_edit',compact('paymenttype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paymenttype $paymenttype)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'paymenttype', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($paymenttype->image))
                unlink($paymenttype->image);
            $inputs['image'] = $upload_filename;
        }

        $paymenttype->update($inputs);
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/paymenttype?bid='.$paymenttype->id.'#list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paymenttype $paymenttype)
    {
        if(file_exists($paymenttype->image))
            unlink($paymenttype->image);
        $paymenttype->delete();
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/paymenttype');
    }

    public function del_img(Paymenttype $paymenttype, $image)
    {
        if(file_exists($paymenttype->image))
            unlink($paymenttype->image);
        $paymenttype->update([$image=>'','position'=>'0']);
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/paymenttype/'.$paymenttype->id.'/edit#list');
    }

    public function sort(Request $request){
        $sorts=$request->sort;
        foreach($request->paymenttype_id as $index => $paymenttype_id){
            if($sorts[$index]!=''){
                Paymenttype::where('id',$paymenttype_id)->update(['sort'=>$sorts[$index]]);
            }
        }
        Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/paymenttype');
    }

    public function status($id, $status){
        Paymenttype::where('id',$id)->update(['status'=>$status]);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/paymenttype');
    }

}
