<?php

namespace App\Http\Controllers\admin\Contact;

use App\Mail\ContactReplyPlaced;
use App\Model\Contact;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Contact\AdminContactRequest;
use App\Http\Controllers\Controller;

class AdminContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search_keyword=Request('search_keyword');
        $contacts=Contact::where('id','>',0);
        if($search_keyword!='') {
            $contacts = $contacts->where('name', 'like', '%'.$search_keyword.'%')
                ->orWhere('email', 'like', '%'.$search_keyword.'%')
                ->orWhere('phone', 'like', '%'.$search_keyword.'%')
                ->orWhere('telephone', 'like', '%'.$search_keyword.'%');
        }
        $contacts=$contacts->orderBy('created_at','DESC')->paginate(20);
        return view('admin/contact/contact',compact('contacts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function create(){
        return view('admin/contact/contact_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminContactRequest $request)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'contact', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            $inputs['image'] = $upload_filename;
        }
        $contact=Contact::create($inputs);
        Session::flash('success_message', '新增成功!');
        // flash()->overlay('新增成功!','系統訊息:');
        return redirect('/admin/contact?bid='.$contact->id.'#list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        $contact->isread=1;
        $contact->update();
        return view('admin/contact/contact_edit',compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminContactRequest $request, Contact $contact)
    {
        $inputs=$request->all();
        $image_width=800;
        $image_height=null;
        if ($request->hasFile('imgFile')){
            $upload_filename = upload_file($request->file('imgFile'), 'contact', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                return redirect()->back();
            }
            if(file_exists($contact->image))
                unlink($contact->image);
            $inputs['image'] = $upload_filename;
        }

        $contact->update($inputs);
        if($request->flag==1) {
            Mail::send(new ContactReplyPlaced($contact));
            $contact->isreply=1;
            $contact->update();
            Session::flash('success_message', '回覆訊息已成功寄出!');
        }
        else
            Session::flash('success_message', '更新成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/contact?bid='.$contact->id.'#list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        if(file_exists($contact->image))
            unlink($contact->image);
        $contact->delete();
        Session::flash('success_message', '刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/contact');
    }

    public function del_img(Contact $contact, $image)
    {
        if(file_exists($contact->image))
            unlink($contact->image);
        $contact->update([$image=>'','position'=>'0']);
        Session::flash('success_message', '圖檔刪除成功!');
        // flash()->overlay('刪除成功!','系統訊息:');
        return redirect('/admin/contact/'.$contact->id.'/edit#list');
    }

    public function batch_update(Request $request){
        //$sorts=$request->sort;
        //foreach($request->contact_id as $index => $contact_id){
        //    if($sorts[$index]!=''){
        //        Contact::where('id',$contact_id)->update(['sort'=>$sorts[$index]]);
        //    }
        //}
        //$ids=$request->id;

        $isdels=$request->isdel;
        if($isdels){
            foreach ($isdels as $isdel) {
                $contact=Contact::whereId($isdel)->first();
                if(file_exists($contact->image))
                    unlink($contact->image);
                $contact->delete();
            }
        }

        Session::flash('success_message', '批次刪除成功!');
        // flash()->overlay('更新成功!','系統訊息:');
        return redirect('/admin/contact');
    }

    public function status($id, $status){
        Contact::where('id',$id)->update(['status'=>$status]);
        Session::flash('success_message', '狀態更新成功!');
        return redirect('/admin/contact');
    }

}
