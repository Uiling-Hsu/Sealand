<?php

    namespace App\Http\Controllers\admin\OrdSelectcar;

    use App\Model\Brandcat;
    use App\Model\Brandin;
    use App\Model\Ord;
    use App\Model\Partner;
    use App\Model\Proarea;
    use App\Model\Product;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\Controller;

    class AdminProductController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function ordselcar(Ord $ord)
        {
            $cate_id=$ord->cate_id;
            $subscriber=$ord->subscriber;
            $subcars=$subscriber->subcars;
            $list_partners=Partner::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('全部','all');
            $list_proareas=Proarea::whereStatus(1)->where('id','!=',9)->orderBy('sort')->pluck('title','id')->prepend('全部','all');
            //$list_brandcats=Brandcat::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('全部','all');
            $list_brandcats=[];
            $list_brandins=[];

            $products = Product::whereStatus(1)->where('cate_id', $cate_id);
            $search_partner_id=Request('search_partner_id');
            if($search_partner_id && $search_partner_id!='all') {
	            $products = $products->where('partner_id', $search_partner_id);
            }
            $list_brandcats=Brandcat::whereStatus(1)->where('cate_id',$cate_id)->orderBy('sort')->pluck('title','id')->prepend('全部','all');
            $list_brandins = [];

            $search_brandcat_id=Request('search_brandcat_id');
            if($search_brandcat_id && $search_brandcat_id!='all') {
	            $products = $products->where('brandcat_id', $search_brandcat_id);
	            $list_brandins = Brandin::whereStatus(1)->where('brandcat_id',$search_brandcat_id)->pluck('title','id')->prepend('全部','all');
            }
            //else{
            //    $subcar=$subcars[0];
            //    $search_brandcat_id=$subcar->brandcat_id;
            //    $list_brandins = Brandin::whereStatus(1)->where('brandcat_id',$search_brandcat_id)->pluck('title','id')->prepend('全部','all');
	        //    $products = $products->where('brandcat_id', $search_brandcat_id);
            //}

            $search_brandin_id=Request('search_brandin_id');
            if($search_brandin_id && $search_brandin_id!='all')
                $products=$products->where('brandin_id',$search_brandin_id);

            $search_proarea_id=Request('search_proarea_id');
            if($search_proarea_id && $search_proarea_id!='all')
                $products=$products->where('proarea_id',$search_proarea_id);
            //else{
            //    $subcar=$subcars[0];
            //    $search_brandin_id=$subcar->brandin_id;
            //}
            //$products=$products->where('brandin_id',$search_brandin_id);

            $search_model=Request('search_model');
            if($search_model)
                $products=$products->where('model','like','%'.$search_model.'%');

            $search_plate_no=Request('search_plate_no');
            if($search_plate_no)
                $products=$products->where('plate_no','like','%'.$search_plate_no.'%');

            $products=$products->orderBy('sort')->paginate(30);

            $list_cates=Cate::whereStatus('1')->where('department_id',$search_department_id)->orderBy('sort')->pluck('title_tw','id')->prepend('全部','all');
            return view('admin.ordselcar.ordselcar',
                compact('ord',
                    'subscriber',
                    'products',
                    'list_partners',
                    'list_cates',
                    'list_brandcats',
                    'list_brandins',
                    'list_proareas',
                    'search_partner_id',
                    'search_cate_id',
                    'search_brandcat_id',
                    'search_brandin_id',
                    'search_proarea_id',
                    'search_model',
                    'search_plate_no',
                    'subcars'
                ));
        }

        public function ordselcar_post(Request $request) {
            $ord_id=$request->ord_id;
            $ord=Ord::whereId($ord_id)->first();
            if(!$ord)
                abort(404);

            $ord->product_id=$request->product_id;
            $ord->save();
            writeLog('選取車輛成功','ID:'.$ord->id.';車輛ID：'.$ord->product_id,1);
            Session::flash('modal_success_message', '車輛已選取成功!');
            // flash()->overlay('新增成功!','系統訊息:');
            return redirect('/admin/ord/'.$ord->id.'/edit');
        }

    }
