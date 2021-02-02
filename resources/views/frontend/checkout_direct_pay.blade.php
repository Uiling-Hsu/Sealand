<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<script>
    alert('您的審核已通過，請直接刷卡付保證金')
</script>
    @php
        $cate=$ord->cate;
        if(!$cate)
            return redirect()->back()->with('modal_failure_message','沒有發現可付款的訂單，請聯絡保姆為您查詢。');

        //重新給一組結帳單號, 避免重新刷卡造成訂單號碼重複而無法結帳
        $checkout_no=\Carbon\Carbon::now()->format('ymd').rand(10000,99999);
        $ord->checkout_no=$checkout_no;
        $ord->update();
        $user=$ord->user;
        writeLog('刷卡前產生保證金結帳單號','ID:'.$user->id.', 會員姓名：'.$user->name.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id.', 保證金結帳單號：'.$ord->checkout_no);

        //藍星
        /* 金鑰與版本設定 */
        $MerchantID = env('NEWEBPAY_MERCHANT_ID');
        $HashKey = env('NEWEBPAY_HASH_KEY');
        $HashIV = env('NEWEBPAY_HASH_IV');
        $URL = env('NEWEBPAY_URL');
        $ReturnURL = env('NEWEBPAY_RETURN_URL');
        $NotifyURL = env('NEWEBPAY_NOTIFY_URL');
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
    @endphp
</body>
</html>

