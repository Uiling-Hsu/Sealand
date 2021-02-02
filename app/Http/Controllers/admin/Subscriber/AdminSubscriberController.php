<?php

    namespace App\Http\Controllers\admin\Subscriber;

    use App\Mail\OrdPayNotiyPlaced;
    use App\Mail\SendMail\SendSubscriberEmail;
    use App\Mail\SendUserDataAndCateNotifyPlaced;
    use App\Mail\UserSubscriberReviewRejectNotifyPlaced;
    use App\Model\Cate;
    use App\Model\frontend\User;
    use App\Model\Ord;
    use App\Model\Proarea;
    use App\Model\Product;
    use App\Model\Ssite;
    use App\Model\Subscriber;
    use App\Model\Usergate;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\Controller;
    use Intervention\Image\Facades\Image;

    class AdminSubscriberController extends Controller
    {
        public function __construct(){
            $this->middleware(function ($request, $next) {
                if(!has_permission('subscriber'))
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
            /*$subscribers=Subscriber::get();
            $cnt=0;
            foreach($subscribers as $subscriber){
                if($subscriber->can_order_car==0 && $subscriber->is_history==0){
                    $subscriber->is_history=1;
                    $subscriber->update();
                    $cnt++;
                }
            }
            dd($cnt);*/

            $subscribers = new Subscriber;
            $search_is_history=Request('search_is_history');
            if($search_is_history!=2) {
                if($search_is_history == 1)
                    $subscribers = $subscribers->where('is_history', 1);
                elseif($search_is_history == 0)
                    $subscribers = $subscribers->where('is_history', 0);
            }

            $search_id=Request('search_id');
            if($search_id && $search_id!='all')
                $subscribers=$subscribers->whereId($search_id);

            $search_created_at=Request('search_created_at');
            if($search_created_at!='')
                $subscribers = $subscribers->where('created_at', 'like', $search_created_at.'%');

            $search_is_cancel=Request('search_is_cancel');
            if($search_is_cancel!='')
                $subscribers = $subscribers->where('is_cancel', $search_is_cancel);

            $search_company_no=Request('search_company_no');
            if($search_company_no!='') {
                if($search_company_no==1)
                    $subscribers = $subscribers->whereHas('user', function($q) {
                        $q->where('company_no', '!=','');
                    });
                else
                    $subscribers = $subscribers->whereHas('user',function($q){
                        $q->where('company_no',null)
                            ->orWhere('company_no', '');
                    });
            }

            $search_keyword=Request('search_keyword');
            if($search_keyword!='') {
                $subscribers = $subscribers->whereHas('user',function($q) use($search_keyword) {
                    $q->Where('name', 'like', '%'.$search_keyword.'%')
                        ->orWhere('phone', 'like', '%'.$search_keyword.'%')
                        ->orWhere('email', 'like', '%'.$search_keyword.'%');
                });
            }

            $search_can_order_car=Request('search_can_order_car');
            if($search_can_order_car!='') {
                $subscribers = $subscribers->where('can_order_car', $search_can_order_car);
            }

            if(role('carplus_varify')) {
                $subscribers = $subscribers->whereHas('product', function($q) {
                    $q->where('dealer_id', 1);
                });
                /*$subscribers = $subscribers->where(function($q) {
                    $q->whereHas('user', function($q1) {
                        $q1->where('id_type', 2);
                    })
                    ->orWhere('ret_code', '')
                    ->orWhere('ret_code', '0')
                    ->orWhere('ret_code', '2')
                    ->orWhere('ret_code', '3')
                    ->orWhere('ret_code', '99');
                });*/
            }

            $subscribers=$subscribers->orderBy('created_at','DESC')->paginate(50);

            //$list_cates=Cate::whereStatus('1')->where('department_id',$search_department_id)->orderBy('sort')->pluck('title_tw','id')->prepend('全部','all');
            return view('admin.subscriber.subscriber',compact('subscribers',
                'search_is_history',
                'search_id',
                'search_created_at',
                'search_is_cancel',
                'search_keyword',
                'search_company_no',
                'search_can_order_car'));
        }

        public function create(){
            $admin=getAdminUser();
            $list_cates=Cate::whereStatus(1)->where('is_display',1)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
            $list_proareas=Proarea::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
            $list_users=User::whereStatus(1)->orderBy('id')->pluck('name','id')->prepend('請選擇','');

            $list_products=null;
            $search_cate_id=Request('search_cate_id');
            $search_proarea_id=Request('search_proarea_id');
            if($search_cate_id && $search_proarea_id)
                $list_products=Product::where('ptate_id',3)
                    ->where('cate_id',$search_cate_id)
                    ->where(function($q) use ($search_proarea_id) {
                        $q->where('proarea_id', $search_proarea_id)
                            ->orWhere('proarea2_id', $search_proarea_id);
                    })
                    ->orderBy('plate_no')
                    ->pluck('plate_no','id')
                    ->prepend('請選擇','');

            $list_pick_up_times=array();
            $list_pick_up_times['']='請選擇';
            $list_pick_up_times['皆可']='皆可';
            $list_pick_up_times['09:00~10:00']='09:00~10:00';
            $list_pick_up_times['10:00~11:00']='10:00~11:00';
            $list_pick_up_times['11:00~12:00']='11:00~12:00';
            $list_pick_up_times['12:00~13:00']='12:00~13:00';
            $list_pick_up_times['13:00~14:00']='13:00~14:00';
            $list_pick_up_times['14:00~15:00']='14:00~15:00';
            $list_pick_up_times['15:00~16:00']='15:00~16:00';
            $list_pick_up_times['16:00~17:00']='16:00~17:00';
            return view('admin/subscriber/subscriber_create',compact('list_cates','list_proareas','list_users','list_products','search_cate_id','search_proarea_id','list_pick_up_times'));
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
            $product_id=$request->product_id;
            $product=Product::whereId($product_id)->where('ptate_id',3)->first();
            if(!$product)
                return redirect()->back()->with('failure_message','找不到此車輛或此車輛已下架')->withInput();
            $cate_id=$request->cate_id;
            if($cate_id != $product->cate_id)
                return redirect()->back()->with('failure_message','您所選的方案跟車輛的方案不相同。')->withInput();
            $inputs['ret_code']='99';
            $inputs['ret_message']='手動新增訂閱單';
            $subscriber=Subscriber::create($inputs);
            $product->ptate_id=1;
            $product->update();
            writeLog('新增 訂閱單',$inputs,1);
            Session::flash('success_message', '新增成功!');
            // flash()->overlay('新增成功!','系統訊息:');
            return redirect('/admin/subscriber?page='.Request('page'));
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function edit(Subscriber $subscriber)
        {
            if(!$subscriber)
                abort(404);
            $user=$subscriber->user;

            $list_proareas=Proarea::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
            $cate=$subscriber->cate;
            $user=$subscriber->user;
            $subcars=$subscriber->subcars;

            $list_pick_up_times=array();
            $list_pick_up_times['']='請選擇';
            $list_pick_up_times['皆可']='皆可';
            $list_pick_up_times['10:00~11:00']='10:00~11:00';
            $list_pick_up_times['11:00~12:00']='11:00~12:00';
            $list_pick_up_times['12:00~13:00']='12:00~13:00';
            $list_pick_up_times['13:00~14:00']='13:00~14:00';
            $list_pick_up_times['14:00~15:00']='14:00~15:00';
            $list_pick_up_times['15:00~16:00']='15:00~16:00';
            $list_pick_up_times['16:00~17:00']='16:00~17:00';

            return view('admin/subscriber/subscriber_edit',compact('subscriber','cate','user','subcars','list_proareas','list_pick_up_times'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, Subscriber $subscriber)
        {
            //dd($request->all());
            $inputs=$request->all();

            if($request->is_cancel==1) {
                $subscriber->is_history = 1;
                $product=$subscriber->product;
                if($product){
                    $product->ptate_id=3;
                    $product->update();
                }
            }

            $subscriber->update($inputs);
            writeLog('更新 訂閱',$inputs,1);
            Session::flash('success_message', '更新成功!');
            //flash()->overlay('更新成功!','系統訊息:');
            return redirect('/admin/subscriber/'.$subscriber->id.'/edit?search_is_history='.$request->search_is_history.'&page='.Request('page').'#list');
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Subscriber $subscriber)
        {
            $subcars=$subscriber->subcars;
            if($subcars){
                foreach($subcars as $subcar) {
                    $subcar->delete();
                }
            }
            if(file_exists($subscriber->image))
                unlink($subscriber->image);

            //刪除前先上架車子
            $product=$subscriber->product;
            if($product){
                //$product->status=1;
                //$product->is_renting=0;
                $product->ptate_id=3;
                $product->update();
            }

            $subscriber->delete();
            //writeLog('Delete Subscriber',$subscriber->toArray());
            writeLog('刪除 訂閱','訂閱ID：'.$subscriber->id,1);
            Session::flash('success_message', '刪除成功!');
            // flash()->overlay('刪除成功!','系統訊息:');
            return redirect('/admin/subscriber?search_is_history='.Request('search_is_history').'&page='.Request('page'));
        }

        public function sub_trandfer_ord(Request $request) {
            $subscriber_id=$request->subscriber_id;
            $subscriber=Subscriber::whereId($subscriber_id)->first();
            if(!$subscriber)
                abort(404);
            //dd($subscriber->product_id);
            //檢查目前訂單中是否有未取消、未結案的車輛
            $chk_ord_count=Ord::where('product_id',$subscriber->product_id)->where('is_cancel',0)->where('state_id','<=',10)->count();
            if($chk_ord_count>0)
                return redirect()->back()->with('failure_message','訂單內已有此車輛出租中，請重新選擇其它車輛。');

            $user=$subscriber->user;
            $cate=$subscriber->cate;
            $product=$subscriber->product;
            $partner=$product->partner;
            $is_carplus=0;
            if(mb_substr( $partner->title,0,2,"utf-8")=='格上')
                $is_carplus=1;
            $proarea_id=$subscriber->proarea_id;
            $brandcat=$product->brandcat;
            $brandin=$product->brandin;

            //起租款
            $basic_fee=$cate->basic_fee;
            $mile_fee=$cate->mile_fee;
            $mile_pre_month=$cate->mile_pre_month;
            $payment_total=($basic_fee+($mile_fee*$mile_pre_month)) * $ord->rent_month;

            $ord=new Ord();
            $ord->user_id=$user->id;
            $ord_no=Carbon::now()->format('ymd').rand(10000,99999);
            $ord->ord_no=$ord_no;
            $ord->checkout_no=$ord_no;
            $ord->deposit=$cate->deposit;
            $ord->basic_fee=$cate->basic_fee;
            $ord->mile_fee=$cate->mile_fee;
            $ord->mile_pre_month=$cate->mile_pre_month;
            $ord->milage = $product->milage;
            $ord->payment_total=$payment_total;
            $ord->subscriber_id=$subscriber->id;
            $ord->cate_id=$cate->id;
            $ord->cate_title=$cate->title;
            $ord->partner_id=$product->partner_id;
            $ord->partner2_id=$product->partner2_id;
            $ord->order_from=$subscriber->order_from;
            $ord->is_carplus=$is_carplus;
            $ord->product_id=$product->id;
            $ord->delivery_address=$subscriber->delivery_address;
            $ord->return_delivery_address=$subscriber->return_delivery_address;
            $ord->model=$product->model;
            $ord->plate_no=$product->plate_no;
            $ord->proarea_id=$proarea_id;
            $ord->pick_up_time=$subscriber->pick_up_time;
            $ord->sub_date=$subscriber->sub_date;
            $ord->expiry_date=date('Y-m-d',strtotime($ord->sub_date.' +89 day'));
            $ord->brandcat_name=$brandcat->title;
            $ord->brandin_name=$brandin->title;
            $ord->total=$cate->deposit;
            $ord->name=$user->name;
            $ord->phone=$user->phone;
            $ord->email=$user->email;
            $ord->address=$user->address;
            $ord->save();

            $product->ord_id=$ord->id;
            //$product->status=0;
            //$product->is_renting=1;
            $product->ptate_id=1;
            $product->update();

            $subscriber->is_history=1;
            $subscriber->update();

            //清空授信開關
            /*$usergates=Usergate::where('user_id',$user->id)->where('cate_id',$cate->id)->get();
            foreach($usergates as $usergate){
                $usergate->delete();
            }*/
            Mail::send(new OrdPayNotiyPlaced($ord, $ord->email, $ord->name));
            writeLog('訂閱轉訂單, 並已寄Mail通知消費者前往繳保證金','會員姓名：'.$user->name.' 訂單ID：'.$ord->id,1);
            /*$partner=$ord->partner;
            if($partner){
                Mail::send(new OrdPayNotiyPlaced($ord, $partner->email, $partner->title));
                if($partner->partneremails->count()>0) {
                    foreach($partner->partneremails as $partneremail) {
                        Mail::send(new OrdPayNotiyPlaced($ord, $partneremail->email, $partner->title));
                    }
                }
            }*/
            Session::flash('success_message', '已產生此頁訂單，並已寄發保證金繳費通知至會員信箱!');
            // flash()->overlay('刪除成功!','系統訊息:');
            return redirect('/admin/ord/'.$ord->id.'/edit');
        }

        function licenceFileShow($field, $slug)
        {
            $storagePath = storage_path('app/user/'.$slug);
            return Image::make($storagePath)->response();
        }


        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function subscriber_user(User $user)
        {
            $cates=Cate::whereStatus(1)->orderBy('sort')->get();
            $list_ssites = Ssite::whereStatus(1)->orderBy('sort')->pluck('title', 'id')->prepend('選選擇', '');
            return view('admin/subscriber/user_edit',compact('user','cates','list_ssites'));
        }
    }
