<?php

    namespace App\Http\Controllers\admin\Cate;

    use App\Model\Cate;
    use App\Http\Requests;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Cate\AdminCateRequest;
    use Intervention\Image\Facades\Image;

    class AdminCateController extends Controller
    {
        public function __construct(){
            $this->middleware(function ($request, $next) {
                if(!has_permission('cate'))
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

            $cates=Cate::orderBy('sort')->get();

            return view('admin.cate.cate',compact('cates'));
        }

        public function create(){
            return view('admin/cate/cate_create');
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function store(AdminCateRequest $request)
        {
            $inputs=$request->all();
            $image_width=720;
            $image_height=null;
            if ($request->hasFile('imgFile')){
                $upload_filename = upload_file($request->file('imgFile'), 'cate', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg  或 *.png 格式');
                    return redirect()->back();
                }
                $inputs['image'] = $upload_filename;
            }
            $image_width=600;
            $image_height=null;
            if ($request->hasFile('imgFile_xs')){
                $upload_filename = upload_file($request->file('imgFile_xs'), 'cate', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg  或 *.png 格式');
                    return redirect()->back();
                }
                $inputs['image_xs'] = $upload_filename;
            }
            $image_width=720;
            $image_height=null;
            if ($request->hasFile('imgFile_temp')){
                $upload_filename = upload_file($request->file('imgFile_temp'), 'cate', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg  或 *.png 格式');
                    return redirect()->back();
                }
                $inputs['image_temp'] = $upload_filename;
            }
            $cate=Cate::create($inputs);
            writeLog('新增 方案',$inputs,1);
            Session::flash('success_message', '新增成功!');
            // flash()->overlay('新增成功!','系統訊息:');
            return redirect('/admin/cate?bid='.$cate->id);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit(Cate $cate)
        {
            return view('admin/cate/cate_edit',compact('cate'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(AdminCateRequest $request, Cate $cate)
        {
            $inputs=$request->all();
            $image_width=720;
            $image_height=null;
            if ($request->hasFile('imgFile')){
                $upload_filename = upload_file($request->file('imgFile'), 'cate', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg  或 *.png 格式');
                    return redirect()->back();
                }
                if($cate->image && file_exists( public_path() .$cate->image))
                    unlink( public_path() . $cate->image);
                $inputs['image'] = $upload_filename;
            }
            $image_width=600;
            $image_height=null;
            if ($request->hasFile('imgFile_xs')){
                $upload_filename = upload_file($request->file('imgFile_xs'), 'cate', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg  或 *.png 格式');
                    return redirect()->back();
                }
                if($cate->image_xs && file_exists( public_path() .$cate->image_xs))
                    unlink( public_path() . $cate->image_xs);
                $inputs['image_xs'] = $upload_filename;
            }
            $image_width=720;
            $image_height=null;
            if ($request->hasFile('imgFile_temp')){
                $upload_filename = upload_file($request->file('imgFile_temp'), 'cate', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg  或 *.png 格式');
                    return redirect()->back();
                }
                $inputs['image_temp'] = $upload_filename;
            }
            $cate->update($inputs);
            writeLog('更新 方案',$inputs,1);
            Session::flash('success_message', '更新成功!');
            //flash()->overlay('更新成功!','系統訊息:');
            return redirect('/admin/cate?bid='.$cate->id);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Cate $cate)
        {
            if($cate->image && file_exists( public_path() .$cate->image))
                unlink( public_path() . $cate->image);
            $cate->delete();
            writeLog('刪除 方案',$cate->toArray(),1);
            Session::flash('success_message', '刪除成功!');
            // flash()->overlay('刪除成功!','系統訊息:');
            return redirect('/admin/cate');
        }

        public function batch_update(Request $request){
            $sorts=$request->sort;
            foreach($request->cate_id as $index => $cate_id){
                if($sorts[$index]!=''){
                    Cate::where('id',$cate_id)->update(['sort'=>$sorts[$index]]);
                }
            }
            $ids=$request->id;
            $isdels=$request->isdel;
            if($isdels){
                foreach ($isdels as $isdel) {
                    $cate=Cate::whereId($isdel)->first();
                    if($cate->image && file_exists( public_path() .$cate->image))
                        unlink( public_path() . $cate->image);
                    $cate->delete();
                }
            }

            Session::flash('flash_message', '批次刪除及更新排序!');
            // flash()->overlay('更新成功!','系統訊息:');
            return redirect('/admin/cate');
        }

    }
