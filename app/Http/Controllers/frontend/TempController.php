<?php

    namespace App\Http\Controllers\frontend;

    use App\Mail\SendMail\SendSubscriberEmail;
    use App\Model\Cate;
    use App\Model\Ord;
    use App\Model\Partner;
    use App\Model\Proarea;
    use App\Model\Product;
    use App\Model\Subcar;
    use App\Model\Subscriber;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Mail;

    class TempController extends Controller
    {

        function temp($cate_id) {
            $user=getLoginUser();
            $cate=Cate::whereStatus(1)->whereId($cate_id)->first();
            if(!$cate)
                abort(404);
            $list_proareas=Proarea::whereStatus(1)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');

            $search_proarea_id=Request('search_proarea_id');
            $product_arr=array();
            $list_partners=array();
            //先找出有此區域的車輛
            if($search_proarea_id) {
                $list_partners=Partner::whereStatus(1)->where('proarea_id',$search_proarea_id)->orderBy('sort')->pluck('title','id')->prepend('請選擇','');
                $cate_title=$cate->title;
                //如果是商用車
                if(mb_strpos($cate_title,"商用",0,"utf-8")===0) {
                    $brandin_products = Product::where('ptate_id', 3)
                        ->where('cate_id', $cate->id)
                        ->where(function($q) use ($search_proarea_id) {
                            $q->where('proarea_id', $search_proarea_id)
                                ->orWhere('proarea2_id', $search_proarea_id);
                        })
                        ->select('id','brandin_id','equipment')
                        ->groupby('brandin_id','equipment')
                        ->orderBy('equipment')
                        ->get();
                    //dd($brandin_products);
                    $new_product_arr=[];
                    //$msg='';
                    if($brandin_products->count() > 0) {
                        foreach($brandin_products as $k1=>$brandin_product) {
                            $brandin = $brandin_product->brandin;
                            if($brandin) {
                                $brandin_id = $brandin->id;
                                $years = Product::where('ptate_id', 3)
                                    ->where('cate_id', $cate->id)
                                    ->where('brandin_id', $brandin_id)
                                    ->where('equipment', $brandin_product->equipment)
                                    ->where(function($q) use ($search_proarea_id) {
                                        $q->where('proarea_id', $search_proarea_id)
                                            ->orWhere('proarea2_id', $search_proarea_id);
                                    })
                                    //->groupby('equipment','year')
                                    ->select('id','brandcat_id', 'brandin_id', 'year', 'equipment')
                                    ->take(2)
                                    ->orderBy('equipment')
                                    ->orderBy('year','DESC')
                                    ->orderBy('milage')
                                    ->get();

                                foreach($years as $k2=>$year) {
                                    //$msg .= $cnt.'->'.($k1 + 1).'->'.($k2 + 1).'->'.$year->id.'->'.$year->equipment.'->'.$year->year.'<br>';
                                    $new_product_arr[] = $year->id;
                                }

                                //dd('ok');
                                /*if($years->count() > 0) {
                                    $cnt=0;
                                    foreach($years as $year) {
                                        $products = Product::where('ptate_id', 3)
                                            ->where('cate_id', $cate->id)
                                            ->where('brandcat_id', $year->brandcat_id)
                                            ->where('brandin_id', $year->brandin_id)
                                            ->where('year', $year->year)
                                            ->where(function($q) use ($search_proarea_id) {
                                                $q->where('proarea_id', $search_proarea_id)
                                                    ->orWhere('proarea2_id', $search_proarea_id);
                                            })
                                            //->take(2)
                                            ->select('id')
                                            ->orderBy('year','milage')
                                            ->first();
                                        if($products->count()) {
                                            foreach($products as $product) {
                                                $new_product_arr[] = $product->id;
                                            }
                                        }
                                    }
                                }*/
                            }
                        }
                    }
                    if(count($new_product_arr)){
                        $new_product_arr=array_unique($new_product_arr);
                        foreach($new_product_arr as $product_id) {
                            $product=Product::whereId($product_id)
                                ->select('id', 'brandcat_id', 'brandin_id', 'partner_id', 'year', 'new_car_price', 'milage', 'procolor_id', 'displacement', 'equipment')->first();
                            $product_arr[]=$product;
                        }
                    }
                }
                else{
                    //一般非商用車輛
                    $brandin_products = Product::where('ptate_id', 3)
                        ->where('cate_id', $cate->id)
                        ->where(function($q) use ($search_proarea_id) {
                            $q->where('proarea_id', $search_proarea_id)
                                ->orWhere('proarea2_id', $search_proarea_id);
                        })
                        ->select('brandin_id')
                        ->groupby('brandin_id')
                        ->orderBy('created_at', 'DESC')
                        ->get();

                    if($brandin_products->count() > 0) {
                        foreach($brandin_products as $brandin_product) {
                            $brandin = $brandin_product->brandin;
                            if($brandin) {
                                $brandin_id = $brandin->id;
                                $year = Product::where('ptate_id', 3)
                                    ->where('cate_id', $cate->id)
                                    ->where('brandin_id', $brandin_id)
                                    ->where(function($q) use ($search_proarea_id) {
                                        $q->where('proarea_id', $search_proarea_id)
                                            ->orWhere('proarea2_id', $search_proarea_id);
                                    })
                                    ->select('brandcat_id', 'brandin_id', 'year')
                                    ->groupby('brandcat_id', 'brandin_id', 'year')
                                    ->orderBy('year', 'DESC')
                                    ->first();

                                if($year) {
                                    $product = Product::where('ptate_id', 3)
                                        ->where('cate_id', $cate->id)
                                        ->where('brandcat_id', $year->brandcat_id)
                                        ->where('brandin_id', $year->brandin_id)
                                        ->where('year', $year->year)
                                        ->where(function($q) use ($search_proarea_id) {
                                            $q->where('proarea_id', $search_proarea_id)
                                                ->orWhere('proarea2_id', $search_proarea_id);
                                        })
                                        ->orderBy('milage')
                                        ->first();
                                    if($product)
                                        $product_arr[] = $product;
                                }
                            }
                        }
                    }
                }
            }


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

            return view('frontend.temp',compact('cate','user','product_arr','search_proarea_id','list_proareas','list_partners','list_pick_up_times'));
        }

        function temp_post(Request $request) {
            //dd($request->all());
            writeLog('前台會員送出訂閱表單資訊',json_encode($request->except(['select_partner','_token'])),0);
            $user=getLoginUser();

            //取得參數
            $product_id=$request->product_id;
            $proarea_id=$request->proarea_id;
            $partner_id=$request->partner_id;
            $sub_date=$request->sub_date;
            $pick_up_time=$request->pick_up_time;

            if(!$product_id || !$proarea_id || !$partner_id || !$sub_date || !$pick_up_time)
                return redirect()->back()->with('modal_failure_message','所有欄位為必填。請確認後在繼續。')->withInput();

            $partner=Partner::whereId($partner_id)->first();
            $partner_name='';
            if($partner)
                $partner_name=$partner->title;

            //檢查是否已有訂閱單在審核中...
            $chk_subscribers=Subscriber::where('user_id',$user->id)
                ->where('is_history',0)
                ->where('is_cancel',0)
                ->whereNull('ord_id')
                ->get();
            if($chk_subscribers->count()>0)
                return redirect()->back()->with('modal_failure_message','您已有訂閱的車輛待審核，請等候審核結果，目前無法再訂閱此車。')->withInput();

            //檢查排除自己的訂閱單之外，是否已有非取消及非隱藏，但已有此車輛ID出現
            $chk_subscribers=Subscriber::where('user_id','!=',$user->id)
                ->where('product_id',$product_id)
                ->where('is_history',0)
                ->where('is_cancel',0)
                ->get();
            if($chk_subscribers->count()>0)
                return redirect()->back()->with('modal_failure_message','非常抱歉！此車輛已被訂閱，請選擇其它車輛。')->withInput();

            //檢查是否已有訂單未繳保證金
            $chk_ord=Ord::where('user_id',$user->id)
                ->where('is_cancel',0)
                ->where('state_id',1)
                ->get();
            if($chk_ord->count()>0)
                return redirect()->back()->with('modal_failure_message','您已有訂單保證金未付，目前無法再訂閱此車。')->withInput();

            //檢查目前車輛是否可訂閱
            $product=Product::whereId($product_id)
                ->where('ptate_id',3)
                ->first();
            if(!$product)
                return redirect()->back()->with('modal_failure_message','非常抱歉！此車輛已被訂閱，請選擇其它車輛。')->withInput();

            //檢查訂單內是否已有此車輛ID, 檢查此車輛是否可供訂閱
            $chk_ord=Ord::where('product_id',$product_id)
                ->where('state_id','<',11)
                ->where('is_cancel',0)
                ->first();
            if($chk_ord) {
                $product=Product::whereId($product_id)->first();
                if($chk_ord->is_paid==1)
                    $product->ptate_id=2;
                else
                    $product->ptate_id=1;
                $product->update();
                return redirect()->back()->with('modal_failure_message', '非常抱歉！此車輛已被訂閱，請選擇其它車輛。')->withInput();
            }

            //檢查方案是否錯誤
            $cate_id=$request->cate_id;
            $cate=Cate::whereId($cate_id)->first();
            if(!$cate)
                return redirect()->back()->with('modal_failure_message','方案錯誤，請洽保姆為您服務')->withInput();


            //產生訂閱單
            $subscriber=new Subscriber();
            $subscriber->cate_id=$cate_id;
            $subscriber->user_id=$user->id;
            $subscriber->proarea_id=$proarea_id;
            $subscriber->partner_id=$partner_id;

            //訂閱來源：Sealand
            $subscriber->order_from=2;

            $subscriber->delivery_address=$partner_name;
            $subscriber->return_delivery_address=$partner_name;
            $subscriber->sub_date=$sub_date;
            $subscriber->pick_up_time=$pick_up_time;
            $subscriber->product_id = $product_id;
            $subscriber->save();
            //$subscriber=Subscriber::whereId(104)->first();
            $subcar = new Subcar();
            $subcar->cate_id = $cate_id;
            $subcar->user_id = $user->id;
            $subcar->subscriber_id = $subscriber->id;
            $subcar->save();

            //車輛設定為出租中
            $product->ptate_id=1;
            $product->update();

            //如果是持居留證，則直接PASS給格上及保姆
            if($product->dealer_id!=1) {
                //非格上車輛, 只寄給保姆
                $partner=$product->partner;
                send_babysitter_subscriber_email($subscriber, $user->name.' ('.$partner->title.') 訂閱審核通知','ry1');
                writeLog(' (總經銷) 訂閱審核通知 已成功寄給保姆','會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id,0);
                session()->flash('modal_success_message', '親愛的會員您好，您的訂閱資料已送出，目前已在審核中，審核結果將由信件通知您。謝謝!!');
                return redirect('/');
            }
            elseif($user->id_type==2){
                //格上車輛, 寄給保姆
                send_babysitter_subscriber_email($subscriber, $user->name.' (持居留證) 訂閱審核通知', 'ry1');

                writeLog(' (持居留證) 訂閱審核通知 已成功寄給保姆','會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id,0);

                //格上車輛, 寄給格上徵信
                $car_plus_email01 = setting('car_plus_email01');
                if($car_plus_email01)
                    Mail::send(new SendSubscriberEmail($subscriber, $car_plus_email01, '格上審核窗口', '(持居留證) 訂閱審核通知', 'ry1'));
                $car_plus_email02 = setting('car_plus_email02');
                if($car_plus_email02)
                    Mail::send(new SendSubscriberEmail($subscriber, $car_plus_email02, '格上審核窗口', '(持居留證) 訂閱審核通知', 'ry1'));

                writeLog(' (持居留證) 訂閱審核通知 已成功寄給格上徵信','會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id,0);
                session()->flash('modal_success_message', '親愛的會員您好，您的訂閱資料已送出，目前已在審核中，審核結果將由信件通知您。謝謝!!');

                return redirect('/');
            }

            //準備串 API
            $ApplyReason=0;
            if($user->applyreason=='初發')
                $ApplyReason=1;
            elseif($user->applyreason=='補發')
                $ApplyReason=2;
            elseif($user->applyreason=='換發')
                $ApplyReason=3;
            if($ApplyReason==0)
                return redirect()->back()->with('modal_failure_message','身份證領補換類別錯誤，請洽保姆為您服務')->withInput();

            $TransactionNumber=Carbon::now()->format('ymd').rand(10000,99999);

            //取得台灣生日格式
            $chinese_birthday=getChineseBirthday($user->birthday);
            $apply_date=str_pad($user->id_year,3,"0",STR_PAD_LEFT).str_pad($user->id_month,2,"0",STR_PAD_LEFT).str_pad($user->id_day,2,"0",STR_PAD_LEFT);
            $data_arr=[
                "Version"=>"01.00",
                "Token"=> env('CARPULS_TOKEN'),
                "MessageType"=>'CreditCheck',
                "lastUpdatedDateTime"=>date('YmdHis'),
                "TransactionNumber"=>$TransactionNumber,
                "TransactionDateTime"=>date('YmdHis').rand(10,99),
                "CreditCheckRequest"=>[
                    "MonthlyPay"=> $cate->basic_fee,
                    "DeliveryLocation"=> $partner_name,
                    "QueryNumber"=>"$subscriber->id",
                    "Name"=>$user->name,
                    "ApplyReason"=>"$ApplyReason",
                    "LicenseID"=>$user->idno,
                    "LicenseType"=>'1',
                    "AuthorityID"=>$user->driver_no,
                    "Birthday"=>$chinese_birthday,
                    "ApplyDate"=>$apply_date,
                    "SiteId"=>$user->ssite?$user->ssite->code:0,
                ],
            ];
            $json = json_encode($data_arr,JSON_UNESCAPED_UNICODE);
            $url=env('CARPULS_URL');
            try {
                //送出格上串接API...
                $ret_code = carplus_api($url, $json);
                //回應結果
                $result = json_decode($ret_code['result']);

                $ResultCode = $result->ResultCode;
                //$ResultCode='1';
                $ResultMessage = $result->ResultMessage;
                //$ResultMessage='通過';

                //更新 api 結果
                $subscriber->ret_code = $ResultCode;
                $subscriber->ret_message = $ResultMessage;
                //$subscriber->json = $json;
                $subscriber->json = $json;
                $subscriber->update();
                //如果通過
                if($ResultCode == '1') {
                    //產生訂單
                    $cate = $subscriber->cate;
                    $product = $subscriber->product;
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
                    $ord->subscriber_id = $subscriber->id;
                    $ord->cate_id = $cate->id;
                    $ord->cate_title = $cate->title;
                    $ord->partner_id = $product->partner_id;
                    $ord->partner2_id = $product->partner2_id;
                    $ord->partner3_id = $subscriber->partner_id;

                    //訂閱來源：Sealand
                    $ord->order_from = 2;

                    $ord->is_carplus = $is_carplus;
                    $ord->product_id = $product->id;
                    $ord->delivery_address = $subscriber->delivery_address;
                    $ord->return_delivery_address = $subscriber->return_delivery_address;
                    $ord->model = $product->model;
                    $ord->plate_no = $product->plate_no;
                    $ord->proarea_id = $proarea_id;
                    $ord->pick_up_time = $subscriber->pick_up_time;
                    $ord->sub_date = $subscriber->sub_date;
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
                    if($user->is_change_car == 1) {
                        $ord->is_renew_change_order = 1;
                        $ord->renew_ord_id = $user->before_renew_change_car_ord_id;
                        //將原訂單的續約狀態改為5
                        $before_renew_change_car_ord = Ord::whereId($user->before_renew_change_car_ord_id)->first();
                        if($before_renew_change_car_ord) {
                            $before_renew_change_car_ord->is_renewtate_setting_finish = 1;
                            $before_renew_change_car_ord->update();
                        }
                        $ord->renew_ord_no = $user->before_renew_change_car_ord_no;
                    }
                    $ord->save();

                    $product->ord_id = $ord->id;
                    $product->ptate_id = 1;
                    $product->update();

                    $subscriber->ord_id = $ord->id;
                    $subscriber->is_my2_email = 1;
                    $subscriber->is_history = 1;
                    $subscriber->can_order_car = 1;
                    $subscriber->update();
                    send_babysitter_subscriber_email($subscriber, $user->name.' 方案審核通過通知', 'cy2');
                    writeLog('方案審核通過 通知已成功寄給保姆', '會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id.' → is_my2_email=1');
                    writeLog(' API 審核已通過並產生訂單， 並已寄Email通知給保姆', '會員姓名：'.$user->name.' 訂單 ID：'.$ord->id.' 訂單編號：'.$ord->ord_no, 0);

                    /*session()->flash('modal_success_title_color', 'green');
                    session()->flash('modal_success_title', '審核通過');
                    session()->flash('modal_success_message', '您好，您的審核已通過<br>請審閱相關文件，並於時效內付清保證金<br>即完成您的訂閱！');*/

                    //return redirect('/ord/'.$ord->id);
                    return redirect('/checkout_direct_pay/'.$ord->ord_no);
                }
                elseif($ResultCode == '0' || $ResultCode == '2' || $ResultCode == '3') {
                    //法務待確認
                    //寄給保姆
                    send_babysitter_subscriber_email($subscriber, $user->name.' 待確認(法務待確認或罰單未繳)通知', 'ry1');
                    writeLog($user->name.' 法務訂閱待確認通知 已寄給保姆', '會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id, 0);

                    //寄給格上徵信
                    $car_plus_email01 = setting('car_plus_email01');
                    if($car_plus_email01)
                        Mail::send(new SendSubscriberEmail($subscriber, $car_plus_email01, '格上審核窗口', $user->name.' / 待確認(法務待確認或罰單未繳)通知', 'ry1'));
                    $car_plus_email02 = setting('car_plus_email02');
                    if($car_plus_email02)
                        Mail::send(new SendSubscriberEmail($subscriber, $car_plus_email02, '格上審核窗口', $user->name.' / 待確認(法務待確認或罰單未繳)通知', 'ry1'));
                    writeLog($user->name.' 法務訂閱待確認通知 已寄給格上徵信', '會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id, 0);
                    session()->flash('modal_success_title_color', 'orange');
                    session()->flash('modal_success_title', '待確認');
                    session()->flash('modal_success_message', '您的訂閱審核結果將由信件通知，請等候信件通知，謝謝您!!');

                    return redirect('/');
                } elseif($ResultCode == '-1') {
                    //寄給保姆
                    send_babysitter_subscriber_email($subscriber, $user->name.' 方案API回覆：伺服器錯誤通知', 'mn2');
                    writeLog($user->name.' 方案API回覆：系統異常通知 已寄給保姆', '會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id, 0);
                    session()->flash('modal_success_title_color', 'orange');
                    session()->flash('modal_success_title', '伺服器錯誤');
                    session()->flash('modal_success_message', '請撥打客服專線，由專人為您服務，謝謝！');

                    return redirect('/');
                } else {
                    //寄給保姆
                    send_babysitter_subscriber_email($subscriber, $user->name.' 方案API審核未通過通知', 'mn2');
                    writeLog($user->name.' 方案API審核未通過通知 已寄給保姆', '會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id, 0);
                    session()->flash('modal_success_title_color', 'orange');
                    session()->flash('modal_success_title', '未通過');
                    session()->flash('modal_success_message', '您好，您的審核未通過，如有需要，請撥打客服專線。');

                    return redirect('/');
                }
            }
            catch(\Exception $e){
                //法務待確認
                //寄給保姆
                send_babysitter_subscriber_email($subscriber, $user->name.' 待確認(法務待確認、罰單未繳或API串接錯誤)通知', 'ry1');
                writeLog($user->name.' 法務訂閱待確認通知 已寄給保姆', '會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id, 0);

                //寄給格上徵信
                $car_plus_email01 = setting('car_plus_email01');
                if($car_plus_email01)
                    Mail::send(new SendSubscriberEmail($subscriber, $car_plus_email01, '格上審核窗口', $user->name.' / 待確認(法務待確認、罰單未繳或API串接錯誤)通知', 'ry1'));
                $car_plus_email02 = setting('car_plus_email02');
                if($car_plus_email02)
                    Mail::send(new SendSubscriberEmail($subscriber, $car_plus_email02, '格上審核窗口', $user->name.' / 待確認(法務待確認、罰單未繳或API串接錯誤)通知', 'ry1'));
                writeLog($user->name.' 法務訂閱待確認通知 已寄給格上徵信', '會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id, 0);
                session()->flash('modal_success_title_color', 'orange');
                session()->flash('modal_success_title', '待確認');
                session()->flash('modal_success_message', '您的訂閱審核結果將由信件通知，請等候信件通知，謝謝您!!');

                return redirect('/');
            }
        }
    }
