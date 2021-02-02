<?php

    namespace App\Http\Controllers\admin\Ord;

    use App\Exports\OrdExport;
    use App\Exports\OrdReporterExport;
    use App\Exports\ProductExport;
    use App\Mail\OrdCancelPlaced;
    use App\Mail\OrdChangeSubdateNotifyPlaced;
    use App\Mail\OrdPartnerFinishedDeliveryCarNotifyPlaced;
    use App\Mail\OrdPartnerFinishedReturnCarNotifyPlaced;
    use App\Mail\OrdPay2NotiyPlaced;
    use App\Mail\OrdPay3NotiyPlaced;
    use App\Mail\OrdPayNotiyPlaced;
    use App\Mail\OrdPlaced;
    use App\Mail\OrdUserRremindDeliveryCarNotifyPlaced;
    use App\Mail\RenewalNewOrdNotiyPlaced;
    use App\Mail\SendMail\SendOrdEmail;
    use App\Mail\SendMail\SendOrdPlaceEmail;
    use App\Mail\SendUserDataAndCateNotifyPlaced;
    use App\Model\Cate;
    use App\Model\Dealer;
    use App\Model\frontend\User;
    use App\Model\Ord;
    use App\Http\Requests;
    use App\Model\Partner;
    use App\Model\Proarea;
    use App\Model\Product;
    use App\Model\Renewtate;
    use App\Model\State;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Session;
    use App\Http\Controllers\Controller;
    use App\Http\Requests\Ord\AdminOrdRequest;
    use Intervention\Image\Facades\Image;
    use Maatwebsite\Excel\Facades\Excel;
    use function foo\func;

    class AdminOrdController extends Controller
    {
        public function __construct(){
            $this->middleware(function ($request, $next) {
                if(!has_permission('ord'))
                    abort(403);
                return $next($request);
            });
        }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|\Symfony\Component\HttpFoundation\BinaryFileResponse
         */
        public function index()
        {
            /*$ords=Ord::where('is_paid',1)->get();
            foreach($ords as $ord){
                if($ord->paid_date && strlen($ord->paid_date)<11) {
                    $ord->paid_date = $ord->paid_date.' 10:10:10';
                    $ord->update();
                }
                if($ord->paid2_date && strlen($ord->paid2_date)<11) {
                    $ord->paid2_date = $ord->paid2_date.' 10:10:10';
                    $ord->update();
                }
                if($ord->paid3_date && strlen($ord->paid3_date)<11) {
                    $ord->paid3_date = $ord->paid3_date.' 10:10:10';
                    $ord->update();
                }
            }*/

            $list_cates=Cate::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('全部','');
            $list_states=State::whereStatus(1)->orderBy('sort')->pluck('ftitle','id')->prepend('全部','');
            //dd($lefts_ord_id_arr);
            $admin=getAdminUser();

            $ords=new Ord;

            //查詢的時間欄位
            $search_date_field=Request('search_date_field');
            if(!$search_date_field)
                $search_date_field='created_at';

            $search_start_date=Request('search_start_date');
            if($search_start_date)
                $ords = $ords->where($search_date_field, '>=', $search_start_date.' 00:00:01');
            $search_end_date=Request('search_end_date');
            if($search_start_date)
                $ords = $ords->where($search_date_field, '<=', $search_end_date.' 23:59:59');

            $list_dealers=Dealer::whereStatus(1)->pluck('title','id')->prepend('全部','');
            $list_partners=Partner::whereStatus(1)->pluck('title','id')->prepend('全部','');
            if($admin->hasRole('partner')){
                $ords = $ords->where('partner_id', $admin->partner_id)->where('state_id','>', 1);
            }
            elseif($admin->hasRole('carplus_company') || $admin->hasRole('carplus_varify')){
                $list_partners=Partner::whereStatus(1)->where('title','like','%格上%')->pluck('title','id')->prepend('全部','');
                $ords = $ords->where('is_carplus', 1)->where('state_id','>', 1);
            }

            //目的
            $search_purpose=Request('search_purpose');
            if($search_purpose == 'is_paid') {
                $ords = $ords->where('is_paid',1);
            }
            elseif($search_purpose == 'is_paid2') {
                $ords = $ords->where('is_paid2',1);
            }
            elseif($search_purpose == 'is_paid3') {
                $ords = $ords->where('is_paid3',1);
            }
            elseif($search_purpose == 'is_working') {
                $ords = $ords
                    ->where('state_id','>=',2)
                    ->where('state_id','<=',9)
                    ->where('is_cancel', 0);
            }
            /*elseif(substr($search_purpose,0,9)=='is_cancel'){
                $iscancel=substr($search_purpose,9,1);
                $ords = $ords->where('is_cancel',$iscancel);
            }*/
            elseif(substr($search_purpose,0,12)=='renewtate_id'){
                $renewtate_id=substr($search_purpose,12,1);
                $ords = $ords->where('renewtate_id',$renewtate_id);
            }

            $search_dealer_id=Request('search_dealer_id');
            if($search_dealer_id!='') {
                $ords = $ords->whereHas('product', function($q) use($search_dealer_id) {
                    $q->where('dealer_id',$search_dealer_id);
                });
            }

            $search_partner_id=Request('search_partner_id');
            if($search_partner_id!='')
                $ords=$ords->where('partner_id',$search_partner_id);

            $search_cate_id=Request('search_cate_id');
            if($search_cate_id!='')
                $ords=$ords->where('cate_id',$search_cate_id);
            $search_state_id=Request('search_state_id');
            if($search_state_id!='')
                $ords=$ords->where('state_id',$search_state_id);
            $search_plate_no=Request('search_plate_no');
            if($search_plate_no!='')
                $ords=$ords->where('plate_no',$search_plate_no);
            $search_model=Request('search_model');
            if($search_model!='')
                $ords=$ords->where('model',$search_model);

            $search_left_days=Request('search_left_days');
            if($search_left_days!='') {
                $lefts_ord_id_arr = array();
                $left_ords = Ord::where('is_paid', 1)->where('is_paid2', 1)->get();
                foreach($left_ords as $left_ord) {
                    $left_days = getOrdLeftDays($left_ord->id);
                    if($left_days <= $search_left_days)
                        $lefts_ord_id_arr[] = $left_ord->id;
                }
                //if($lefts_ord_id_arr)
                $ords=$ords->whereIn('id',$lefts_ord_id_arr);
            }

            $search_rent_month=Request('search_rent_month');
            if($search_rent_month!='') {
                $ords=$ords->where('rent_month',$search_rent_month)->where('is_renew_order',1);
            }

            $search_is_cancel=Request('search_is_cancel');
            if($search_is_cancel=='')
                $search_is_cancel='0';
            if($search_is_cancel=='1' || $search_is_cancel=='0' ) {
                $ords=$ords->where('is_cancel',$search_is_cancel);
            }

            $search_samecartate_id=Request('search_samecartate_id');
            if($search_samecartate_id!='') {
                $ords=$ords->where('is_renew_order',1);
                $ords = $ords->whereHas('user',function($q)use($search_samecartate_id){
                    $q->where('samecartate_id',$search_samecartate_id);
                });
            }

            $search_company_no=Request('search_company_no');
            if($search_company_no!='') {
                if($search_company_no==1)
                    $ords = $ords->whereHas('user', function($q) {
                        $q->where('company_no', '!=','');
                    });
                else
                    $ords = $ords->whereHas('user',function($q){
                        $q->where('company_no',null)
                            ->orWhere('company_no', '');
                    });
            }

            $search_keyword=Request('search_keyword');
            if($search_keyword!='') {
                $ords = $ords->where(function($q) use($search_keyword) {
                    $q->where('ord_no', 'like', '%'.$search_keyword.'%')
                        ->orWhere('checkout_no', 'like', '%'.$search_keyword.'%')
                        ->orWhere('checkout_no2', 'like', '%'.$search_keyword.'%')
                        ->orWhere('checkout_no3', 'like', '%'.$search_keyword.'%');
                });
            }

            $search_user_keyword=Request('search_user_keyword');
            if($search_user_keyword!='') {
                $ords = $ords->whereHas('user', function($q) use($search_user_keyword) {
                        $q->where('name', 'like', '%'.$search_user_keyword.'%')
                            ->orWhere('email', 'like', '%'.$search_user_keyword.'%')
                            ->orWhere('phone', 'like', '%'.$search_user_keyword.'%');
                    });
            }

            $ords=$ords->orderBy('updated_at','DESC');
            //dd($ords->get());
            if($ords->count()>0 && Request('download')==1) {
                $ords=$ords->get();
                $ord_file_name = 'Order_export_'.date('Y_m_d_H_i_s').'.xlsx';
                return Excel::download(new OrdExport($ords), $ord_file_name);
            }
            else {
                $ords = $ords->paginate(50);
            }

            return view('admin.ord.ord',compact('ords','list_cates','list_states','list_dealers','list_partners','search_company_no','search_left_days','search_is_cancel'));
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

            $search_partner_id=Request('search_partner_id');
            $list_partners=Partner::whereStatus(1)->where('proarea_id',$search_proarea_id)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');

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
            return view('admin/ord/ord_create',compact('list_cates','list_proareas','list_partners','list_users','list_products','search_cate_id','search_proarea_id','search_partner_id','list_pick_up_times'));
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\RedirectResponse
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

            //產生訂單
            $user_id=$request->user_id;
            $user=User::whereId($user_id)->first();

            $cate_id=$request->cate_id;
            $cate=Cate::whereId($cate_id)->first();
            $partner = $product->partner;
            $is_carplus = 0;
            if(mb_substr($partner->title, 0, 2, "utf-8") == '格上')
                $is_carplus = 1;
            $proarea_id = $product->proarea_id;
            $brandcat = $product->brandcat;
            $brandin = $product->brandin;

            //起租款
            $basic_fee = $cate->basic_fee;
            $mile_fee = $cate->mile_fee;
            $mile_pre_month = $cate->mile_pre_month;
            $payment_total = ($basic_fee + ($mile_fee * $mile_pre_month)) * 3;

            $ord = new Ord();
            $ord->user_id = $user->id;
            $ord_no = Carbon::now()->format('ymd').rand(10000, 99999);
            $ord->ord_no = $ord_no;
            $ord->checkout_no = $ord_no;
            $ord->deposit = $cate->deposit;
            $ord->basic_fee = $cate->basic_fee;
            $ord->mile_fee = $cate->mile_fee;
            $ord->mile_pre_month = $cate->mile_pre_month;
            $ord->milage = $product->milage;
            $ord->payment_total = $payment_total;
            //$ord->subscriber_id = $subscriber->id;
            $ord->cate_id = $cate->id;
            $ord->cate_title = $cate->title;
            $ord->partner_id = $product->partner_id;
            $ord->partner2_id = $product->partner2_id;
            //$ord->partner3_id = $subscriber->partner_id;

            //訂閱來源：Sealand
            $ord->order_from=2;

            $ord->is_carplus = $is_carplus;
            $ord->product_id = $product->id;
            $ord->delivery_address = $partner->address;
            $ord->return_delivery_address = $partner->address;
            $ord->model = $product->model;
            $ord->plate_no = $product->plate_no;
            $ord->proarea_id = $proarea_id;
            $ord->pick_up_time = $request->pick_up_time;
            $ord->sub_date = $request->sub_date;
            $ord->expiry_date = date('Y-m-d', strtotime($ord->sub_date.' +89 day'));
            $ord->brandcat_name = $brandcat->title;
            $ord->brandin_name = $brandin->title;
            $ord->total = $cate->deposit;
            $ord->name = $user->name;
            $ord->phone = $user->phone;
            $ord->email = $user->email;
            $ord->address = $user->address;
            $ord->is_pass_by_api = 1;
            //判斷是否為換車續約單
            if($user->is_change_car==1){
                $ord->is_renew_change_order=1;
                $ord->renew_ord_id=$user->before_renew_change_car_ord_id;
                //將原訂單的續約狀態改為5
                $before_renew_change_car_ord=Ord::whereId($user->before_renew_change_car_ord_id)->first();
                if($before_renew_change_car_ord){
                    $before_renew_change_car_ord->is_renewtate_setting_finish=1;
                    $before_renew_change_car_ord->update();
                }
                $ord->renew_ord_no=$user->before_renew_change_car_ord_no;
            }
            $ord->save();
            writeLog('方案審核通過 已產生訂單','訂單編號：'.$ord->ord_no.' 會員姓名：'.$user->name,0,'');
            $product->ord_id = $ord->id;
            $product->ptate_id=1;
            $product->update();

            writeLog('新增訂單成功',$inputs,1);
            Session::flash('success_message', '新增訂單成功!');
            // flash()->overlay('新增成功!','系統訊息:');
            return redirect('/admin/ord');
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int  $id
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
         */
        public function edit(Ord $ord) {

            $cate=$ord->cate;
            $user=$ord->user;
            $product=$ord->product;
            $subscriber=$ord->subscriber;
            $list_proareas=Proarea::where('status','1')->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
            $list_states=State::whereStatus(1)->orderBy('sort')->pluck('title','id');
            $now_state_id=$ord->state_id;
            $next_state_id=$now_state_id++;

            if($next_state_id > 13) {
                $list_onestep_states = State::whereStatus(1)->whereId(13)->pluck('title', 'id');
            } else {
                $list_onestep_states = State::whereStatus(1)->where(function($q) use ($now_state_id, $next_state_id) {
                    $q->where('id', $now_state_id)
                        ->orWhere('id', $next_state_id);
                })->pluck('title', 'id');
            }

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

            $list_partners = Partner::whereStatus(1)->orderBy('sort')->pluck('title', 'id');
            $list_partner2s=Partner::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('無','all');
            $list_renewtates=Renewtate::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('無','all');

            //如果是同車續約，預設月份數是空的，則補上3
            if($ord->renewtate_id==1 && !$ord->renew_month){
                $ord->renew_month=3;
                $ord->update();
            }

            //$list_onestep_states=State::whereStatus(1)->orderBy('sort')->pluck('title','id');
            return view('admin/ord/ord_edit',compact('ord','cate','user','product','subscriber','list_proareas','list_states','list_onestep_states','list_pick_up_times','list_partners','list_partner2s','list_renewtates'));
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function update(AdminOrdRequest $request, Ord $ord)
        {
            $inputs=$request->all();
            $user=$ord->user;
            /*$product=$ord->product;
            //原車輛里程數
            $milage=$product->milage;
            //取車里程
            $request_milage=$request->milage;*/
            //還車里程
            //dd($inputs);
            $image_width=720;
            $image_height=null;
            if ($request->hasFile('imgFile')){
                $upload_filename = upload_file($request->file('imgFile'), 'ord', $image_width, $image_height);
                if($upload_filename==-1){
                    Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg  或 *.png 格式');
                    return redirect()->back();
                }
                if($ord->image && file_exists( public_path() .$ord->image))
                    unlink( public_path() . $ord->image);
                $inputs['image'] = $upload_filename;
            }
            if($request->is_cancel==1){
                $product=$ord->product;
                if($product){
                    $product->ptate_id=3;
                    $product->update();
                }
                $inputs['cancel_date']=date('Y-m-d H:i:s');
                $inputs['state_id']=14;
                Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name,'訂單取消通知','mn5'));
                writeLog('已取消此訂單，並寄給會員 訂單取消通知 通知已成功送出','ID:'.$user->id.', 會員姓名：'.$user->name.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id,1);
                //寄出給 經銷商 訂單已取消通知
                if($ord->state_id>=2) {
                    $partner = $ord->partner;
                    if($partner) {
                        $partner_name=$partner->title;
                        $user = $ord->user;
                        Mail::send(new SendOrdEmail($ord, $partner->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 訂單取消通知','rn5'));
                        if($partner->partneremails->count() > 0) {
                            foreach($partner->partneremails as $partneremail) {
                                if($partneremail->email)
                                    Mail::send(new SendOrdEmail($ord, $partneremail->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 訂單取消通知','rn5'));
                            }
                        }
                        writeLog('寄給經銷商:'.$partner_name.' 訂單取消通知 通知已成功送出','ID:'.$user->id.', 會員姓名：'.$user->name.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id,1);
                    }
                }
            }
            elseif($ord->state_id==8 && getOrdLeftDays($ord->id)<0){
                //逾期租金
                $illegal_days=getOrdLeftDays($ord->id);
                if($illegal_days>=-5) {
                    $inputs['delay_fee'] = (-1) * $illegal_days * $ord->basic_fee * 0.5;
                }
                else {
                    $delay_fee5 = 5 * $ord->basic_fee * 0.5;
                    $delay_fee_plus = (-1) * ($illegal_days+5) * $ord->basic_fee * 0.25;
                    $inputs['delay_fee']=$delay_fee5+$delay_fee_plus;
                }
            }
            if($request->is_paid==1 && $ord->paid_date=='')
                $inputs['paid_date']=date('Y-m-d H:i:s');
            if($request->paid_date && $request->paid_date==10)
                $inputs['paid_date']=$request->paid_date.' 10:10:10';

            if($request->is_paid2==1 && $ord->paid2_date=='')
                $inputs['paid2_date']=date('Y-m-d H:i:s');
            if($request->paid2_date && $request->paid2_date==10)
                $inputs['paid2_date']=$request->paid2_date.' 10:10:10';

            if($request->is_paid3==1 && $ord->paid3_date=='')
                $inputs['paid3_date']=date('Y-m-d H:i:s');
            if($request->paid3_date && $request->paid3_date==10)
                $inputs['paid3_date']=$request->paid3_date.' 10:10:10';

            $log=get_diff_field_content($ord->toArray(), $inputs);
            if($log)
                writeLog('更新訂單資料1：','訂單ID：'.$ord->id.'，訂單編號：'.$ord->ord_no.'，姓名：'.$ord->name.'，車輛ID：'.$ord->product_id.'，變更欄位：'.$log,1);
            //writeLog('更新訂單資料:前',$ord->toArray(),1);
            writeLog('更新訂單資料2：','訂單ID：'.$ord->id.'，訂單編號：'.$ord->ord_no.'，姓名：'.$ord->name.'，車輛ID：'.$ord->product_id.'，'.json_encode($inputs,JSON_UNESCAPED_UNICODE),1);
            $ord->update($inputs);
            $flash_msg='';
            //訂單狀態下拉選單直接操作時執行
            if($request->list==1){
                //3 準備交車
                if($request->state_id==3) {
                    //寄發提醒交車Email
                    Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name,'交車提醒通知','my4'));
                    writeLog('寄給會員 交車提醒通知 通知已成功送出','ID:'.$user->id.', 會員姓名：'.$user->name.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id,1);
                    //寄出提醒經銷商 剩10天要交車
                    $partner=$ord->partner;
                    $partner_name='';
                    if($partner){
                        $partner_name=$partner->title;
                        $partner=$ord->partner;
                        $user=$ord->user;
                        $plate_no=$ord->plate_no;
                        if(!$plate_no)
                            $plate_no=$ord->model;
                        //Mail::send(new \App\Mail\OrdPartnerRremindDeliveryCarNotifyPlaced($ord, 'eric@eze23.com', $partner->title));
                        Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, $partner->email, $partner->title,$partner->title.'/'.$plate_no.'/'.$user->name.' 交車提醒通知','ry4'));
                        if($partner->partneremails->count()>0) {
                            foreach($partner->partneremails as $partneremail) {
                                if($partneremail->email)
                                    Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, $partneremail->email, $partner->title,$partner->title.'/'.$plate_no.'/'.$user->name.' 交車提醒通知','ry4'));
                            }
                        }
                    }
                    $partner2=$ord->partner2;
                    $partner2_name='';
                    if($partner2){
                        $partner2_name=', '.$partner2->title;
                        $user=$ord->user;
                        $plate_no=$ord->plate_no;
                        if(!$plate_no)
                            $plate_no=$ord->model;
                        Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, $partner2->email, $partner2->title,'(原車所) '.$partner2->title.'/'.$plate_no.'/'.$user->name.' 交車提醒通知','ry4'));
                        if($partner2->partneremails->count()>0) {
                            foreach($partner2->partneremails as $partneremail) {
                                if($partneremail->email)
                                    Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, $partneremail->email, $partner2->title,'(原車所) '.$partner2->title.'/'.$plate_no.'/'.$user->name.' 交車提醒通知','ry4'));
                            }
                        }
                    }
                    $flash_msg = ' 並已寄出Email提醒交車通知給會員';
                    writeLog('交車提醒通知經銷商:'.$partner_name.$partner2_name,'會員姓名：'.$user->name.' 訂單ID：'.$ord->id.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id,1);
                }
                //4 已完成交車前作業
                elseif($request->state_id==4) {
                    /*$inputs['sub_date'] = date('Y-m-d');
                    $inputs['expiry_date'] = date('Y-m-d', strtotime($ord->sub_date.' +89 day'));*/

                    //會員
                    Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name,'起租繳款通知','my5'));
                    $flash_msg = ' 並已寄出繳款通知Email給會員';
                    writeLog('寄給會員 繳款通知已成功送出','ID:'.$user->id.', 會員姓名：'.$user->name.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id,1);
                }
                //9 完成還車前作業  (寄發是否繳款Email，如無需繳款請進行下一步)
                elseif($request->state_id==9){
                    //會員
                    Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name,'迄租繳款通知','my9'));
                    $flash_msg = ' 並已寄出迄租繳款通知給會員';
                    writeLog('寄給會員 迄租款繳款通知已成功送出','ID:'.$user->id.', 會員姓名：'.$user->name.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id,1);
                }
                //10 or 11 完成還車前作業 or 已還車 (寄發是否繳款Email，如無需繳款請進行下一步)
                elseif($request->state_id==10 || $request->state_id==11){
                    //
                    if($request->state_id==11 && $ord->renewtate_id!=1){
                        $product=$ord->product;
                        if($product){
                            $product->ptate_id=6;
                            $product->return_date=date('Y-m-d');
                            $product->update();
                        }
                    }
                    //還車免付款，更新會員訂單資料: 已付迄租款、迄租款繳款日期
                    if($ord->payment_backcar_total<=0){
                        $ord->is_paid3=1;
                        $ord->paid3_date=date('Y-m-d H:i:s');
                        $msg='';
                        $user = $ord->user;
                        $partner = $ord->partner;
                        if($partner && $user) {
                            Mail::send(new SendOrdEmail($ord, $partner->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 已還車通知', 'ry10'));
                            if($partner->partneremails->count() > 0) {
                                foreach($partner->partneremails as $partneremail) {
                                    if($partneremail->email)
                                        Mail::send(new SendOrdEmail($ord, $partneremail->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 已還車通知', 'ry10'));
                                }
                            }
                            $msg .= '，並寄出：已還車通知：ry10->車源商。';
                        }
                        writeLog('還車免付款，更新會員訂單資料：已付迄租款、迄租款繳款日期'.$msg,'ID:'.$user->id.', 會員姓名：'.$user->name.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id,1);
                    }
                }
                //12 保証金退還  (結案)
                elseif($request->state_id==12){
                    //結案日期/時間
                    $inputs['close_date']=date('Y-m-d');
                    $inputs['close_time']=date('H:i:s');
                    Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name,'保證金退還通知','my11'));
                    writeLog('寄給會員 保證金退還 通知已成功送出','ID:'.$user->id.', 會員姓名：'.$user->name.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id,1);
                    $flash_msg = ' 已結案並記錄結案日期及時間，寄出保證金退還通知';
                }
            }
            $log=get_diff_field_content($ord->toArray(), $inputs);
            if($log)
                writeLog('更新訂單資料3：','訂單ID：'.$ord->id.'，訂單編號：'.$ord->ord_no.'，姓名：'.$ord->name.'，車輛ID：'.$ord->product_id.'，變更欄位：'.$log,1);
            //writeLog('更新訂單資料:前',$ord->toArray(),1);
            writeLog('更新訂單資料4：','訂單ID：'.$ord->id.'，訂單編號：'.$ord->ord_no.'，姓名：'.$ord->name.'，車輛ID：'.$ord->product_id.'，'.json_encode($inputs,JSON_UNESCAPED_UNICODE),1);

            $ord->update();
            $product=$ord->product;
            if($product && $product->plate_no!=$ord->plate_no){
                $product->plate_no=$ord->plate_no;
                $product->update();
            }
            $list='';
            if($request->list==1)
                $list='#list';
            Session::flash('success_message', '更新成功!'.$flash_msg);
            //flash()->overlay('更新成功!','系統訊息:');
            return redirect('/admin/ord/'.$ord->id.'/edit'.$list);
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
         */
        public function destroy(Ord $ord)
        {
            if($ord->image && file_exists( public_path() .$ord->image))
                unlink( public_path() . $ord->image);
            $ord->delete();
            writeLog('刪除 訂單',$ord->toArray(),1);
            Session::flash('success_message', '刪除成功!');
            // flash()->overlay('刪除成功!','系統訊息:');
            return redirect('/admin/ord');
        }

        public function batch_update(Request $request){
            $sorts=$request->sort;
            foreach($request->ord_id as $index => $ord_id){
                if($sorts[$index]!=''){
                    Ord::where('id',$ord_id)->update(['sort'=>$sorts[$index]]);
                }
            }
            $ids=$request->id;
            $isdels=$request->isdel;
            if($isdels){
                foreach ($isdels as $isdel) {
                    $ord=Ord::whereId($isdel)->first();
                    if($ord->image && file_exists( public_path() .$ord->image))
                        unlink( public_path() . $ord->image);
                    $ord->delete();
                }
            }

            Session::flash('flash_message', '批次刪除及更新排序!');
            // flash()->overlay('更新成功!','系統訊息:');
            return redirect('/admin/ord');
        }

        public function ord_email(Ord $ord) {
            //經銷商
            $partner=$ord->partner;
            $user=$ord->user;
            $partner_name='';
            if($partner){
                $partner_name=$partner->title;
                Mail::send(new OrdPlaced($ord, $partner->email, $partner->title,1));
                if($partner->partneremails->count()>0) {
                    foreach($partner->partneremails as $partneremail) {
                        if($partneremail->email)
                            Mail::send(new OrdPlaced($ord, $partneremail->email, $partner->title,1));
                    }
                }
            }

            $partner2=$ord->partner2;
            $partner2_name='';
            if($partner2 && $partner2->email) {
                $partner2_name=', '.$partner2->title;
                Mail::send(new OrdPlaced($ord, $partner2->email, $partner2->title, 1));
                if($partner2->partneremails->count() > 0) {
                    foreach($partner2->partneremails as $partneremail) {
                        if($partneremail->email)
                            Mail::send(new OrdPlaced($ord, $partneremail->email, $partner2->title, 1));
                    }
                }
            }
            writeLog('寄給經銷商:'.$partner_name.$partner2_name.' 保證金付清','會員姓名：'.$user->name.' 訂單ID：'.$ord->id.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id,1);
            Session::flash('modal_success_message', '保證金付清通知已成功寄出!');
            // flash()->overlay('新增成功!','系統訊息:');
            return redirect('/admin/ord/'.$ord->id.'/edit');
        }

        public function backend_change_subdate_notify(Ord $ord) {
            //經銷商
            $partner=$ord->partner;
            $user=$ord->user;
            if($partner){
                $partner_name=$partner->title;
                Mail::send(new OrdChangeSubdateNotifyPlaced($ord, $partner->email, $partner->title));
                if($partner->partneremails->count()>0) {
                    foreach($partner->partneremails as $partneremail) {
                        if($partneremail->email)
                            Mail::send(new OrdChangeSubdateNotifyPlaced($ord, $partneremail->email, $partner->title));
                    }
                }
                writeLog('寄給經銷商:'.$partner_name.' 保證金付清','會員姓名：'.$user->name.' 訂單ID：'.$ord->id.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id,1);
            }

            Session::flash('modal_success_message', '交車時間變更通知!');
            // flash()->overlay('新增成功!','系統訊息:');
            return redirect('/admin/ord/'.$ord->id.'/edit');
        }

        public function reporter() {
            if(!role('admin') && !role('babysitter'))
                abort(403);
            /*$year=Request('year');
            if(!$year)
                $year=(int)date('Y');
            $month=Request('month');
            if(!$month)
                $month=(int)date('m');
            $list_years=array();
            for($i=date('Y');$i>date('Y')-10;$i--){
                $list_years[$i]=(int)$i;
            }
            $list_months=array();
            for($i=1;$i<=12;$i++)
                $list_months[$i]=$i;
            $ym=$year.'-'.str_pad($month,2,'0',STR_PAD_LEFT);
            $start_ords=null;
            $end_ords=null;*/

            $search_start_date=Request('search_start_date');
            $search_end_date=Request('search_end_date');
            $search_dealer_id=Request('search_dealer_id');
            if($search_dealer_id && $search_start_date && $search_end_date) {
                /*if($search_dealer_id[0]=='all'){
                    $dealers=Dealer::whereStatus(1)->select('id')->orderBy('sort')->get();
                    foreach($dealers as $key=>$dealer) {
                        $search_dealer_id[$key]=$dealer->id;
                    }
                }*/

                $start_ords = Ord::where('is_paid2',1)
                    ->where('paid2_date', '>=', $search_start_date.' 00:00:01')
                    ->where('paid2_date', '<=', $search_end_date.' 23:59:59')
                    ->whereHas('product',function($q) use($search_dealer_id){
                        $q->where('dealer_id',$search_dealer_id);
                    })
                    ->where('is_cancel', 0)
                    ->orderBy('paid2_date')
                    ->get();
                $start_carplus_commission_ords = Ord::where('is_paid2',1)
                    ->where('paid2_date', '>=', $search_start_date.' 00:00:01')
                    ->where('paid2_date', '<=', $search_end_date.' 23:59:59')
                    ->where('order_from', 1)
                    ->whereHas('product',function($q) use($search_dealer_id){
                        $q->where('dealer_id','!=',1)
                            ->where('dealer_id',$search_dealer_id);
                    })
                    ->where('is_cancel', 0)
                    ->orderBy('paid2_date')
                    ->get();

                $end_ords = Ord::where('is_paid3',1)
                    ->where('paid3_date', '>=', $search_start_date.' 00:00:01')
                    ->where('paid3_date', '<=', $search_end_date.' 23:59:59')
                    ->whereHas('product',function($q) use($search_dealer_id){
                        $q->where('dealer_id',$search_dealer_id);
                    })
                    ->where('is_cancel', 0)
                    ->orderBy('paid3_date')
                    ->get();
                $end_carplus_commission_ords = Ord::where('is_paid3',1)
                    ->where('paid3_date', '>=', $search_start_date.' 00:00:01')
                    ->where('paid3_date', '<=', $search_end_date.' 23:59:59')
                    ->where('order_from', 1)
                    ->whereHas('product',function($q) use($search_dealer_id){
                        $q->where('dealer_id','!=',1)
                            ->where('dealer_id',$search_dealer_id);
                    })
                    ->where('is_cancel', 0)
                    ->orderBy('paid3_date')
                    ->get();
                if($start_ords->count()>0 && Request('download')==1) {
                    $ord_file_name = 'Order_Reporter_'.date('Y_m_d_H_i_s').'.xlsx';
                    return Excel::download(new OrdReporterExport($search_dealer_id, $search_start_date, $search_end_date), $ord_file_name);
                }
            }
            //$list_dealers=Dealer::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('全部','all');
            $list_dealers=Dealer::whereStatus(1)->orderBy('sort')->pluck('title','id');
            return view('admin.ord.reporter',compact('search_start_date',
                'search_end_date',
                'search_dealer_id',
                'list_years',
                'list_months',
                'start_ords',
                'start_carplus_commission_ords',
                'end_ords',
                'end_carplus_commission_ords',
                'list_dealers'));
        }

    }
