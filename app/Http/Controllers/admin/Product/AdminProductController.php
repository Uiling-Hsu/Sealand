<?php

    namespace App\Http\Controllers\admin\Product;

    use App\Exports\ProductExport;
    use App\Imports\ProductImport;
    use App\Model\Addition;
    use App\Model\Brandcat;
    use App\Model\Brandin;
    use App\Model\Cate;
    use App\Model\Category;
    use App\Model\CategoryProduct;
    use App\Model\Dealer;
    use App\Model\Department;
    use App\Model\Ord;
    use App\Model\Partner;
    use App\Model\Proarea;
    use App\Model\Procolor;
    use App\Model\Prodaddition;
    use App\Model\Product;
    use App\Http\Requests;
    use App\Model\Productimage;
    use App\Model\Profuel;
    use App\Model\Progeartype;
    use App\Model\Ptate;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Product\AdminProductRequest;
    use Intervention\Image\Facades\Image;
    use Maatwebsite\Excel\Facades\Excel;

    class AdminProductController extends Controller
    {

        public function __construct(){
            $this->middleware(function ($request, $next) {
                if(!has_permission('product'))
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

            $admin=getAdminUser();

            $list_dealers=Dealer::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('全部','');
            $list_partners=Partner::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('全部','');
            $list_proareas=Proarea::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('全部','');
            $list_cates=Cate::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('全部','');
            if(role('admin') || role('babysitter'))
                $list_ptates=Ptate::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('全部','');
            else
                $list_ptates=Ptate::whereStatus(1)->where('id','<',7)->orderBy('sort')->pluck('title','id')->prepend('全部','');
            $list_ptate_ids=Ptate::whereStatus(1)->where('id','>=',3)->where('id','<',7)->orderBy('sort')->pluck('title','id');
            //$list_brandcats=Brandcat::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('全部','all');
            $list_brandcats=[];
            $list_brandins=[];

            $search_ptate_id=Request('search_ptate_id');
            if($search_ptate_id)
                $products = new Product;
            else
                $products = Product::where('ptate_id','<',7);
            if($admin->hasRole('partner')){
                $products = $products->where('partner_id', $admin->partner_id);
            }
            elseif($admin->hasRole('carplus_company')){
                $list_partners=Partner::whereStatus(1)->where('title','like','%格上%')->pluck('title','id')->prepend('','');
                $products = $products->where('dealer_id', 1);
            }
            elseif(!$admin->hasRole('admin|babysitter')){
                $products = $products->where('partner_id', $admin->partner_id);
            }

            $search_start_date=Request('search_start_date');
            $search_end_date=Request('search_end_date');

            if($search_ptate_id!='') {
                $products = $products->where('ptate_id', $search_ptate_id);
                if($search_start_date && $search_end_date){
                    if($search_ptate_id==1){
                        $products=$products->whereHas('ord', function($q) use($search_start_date, $search_end_date) {
                            $q->where('paid_date','>=',$search_start_date)
                                ->where('paid_date','<=',$search_end_date);
                        });
                    }
                    elseif($search_ptate_id==2){
                        $products=$products->whereHas('ord', function($q) use($search_start_date, $search_end_date) {
                            $q->where('paid2_date','>=',$search_start_date)
                                ->where('paid2_date','<=',$search_end_date);
                        });
                    }
                    elseif($search_ptate_id==3){
                        $products = $products
                            ->where('online_date','>=',$search_start_date)
                            ->where('online_date','<=',$search_end_date);
                    }
                }
            }
            else{
                $products = $products->where('ptate_id','<',7);
            }

            $search_start_updated_date=Request('search_start_updated_date');
            if($search_start_updated_date!='')
                $products=$products->where('updated_at','>=',$search_start_updated_date.' 00:00:01');

            $search_end_updated_date=Request('search_end_updated_date');
            if($search_end_updated_date!='')
                $products=$products->where('updated_at','<=',$search_end_updated_date.' 23:59:59');

            $search_dealer_id=Request('search_dealer_id');
            if($search_dealer_id!='') {
                $products = $products->where('dealer_id', $search_dealer_id);
            }

            $search_cate_id_arr=Request('search_cate_id_arr');
            //dd($search_cate_id_arr);
            if(count($search_cate_id_arr)>0 && $search_cate_id_arr[0]!='') {
                $products = $products->whereIn('cate_id', $search_cate_id_arr);
            }

            $search_cate_id=Request('search_cate_id');
            if($search_cate_id!='') {
	            $products = $products->where('cate_id', $search_cate_id);
                $list_brandcats=Brandcat::whereStatus(1)->where('cate_id',$search_cate_id)->orderBy('sort')->pluck('title','id')->prepend('全部','');
                $list_brandins = [];
            }

            $search_proarea_id=Request('search_proarea_id');
            if($search_proarea_id!='') {
	            $products = $products->where(function($q) use ($search_proarea_id) {
                    $q->where('proarea_id', $search_proarea_id)
                        ->orWhere('proarea2_id', $search_proarea_id);
                });
            }

            $search_brandcat_id=Request('search_brandcat_id');
            if($search_brandcat_id!='') {
	            $products = $products->where('brandcat_id', $search_brandcat_id);
	            $list_brandins = Brandin::whereStatus(1)->where('brandcat_id',$search_brandcat_id)->pluck('title','id')->prepend('全部','');
            }
            $search_id=Request('search_id');
            if($search_id!='')
                $products=$products->whereId($search_id);

            $search_brandin_id=Request('search_brandin_id');
            if($search_brandin_id!='')
                $products=$products->where('brandin_id',$search_brandin_id);

            $search_model=Request('search_model');
            if($search_model!='')
                $products=$products->where('model','like','%'.$search_model.'%');

            $search_plate_no=Request('search_plate_no');
            if($search_plate_no!='')
                $products=$products->where('plate_no','like','%'.$search_plate_no.'%');
            $search_show_hide=Request('search_show_hide');

            $products=$products->orderBy('sort');
            if($products->count()>0 && Request('download')==1) {
                $products=$products->get();
                $product_file_name = 'Car_export_'.date('Y_m_d_H_i_s').'.xlsx';
                return Excel::download(new ProductExport($products), $product_file_name);
            }
            else {
                $products = $products->paginate(50);
                return view('admin.product.product',
                    compact('admin',
                        'products',
                        'list_dealers',
                        'list_partners',
                        'list_proareas',
                        'list_cates',
                        'list_brandcats',
                        'list_brandins',
                        'list_ptates',
                        'list_ptate_ids',
                        'search_id',
                        'search_dealer_id',
                        'search_cate_id_arr',
                        'search_cate_id',
                        'search_proarea_id',
                        'search_brandcat_id',
                        'search_brandin_id',
                        'search_status',
                        'search_model',
                        'search_plate_no'
                    ));
            }
        }

        public function create(){
            $admin=getAdminUser();

            $list_dealers=Dealer::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
            if(!$admin->hasRole('admin|babysitter'))
                $list_partners=Partner::whereStatus(1)->whereId($admin->partner_id)->orderBy('sort')->pluck('title',
                    'id');
            else
                $list_partners=Partner::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');

            $list_cates=Cate::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
	        //$list_brandcats=Brandcat::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
	        $list_brandcats=[''=>'請選擇'];
	        $list_brandins=[''=>'請選擇'];
	        $list_progeartypes=Progeartype::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
	        $list_profuels=Profuel::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
	        $list_procolors=Procolor::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
	        $list_proareas=Proarea::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
            return view('admin/product/product_create',compact('list_dealers','list_partners','list_cates','list_brandcats','list_brandins','list_progeartypes','list_profuels','list_procolors','list_proareas'));
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
            $plate_no=$request->plate_no;
            $chk_product_count=Product::where('plate_no',$plate_no)->count();
            if($chk_product_count)
                return redirect()->back()->with('failure_message','已有此車號的車輛存在，不可重複輸入車號。')->withInput();
            $image_width=1500;
            $image_height=900;
            if ($request->hasFile('imgFile')){
                $upload_filename = upload_file($request->file('imgFile'), 'product', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                    return redirect()->back();
                }
                $inputs['image'] = $upload_filename;
            }
            $partner=Partner::whereId($inputs['partner_id'])->first();
            $inputs['is_carplus']=0;
            if($partner && mb_substr( $partner->title,0,2,"utf-8")=='格上')
                $inputs['is_carplus']=1;

            $product=Product::create($inputs);
            writeLog('新增 車輛',$inputs,1);
            Session::flash('success_message', '新增成功!');
            // flash()->overlay('新增成功!','系統訊息:');
            return redirect('/admin/product?bid='.$product->id.'&page='.Request('page'));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit(Product $product)
        {
        	if(!$product)
        		abort(404);

            $admin=getAdminUser();
            /*if(!$admin->hasRole('admin|babysitter'))
                $list_partners = Partner::whereStatus(1)->whereId($admin->partner_id)->orderBy('sort')->pluck('title', 'id');
            else*/
            $list_dealers=Dealer::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('全部','');
            $list_partners=Partner::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
            $list_ptates=Ptate::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');

            $list_cates=Cate::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
	        $list_brandcats=Brandcat::where('status','1')->where('cate_id',$product->cate_id)->orderBy('sort')->pluck('title','id');

	        $list_brandins=Brandin::where('status','1')->where('brandcat_id',$product->brandcat_id)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');

	        $list_progeartypes=Progeartype::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
	        $list_profuels=Profuel::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
	        $list_procolors=Procolor::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
	        $list_proareas=Proarea::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
            $productimages=Productimage::where('product_id',$product->id)->get();
            return view('admin/product/product_edit',compact('product', 'list_cates', 'list_partners', 'list_ptates', 'list_dealers','list_brandcats','list_brandins','list_progeartypes','list_profuels','list_procolors','list_proareas', 'productimages'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(AdminProductRequest $request, Product $product)
        {
            //dd($request->all());
            $inputs=$request->all();

            $plate_no=$request->plate_no;
            $chk_product_count=Product::where('id','!=',$product->id)->where('plate_no',$plate_no)->count();
            if($chk_product_count>0)
                return redirect()->back()->with('failure_message','已有此車號的車輛存在，不可重複輸入車號。')->withInput();

            $image_width=1500;
            $image_height=900;
            if ($request->hasFile('imgFile')){
                $upload_filename = upload_file($request->file('imgFile'), 'product', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                    return redirect()->back();
                }
                if(file_exists($product->image))
                    unlink($product->image);
                $inputs['image'] = $upload_filename;
            }

            //other images
            //dd($request->file());
            if($request->uploadNewFile) {
                foreach($request->uploadNewFile as $key=>$imgFileOther) {
                    $upload_filename = upload_file($imgFileOther, 'product', $image_width, $image_height);
                    if($upload_filename == -1) {
                        Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg、*.png 或 *.gif 格式');
                        return redirect()->back();
                    }
                    $productimage=new Productimage();
                    $productimage->product_id=$product->id;
                    $productimage->image=$upload_filename;
                    $productimage->save();
                }
            }

            //更新 Category_Product
            //if ($request->category_id) {
            //    $department_id=$request->department_id;
            //    CategoryProduct::where('product_id', $product->id)->delete();
            //    foreach ($request->category_id as $key=>$category_id) {
            //        $category=Category::whereId($category_id)->first();
            //        CategoryProduct::create([
            //            'product_id' => $product->id,
            //            'category_id' => $category_id,
            //            'department_id' => $category->department_id,
            //        ]);
            //    }
            //}
            if($product->partner_id != $request->partner_id)
                $inputs['partner2_id']=$product->partner_id;

            if($product->ptate_id != $request->ptate_id) {
                $chk_product_count=Ord::where('product_id',$product->id)->where('is_cancel',0)->where('state_id','<',11)->count();
                if($chk_product_count>0)
                    return redirect()->back()->with('failure_message','此車輛已在訂閱中無法更改狀態。')->withInput();
            }
            writeLog('更新訂單資料:前',$product->toArray(),1);
            $log=get_diff_field_content($product->toArray(), $inputs);
            if($log)
                writeLog('更新車輛資料：','車輛ID：'.$product->id.'，變更欄位：'.$log,1);
            //writeLog('更新訂單資料:後',$inputs,1);
            $product->update($inputs);
            Session::flash('success_message', '更新成功!');
            //flash()->overlay('更新成功!','系統訊息:');
            return redirect('/admin/product/'.$product->id.'/edit?page='.Request('page').'&search_brandcat_id='.Request('search_brandcat_id').'&search_brandin_id='.Request('search_brandin_id'));
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Product $product)
        {
            //if(file_exists($product->image))
            //    unlink($product->image);
            $product->ptate_id=7;
            $product->update();
            writeLog('軟刪除 車輛',$product->toArray(),1);
            Session::flash('success_message', '軟刪除成功!');
            // flash()->overlay('刪除成功!','系統訊息:');
            return redirect('/admin/product?restore=1&page='.Request('page'));
        }

        public function batch_update(Request $request){
            //dd($request->all());
            $sorts=$request->sort;
            //$images=$request->image;
            foreach($request->product_id as $index => $product_id){
                if($sorts[$index]!=''){
                    Product::where('id',$product_id)->update(['sort'=>$sorts[$index]]);
                    //Product::where('id',$product_id)->update(['image'=>$sorts[$index].'_'.$images[$index]]);
                }
            }

            $isdels=$request->isdel;
            if($isdels){
                foreach ($isdels as $isdel) {
                    $product=Product::whereId($isdel)->first();
                    if(file_exists($product->image))
                        unlink($product->image);
                    $product->delete();
                }
            }

            Session::flash('flash_message', '批次刪除及更新排序!');
            // flash()->overlay('更新成功!','系統訊息:');
            return redirect('/admin/product?restore=1&page='.Request('page'));
        }

        public function status($id, $status){
            Product::where('id',$id)->update(['status'=>$status]);
            //writeLog('status Product','id:'.$id.'=>status:'.$status);
            Session::flash('success_message', '狀態更新成功!');
            return redirect('/admin/product?restore=1&bid='.$id.'&page='.Request('page').'#list'.(Request('key')-1));
        }

        public function del_img(Product $product)
        {
            $product_id=$productimage->product_id;
            if(file_exists($product->image))
                unlink($product->image);
            $product->image='';
            $product->update();
            Session::flash('success_message', '圖檔刪除成功!');
            // flash()->overlay('圖檔刪除成功!','系統訊息:');
            return redirect('/admin/product/'.$product_id.'/edit');
        }

        function productimage_del_img(Productimage $productimage) {
            $product_id=$productimage->product_id;
            if(file_exists($productimage->image))
                unlink($productimage->image);
            $productimage->delete();
            Session::flash('success_message', '其它圖檔刪除成功!');
            // flash()->overlay('圖檔刪除成功!','系統訊息:');
            return redirect('/admin/product/'.$product_id.'/edit');;
        }

        public function prodaddition(Product $product){
            $department=Department::whereId(3)->first();
            $all_prodaddition_prods=$department->products;
            $prodadditions=Prodaddition::where('product_id',$product->id)->orderBy('sort')->select('id','prodaddition_id')->get()->toArray();
            $addition_arr=array();
            $addition_id_arr=array();
            foreach($prodadditions as $prodaddition) {
                $addition_id_arr[] = $prodaddition['id'];
                $addition_arr[] = $prodaddition['prodaddition_id'];
            }
            return view('admin.prodaddition.prodaddition',compact('all_prodaddition_prods','addition_id_arr','addition_arr','product'));
        }

        public function prodaddition_update(Request $request) {
            /*dd($request->all());
            $sorts=$request->sort;
            $images=$request->image;
            $cnt=0;
            foreach($request->addition_prod as $addition_prod_id){
                if($sorts[$cnt]!=''){
                    //print_r($p);
                    //$p=Prodaddition::where('prodaddition_id',$addition_prod_id)
                    //    ->where('product_id',$request->product_id)->first();
                    //if($p) {
                    //    $p->sort = $sorts[ $cnt ];
                    //    $p->update();
                    //}
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                    echo '<br>';
                    //->where('product_id',$request->product_id)
                    //->update(['sort'=>$sorts[$index]]);
                    //Product::where('id',$product_id)->update(['image'=>$sorts[$index].'_'.$images[$index]]);
                }
                $cnt++;
            }*/

            $isAdds=$request->isAdd;
            if($isAdds){
                $prodadditions=Prodaddition::where('product_id',$request->product_id)->get();
                foreach($prodadditions as $prodaddition) {
                    $prodaddition->delete();
                }
                foreach ($isAdds as $isAdd) {
                    $prodaddition=new Prodaddition();
                    $prodaddition->product_id=$request->product_id;
                    $prodaddition->prodaddition_id=$isAdd;
                    $prodaddition->save();
                }
            }
            Session::flash('flash_message', '批次更新加購產品 成功!');
             //flash()->overlay('更新成功!','系統訊息:');
            return redirect('/admin/prodaddition/'.$request->product_id.'?page='.Request('page'));
        }

        public function product_import(Request $request)
        {
            //dd($request->all());
            $arrays=Excel::toCollection(new ProductImport(), $request->file('importFile'));
            $append_count=$update_count=0;
            $show_header_arr=['編號','方案ID','車輛等級','品牌','車型','排氣量','車色','排檔方式','座位數','燃料種類','年份','里程數','配備','交車區域','交車區域2','經銷商ID','經銷商','總經銷商','新車車價','中古車定價'];
            if(count($arrays)>0) {
                $show_row_arr=array();
                $msg='';
                $failure_msg='';
                $chk_ok=true;

                foreach($arrays[0] as $key=>$row){
                    $chk_row_ok=true;
                    $row_failure_msg='';
                    if(count($row)!=30){
                        Session::flash('failure_message', '匯入檔的格式錯誤，請確認匯入的欄位數是 30個 後再繼續。');
                        return redirect()->back();
                    }
                    if($key>0 && $row) {
                        //編號(唯一值)
                        $plate_no=$row[6];
                        //忽略出租中的車輛
                        if($plate_no!='') {
                            //方案
                            $cate_id = $row[ 1 ];
                            $cnt=7;
                            $brandcat_name = $row[ $cnt++ ];
                            $brandin_name = $row[ $cnt++ ];

                            $cate = Cate::whereId($cate_id)->whereStatus(1)->select('id')->first();
                            if(! $cate) {
                                $chk_row_ok = false;
                                $row_failure_msg .= '方案類別:'.$cate_id.' 錯誤，';
                            }
                            else {
                                //廠牌名稱
                                $brandcat = Brandcat::where('cate_id', $cate->id)->where('title', $brandcat_name)->select('id')->first();
                                if(! $brandcat) {
                                    $brandcat=new Brandcat;
                                    $brandcat->cate_id=$cate->id;
                                    $brandcat->title=$brandcat_name;
                                    $brandcat->save();
                                }
                                //車型名稱
                                $brandin = Brandin::where('cate_id', $cate->id)->where('brandcat_id', $brandcat->id)->where('title', $brandin_name)->select('id')->first();
                                if(! $brandin) {
                                    $brandin=new Brandin;
                                    $brandin->cate_id=$cate->id;
                                    $brandin->brandcat_id=$brandcat->id;
                                    $brandin->title=$brandin_name;
                                    $brandin->save();
                                }
                            }
                            //排氣量
                            $displacement = $row[ $cnt++ ];

                            //顏色
                            $procolor_name = $row[ $cnt++ ];
                            $procolor = Procolor::where('title', $procolor_name)->select('id')->first();
                            if(! $procolor) {
                                $procolor=new Procolor;
                                $procolor->title=$procolor_name;
                                $procolor->save();
                            }

                            //排檔方式
                            $progeartype_name = $row[ $cnt++ ];
                            $progeartype = Progeartype::where('title', $progeartype_name)->select('id')->first();
                            if(! $progeartype) {
                                $progeartype=new Progeartype;
                                $progeartype->title=$progeartype_name;
                                $progeartype->save();
                            }

                            //座位數
                            $seatnum = $row[ $cnt++ ];

                            //燃料種類
                            $profuel_name = $row[ $cnt++ ];
                            $profuel = Profuel::where('title', $profuel_name)->select('id')->first();
                            if(! $profuel) {
                                $profuel=new Profuel;
                                $profuel->title=$profuel_name;
                                $profuel->save();
                            }

                            //出廠年月
                            $year = $row[ $cnt++ ];

                            //入庫里程
                            $milage = $row[ $cnt++ ];

                            //配備
                            $equipment_name = $row[ $cnt++ ];

                            //交車區域
                            $proarea_name = $row[ $cnt++ ];
                            $proarea = Proarea::where('title', $proarea_name)->select('id')->first();
                            if(! $proarea) {
                                $chk_row_ok = false;
                                $row_failure_msg .= '交車區域:'.$proarea_name.' 錯誤，';
                            }

                            //交車區域2
                            $proarea2_name = $row[ $cnt++ ];
                            $proarea = Proarea::where('title', $proarea_name)->select('id')->first();
                            if(! $proarea) {
                                $chk_row_ok = false;
                                $row_failure_msg .= '交車區域2:'.$proarea_name.' 錯誤，';
                            }

                            //經銷商
                            $partner_id = $row[ $cnt++ ];
                            $partner = Partner::whereId($partner_id)->select('id')->first();
                            if(! $partner) {
                                $chk_row_ok = false;
                                $row_failure_msg .= '經銷商:'.$partner_id.' 錯誤，';
                            }

                            if(! $chk_row_ok) {
                                $chk_ok = $chk_row_ok;
                                $failure_msg .= '車牌號碼 '.$plate_no.'：'.$row_failure_msg.'<br>';
                            }
                        }
                    }
                }
                if(!$chk_ok){
                    Session::put('product_failure_message',$failure_msg);
                    return redirect('/admin/product')->with('failure_message', '匯入檢查發現錯誤，請修正Excel內容後再繼續。');
                }

                foreach($arrays[0] as $key => $row) {
                    $row_arr = array();
                    if($key > 0 && $row) {
                        //編號(唯一值)
                        $plate_no=$row[6];
                        if($plate_no != '') {

                            $product = Product::where('plate_no', $plate_no)->first();

                            $product_flag = null;
                            $ptate_id=null;
                            if($product) {
                                //更新
                                $ptate_id=$product->ptate_id;
                                $product->online_date=date('Y-m-d');
                                $product_flag = '更新';
                            } else {
                                //新增
                                $product = new Product();
                                $product->online_date=date('Y-m-d');
                                $product_flag = '新增';
                            }
                            //只匯入上架及
                            if($ptate_id==null || $ptate_id==3 || $ptate_id==4) {
                                $row_arr[] = $product_flag;

                                $row_arr[] = $plate_no;
                                $product->model = $row[5];
                                $product->plate_no = $plate_no;

                                //方案
                                $cate_id = $row[ 1 ];
                                $row_arr[] = $cate_id;
                                $cate = Cate::whereId($cate_id)->select('id','title')->first();
                                $row_arr[] = $cate->title;
                                $product->cate_id = $cate->id;

                                $cnt=7;

                                //廠牌名稱
                                $brandcat_name = $row[ $cnt++ ];
                                $row_arr[] = $brandcat_name;
                                $brandcat = Brandcat::where('cate_id', $cate->id)->where('title', $brandcat_name)->select('id')->first();
                                $product->brandcat_id = $brandcat->id;

                                //車型名稱
                                $brandin_name = $row[ $cnt++ ];
                                $row_arr[] = $brandin_name;
                                $brandin = Brandin::where('brandcat_id', $brandcat->id)->where('title', $brandin_name)->select('id')->first();
                                $product->brandin_id = $brandin->id;

                                //排氣量
                                $displacement = $row[ $cnt++ ];
                                $row_arr[] = $displacement;
                                $product->displacement = (int) $displacement;

                                //顏色
                                $procolor_name = $row[ $cnt++ ];
                                $row_arr[] = $procolor_name;
                                $procolor = Procolor::where('title', $procolor_name)->select('id')->first();
                                $product->procolor_id = $procolor->id;

                                //排檔方式
                                $progeartype_name = $row[ $cnt++ ];
                                $row_arr[] = $progeartype_name;
                                $progeartype = Progeartype::where('title', $progeartype_name)->select('id')->first();
                                $product->progeartype_id = $progeartype->id;

                                //座位數
                                $seatnum = $row[ $cnt++ ];
                                $row_arr[] = $seatnum;
                                $product->seatnum = (int) $seatnum;

                                //燃料種類
                                $profuel_name = $row[ $cnt++ ];
                                $row_arr[] = $seatnum;
                                $profuel = Profuel::where('title', $profuel_name)->select('id')->first();
                                $product->profuel_id = (int) $profuel->id;

                                //出廠年月
                                $year = $row[ $cnt++ ];
                                $row_arr[] = $year;
                                $product->year = $year;

                                //入庫里程
                                $milage = $row[ $cnt++ ];
                                $row_arr[] = $milage;
                                $product->milage = $milage;

                                //配備
                                $equipment = $row[ $cnt++ ];
                                $row_arr[] = $equipment;
                                $product->equipment = $equipment;

                                ///交車區域
                                $proarea_name = $row[ $cnt++ ];
                                $row_arr[] = $proarea_name;
                                $proarea = Proarea::where('title', $proarea_name)->select('id')->first();
                                $product->proarea_id = $proarea->id;

                                ///交車區域2
                                $proarea_name2 = $row[ $cnt++ ];
                                $row_arr[] = $proarea_name2;
                                $proarea2 = Proarea::where('title', $proarea_name2)->select('id')->first();
                                if($proarea2)
                                    $product->proarea_id = $proarea2->id;

                                //經銷商
                                $partner_id = $row[ $cnt++ ];
                                $row_arr[] = $partner_id;
                                $partner = Partner::whereId($partner_id)->select('id','title')->first();
                                $row_arr[] = $partner->title;
                                $product->partner_id = $partner->id;

                                $cnt++;
                                $cnt++;
                                //總經銷商
                                $dealer_id = $row[ $cnt++ ];
                                $row_arr[] = $dealer_id;
                                $product->dealer_id = $dealer_id;

                                $cnt++;
                                $cnt++;

                                //新車車價
                                $new_car_price = $row[ $cnt++ ];
                                $row_arr[] = $new_car_price;
                                $product->new_car_price = $new_car_price;

                                //中古車定價
                                $second_hand_price = $row[ $cnt++ ];
                                $row_arr[] = $second_hand_price;
                                $product->second_hand_price = $second_hand_price;

                                //dd($product);
                                if($product_flag == '更新') {
                                    $product->update();
                                    $update_count++;
                                } elseif($product_flag == '新增') {
                                    $product->save();
                                    $append_count++;
                                }

                                $show_row_arr[] = $row_arr;
                            }
                        }
                    }
                }
            }
            $msg='新增: '.$append_count.' 筆, 更新 '.$update_count.' 筆';
            Session::put('product_show_header_arr',$show_header_arr);
            Session::put('product_show_row_arr',$show_row_arr);
            return redirect('/admin/product')->with('success_message', $msg);
        }

        /*public function product_import(Request $request)
        {
            //dd($request->all());
            $arrays=Excel::toCollection(new ProductImport(), $request->file('importFile'));
            $append_count=$update_count=0;
            $show_header_arr=['編號','車輛等級','品牌','車型','排氣量','車色','排檔方式','座位數','燃料種類','年份','里程數','配備','交車區域','交車區域2','經銷商','總經銷商','新車車價','中古車定價'];
            if(count($arrays)>0) {
                $show_row_arr=array();
                $msg='';
                $failure_msg='';
                $chk_ok=true;

                foreach($arrays[0] as $key=>$row){
                    $chk_row_ok=true;
                    $row_failure_msg='';
                    if(count($row)!=28){
                        Session::flash('failure_message', '匯入檔的格式錯誤，請確認匯入的欄位數是 28個 後再繼續。');
                        return redirect()->back();
                    }
                    if($key>0 && $row) {
                        //編號(唯一值)
                        $plate_no=$row[5];
                        //忽略出租中的車輛
                        if($plate_no!='') {
                            //方案
                            $cate_name = $row[ 1 ];
                            $cnt=6;
                            $brandcat_name = $row[ $cnt++ ];
                            $brandin_name = $row[ $cnt++ ];

                            $cate = Cate::where('title', $cate_name)->select('id')->first();
                            if(! $cate) {
                                $chk_row_ok = false;
                                $row_failure_msg .= '方案類別:'.$cate_name.' 錯誤，';
                            }
                            else {
                                //廠牌名稱
                                $brandcat = Brandcat::where('cate_id', $cate->id)->where('title', $brandcat_name)->select('id')->first();
                                if(! $brandcat) {
                                    $chk_row_ok = false;
                                    $row_failure_msg .= '廠牌:'.$brandcat_name.' 錯誤，';
                                } else {
                                    //車型名稱
                                    $brandin = Brandin::where('brandcat_id', $brandcat->id)->where('title', $brandin_name)->select('id')->first();
                                    if(! $brandin) {
                                        $chk_row_ok = false;
                                        $row_failure_msg .= '車型:'.$brandin_name.' 錯誤，';
                                    }
                                }
                            }
                            //排氣量
                            $displacement = $row[ $cnt++ ];

                            //顏色
                            $procolor_name = $row[ $cnt++ ];
                            $procolor = Procolor::where('title', $procolor_name)->select('id')->first();
                            if(! $procolor) {
                                $chk_row_ok = false;
                                $row_failure_msg .= '顏色:'.$procolor_name.' 錯誤，';
                            }

                            //排檔方式
                            $progeartype_name = $row[ $cnt++ ];
                            $progeartype = Progeartype::where('title', $progeartype_name)->select('id')->first();
                            if(! $progeartype) {
                                $chk_row_ok = false;
                                $row_failure_msg .= '排檔方式:'.$progeartype_name.' 錯誤，';
                            }

                            //座位數
                            $seatnum = $row[ $cnt++ ];

                            //燃料種類
                            $profuel_name = $row[ $cnt++ ];
                            $profuel = Profuel::where('title', $profuel_name)->select('id')->first();
                            if(! $profuel) {
                                $chk_row_ok = false;
                                $row_failure_msg .= '燃料種類:'.$profuel_name.' 錯誤，';
                            }

                            //出廠年月
                            $year = $row[ $cnt++ ];

                            //入庫里程
                            $milage = $row[ $cnt++ ];

                            //配備
                            $equipment_name = $row[ $cnt++ ];

                            //交車區域
                            $proarea_name = $row[ $cnt++ ];
                            $proarea = Proarea::where('title', $proarea_name)->select('id')->first();
                            if(! $proarea) {
                                $chk_row_ok = false;
                                $row_failure_msg .= '交車區域:'.$proarea_name.' 錯誤，';
                            }

                            //交車區域2
                            $proarea2_name = $row[ $cnt++ ];
                            $proarea = Proarea::where('title', $proarea_name)->select('id')->first();
                            if(! $proarea) {
                                $chk_row_ok = false;
                                $row_failure_msg .= '交車區域2:'.$proarea_name.' 錯誤，';
                            }

                            //經銷商
                            $partner_name = $row[ $cnt++ ];
                            $partner = Partner::where('title', $partner_name)->select('id')->first();
                            if(! $partner) {
                                $chk_row_ok = false;
                                $row_failure_msg .= '經銷商:'.$partner_name.' 錯誤，';
                            }

                            if(! $chk_row_ok) {
                                $chk_ok = $chk_row_ok;
                                $failure_msg .= '車牌號碼 '.$plate_no.'：'.$row_failure_msg.'<br>';
                            }
                        }
                    }
                }
                if(!$chk_ok){
                    Session::put('product_failure_message',$failure_msg);
                    return redirect('/admin/product')->with('failure_message', '匯入檢查發現錯誤，請修正Excel內容後再繼續。');
                }

                foreach($arrays[0] as $key => $row) {
                    $row_arr = array();
                    if($key > 0 && $row) {
                        //編號(唯一值)
                        $plate_no = $row[5];
                        if($plate_no != '') {

                            $product = Product::where('plate_no', $plate_no)->first();

                            $product_flag = null;
                            $ptate_id=null;
                            if($product) {
                                //更新
                                $ptate_id=$product->ptate_id;
                                $product->online_date=date('Y-m-d');
                                $product_flag = '更新';
                            } else {
                                //新增
                                $product = new Product();
                                $product->online_date=date('Y-m-d');
                                $product_flag = '新增';
                            }
                            //只匯入上架及
                            if($ptate_id==null || $ptate_id==3 || $ptate_id==4) {
                                $row_arr[] = $product_flag;

                                $row_arr[] = $plate_no;
                                $product->model = $row[4];
                                $product->plate_no = $plate_no;

                                //方案
                                $cate_name = $row[ 1 ];
                                $row_arr[] = $cate_name;
                                $cate = Cate::where('title', $cate_name)->select('id')->first();
                                $product->cate_id = $cate->id;

                                $cnt=6;

                                //廠牌名稱
                                $brandcat_name = $row[ $cnt++ ];
                                $row_arr[] = $brandcat_name;
                                $brandcat = Brandcat::where('cate_id', $cate->id)->where('title', $brandcat_name)->select('id')->first();
                                $product->brandcat_id = $brandcat->id;

                                //車型名稱
                                $brandin_name = $row[ $cnt++ ];
                                $row_arr[] = $brandin_name;
                                $brandin = Brandin::where('brandcat_id', $brandcat->id)->where('title', $brandin_name)->select('id')->first();
                                $product->brandin_id = $brandin->id;

                                //排氣量
                                $displacement = $row[ $cnt++ ];
                                $row_arr[] = $displacement;
                                $product->displacement = (int) $displacement;

                                //顏色
                                $procolor_name = $row[ $cnt++ ];
                                $row_arr[] = $procolor_name;
                                $procolor = Procolor::where('title', $procolor_name)->select('id')->first();
                                $product->procolor_id = $procolor->id;

                                //排檔方式
                                $progeartype_name = $row[ $cnt++ ];
                                $row_arr[] = $progeartype_name;
                                $progeartype = Progeartype::where('title', $progeartype_name)->select('id')->first();
                                $product->progeartype_id = $progeartype->id;

                                //座位數
                                $seatnum = $row[ $cnt++ ];
                                $row_arr[] = $seatnum;
                                $product->seatnum = (int) $seatnum;

                                //燃料種類
                                $profuel_name = $row[ $cnt++ ];
                                $row_arr[] = $seatnum;
                                $profuel = Profuel::where('title', $profuel_name)->select('id')->first();
                                $product->profuel_id = (int) $profuel->id;

                                //出廠年月
                                $year = $row[ $cnt++ ];
                                $row_arr[] = $year;
                                $product->year = $year;

                                //入庫里程
                                $milage = $row[ $cnt++ ];
                                $row_arr[] = $milage;
                                $product->milage = $milage;

                                //配備
                                $equipment = $row[ $cnt++ ];
                                $row_arr[] = $equipment;
                                $product->equipment = $equipment;

                                ///交車區域
                                $proarea_name = $row[ $cnt++ ];
                                $row_arr[] = $proarea_name;
                                $proarea = Proarea::where('title', $proarea_name)->select('id')->first();
                                $product->proarea_id = $proarea->id;

                                ///交車區域2
                                $proarea_name2 = $row[ $cnt++ ];
                                $row_arr[] = $proarea_name2;
                                $proarea2 = Proarea::where('title', $proarea_name2)->select('id')->first();
                                if($proarea2)
                                    $product->proarea_id = $proarea2->id;

                                //經銷商
                                $partner_name = $row[ $cnt++ ];
                                $row_arr[] = $partner_name;
                                $partner = Partner::where('title', $partner_name)->select('id')->first();
                                $product->partner_id = $partner->id;

                                $cnt++;
                                //總經銷商
                                $dealer_id = $row[ $cnt++ ];
                                $row_arr[] = $dealer_id;
                                $product->dealer_id = $dealer_id;

                                $cnt++;
                                $cnt++;

                                //新車車價
                                $new_car_price = $row[ $cnt++ ];
                                $row_arr[] = $new_car_price;
                                $product->new_car_price = $new_car_price;

                                //中古車定價
                                $second_hand_price = $row[ $cnt++ ];
                                $row_arr[] = $second_hand_price;
                                $product->second_hand_price = $second_hand_price;

                                //dd($product);
                                if($product_flag == '更新') {
                                    $product->update();
                                    $update_count++;
                                } elseif($product_flag == '新增') {
                                    $product->save();
                                    $append_count++;
                                }

                                $show_row_arr[] = $row_arr;
                            }
                        }
                    }
                }
            }
            $msg='新增: '.$append_count.' 筆, 更新 '.$update_count.' 筆';
            Session::put('product_show_header_arr',$show_header_arr);
            Session::put('product_show_row_arr',$show_row_arr);
            return redirect('/admin/product')->with('success_message', $msg);
        }*/

    }
