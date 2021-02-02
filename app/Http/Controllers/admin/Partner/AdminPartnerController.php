<?php

    namespace App\Http\Controllers\admin\Partner;

    use App\Model\Dealer;
    use App\Model\Partner;
    use App\Http\Requests;
    use App\Model\Partneremail;
    use App\Model\Proarea;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Partner\AdminPartnerRequest;
    use Intervention\Image\Facades\Image;

    class AdminPartnerController extends Controller
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

            $partners=Partner::orderBy('sort')->get();

            return view('admin.partner.partner',compact('partners'));
        }

        public function create(){
            $list_dealers=Dealer::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
            $list_proareas=Proarea::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
            return view('admin/partner/partner_create',compact('list_dealers','list_proareas'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(AdminPartnerRequest $request)
        {
            $inputs=$request->all();
            $image_width=720;
            $image_height=null;
            if ($request->hasFile('imgFile')){
                $upload_filename = upload_file($request->file('imgFile'), 'partner', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg  或 *.png 格式');
                    return redirect()->back();
                }
                $inputs['image'] = $upload_filename;
            }
            $partner=Partner::create($inputs);
            writeLog('新增 經銷商',$inputs);
            Session::flash('success_message', '新增成功!');
            // flash()->overlay('新增成功!','系統訊息:');
            return redirect('/admin/partner?bid='.$partner->id);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit(Partner $partner)
        {
            $list_dealers=Dealer::where('status','1')->orderBy('sort')->pluck('title','id');
            $list_proareas=Proarea::where('status','1')->orderBy('sort')->pluck('title','id');
            return view('admin/partner/partner_edit',compact('partner','list_dealers','list_proareas'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(AdminPartnerRequest $request, Partner $partner)
        {
            $inputs=$request->all();
            $image_width=720;
            $image_height=null;
            if ($request->hasFile('imgFile')){
                $upload_filename = upload_file($request->file('imgFile'), 'partner', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg  或 *.png 格式');
                    return redirect()->back();
                }
                if($partner->image && file_exists( public_path() .$partner->image))
                    unlink( public_path() . $partner->image);
                $inputs['image'] = $upload_filename;
            }

            $newEmails=$request->newEmail;
            if($newEmails) {
                foreach($newEmails as $key => $newEmail) {
                    $chk_email_count=Partneremail::where('email',$newEmail)->count();
                    //if($chk_email_count==0 && $newEmail) {
                        $append_partneremail = new Partneremail();
                        $append_partneremail->partner_id = $partner->id;
                        $append_partneremail->email = $newEmail;
                        $append_partneremail->save();
                    //}
                }
            }
            $partner->update($inputs);
            writeLog('更新 經銷商',$inputs);
            Session::flash('success_message', '更新成功!');
            //flash()->overlay('更新成功!','系統訊息:');
            return redirect('/admin/partner/'.$partner->id.'/edit');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Partner $partner)
        {
            if($partner->image && file_exists( public_path() .$partner->image))
                unlink( public_path() . $partner->image);
            $partner->delete();
            writeLog('刪除 經銷商',$partner->toArray());
            Session::flash('success_message', '刪除成功!');
            // flash()->overlay('刪除成功!','系統訊息:');
            return redirect('/admin/partner');
        }

        public function batch_update(Request $request){
            $sorts=$request->sort;
            foreach($request->partner_id as $index => $partner_id){
                if($sorts[$index]!=''){
                    Partner::where('id',$partner_id)->update(['sort'=>$sorts[$index]]);
                }
            }
            $ids=$request->id;
            $isdels=$request->isdel;
            if($isdels){
                foreach ($isdels as $isdel) {
                    $partner=Partner::whereId($isdel)->first();
                    if($partner->image && file_exists( public_path() .$partner->image))
                        unlink( public_path() . $partner->image);
                    $partner->delete();
                }
            }

            Session::flash('flash_message', '批次刪除及更新排序!');
            // flash()->overlay('更新成功!','系統訊息:');
            return redirect('/admin/partner');
        }

    }
