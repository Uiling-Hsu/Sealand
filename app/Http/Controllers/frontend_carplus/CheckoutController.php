<?php

    namespace App\Http\Controllers\frontend;

    use App\Mail\OrdPartnerFinishedDeliveryCarNotifyPlaced;
    use App\Mail\OrdPlaced2;
    use App\Mail\OrdPlaced3;
    use App\Mail\SendMail\SendOrdEmail;
    use App\Mail\SendMail\SendOrdPlaceEmail;
    use App\Model\Ord;
    use App\Model\OrddailyQty;
    use App\Model\Period;
    use App\Model\Product;
    use App\Mail\OrdPlaced;
    use App\Model\OrdProduct;
    use App\Model\Paymenttype;
    use App\Model\Setting;
    use App\Model\Shippingtype;
    use Carbon\Carbon;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Mail;
    use Gloudemans\Shoppingcart\Facades\Cart;
    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Session;

    //use Cartalyst\Stripe\Exception\CardErrorException;
    //use Ecpay;


    class CheckoutController extends Controller
    {
        public function checkout_direct_pay($ord_no) {
            $ord=Ord::where('ord_no',$ord_no)->first();
            $user=getLoginUser();
            if($user->id!=$ord->user_id)
                return redirect()->back()->with('modal_failure_message','沒有發現可付款的訂單，請聯絡保姆為您查詢。');
            return view('frontend.checkout_direct_pay',compact('ord'));
        }

        public function creditPaid(Request $request)
        {
            //dd($request->all());
            $ord_id=$request->ord_id;
            $ord=Ord::whereId($ord_id)->first();
            if(!$ord)
                return redirect()->back()->with('modal_failure_message','沒有發現可付款的訂單，請聯絡保姆為您查詢。');
            if($ord->is_cancel==1)
                return redirect()->back()->with('modal_failure_message','此訂單已取消，如有問題請聯絡保姆提供進一步查詢。');

            //檢查訂單是否已失效
            /*$time2=date('Y-m-d H:i:s');
            $time1=$ord->created_at;
            $diff=(strtotime($time2) - strtotime($time1)) / 60;
            //if($diff>30)
            if($ord->is_pass_by_api==1)
                $limit_minutes=30;
            else
                $limit_minutes=480;

            if($diff > $limit_minutes)
                return redirect()->back()->with('modal_failure_message','您的訂單已過期失效，請再重新訂閱及送審。');*/

            $cate=$ord->cate;
            if(!$cate)
                return redirect()->back()->with('modal_failure_message','沒有發現可付款的訂單，請聯絡保姆為您查詢。');

            //重新給一組結帳單號, 避免重新刷卡造成訂單號碼重複而無法結帳
            $checkout_no=Carbon::now()->format('ymd').rand(10000,99999);
            $ord->checkout_no=$checkout_no;
            $ord->update();
            $user=$ord->user;
            writeLog('刷卡前產生保證金結帳單號','ID:'.$user->id.', 會員姓名：'.$user->name.', 訂單編號：'.$ord->ord_no.', 保證金結帳單號：'.$ord->checkout_no);

            //藍星
            /* 金鑰與版本設定 */
            $MerchantID = env('NEWEBPAY_MERCHANT_ID');
            $HashKey = env('NEWEBPAY_HASH_KEY');
            $HashIV = env('NEWEBPAY_HASH_IV');
            $URL = env('NEWEBPAY_URL');
            $ReturnURL = env('CARPLUS_NEWEBPAY_RETURN_URL');
            $NotifyURL = env('CARPLUS_NEWEBPAY_NOTIFY_URL');
            $VER = env('NEWEBPAY_VER');

            /* 送給藍新資料 */
            $trade_info_arr = array(
                'MerchantID' => $MerchantID,
                'RespondType' => 'JSON',
                'TimeStamp' => time(),
                'Version' => $VER,
                'MerchantOrderNo' => $ord->checkout_no,
                'Amt' => $ord->deposit,
                'ItemDesc' => '付訂閱方案：'.$cate->title.' 保證金',
                'CREDIT' => 1,
                'VACC' => 0,//ATM
                'ReturnURL' => $ReturnURL, //支付完成 返回商店網址
                'NotifyURL' => $NotifyURL, //支付通知網址
            );

            $TradeInfo = create_mpg_aes_encrypt($trade_info_arr, $HashKey, $HashIV);
            $SHA256 = strtoupper(hash("sha256", SHA256($HashKey,$TradeInfo,$HashIV)));
            echo CheckOut($URL,$MerchantID,$TradeInfo,$SHA256,$VER);

            //台新
            /*$deposit=$ord->deposit * 100;
            $data_arr=[
                "ver"=>"1.0.0",
                "sender"=>"rest",
                "mid"=>env('TSPG_MID'),
                "pay_type"=>1,
                "tx_type"=>1,
                "params"=>[
                    "layout"=>"1",
                    "order_no"=>$checkout_no,
                    "cur"=>"NTD",
                    "install_period"=>"",
                    "post_back_url"=>env('TSPG_POST_BACK_URL'),
                    "result_url"=>env('TSPG_RESULT_URL'),
                    "capt_flag"=>"1",
                    "result_flag"=>"1",
                    "amt"=>"$deposit",
                    "order_desc"=>""
                ],
                "tid"=>env('TSPG_TID')
            ];

            $payload = json_encode($data_arr);
            // Prepare new cURL resource
            $ch = curl_init(env('TSPG_API_ROOT'));
            //$ch = curl_init('https://www.r4d.com.tw');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            // Set HTTP Header for POST request
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: '. strlen($payload))
            );

            // Submit the POST request
            $result = curl_exec($ch);
            // Close cURL session handle
            curl_close($ch);
            $result_arr=json_decode($result);
            if($result_arr){
                $params=$result_arr->params;
                $ret_code=$params->ret_code;
                $hpp_url=$params->hpp_url;
                if($ret_code=="00" && $hpp_url){
                    return redirect($hpp_url);
                }
                else{
                    return redirect()->back()->with('modal_failure_messsage','信用卡刷卡驗證失敗，請洽客服人員！');
                }
            }
            else{
                return redirect()->back()->with('modal_failure_messsage','信用卡刷卡驗證失敗，請洽客服人員！');
            }*/

        }

        public function newebpay_return(Request $request)
        {
            //藍星
            $tradeInfo = file_get_contents("php://input");
            $arr = mb_split("&",$tradeInfo);
            $get_aes = str_replace("TradeInfo=","",$arr[3]);
            $data = create_aes_decrypt($get_aes,env('NEWEBPAY_HASH_KEY'),env('NEWEBPAY_HASH_IV'));
            $json = json_decode($data);
            $result=$json->Result;
            $checkout_no=$result->MerchantOrderNo;
            $status=$json->Status;
            $message=$json->Message;
            $ord = Ord::where('checkout_no', $checkout_no)->first();
            if($ord) {
                if($status=="SUCCESS") {
                    $ord->state_id = 2;
                    $ord->is_paid = 1;
                    $ord->paid_date = date('Y-m-d H:i:s');
                    $ord->is_creditpay_success = 1;
                    $ord->creditpay_return_code = $status;
                    $ord->creditpay_return_message = $message;
                    $ord->update();
                    //商品下架
                    $product = $ord->product;
                    if($product) {
                        $product->ptate_id = 2;
                        $product->update();
                    }

                    return redirect('/thankyou/'.$ord->ord_no)->with('modal_success_message', '線上刷卡成功，您的訂單編號：'.$ord->ord_no);
                }
                else {
                    $ord->creditpay_return_code = $status;
                    $ord->creditpay_return_message = $message;
                    $ord->update();

                    return redirect('/failure/'.$message)->with('modal_failure_message', '線上刷卡失敗，'.$message);
                }
            }
            else
                return redirect('/failure/找不到相關訂單')->with('modal_failure_message', '線上刷卡失敗，找不到相關訂單');

            //台新
            /*$ret_code=$request->ret_code;
            $ord = Ord::where('checkout_no', $request->order_no)->first();
            if($ord) {
                if($ret_code=="00") {
                    $ord->state_id = 2;
                    $ord->is_paid = 1;
                    $ord->paid_date = date('Y-m-d H:i:s');
                    $ord->update();
                    //商品下架
                    $product = $ord->product;
                    if($product) {
                        $product->ptate_id = 2;
                        $product->update();
                    }
                    return redirect('/thankyou/'.$ord->ord_no)->with('modal_success_message', '線上刷卡成功，您的訂單編號：'.$ord->ord_no);
                }
                else {
                    $ord->creditpay_return_code = $request->ret_code;
                    $ord->creditpay_return_message = $request->ret_msg;
                    $ord->update();

                    return redirect('/failure/'.$request->ret_msg)->with('modal_failure_message', '線上刷卡失敗，'.$request->ret_msg);
                }
            }
            else
                return redirect('/failure/找不到相關訂單')->with('modal_failure_message', '線上刷卡失敗，找不到相關訂單');*/

        }


        public function newebpay_notify(Request $request)
        {
            //藍星
            $tradeInfo = file_get_contents("php://input");
            $arr = mb_split("&",$tradeInfo);
            $get_aes = str_replace("TradeInfo=","",$arr[3]);
            $data = create_aes_decrypt($get_aes,env('NEWEBPAY_HASH_KEY'),env('NEWEBPAY_HASH_IV'));
            $json = json_decode($data);
            $result=$json->Result;
            $checkout_no=$result->MerchantOrderNo;
            $status=$json->Status;
            $message=$json->Message;
            $ord = Ord::where('checkout_no', $checkout_no)->first();
            if($ord) {
                if($status=="SUCCESS") {
                    $ord->state_id = 2;
                    $ord->is_paid = 1;
                    $ord->paid_date = date('Y-m-d H:i:s');
                    $ord->is_creditpay_success = 1;
                    $ord->creditpay_return_code = $status;
                    $ord->creditpay_return_message = $message;
                    $ord->update();

                    //商品下架
                    $product = $ord->product;
                    if($product) {
                        $partner3_id=$ord->partner3_id;
                        $partner_id=$ord->partner_id;
                        if($partner3_id && $partner3_id!=$partner_id){
                            $partner2_id=$ord->partner2_id;
                            $product->partner_id = $partner3_id;
                            $product->partner2_id = $partner_id;
                            $ord->partner_id = $partner3_id;
                            $ord->partner2_id = $partner_id;
                            $ord->update();
                        }
                        $product->ptate_id=2;
                        $product->update();
                    }
                    if($ord->is_paid_send_email==0) {
                        //先判斷此車是否為換車的續約單
                        $user = $ord->user;
                        $msg='';
                        if($user->is_change_car == 1) {
                            //換車續約單
                            //寄給會員
                            Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name, '訂閱換車通知', 'my8-2'));
                            //寄給保姆
                            $msg.='my8-2→會員、';
                            $partner = $ord->partner;
                            $store_name = setting('store_name');
                            for($i = 1; $i <= 4; $i++) {
                                $email = setting('email0'.$i);
                                if($email)
                                    Mail::send(new SendOrdPlaceEmail($ord, $email, $store_name, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 訂閱換車通知', 'ry8-2'));
                            }
                            $msg.='保姆ry8-2、';
                            //寄給經銷商
                            if($partner) {
                                if($partner->email)
                                    Mail::send(new SendOrdPlaceEmail($ord, $partner->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 訂閱換車通知', 'ry8-2'));
                                if($partner->partneremails->count() > 0) {
                                    foreach($partner->partneremails as $partneremail) {
                                        if($partneremail->email)
                                            Mail::send(new SendOrdPlaceEmail($ord, $partneremail->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 訂閱換車通知', 'ry8-2'));
                                    }
                                }
                                $msg.='ry8-2→經銷商、';
                            }
                            $partner2 = $ord->partner2;
                            if($partner2) {
                                if($partner2->email)
                                    Mail::send(new SendOrdPlaceEmail($ord, $partner2->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' 訂閱換車通知', 'ry8-2'));
                                if($partner2->partneremails->count() > 0) {
                                    foreach($partner2->partneremails as $partneremail) {
                                        if($partneremail->email)
                                            Mail::send(new SendOrdPlaceEmail($ord, $partneremail->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' 訂閱換車通知', 'ry8-2'));
                                    }
                                }
                                $msg.='ry8-2→原車所、';
                            }
                            //
                            $user->is_change_car = 0;
                            $user->before_renew_change_car_ord_id = null;
                            $user->before_renew_change_car_ord_no = null;
                            $user->update();
                        } else {
                            //不是換車續約單
                            //寄給會員
                            Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name, '保證金付清通知', 'my3'));
                            $msg.='my3→會員、';
                            //寄給保姆
                            $partner = $ord->partner;
                            $store_name = setting('store_name');
                            for($i = 1; $i <= 4; $i++) {
                                $email = setting('email0'.$i);
                                if($email)
                                    Mail::send(new SendOrdPlaceEmail($ord, $email, $store_name, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知', 'cy3'));
                            }
                            $msg.='cy3→保姆、';
                            //寄給經銷商
                            if($partner) {
                                if($partner->email)
                                    Mail::send(new SendOrdPlaceEmail($ord, $partner->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知', 'ry3'));
                                if($partner->partneremails->count() > 0) {
                                    foreach($partner->partneremails as $partneremail) {
                                        if($partneremail->email)
                                            Mail::send(new SendOrdPlaceEmail($ord, $partneremail->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知', 'ry3'));
                                    }
                                }
                                $msg.='ry3→經銷商、';
                            }
                            $partner2 = $ord->partner2;
                            if($partner2) {
                                if($partner2->email)
                                    Mail::send(new SendOrdPlaceEmail($ord, $partner2->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知', 'ry3'));
                                if($partner2->partneremails->count() > 0) {
                                    foreach($partner2->partneremails as $partneremail) {
                                        if($partneremail->email)
                                            Mail::send(new SendOrdPlaceEmail($ord, $partneremail->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知', 'ry3'));
                                    }
                                }
                                $msg.='ry3→原車所、';
                            }
                        }
                        $ord->is_paid_send_email=1;
                        $ord->update();
                        writeLog('保證金付款成功，並寄Email：'.$msg, '訂單ID：'.$ord->id.' 會員ID：'.$ord->user_id.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id, 0);
                    }

                } else {
                    $ord->creditpay_return_code = $status;
                    $ord->creditpay_return_message = $message;
                    $ord->update();
                }
            }


            //台新
            /*$inputs=$request->json()->all();
            $setting=Setting::where('key','json')->first();
            $setting->val=json_encode($inputs);
            $setting->update();
            //echo json_encode($inputs['params']);

            if($inputs) {
                $params = $inputs['params'];
                $ret_code = $params['ret_code'];
                $ret_msg = $params['ret_msg'];
                $order_no = $params['order_no'];
                $order_status = $params['order_status'];
                $ord = Ord::where('checkout_no', $order_no)->first();
                if($ord) {
                    if($ret_code == "00") {
                        $ord->state_id = 2;
                        $ord->is_paid = 1;
                        $ord->paid_date = date('Y-m-d H:i:s');
                        $ord->is_creditpay_success = 1;
                        $ord->creditpay_return_code = $ret_code;
                        $ord->creditpay_return_message = $ret_msg;
                        $ord->update();
                        writeLog('保證金付款成功，並寄Email給消費者、保姆及經銷商', '訂單ID：'.$ord->id.' 會員ID：'.$ord->user_id, 0);
                        //商品下架
                        $product = $ord->product;
                        if($product) {
                            $partner3_id=$ord->partner3_id;
                            $partner_id=$ord->partner_id;
                            if($partner3_id && $partner3_id!=$partner_id){
                                $partner2_id=$ord->partner2_id;
                                $product->partner_id = $partner3_id;
                                $product->partner2_id = $partner_id;
                                $ord->partner_id = $partner3_id;
                                $ord->partner2_id = $partner_id;
                                $ord->update();
                            }
                            $product->ptate_id=2;
                            $product->update();
                        }
                        //會員
                        Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name, '保證金付清通知', 'my3'));
                        //保姆
                        $partner=$ord->partner;
                        $user=$ord->user;
                        send_babysitter_ord_email($ord,$partner->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知', 'cy3');

                        //經銷商
                        if($partner){
                            if($partner->email)
                                Mail::send(new SendOrdPlaceEmail($ord, $partner->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知','ry3'));
                            if($partner->partneremails->count()>0) {
                                foreach($partner->partneremails as $partneremail) {
                                    if($partneremail->email)
                                        Mail::send(new SendOrdPlaceEmail($ord, $partneremail->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知','ry3'));
                                }
                            }
                        }
                        $partner2=$ord->partner2;
                        if($partner2) {
                            if($partner2->email)
                                Mail::send(new SendOrdPlaceEmail($ord, $partner2->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知','ry3'));
                            if($partner2->partneremails->count() > 0) {
                                foreach($partner2->partneremails as $partneremail) {
                                    if($partneremail->email)
                                        Mail::send(new SendOrdPlaceEmail($ord, $partneremail->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知','ry3'));
                                }
                            }
                        }
                    } else {
                        $ord->creditpay_return_code = $ret_code;
                        $ord->creditpay_return_message = $ret_msg;
                        $ord->update();
                    }
                }
            }*/
        }

        public function creditPaid2(Request $request)
        {
            //dd($request->all());
            $ord_id=$request->ord_id;
            $ord=Ord::whereId($ord_id)->first();
            if(!$ord)
                return redirect()->back()->with('modal_failure_message','沒有發現可付款的訂單，請聯絡保姆為您查詢。');
            //dd($ord);

            if($ord->is_paid==0){
                return redirect()->back()->with('modal_failure_message','您必需先付保證金後才能交付起租款');
            }

            if($ord->is_paid2==1){
                return redirect()->back()->with('modal_failure_message','您已經繳過起租款，無需再次繳款。');
            }

            $cate=$ord->cate;
            if(!$cate)
                return redirect()->back()->with('modal_failure_message','沒有發現可付款的訂單，請聯絡保姆為您查詢。');

            //重新給一組結帳單號, 避免重新刷卡造成訂單號碼重複而無法結帳
            $checkout_no2=Carbon::now()->format('ymd').rand(10000,99999);
            $ord->checkout_no2=$checkout_no2;
            $ord->update();
            $user=$ord->user;
            writeLog('刷卡前產生起租款結帳單號','ID:'.$user->id.', 會員姓名：'.$user->name.', 訂單編號：'.$ord->ord_no.', 起租款結帳單號：'.$ord->checkout_no2);

            //藍星
            /* 金鑰與版本設定 */
            $MerchantID = env('NEWEBPAY_MERCHANT_ID');
            $HashKey = env('NEWEBPAY_HASH_KEY');
            $HashIV = env('NEWEBPAY_HASH_IV');
            $URL = env('NEWEBPAY_URL');
            $ReturnURL = env('CARPLUS_NEWEBPAY_RETURN_URL');
            $NotifyURL = env('CARPLUS_NEWEBPAY_NOTIFY_URL');
            $VER = env('NEWEBPAY_VER');

            /* 送給藍新資料 */
            $trade_info_arr = array(
                'MerchantID' => $MerchantID,
                'RespondType' => 'JSON',
                'TimeStamp' => time(),
                'Version' => $VER,
                'MerchantOrderNo' => $ord->checkout_no2,
                'Amt' => $ord->payment_total,
                'ItemDesc' => '付訂閱方案：'.$cate->title.'起租款',
                'CREDIT' => 1,
                'VACC' => 0,//ATM
                'ReturnURL' => $ReturnURL.'2', //支付完成 返回商店網址
                'NotifyURL' => $NotifyURL.'2', //支付通知網址
            );

            $TradeInfo = create_mpg_aes_encrypt($trade_info_arr, $HashKey, $HashIV);
            $SHA256 = strtoupper(hash("sha256", SHA256($HashKey,$TradeInfo,$HashIV)));
            echo CheckOut($URL,$MerchantID,$TradeInfo,$SHA256,$VER);

            //台新
            /*$payment_total=$ord->payment_total * 100;
            $data_arr=[
                "ver"=>"1.0.0",
                "sender"=>"rest",
                "mid"=>env('TSPG_MID'),
                "pay_type"=>1,
                "tx_type"=>1,
                "params"=>[
                    "layout"=>"1",
                    "order_no"=>$checkout_no2,
                    "cur"=>"NTD",
                    "install_period"=>"",
                    "post_back_url"=>env('TSPG_POST_BACK_URL').'2',
                    "result_url"=>env('TSPG_RESULT_URL').'2',
                    "capt_flag"=>"1",
                    "result_flag"=>"1",
                    "amt"=>"$payment_total",
                    "order_desc"=>""
                ],
                "tid"=>env('TSPG_TID')
            ];

            $payload = json_encode($data_arr);

            // Prepare new cURL resource
            $ch = curl_init(env('TSPG_API_ROOT'));
            //$ch = curl_init('https://www.r4d.com.tw');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            // Set HTTP Header for POST request
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: '. strlen($payload))
            );

            // Submit the POST request
            $result = curl_exec($ch);
            // Close cURL session handle
            curl_close($ch);
            $result_arr=json_decode($result);
            if($result_arr){
                $params=$result_arr->params;
                $ret_code=$params->ret_code;
                $hpp_url=$params->hpp_url;
                if($ret_code=="00" && $hpp_url){
                    return redirect($hpp_url);
                }
                else{
                    return redirect()->back()->with('modal_failure_messsage','信用卡刷卡驗證失敗，請洽客服人員！');
                }
            }
            else{
                return redirect()->back()->with('modal_failure_messsage','信用卡刷卡驗證失敗，請洽客服人員！');
            }*/
        }

        public function newebpay_return2(Request $request)
        {
            //藍星
            $tradeInfo = file_get_contents("php://input");
            $arr = mb_split("&",$tradeInfo);
            $get_aes = str_replace("TradeInfo=","",$arr[3]);
            $data = create_aes_decrypt($get_aes,env('NEWEBPAY_HASH_KEY'),env('NEWEBPAY_HASH_IV'));
            $json = json_decode($data);
            $result=$json->Result;
            $checkout_no2=$result->MerchantOrderNo;
            $status=$json->Status;
            $message=$json->Message;
            $ord = Ord::where('checkout_no2', $checkout_no2)->first();
            if($ord) {
                if($status == "SUCCESS") {
                    $ord->real_sub_date = date('Y-m-d');
                    $ord->real_sub_time = date('H:i:s');
                    //$ord->expiry_date = date('Y-m-d', strtotime($ord->real_sub_date.' +89 day'));
                    //$ord->expiry_time = date('H:i:s');

                    $ord->is_paid2 = 1;
                    $ord->paid2_date = date('Y-m-d H:i:s');
                    $ord->state_id = 5;
                    $ord->update();

                    //Mail::send(new OrdPlaced($ord));
                    return redirect('/thankyou/'.$ord->ord_no)->with('modal_success_message', '線上刷卡成功，您的訂單編號：'.$ord->ord_no);
                } else {
                    $ord = Ord::where('checkout_no2', $checkout_no2)->first();
                    $ord->creditpay_return_code2 = $status;
                    $ord->creditpay_return_message2 = $message;
                    $ord->update();

                    return redirect('/failure/'.$message)->with('modal_failure_message', $message);
                }
            }
            else
                return redirect('/failure/找不到相關訂單')->with('modal_failure_message', '線上刷卡失敗，找不到相關訂單');

            //台新
            /*$ret_code=$request->ret_code;
            $ord = Ord::where('checkout_no2', $request->order_no)->first();
            if($ord) {
                if($ret_code == "00") {
                    $ord->real_sub_date = date('Y-m-d');
                    $ord->real_sub_time = date('H:i:s');
                    //$ord->expiry_date = date('Y-m-d', strtotime($ord->real_sub_date.' +89 day'));
                    //$ord->expiry_time = date('H:i:s');

                    $ord->is_paid2 = 1;
                    $ord->paid2_date = date('Y-m-d H:i:s');
                    $ord->state_id = 5;
                    $ord->update();

                    //Mail::send(new OrdPlaced($ord));
                    return redirect('/thankyou/'.$ord->ord_no)->with('modal_success_message', '線上刷卡成功，您的訂單編號：'.$ord->ord_no);
                } else {
                    $ord->creditpay_return_code2 = $request->ret_code;
                    $ord->creditpay_return_message2 = $request->ret_msg;
                    $ord->update();

                    return redirect('/failure/'.$request->ret_msg)->with('modal_failure_message', $request->ret_msg);
                }
            }
            else
                return redirect('/failure/找不到相關訂單')->with('modal_failure_message', '線上刷卡失敗，找不到相關訂單');*/

        }


        public function newebpay_notify2(Request $request)
        {
            //藍星
            $tradeInfo = file_get_contents("php://input");
            $arr = mb_split("&",$tradeInfo);
            $get_aes = str_replace("TradeInfo=","",$arr[3]);
            $data = create_aes_decrypt($get_aes,env('NEWEBPAY_HASH_KEY'),env('NEWEBPAY_HASH_IV'));
            $json = json_decode($data);
            $result=$json->Result;
            $checkout_no2=$result->MerchantOrderNo;
            $status=$json->Status;
            $message=$json->Message;
            $ord = Ord::where('checkout_no2', $checkout_no2)->first();
            if($ord) {
                if($status=="SUCCESS") {
                    $ord->real_sub_date = date('Y-m-d');
                    $ord->real_sub_time = date('H:i:s');
                    //$ord->expiry_date = date('Y-m-d', strtotime($ord->real_sub_date.' +89 day'));
                    //$ord->expiry_time = date('H:i:s');

                    $ord->is_paid2 = 1;
                    $ord->paid2_date = date('Y-m-d H:i:s');
                    $ord->is_creditpay_success2 = 1;
                    $ord->creditpay_return_code2 = $status;
                    $ord->creditpay_return_message2 = $message;
                    $ord->state_id = 5;
                    $ord->update();
                    if($ord->is_paid2_send_email==0) {
                        Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name, '起租款付清通知', 'my6'));

                        $user = $ord->user;
                        $partner = $ord->partner;
                        //保姆
                        send_babysitter_ord_email($ord, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 起租款付清通知', 'cy6');
                        //經銷商
                        //寄出給 經銷商 車輛已完成交車通知
                        if($partner) {
                            Mail::send(new SendOrdEmail($ord, $partner->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 已交車通知', 'ry6'));
                            if($partner->partneremails->count() > 0) {
                                foreach($partner->partneremails as $partneremail) {
                                    if($partneremail->email)
                                        Mail::send(new SendOrdEmail($ord, $partneremail->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 已交車通知', 'ry6'));
                                }
                            }
                        }
                        writeLog('交車租金付款成功，並寄Email給消費者、保姆及經銷商', '訂單ID：'.$ord->id.' 會員ID：'.$ord->user_id, 0);

                        $ord->is_paid2_send_email=1;
                        $ord->update();
                    }
                }
                else{
                    $ord = Ord::where('checkout_no2', $checkout_no2)->first();
                    $ord->creditpay_return_code2=$status;
                    $ord->creditpay_return_message2 = $message;
                    $ord->update();
                }
            }


            //台新
            /*$inputs=$request->json()->all();
            if($inputs) {
                $params = $inputs['params'];
                $ret_code = $params['ret_code'];
                $ret_msg = $params['ret_msg'];
                $order_no = $params['order_no'];
                $order_status = $params['order_status'];
                $ord = Ord::where('checkout_no2', $order_no)->first();
                if($ord) {
                    if($ret_code == "00") {
                        $ord->real_sub_date = date('Y-m-d');
                        $ord->real_sub_time = date('H:i:s');
                        //$ord->expiry_date = date('Y-m-d', strtotime($ord->real_sub_date.' +89 day'));
                        //$ord->expiry_time = date('H:i:s');

                        $ord->is_paid2 = 1;
                        $ord->paid2_date = date('Y-m-d H:i:s');
                        $ord->is_creditpay_success2 = 1;
                        $ord->creditpay_return_code2 = $order_status;
                        $ord->creditpay_return_message2 = $ret_msg;
                        $ord->state_id = 5;
                        $ord->update();

                        Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name, '起租款付清通知', 'my6'));

                        //保姆
                        $partner = $ord->partner;
                        $user = $ord->user;
                        send_babysitter_ord_email($ord, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 起租款付清通知', 'cy6');

                        //經銷商
                        //寄出給 經銷商 車輛已完成交車通知
                        if($partner) {
                            Mail::send(new SendOrdEmail($ord, $partner->email, $ord->name, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 已交車通知', 'ry6'));
                            if($partner->partneremails->count() > 0) {
                                foreach($partner->partneremails as $partneremail) {
                                    if($partneremail->email)
                                        Mail::send(new SendOrdEmail($ord, $partneremail->email, $ord->name, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 已交車通知', 'ry6'));
                                }
                            }
                        }
                        writeLog('交車租金付款成功，並寄Email給消費者、保姆及經銷商', '訂單ID：'.$ord->id.' 會員ID：'.$ord->user_id, 0);
                    }
                    else {
                        $ord->creditpay_return_code2 = $ret_code;
                        $ord->creditpay_return_message2 = $ret_msg;
                        $ord->update();
                    }
                }
            }*/
        }

        public function creditPaid3(Request $request)
        {
            //dd($request->all());
            $ord_id=$request->ord_id;
            $ord=Ord::whereId($ord_id)->first();
            if(!$ord)
                return redirect()->back()->with('modal_failure_message','沒有發現可付款的訂單，請聯絡保姆為您查詢。');
            //dd($ord);

            if($ord->is_paid==0){
                return redirect()->back()->with('modal_failure_message','您必需先付保證金後才能付起租款');
            }
            elseif($ord->is_paid2==0){
                return redirect()->back()->with('modal_failure_message','您必需先付起租款後才能付還車款項');
            }
            if($ord->is_paid3==1){
                return redirect()->back()->with('modal_failure_message','您已經繳過迄租款，無需再次繳款。');
            }


            $cate=$ord->cate;
            if(!$cate)
                return redirect()->back()->with('modal_failure_message','沒有發現可付款的訂單，請聯絡保姆為您查詢。');

            //重新給一組結帳單號, 避免重新刷卡造成訂單號碼重複而無法結帳
            $checkout_no3=Carbon::now()->format('ymd').rand(10000,99999);
            $ord->checkout_no3=$checkout_no3;
            $ord->update();
            $user=$ord->user;
            writeLog('刷卡前產生迄租款結帳單號','ID:'.$user->id.', 會員姓名：'.$user->name.', 訂單編號：'.$ord->ord_no.', 迄租款結帳單號：'.$ord->checkout_no3);

            //藍星
            /* 金鑰與版本設定 */
            $MerchantID = env('NEWEBPAY_MERCHANT_ID');
            $HashKey = env('NEWEBPAY_HASH_KEY');
            $HashIV = env('NEWEBPAY_HASH_IV');
            $URL = env('NEWEBPAY_URL');
            $ReturnURL = env('CARPLUS_NEWEBPAY_RETURN_URL');
            $NotifyURL = env('CARPLUS_NEWEBPAY_NOTIFY_URL');
            $VER = env('NEWEBPAY_VER');

            /* 送給藍新資料 */
            $trade_info_arr = array(
                'MerchantID' => $MerchantID,
                'RespondType' => 'JSON',
                'TimeStamp' => time(),
                'Version' => $VER,
                'MerchantOrderNo' => $ord->checkout_no3,
                'Amt' => $ord->payment_backcar_total,
                'ItemDesc' => '付訂閱方案：'.$cate->title.' 還車應付款項',
                'CREDIT' => 1,
                'VACC' => 0,//ATM
                'ReturnURL' => $ReturnURL.'3', //支付完成 返回商店網址
                'NotifyURL' => $NotifyURL.'3', //支付通知網址
            );

            $TradeInfo = create_mpg_aes_encrypt($trade_info_arr, $HashKey, $HashIV);
            $SHA256 = strtoupper(hash("sha256", SHA256($HashKey,$TradeInfo,$HashIV)));
            echo CheckOut($URL,$MerchantID,$TradeInfo,$SHA256,$VER);

            //台新
            /*$payment_backcar_total=$ord->payment_backcar_total * 100;
            $data_arr=[
                "ver"=>"1.0.0",
                "sender"=>"rest",
                "mid"=>env('TSPG_MID'),
                "pay_type"=>1,
                "tx_type"=>1,
                "params"=>[
                    "layout"=>"1",
                    "order_no"=>$checkout_no3,
                    "cur"=>"NTD",
                    "install_period"=>"",
                    "post_back_url"=>env('TSPG_POST_BACK_URL').'3',
                    "result_url"=>env('TSPG_RESULT_URL').'3',
                    "capt_flag"=>"1",
                    "result_flag"=>"1",
                    "amt"=>"$payment_backcar_total",
                    "order_desc"=>""
                ],
                "tid"=>env('TSPG_TID')
            ];

            $payload = json_encode($data_arr);

            // Prepare new cURL resource
            $ch = curl_init(env('TSPG_API_ROOT'));
            //$ch = curl_init('https://www.r4d.com.tw');
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            // Set HTTP Header for POST request
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: '. strlen($payload))
            );

            // Submit the POST request
            $result = curl_exec($ch);
            // Close cURL session handle
            curl_close($ch);
            $result_arr=json_decode($result);
            if($result_arr){
                $params=$result_arr->params;
                $ret_code=$params->ret_code;
                $hpp_url=$params->hpp_url;
                if($ret_code=="00" && $hpp_url){
                    return redirect($hpp_url);
                }
                else{
                    return redirect()->back()->with('modal_failure_messsage','信用卡刷卡驗證失敗，請洽客服人員！');
                }
            }
            else{
                return redirect()->back()->with('modal_failure_messsage','信用卡刷卡驗證失敗，請洽客服人員！');
            }*/

        }

        public function newebpay_return3(Request $request)
        {

            $tradeInfo = file_get_contents("php://input");
            $arr = mb_split("&",$tradeInfo);
            $get_aes = str_replace("TradeInfo=","",$arr[3]);
            $data = create_aes_decrypt($get_aes,env('NEWEBPAY_HASH_KEY'),env('NEWEBPAY_HASH_IV'));
            $json = json_decode($data);
            $result=$json->Result;
            $checkout_no3=$result->MerchantOrderNo;
            $status=$json->Status;
            $message=$json->Message;
            $ord = Ord::where('checkout_no3', $checkout_no3)->first();
            if($ord) {
                if($status == "SUCCESS") {
                    $ord->is_paid3 = 1;
                    $ord->paid3_date = date('Y-m-d H:i:s');
                    $ord->update();

                    //Mail::send(new OrdPlaced($ord));
                    return redirect('/thankyou/'.$ord->ord_no)->with('modal_success_message', '線上刷卡成功，您的訂單編號：'.$ord->ord_no);
                } else {
                    $ord = Ord::where('checkout_no3', $checkout_no3)->first();
                    $ord->creditpay_return_code3 = $status;
                    $ord->creditpay_return_message3 = $message;
                    $ord->update();

                    return redirect('/failure/'.$message)->with('modal_failure_message', $message);
                }
            }
            else
                return redirect('/failure/找不到相關訂單')->with('modal_failure_message', '線上刷卡失敗，找不到相關訂單');

            //台新
            /*$ret_code=$request->ret_code;
            $ord = Ord::where('checkout_no3', $request->order_no)->first();
            if($ord) {
                if($ret_code=="00") {
                    $ord->is_paid3 = 1;
                    $ord->paid3_date = date('Y-m-d H:i:s');
                    $ord->update();
                    //Mail::send(new OrdPlaced($ord));
                    return redirect('/thankyou/'.$ord->ord_no)->with('modal_success_message', '線上刷卡成功，您的訂單編號：'.$ord->ord_no);

                }
                else{
                    $ord = Ord::where('checkout_no3', $checkout_no3)->first();
                    $ord->creditpay_return_code3=$request->ret_code;
                    $ord->creditpay_return_message3 = $request->ret_msg;
                    $ord->update();
                    return redirect('/failure/'.$request->ret_msg)->with('modal_failure_message', $request->ret_msg);
                }
            }
            else
                return redirect('/failure/找不到相關訂單')->with('modal_failure_message', '線上刷卡失敗，找不到相關訂單');*/

        }


        public function newebpay_notify3(Request $request)
        {
            //藍星
            $tradeInfo = file_get_contents("php://input");
            $arr = mb_split("&",$tradeInfo);
            $get_aes = str_replace("TradeInfo=","",$arr[3]);
            $data = create_aes_decrypt($get_aes,env('NEWEBPAY_HASH_KEY'),env('NEWEBPAY_HASH_IV'));
            $json = json_decode($data);
            $result=$json->Result;
            $checkout_no3=$result->MerchantOrderNo;
            $status=$json->Status;
            $message=$json->Message;
            $ord = Ord::where('checkout_no3', $checkout_no3)->first();
            if($ord) {
                if($status == "SUCCESS") {
                    $ord->is_paid3 = 1;
                    $ord->paid3_date = date('Y-m-d H:i:s');
                    $ord->is_creditpay_success3 = 1;
                    $ord->creditpay_return_message3 = $message;
                    $ord->state_id = 10;
                    $ord->update();
                    $msg='已寄Email';
                    if($ord->is_paid3_send_email==0) {
                        //寄發Email:會員保姆及經銷商
                        send_ord_all_email($ord, '迄租款付清通知', 1, 'my10', 1, 'cy10', 1, 'cy10');
                        $msg.='迄租款付清通知：mh10->消費者、cy10->保姆、cy10->車源商。';
                        //同車續租，寄給保姆及經銷商產生新訂單通知
                        /*if($ord->renewtate_id == 1) {
                            $ord->state_id = 11;
                            $ord->is_renewtate_setting_finish = 1;
                            $ord->update();
                            //send_ord_all_email($new_ord, '續約訂單產生通知', 0, '', 1, 'ry13', 1, 'ry13');
                        } //換車續租
                        elseif($ord->renewtate_id == 2) {
                            send_ord_all_email($ord, '換車續租通知', 0, '', 1, 'ry8-2', 1, 'ry8-2');
                            $msg.='換車續租通知：ry8-2->保姆、ry8-2->車源商。';
                        } //不續租
                        elseif($ord->renewtate_id == 3) {
                            send_ord_all_email($ord, '訂閱不續約通知', 0, '', 1, 'rn8', 1, 'rn8');
                            $msg .= '換車續租通知：rn8->保姆、rn8->車源商。';
                        }
                        //購車
                        else
                            send_ord_all_email($ord, '訂閱購車通知', 0,'',1,'ry8-3',1,'ry8-3');*/

                        if($ord->renewtate_id > 1) {
                            //寄出給 經銷商 車輛已完成還車通知
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
                                $msg .= '已還車通知：ry10->車源商。';
                            }
                        }

                        $ord->is_paid3_send_email=1;
                        $ord->update();
                        writeLog('還車應付款繳費成功', '訂單ID：'.$ord->id.' 會員ID：'.$ord->user_id.' 會員姓名：'.$ord->name.' '.$msg, 0);
                    }

                } else {
                    $ord = Ord::where('checkout_no', $checkout_no3)->first();
                    $ord->creditpay_return_code = $status;
                    $ord->creditpay_return_message = $message;
                    $ord->update();
                }
            }

            //台新
            /*$inputs=$request->json()->all();

            $setting=Setting::where('key','json')->first();
            $setting->val=json_encode($inputs);
            $setting->update();
            if($inputs) {
                $params = $inputs['params'];
                $ret_code = $params['ret_code'];
                $ret_msg = $params['ret_msg'];
                $order_no = $params['order_no'];
                $ord = Ord::where('checkout_no3', $order_no)->first();
                if($ord) {
                    $ord->is_paid3 = 1;
                    $ord->paid3_date = date('Y-m-d H:i:s');
                    $ord->is_creditpay_success3 = 1;
                    $ord->creditpay_return_message3 = $ret_msg;
                    $ord->state_id=10;
                    $ord->update();

                    //寄發Email:會員保姆及經銷商
                    send_ord_all_email($ord, '迄租款付清通知', 1, 'my10', 1, 'cy10', 1, 'cy10');

                    //同車續租，寄給保姆及經銷商產生新訂單通知
                    if($ord->renewtate_id == 1) {
                        $ord->state_id = 11;
                        $ord->update();
                        $new_ord = clone_new_ord($ord);
                        send_ord_all_email($new_ord, '續約訂單產生通知', 0, '', 1, 'ry13', 1, 'ry13');
                    }
                    //換車續租
                    elseif($ord->renewtate_id == 2)
                        send_ord_all_email($ord, '換車續租通知', 0,'',1,'ry8-2',1,'ry8-2');
                    //不續租
                    elseif($ord->renewtate_id == 3)
                        send_ord_all_email($ord, '訂閱不續約通知', 0,'',1,'rn8',1,'rn8');
                    //購車
                    //else
                    //    send_ord_all_email($ord, '訂閱購車通知', 0,'',1,'ry8-3',1,'ry8-3');

                    //if($ord->renewtate_id > 1){
                        //寄出給 經銷商 車輛已完成還車通知
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
                        }
                    }

                    writeLog('還車應付款繳費成功，並寄Email給消費者、保姆','訂單ID：'.$ord->id.' 會員ID：'.$ord->user_id,0);
                }
                else{
                    $ord = Ord::where('checkout_no3', $checkout_no3)->first();
                    $ord->creditpay_return_message3 = $ret_msg;
                    $ord->update();
                }

            }*/

        }

        /*public function B2C_MerUpdate(Request $request)
        {
            echo "R01=00";
        }*/

        /*public function checkoutBack(Request $request) {
            $RtnCode=$request->RtnCode;
            $ord=Ord::where('ordCode',$request->MerchantTradeNo)->first();
            $ord->ecpayPaymentType=$request->PaymentType;
            if($RtnCode==1){
                $ord->isPaid=1;
                $ord->isPreOrder=0;
                $ord->paidTime=$request->PaymentDate;
                $ord->ecpayReturnJson=json_encode($request->all());
                $ord->save();

                //Mail::send(new OrdPlaced($ord));
                //Cart::instance('default')->destroy();

                return redirect()->route('orders.index')->with('modal_success_message', '您已線上付款成功，訂單編號：'.$ord->ordCode);
            }
            else{
                $ord->delete();
                return redirect()->route('orders.index')->withErrors('線上付款失敗，請再重新結帳一次');
            }
        }

        protected function storePaid($ord, $paymentType) {

            require('ECPay.Logistics.Integration.php');
            try {
                $AL = new \ECPayLogistics();
                $AL->HashKey = env('PAY_HASH_KEY');
                $AL->HashIV = env('PAY_HASH_IV');
                $logisticsSubType='FAMI';
                if($ord->paymentType==6)
                    $logisticsSubType='UNIMART';
                //dd($logisticsSubType);
                $AL->Send = array(
                    'MerchantID' => env('PAY_MERCHANT_ID'),
                    'MerchantTradeNo' => $ord->ordCode,
                    'MerchantTradeDate' => date('Y/m/d H:i:s'),
                    'LogisticsType' => \LogisticsType::CVS,
                    'LogisticsSubType' => $logisticsSubType,
                    'GoodsAmount' => (int) getNumbers()->get('newTotal'), //price型別必為int
                    'CollectionAmount' => (int) getNumbers()->get('newTotal'), //price型別必為int
                    'IsCollection' => 'Y',
                    'GoodsName' => 'Qstyle商品',
                    'SenderName' => '莊子逸',
                    'SenderCellPhone' => '0978210979',
                    'ReceiverName' => $ord->user->name,
                    'ReceiverCellPhone' => $ord->receivePhone,
                    'ReceiverEmail' => $ord->receiveEmail,
                    'TradeDesc' => 'QstyleNation購物',
                    'ServerReplyURL' => env('PAY_RETURN_URL').'/checkoutServerReplyURL',
                    'Remark' => '',
                    'PlatformID' => '',
                );
                $AL->SendExtend = array(
                    'ReceiverStoreID' => $ord->storeId,
                    'ReturnStoreID' => '',
                );
                // BGCreateShippingOrder()

                $Result = $AL->BGCreateShippingOrder();
                $ResCode=$Result['ResCode'];
                if($ResCode==1){
                    $ord=Ord::where('ordCode',$Result['MerchantTradeNo'])->first();
                    //$ord->ecpayPaymentType=$request->PaymentType;
                    $ord->isPreOrder=0;
                    $ord->ecpayReturnJson=json_encode($Result);
                    $ord->save();

                    //Mail::send(new OrdPlaced($ord));
                    Cart::instance('default')->destroy();
                    echo '<script>document.location.href="/orders"</script>';
                    return redirect()->route('orders.index')->with('modal_success_message', '您已申請超商取貨付款，訂單編號：'.$ord->ordCode);
                }
                else{
                    //$ord->delete();
                    return redirect()->route('orders.index')->withErrors('申請超商取貨付款失敗，請再重新結帳一次');
                }


            } catch(Exception $e) {
                return $e->getMessage();
            }
        }*/

        protected function addToOrdersTables($ord_no)
        {
            $cart_type='default';
            $shippingtype_id=session()->get('shippingtype_id');
            $paymenttype_id=session()->get('paymenttype_id');
            $white_point=getNumbers('default')->get('white_point');
            //$ord=Ord::whereId(8636)->first();
            //$ordproduct=OrdProduct::whereId(84)->first();
            // 新增主訂單
            $ord = Ord::create([
                'user_id' => auth()->guard('user')->user() ? auth()->guard('user')->user()->id : null,
                'ord_no' => $ord_no,
                'discount' => getNumbers($cart_type)->get('discount'),
                'is_user_discount' => getNumbers($cart_type)->get('is_user_discount'),
                'coupon_name' => session()->get('coupon')?session()->get('coupon')['coupon_name']:'',
                'coupon_type' => session()->get('coupon')?session()->get('coupon')['coupon_type']:'',
                'coupon_code' => session()->get('coupon')?session()->get('coupon')['coupon_code']:'',
                'white_point' => $white_point?$white_point:0,
                'subtotal' => getNumbers($cart_type)->get('subtotal'),
                'ship_fee' => getNumbers($cart_type)->get('shipping'),
                'total' => getNumbers($cart_type)->get('newTotal'),
                'cart_type' => $cart_type,
                'name' => session('ord_name'),
                'phone' => session('ord_phone'),
                'telephone' => session('ord_telephone'),
                'email' => session('ord_email'),
                'address' => session('ord_address'),
                'delivery_name' => session('ord_delivery_name'),
                'delivery_phone' => session('ord_delivery_phone'),
                'delivery_telephone' => session('ord_delivery_telephone'),
                'delivery_email' => session('ord_delivery_email'),
                'delivery_address' => session('ord_delivery_address'),
                'delivery_date' => session('ord_delivery_date'),
                'delivery_time' => session('ord_delivery_time'),
                'paymenttype_id' => $paymenttype_id,
                'shippingtype_id' => $shippingtype_id,
                'print_cart' => session('ord_print_cart'),
                'memo' => session('ord_memo'),
            ]);
            // 新增訂單產品
            $carts=Cart::instance($cart_type)->content();
            $carts=$carts->sortBy('name');
            foreach ($carts as $item) {
                $prod_name=$item->options->prod_name;
                $is_addition=0;
                if($item->options->type!='main') {
                    $prod_name = '     加購品: '.$prod_name;
                    $is_addition=1;
                }
                $ordproduct=OrdProduct::create([
                    'ord_id' => $ord->id,
                    'product_id' => $item->model->id,
                    'is_addition' => $is_addition,
                    'product_name' => $prod_name,
                    'quantity' => $item->qty,
                    'ordPrice' => $item->price,
                    'sum' => $item->price * $item->qty,
                ]);
                //扣庫存
                $productstock_id=$item->options->productstock_id;
                $productStock=\App\Model\ProductStock::whereId($productstock_id)->first();
                if($productStock) {
                    $stocks = $productStock->stocks;
                    $productStock->stocks=$stocks - $item->qty;
                    $productStock->update();
                }
            }

            if($white_point) {
                $user = getLoginUser();
                //如果有使用點數則扣除
                createPointRecord($user, 'white', '購物使用R點折抵', 'point_out', $white_point, '訂單編號：'.$ord_no);
            }

            session()->forget('cart_type');
            session()->forget('coupon');
            session()->forget('white_point');
            session()->forget('shippingtype');
            session()->forget('paymenttype');
            session()->forget('ord_e03');
            session()->forget('ord_name');
            session()->forget('ord_phone');
            session()->forget('ord_telephone');
            session()->forget('ord_email');
            session()->forget('ord_address');
            session()->forget('ord_delivery_name');
            session()->forget('ord_delivery_phone');
            session()->forget('ord_delivery_telephone');
            session()->forget('ord_delivery_email');
            session()->forget('ord_delivery_address');
            session()->forget('ord_delivery_date');
            session()->forget('ord_delivery_time');
            session()->forget('ord_print_cart');
            session()->forget('ord_memo');

            return $ord;
        }

        protected function thankyou($ord_no) {
            $ord=Ord::where('ord_no',$ord_no)->first();
            if(!$ord)
                abort(404);
            $cate=$ord->cate;
            $proarea=$ord->proarea;
            $product=$ord->product;
            return view('frontend.thankyou',compact('ord','cate','proarea','product'));
        }

        protected function failure($retcode) {
            return view('frontend.failure',compact('retcode'));
        }

        protected function session_put($request) {
            session()->put('ord_e03',$request->e03);
            session()->put('ord_name',$request->name);
            session()->put('ord_phone',$request->phone);
            session()->put('ord_telephone',$request->telephone);
            session()->put('ord_email',$request->email);
            session()->put('ord_address',$request->address);
            session()->put('ord_delivery_name',$request->delivery_name);
            session()->put('ord_delivery_phone',$request->delivery_phone);
            session()->put('ord_delivery_telephone',$request->delivery_telephone);
            session()->put('ord_delivery_email',$request->delivery_email);
            session()->put('ord_delivery_address',$request->delivery_address);
            session()->put('ord_delivery_date',$request->delivery_date);
            session()->put('ord_delivery_time',$request->delivery_time);
            session()->put('ord_print_cart',$request->print_cart);
            session()->put('ord_memo',$request->memo);
        }
    }
