<?php
    date_default_timezone_set('Asia/Taipei');
    function getPrice($price_tw, $price){
        return getCurrency()=='TWD'? floatval($price_tw):floatval($price);
    }

    function formatPrice($price)
    {
        return getCurrency().' $'.number_format($price);//money_format('$%i', $price);
    }

    function setActiveCategory($category, $output = 'active')
    {
        return request()->category == $category ? $output : '';
    }

    function productImage($path)
    {
        return $path && file_exists('storage/'.$path) ? asset('storage/'.$path) : asset('img/not-found.jpg');
    }

    function strDigitalToNumber($strDigital){
        if(!$strDigital)
            return '';
        else
            return intval(str_replace(',','',$strDigital));
    }

    function setting($key){
        $setting=\App\Model\Setting::where('key',$key)->first();
        if($setting)
            return $setting->val;
        else
            return '';
    }

    function getNumbers($cart_type='default')
    {
        $tax = 0;//config('cart.tax') / 100;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $code = session()->get('coupon')['name'] ?? null;
        $subtotal=strDigitalToNumber(Cart::instance('default')->subtotal());
        $is_user_discount=false;
        //$user_discount = isUserLogin()? round($subtotal * 0.05):0;
        $user_discount = 0;
        //dd($user_discount.'--'.$discount);
        if($user_discount > $discount){
            $discount=$user_discount;
            $is_user_discount=true;
            session()->forget('coupon');
        }

        $white_point = session()->get('white_point') ?? 0;

        $newSubtotal = $subtotal - $discount - $white_point;
        if ($newSubtotal < 0) {
            $newSubtotal = 0;
        }

        $shipping=setting('shipping');//setting('site.shipping');
        $free_shipping=setting('free_shipping');//setting('site.free_shipping');
        if($newSubtotal>=$free_shipping || session()->get('shippingtype_id')==2)
            $shipping=0;
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal * (1 + $tax) + $shipping;

        return collect([
            'tax' => $tax,
            'code' => $code,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'white_point' => $white_point,
            'is_user_discount' => $is_user_discount,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'shipping' => $shipping,
            'free_shipping' => $free_shipping,
            'newTotal' => $newTotal,
        ]);
    }

    function getLocale(){
        return app()->getLocale();
    }

    function getCurrency(){
        return session('currency');
    }

    function getProductStockOptionName($productStockId){
        $option_name='';
        if($productStockId){
            $productStock=\App\ProductStock::whereId($productStockId)->first();
            $option=$productStock->option;
            if($option){
                $option_name= (getLocale()=='en' || !$option->name_tw) ? $option->name:$option->name_tw;
            }
        }
        return $option_name;
    }

    function tableBgColor($style=4){
        $style1=' style="background:#FDFBD9;"';
        $style2=' style="background:#E8FFE8;"';
        $style3=' style="background:#FBF0F2;"';
        $style4=' style="background:#F4EBFA;"';
        if($style==1)
            return $style1;
        elseif($style==2)
            return $style2;
        elseif($style==3)
            return $style3;
        else
            return $style4;
    }

    function tableBgColorNoStyleTag($style=4){
        $style1='background:#FDFBD9;';
        $style2='background:#E8FFE8;';
        $style3='background:#FBF0F2;';
        $style4='background:#F4EBFA;';
        if($style==1)
            return $style1;
        elseif($style==2)
            return $style2;
        elseif($style==3)
            return $style3;
        else
            return $style4;
    }

    use App\Mail\SendMail\SendOrdEmail;
    use App\Mail\SendMail\SendOrdPlaceEmail;
    use App\Mail\SendMail\SendSubscriberEmail;
    use App\Mail\SendMail\SendUserEmail;
    use App\Model\Ord;
    use Carbon\Carbon;
    function getOrdNumber() {
        return Carbon::now()->format('ymd').rand(10000,99999);
    }

    function getRandomFile($file) {
        return md5($file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
    }

    //function upload_file($request, $keyword, $imgFile, $width=null, $height=null) {
    //    $file=$request->file('imgFile');
    //    $path='storages/'.$keyword;
    //    $filename=getRandomFile($file);
    //    $extension=$file->getClientOriginalExtension();
    //    if($extension!='jpg' && $extension!='png'){
    //        return -1;
    //    }
    //
    //    $img = Image::make($_FILES[$imgFile]['tmp_name']);
    //    if($width && $height) {
    //        $img->fit($width, $height);
    //    }
    //    elseif($width) {
    //        //dd('ok1');
    //        $img->resize($width, null, function($constraint) {
    //            $constraint->aspectRatio();
    //        });
    //    }
    //    elseif($height) {
    //        $img->resize(null, $height, function($constraint) {
    //            $constraint->aspectRatio();
    //        });
    //    }
    //    $img->save($path.'/'.$filename);
    //    return $path.'/'.$filename;
    //}

    use Intervention\Image\Facades\Image;
    function upload_file($file, $keyword, $width=null, $height=null, $is_thumbnail=null) {
        //$file=$request->file('imgFile');
        $path = 'storages/'.$keyword;
        if(! file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $filename= rand(1000,9999).getRandomFile($file);
        $extension=strtolower($file->getClientOriginalExtension());
        if($extension!='jpg' && $extension!='jpeg' && $extension!='gif' && $extension!='png'){
            return -1;
        }

        $img = Image::make($file);
        if($width && $height) {
            $img->fit($width, $height);
        }
        elseif($width) {
            //dd('ok1');
            $img->resize($width, null, function($constraint) {
                $constraint->aspectRatio();
            });
        }
        elseif($height) {
            $img->resize(null, $height, function($constraint) {
                $constraint->aspectRatio();
            });
        }
        if($is_thumbnail==1)
            $filename='s_'.$filename;

        $img->save($path.'/'.$filename);
        return '/'.$path.'/'.$filename;
    }

    function upload_user_image_file($prefix, $file, $width=null, $height=null, $is_thumbnail=null) {
        //$file=$request->file('imgFile');
        $path = storage_path('app/user');
        if(! file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $filename= $prefix.rand(1000,9999).getRandomFile($file);
        $extension=strtolower($file->getClientOriginalExtension());
        if($extension!='jpg' && $extension!='jpeg' && $extension!='gif' && $extension!='png'){
            return -1;
        }

        $img = Image::make($file);
        if($width && $height) {
            $img->fit($width, $height);
        }
        elseif($width) {
            //dd('ok1');
            $img->resize($width, null, function($constraint) {
                $constraint->aspectRatio();
            });
        }
        elseif($height) {
            $img->resize(null, $height, function($constraint) {
                $constraint->aspectRatio();
            });
        }

        $img->save($path.'/'.$filename);
        return '/'.$path.'/'.$filename;
    }



    function watermark($from_filename, $watermark_filename, $save_filename)
    {
        $allow_format = array('jpeg', 'png', 'gif');
        $sub_name = $t = '';
        // 原圖
        $img_info = getimagesize($from_filename);
        $width    = $img_info['0'];
        $height   = $img_info['1'];
        $mime     = $img_info['mime'];

        list($t, $sub_name) = explode('/', $mime);
        if ($sub_name == 'jpg')
            $sub_name = 'jpeg';

        if (!in_array($sub_name, $allow_format))
            return false;

        $function_name = 'imagecreatefrom' . $sub_name;
        $image     = $function_name($from_filename);

        // 浮水印
        $img_info = getimagesize($watermark_filename);

        $w_width  = $img_info['0'];
        $w_height = $img_info['1'];
        $w_mime   = $img_info['mime'];

        list($t, $sub_name) = explode('/', $w_mime);
        if (!in_array($sub_name, $allow_format))
            return false;

        $function_name = 'imagecreatefrom' . $sub_name;
        $watermark = $function_name($watermark_filename);

        //$watermark_pos_x = ($width  - $w_width)/2;
        $watermark_pos_x = 500;
        $watermark_pos_y = ($height / 2)-20;

        // imagecopymerge($image, $watermark, $watermark_pos_x, $watermark_pos_y, 0, 0, $w_width, $w_height, 100);

        // 浮水印的圖若是透明背景、透明底圖, 需要用下述兩行
        imagesetbrush($image, $watermark);
        imageline($image, $watermark_pos_x, $watermark_pos_y, $watermark_pos_x, $watermark_pos_y, IMG_COLOR_BRUSHED);
        imagejpeg($image, $from_filename);
        return $save_filename;
    }

    function isAdminLogin() {
        return auth()->guard('admin')->check();
    }

    function getAdminUser() {
        return auth()->guard('admin')->user();
    }

    function isUserLogin() {
        return auth()->guard('user')->check();
    }

    function getLoginUser() {
        return auth()->guard('user')->user();
    }

    use App\Model\Product;
    function getHeaderCategories($department_id=1) {
        $categories = Category::whereStatus(1);
        $category_ids_arr = CategoryProduct::where('department_id',$department_id)->select('category_id')->distinct()->get()->toArray();
        $category_ids_new_arr=array();
        foreach($category_ids_arr as $key=>$category_id){
            $cntData = 0;
            $prod_ids = CategoryProduct::where('category_id', $category_id)->select('product_id')->get()->toArray();
            foreach($prod_ids as $ii => $prod_id) {
                $p = Product::whereStatus(1)->whereId($prod_id)->first();
                if($p)
                    $cntData++;
            }
            if($cntData > 0)
                $category_ids_new_arr[] = $category_id;

        }
        return $categories->whereIn('id',$category_ids_new_arr)->orderBy('sort')->get();
    }

    function getHeaderProductsByCategory($department_id, $category_id) {
        // filter products;
        $products = Product::where('id','>',0);
        $cateprods_arr=CategoryProduct::where('department_id',$department_id)
            ->where('category_id', $category_id)
            ->select('product_id')
            ->distinct()
            ->take(6)
            ->get()
            ->toArray();
        return $products->whereIn('id',$cateprods_arr)->whereStatus(1)->get();
    }

    function substrByLens($str, $len=0) {
        $getLength=mb_strlen($str);
        if($getLength < $len)
            return $str;
        else
            return mb_substr($str,0,$len,"UTF-8").'...';
    }
    function getSetting($key) {
        $setting=\App\Model\Setting::where('key',$key)->first();
        if($setting)
            return $setting->val;
        else
            return '';
    }

    function getHoldays() {
        $holidays=getSetting('holiday');
        $holidays=explode("\n", str_replace("\r", "", $holidays));
        return $holidays;
        //$holiday_arr=array();
        //dd($holidays);

    }

    function getChineseWeekFromDate($date) {
        if($date=='')
            return '';
        else
            return getChineseWeek(date('w', strtotime($date)));
    }

    function getChineseWeek($week) {
        $ret_week = '';
        switch ($week) {
            case 1:
                $ret_week = "一";
                break;
            case 2:
                $ret_week = "二";
                break;
            case 3:
                $ret_week = "三";
                break;
            case 4:
                $ret_week = "四";
                break;
            case 5:
                $ret_week = "五";
                break;
            case 6:
                $ret_week = "六";
                break;
            case 0:
                $ret_week = "日";
                break;
            default:
        }
        return $ret_week;
    }

    use Illuminate\Support\Facades\Auth;
    function role($role) {
        return Auth::guard('admin')->user()?Auth::guard('admin')->user()->hasRole($role):'';
    }


    function import_user() {
        $members=\App\Model\frontend\Member::get();
        $cnt=0;
        set_time_limit(0);
        foreach($members as $key=>$member){
            $email=$member->email;
            if($email){
                $user=\App\Model\frontend\User::whereEmail($email)->select('id')->first();
                if(!$user && $cnt<=250){
                    $user = new \App\Model\frontend\User();
                    $user->name = $member->member_name;
                    $user->email = $member->email;
                    $user->phone = $member->cellphone;
                    $user->telephone = $member->tel;
                    $bday=$member->bday;
                    $date='';
                    if($bday){
                        $bday=str_replace('/','-',$bday);
                        $bday=str_replace('*','',$bday);
                        $bday_arr=explode('-',$bday);
                        $year=$bday_arr[0];
                        $month=$bday_arr[1];
                        $month=str_pad($month,2,"0",STR_PAD_LEFT);
                        $day=$bday_arr[2];
                        $day=str_pad($day,2,"0",STR_PAD_LEFT);
                        if($year>=200 && $year<1000)
                            $year+=1000;
                        elseif($year<=120)
                            $year+=1911;
                        $date=$year.'-'.$month.'-'.$day;
                        echo $date.'<br>';
                    }
                    $user->birthday = $date;
                    $user->address = $member->address;
                    $user->delivery_name = $member->member_name;
                    $user->delivery_email = $member->email;
                    $user->delivery_phone = $member->cellphone;
                    $user->delivery_telephone = $member->tel;
                    $user->delivery_address = $member->address;
                    $user->edm = $member->edm=='Y'?'1':'0';
                    $user->gender = $member->gender;
                    $user->password = bcrypt($member->pwd);
                    $user->is_activate = 1;
                    $user->status = 1;
                    $user->save();
                    $cnt++;
                }
            }
        }
    }

    //驗證台灣手機號碼
    function isPhone($str) {
        if (preg_match("/^09[0-9]{2}-[0-9]{3}-[0-9]{3}$/", $str)) {
            return true;    // 09xx-xxx-xxx
        } else if(preg_match("/^09[0-9]{2}-[0-9]{6}$/", $str)) {
            return true;    // 09xx-xxxxxx
        } else if(preg_match("/^09[0-9]{8}$/", $str)) {
            return true;    // 09xxxxxxxx
        } else {
            return false;
        }
    }

    function parseDate($d) {
        return Carbon::parse($d)->format('Y-m-d');
    }

    function getCanBuyQty($stockid, $max_qty=30) {
        $productstock=\App\Model\ProductStock::whereId($stockid)->first();
        $left_stocks = $productstock->stocks;
        //$unit_stock=$productstock->unit_stock;
        $unit_stock=1;
        $canBuyQty=floor($left_stocks/$unit_stock);
        if($canBuyQty<30)
            $max_qty=$canBuyQty;
        return $max_qty;
    }

    function updateProductStock($products) {
        foreach($products as $product){
            $quantity=$product->pivot->quantity;
            $stock_id=$product->pivot->stock_id;
            $productstock=\App\Model\ProductStock::whereId($stock_id)->first();
            //$unit_stock=$productstock->unit_stock;
            $unit_stock=1;
            $stocks=$productstock->stocks;
            $stocks+=$quantity*$unit_stock;
            $productstock->stocks=$stocks;
            $productstock->update();
        }
    }

    use App\Model\Wlog;
    function writeLog($title, $content, $is_backend=1, $auto_run='') {

        if ($content && $title) {
            $user_title='';
            if($is_backend && $auto_run=='') {
                $user = getAdminUser();
                if($user)
                    $user_title='操作者 ( ID:'.$user->id.', '.$user->email.' )：';
            }
            else {
                $user = getLoginUser();
                $user_title='前台使用者：';
                if($user){
                    $user_title.='( ID:'.$user->id.', '.$user->email.' )';
                }
            }
            $user_name='';
            $user_id='';
            if($user){
                $user_name=$user->name;
                $user_id=$user->id;
            }
            $sdate = date('Y-m-d');
            $stime = date('H:i:s');
            $msg = $user_title . $user_name . ' ( 時間：'.$sdate . " " . $stime.' )'. PHP_EOL;
            $msg .='<div style="color:brown;font-weight: bold;padding-top: 5px;border-top:solid 1px #ccc;margin-top: 5px">';
            if (is_array($content) && $content) {
                foreach($content as $key=>$cont) {
                    if (is_array($cont) && $cont) {
                        foreach($cont as $key2=>$c) {
                            $msg .= $key2.':'.$c.', ';
                        }
                    }
                    else{
                        if($key != '_token')
                            $msg .= $key.':'.$cont.', ';
                    }
                }
            } else if ($content) {
                $msg .= $content . PHP_EOL;
            }
            $msg .='</div>';

            $wlog=new Wlog;
            $wlog->user_id=$user_id;
            $wlog->user_name=$user_name;
            $wlog->platform=$is_backend?'backend':'frontend';
            $wlog->title=$title;
            $wlog->content=$msg.PHP_EOL.PHP_EOL;
            $wlog->save();

        }
        return true;
    }

    //get_diff_field_content($ord->toArray(), $inputs);
    //更新後取得差異的欄位值
    function get_diff_field_content($table_arr, $inputs) {
        $msg='';
        $column_arr=array_keys($table_arr);
        foreach($column_arr as $col)
            if(array_key_exists($col, $inputs)){
                if($inputs[$col]!=$table_arr[$col]) {
                    $msg .= '<span style="color: green">前：'.$col.' = '.$table_arr[ $col ].'</span>';
                    $msg .= '<span style="color: red"> → 後：'.$col.' = '.$inputs[ $col ].'</span>，';
                }
            }
        return $msg;
    }

    function has_permission($permission_name) {
        $admin=getAdminUser();
        if(!$admin)
            return false;

        $admin_role=\App\Model\AdminRole::where('admin_id',$admin->id)->first();
        if(!$admin_role)
            return false;

        $role_id=$admin_role->role_id;
        if($role_id==1)
            return true;

        $permission=\App\Model\Permission::where('slug',$permission_name)->first();
        if($permission){
            $permission_role=\App\Model\PermissionRole::where('role_id',$role_id)->where('permission_id',$permission->id)->first();
            if($permission_role)
                return true;
        }
        else
            return false;
    }

    function getAdminShowDateString() {
        $date_arr=array();

        for($i=1;$i<=30;$i++){
            $date_arr[]=date('Y-m-d',strtotime(date('Y-m-d').'+'.$i.' day'));
        }
        //["2020-6-1","2020-6-2","2020-6-3"]
        $show_date='[';
        foreach($date_arr as $d){
            $d_arr=explode('-',$d);
            $show_date.= '"'.$d_arr[0].'-'.intval($d_arr[1]).'-'.intval($d_arr[2]).'",';
        }
        $show_date=substr($show_date,0,-1).']';
        return $show_date;
    }

    function getShowDateString() {

        $holidays = \App\Model\Holiday::orderBy('holiday_date')->get();
        $holiday_arr=array();
        if($holidays->count()>0){
            foreach($holidays as $holiday)
                $holiday_arr[]=$holiday->holiday_date;
        }
        //dd($holiday_arr);
        $date_arr=array();
        //遇到假日要延展天數
        $d_from=setting('d_from');
        $d_to=setting('d_to');
        $total_days=$d_to-$d_from+1;
        //dd($total_days);
        //加到5為止的變數
        $expend_days=0;
        $stop_days=0;
        for($i=1;$i<=30;$i++){
            if($stop_days<=$d_from) {
                $plus_workdate = date('Y-m-d', strtotime(date('Y-m-d').'+'.$i.' day'));
                $w = date("w", strtotime($plus_workdate));
                $expend_days++;
                $stop_days++;
                if(in_array($plus_workdate, $holiday_arr) || $w == 6 || $w == 0) {
                    $expend_days++;
                }
            }
        }
        //dd($expend_days);
        //$expend_days++;
        for($i=$expend_days;$i < $expend_days+$total_days;$i++){
            $date_arr[]=date('Y-m-d', strtotime('+'.$i.' day'));
        }
        $show_date='[';
        foreach($date_arr as $d){
            $d_arr=explode('-',$d);
            $show_date.= '"'.$d_arr[0].'-'.intval($d_arr[1]).'-'.intval($d_arr[2]).'",';
        }
        $show_date=substr($show_date,0,-1).']';
        return $show_date;
    }

    function getShowDateString2() {
        //測試用
        $holidays = \App\Model\Holiday::orderBy('holiday_date')->get();
        $holiday_arr=array();
        if($holidays->count()>0){
            foreach($holidays as $holiday)
                $holiday_arr[]=$holiday->holiday_date;
        }
        //dd($holiday_arr);
        $date_arr=array();
        //遇到假日要延展天數
        $d_from=setting('d_from');
        $d_to=setting('d_to');
        $total_days=$d_to-$d_from+1;
        //dd($total_days);
        //加到5為止的變數
        $expend_days=0;
        $stop_days=0;
        for($i=1;$i<=30;$i++){
            if($stop_days<=$d_from) {
                $plus_workdate = date('Y-m-d', strtotime(date('Y-m-d').'+'.$i.' day'));
                $w = date("w", strtotime($plus_workdate));
                $expend_days++;
                $stop_days++;
                if(in_array($plus_workdate, $holiday_arr) || $w == 6 || $w == 0) {
                    $expend_days++;
                }
            }
        }
        //dd($expend_days);
        //$expend_days++;
        for($i=$expend_days;$i < $expend_days+$total_days;$i++){
            $date_arr[]=date('Y-m-d', strtotime('+'.$i.' day'));
        }
        $show_date='[';
        foreach($date_arr as $d){
            $d_arr=explode('-',$d);
            $show_date.= '"'.$d_arr[0].'-'.intval($d_arr[1]).'-'.intval($d_arr[2]).'",';
        }
        $show_date=substr($show_date,0,-1).']';
        return $show_date;
    }

    function getFirstCanSelectDate() {
        $holidays = \App\Model\Holiday::orderBy('holiday_date')->get();
        $holiday_arr=array();
        if($holidays->count()>0){
            foreach($holidays as $holiday)
                $holiday_arr[]=$holiday->holiday_date;
        }
        //加到5為止的變數
        $expend_days=0;
        $plus_date='';
        for($i=1;$i<=30;$i++){
            if($expend_days<=4) {
                $plus_date = date('Y-m-d', strtotime(date('Y-m-d').'+'.$i.' day'));
                $w = date("w", strtotime($plus_date));
                if(! in_array($plus_date, $holiday_arr) && $w != 6 && $w != 0) {
                    $expend_days++;
                }
            }
        }
        return $plus_date;
    }

    function getShowDateArr() {
        $date_arr=array();

        for($i=7;$i<=35;$i++){
            $date_arr[]=date('Y-m-d',strtotime(date('Y-m-d').'+'.$i.' day'));
        }

        return $date_arr;
    }


    //藍新
    /*HashKey AES 加解密 */
    function create_mpg_aes_encrypt ($parameter = "" , $key = "", $iv = "") {
        $return_str = '';
        if (!empty($parameter)) {
            //將參數經過 URL ENCODED QUERY STRING
            $return_str = http_build_query($parameter);
        }
        return trim(bin2hex(openssl_encrypt(addpadding($return_str), 'aes-256-cbc', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv)));
    }
    function addpadding($string, $blocksize = 32) {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);

        return $string;
    }

    /*HashKey AES 解密 */
    function create_aes_decrypt($parameter = "", $key = "", $iv = "") {
        return strippadding(openssl_decrypt(hex2bin($parameter),'AES-256-CBC', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv));
    }

    function strippadding($string) {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }

    /*HashIV SHA256 加密*/
    function SHA256($key="", $tradeinfo="", $iv=""){
        $HashIV_Key = "HashKey=".$key."&".$tradeinfo."&HashIV=".$iv;

        return $HashIV_Key;
    }

    function CheckOut($URL="", $MerchantID="", $TradeInfo="", $SHA256="", $VER="") {
        $szHtml = '<!doctype html>';
        $szHtml .='<html>';
        $szHtml .='<head>';
        $szHtml .='<meta charset="utf-8">';
        $szHtml .='</head>';
        $szHtml .='<body>';
        $szHtml .='<form name="newebpay" id="newebpay" method="post" action="'.$URL.'" style="display:none;">';
        $szHtml .='<input type="text" name="MerchantID" value="'.$MerchantID.'" type="hidden">';
        $szHtml .='<input type="text" name="TradeInfo" value="'.$TradeInfo.'"   type="hidden">';
        $szHtml .='<input type="text" name="TradeSha" value="'.$SHA256.'" type="hidden">';
        $szHtml .='<input type="text" name="Version"  value="'.$VER.'" type="hidden">';
        $szHtml .='</form>';
        $szHtml .='<script type="text/javascript">';
        $szHtml .='document.getElementById("newebpay").submit();';
        $szHtml .='</script>';
        $szHtml .='</body>';
        $szHtml .='</html>';

        return $szHtml;
    }
    /*取得訂單編號*/
    function getOrderNo(){
        date_default_timezone_set('Asia/Taipei'); // CDT
        $info = getdate();
        $date = $info['mday'];
        $month = $info['mon'];
        $year = $info['year'];
        $hour = $info['hours'];
        $min = $info['minutes'];
        $sec = $info['seconds'];
        $ordre_no = $year.$month.$date.$hour.$min.$sec;

        return $ordre_no;
    }

    //訂單自動取消，車輛自動上架
    function chk_ord_auto_cancel() {
        $ords=\App\Model\Ord::where('is_cancel',0)
            ->where('state_id',1)
            ->where('is_paid',0)
            ->get();
        if($ords){
            foreach($ords as $ord){
                $time2=date('Y-m-d H:i:s');
                $time1=$ord->created_at;
                $diff=(strtotime($time2) - strtotime($time1)) / 60;
                if($ord->is_pass_by_api==1)
                    $limit_minutes=setting('ord_limit_minutes');
                else
                    $limit_minutes=480;

                if($diff > $limit_minutes){
                    //dd($ord);
                    $ord->is_cancel=1;
                    $ord->state_id=14;
                    $ord->cancel_date=date('Y-m-d H:i:s');
                    $ord->update();
                    Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name,'訂單失效通知','mn3'));
                    $product=$ord->product;
                    if($product){
                        //$product->status=1;
                        //$product->is_renting=0;
                        $product->ptate_id=3;
                        $product->ord_id=null;
                        $product->update();
                    }
                    $user=$ord->user;
                    writeLog('訂單失效通知','訂單ID：'.$ord->ord_no.', 訂單編號：'.$ord->ord_no.',車輛ID：'.$product->id.',會員姓名：'.$user->id,1,'1');
                }
            }
        }
    }

    //訂閱自動下架，車輛自動上架
    function chk_subscriber_auto_cancel() {
        $subscribers=\App\Model\Subscriber::where('is_history',0)->where('is_cancel',0)->where('created_at','>=','2020-09-24 00:00:01')->get();

        if($subscribers){
            foreach($subscribers as $subscriber){
                $time2=date('Y-m-d H:i:s');
                $time1=$subscriber->created_at;
                $diff=(strtotime($time2) - strtotime($time1))/ (60*60);
                if($diff>24){
                    //dd($subscriber);
                    $subscriber->is_cancel=1;
                    $subscriber->is_history=1;
                    $subscriber->update();
                    $product=$subscriber->product;
                    if($product){
                        //$product->status=1;
                        //$product->is_renting=0;
                        $product->ptate_id=3;
                        $product->ord_id=null;
                        $product->update();
                        writeLog('訂閱單自動下架及車輛自動上架','subscriber_id='.$subscriber->id.',product_id='.$product->id,1,'1');
                    }
                }
            }
        }
    }

    //回傳訂單欄位已過的天數
    function getOrdDays($ord_id, $field='real_sub_date') {
        $ord=\App\Model\Ord::whereId($ord_id)->first();
        if($ord) {
            $time1 = $ord->{$field};
            if(!$time1)
                $time1 = $ord->sub_date;
            $time2 = date('Y-m-d H:i:s');
            return floor((strtotime($time2) - strtotime($time1)) / (60 * 60 * 24));
        }
        else
            return 0;
    }

    function getOrdReturnDays($ord_id, $field='real_back_date') {
        $ord=\App\Model\Ord::whereId($ord_id)->first();
        if($ord) {
            $time1 = $ord->{$field};
            if(!$time1)
                $time1 = $ord->sub_date;
            $time2 = date('Y-m-d H:i:s');
            return floor((strtotime($time2) - strtotime($time1)) / (60 * 60 * 24));
        }
        else
            return 0;
    }

    //回傳訂單剩餘天數
    function getOrdLeftDays($ord_id) {
        /*$left_days=setting('ord_pass_days');
        if($left_days=='')*/
        /*$ord=\App\Model\Ord::whereId($ord_id)->first();
        if($ord) {
            $rent_month=$ord->rent_month;
            if(!$rent_month)
                $rent_month=3;
            $left_days = (30*$rent_month) - getOrdDays($ord_id);
        }*/
        $ord=\App\Model\Ord::whereId($ord_id)->first();
        $time1 = $ord->expiry_date;
        $time2 = date('Y-m-d');
        $left_days=floor((strtotime($time1) - strtotime($time2)) / (60 * 60 * 24));
        return $left_days;
    }

    //檢查此車輛是否能續約
    function is_can_order_cate($subscriber_id, $user_id) {
        $usergate=\App\Model\Usergate::where('subscriber_id',$subscriber_id)->where('user_id',$user_id)->first();
        if($usergate)
            return $usergate->status;
        else
            return false;
    }

    use \Illuminate\Support\Facades\Mail;
    //訂單剩餘20天時，切換訂單狀態 6 至：7 續約招攬 , 並寄Email通知 Partner 前往設定
    function chk_change_ord_state_7(){
        $ords=\App\Model\Ord::where('is_cancel',0)->where('state_id',6)->get();
        $partner_renewal_confirm_days=setting('partner_renewal_confirm_days');
        foreach($ords as $ord){
            $left_days=getOrdLeftDays($ord->id);
            if($left_days<=$partner_renewal_confirm_days) {
                //dd($ord);
                $ord->state_id++;
                $ord->update();
                //寄發Email通知經銷商：車輛是否續租
                $partner=$ord->partner;
                if($partner){
                    $user = $ord->user;
                    Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, $partner->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 車輛續約設定通知','ry7'));
                    if($partner->partneremails->count()>0) {
                        foreach($partner->partneremails as $partneremail) {
                            if($partneremail->email)
                                Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, $partneremail->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 車輛續約設定通知','ry7'));
                        }
                        writeLog('寄發Email通知經銷商：車輛是否續租，車輛續約設定通知','ord_no='.$ord->ord_no,1,'1');
                    }
                }
            }
        }
    }

    //訂單剩餘12天時
    //1. 在訂單剩12天，車源商決定車輛不續約：發Mail通知會員不續約此車輛，請會員決定：換車續租 或 不續約(還車)
    //2. 車源商決定車輛要續約：發Mail通知會員 前往設定 是否要續約
    function chk_user_renewal_notify_email(){
        $user_renewal_start_days=setting('user_renewal_start_days');
        $ords=\App\Model\Ord::where('is_cancel',0)->where('state_id',7)->get();

        foreach($ords as $ord){
            $left_days=getOrdLeftDays($ord->id);
            /*if(getAdminUser()->id==1) {
                //echo $left_days.'<='.$user_renewal_start_days.'=='.$ord->is_user_renewal_notify_email.'--'.$ord->is_car_renewal.'<br>';
            }*/
            if($left_days<=$user_renewal_start_days && $ord->is_user_renewal_notify_email==0) {
                //如果車源商不續約
                if($ord->is_car_renewal==0){
                    $ord->state_id++;
                    $ord->update();
                    //發Mail給會員通知車輛不續約
                    send_ord_all_email($ord, '車輛不提供續約通知', 1, 'mn7', 1, 'mn7', 0, '');
                    writeLog('寄發Email，車輛不提供續約通知','ord_no='.$ord->ord_no,1,'1');
                }
                else{
                    //發Mail通知會員前往設定是否要續約
                    $is_user_renewal_notify_email=$ord->is_user_renewal_notify_email;
                    if($is_user_renewal_notify_email==0){
                        Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, $ord->email, $ord->name, '訂閱續約設定通知', 'my7'));
                        $ord->is_user_renewal_notify_email=1;
                        $ord->update();
                        writeLog('發Mail通知會員前往設定是否要續約','ord_no='.$ord->ord_no,1,'1');
                    }
                }
            }
        }
        /*if(getAdminUser()->id==1) {
            //dd('');
        }*/
    }

    //訂單剩餘10天時，寄Email通知 保姆設定續約月份
    function chk_renew_autosend_email_to_babysitter(){
        $ords=\App\Model\Ord::where('is_cancel',0)->where('state_id',7)->get();
        $user_renewal_end_days=setting('user_renewal_end_days');
        foreach($ords as $ord){
            $left_days=getOrdLeftDays($ord->id);
            $renewtate_id=$ord->renewtate_id;
            //如果是剩10天，同車續約，沒有通知過保姆
            if($left_days<$user_renewal_end_days){
                //dd($ords);
                $user=$ord->user;
                if($renewtate_id==1 && $ord->is_notify_babysitter_renewtate_id_1==0) {
                    send_ord_all_email($ord, ' 月份數設定通知', '', '', 1, 'ry8-1', '', '');
                    $ord->is_notify_babysitter_renewtate_id_1 = 1;
                    $ord->update();
                }
                //如果是換車，但會員還是沒有上去換車，則到第10天清除會員的換車記錄
                elseif($renewtate_id==2 && $user->is_change_car==1){
                    //清除會員換車註記
                    $user->is_change_car=0;
                    $user->before_renew_change_car_ord_id=null;
                    $user->before_renew_change_car_ord_no=null;
                    $user->update();
                }
            }
        }
    }

    //訂單剩餘7天時，將狀態還是7的 自動切換狀態至：8 準備還車事宜, 並寄Email通知 會員準備還車
    //1.如果車源商要提供續租：則會有選項
    //  (1).同車續約
    //  (2).換車續約
    //  (3).不續約
    //  (4).購車
    //2.如果車源商不提供續租：則會有選項
    //  (1).換車車續約
    //  (2).不續約
    function chk_change_ord_state_8(){
        $ords=\App\Model\Ord::where('is_cancel',0)->where('state_id',7)->get();
        //dd($ords);
        $user_renewal_autosend_days=setting('user_renewal_autosend_days');
        foreach($ords as $ord){
            $left_days=getOrdLeftDays($ord->id);

            if($left_days<$user_renewal_autosend_days) {
                //dd($ord);
                $ord->state_id++;
                $ord->update();

                $renewtate_id=$ord->renewtate_id;
                if(!$renewtate_id)
                    $renewtate_id=3;
                if($renewtate_id==1) {
                    $new_ord = clone_new_ord($ord);
                    //同車續約
                    send_ord_all_email($new_ord, '訂閱續約通知', 1, 'my8', 1, 'ry8', 1, 'ry8', '', 1);
                }
                /*elseif($renewtate_id==2)
                    //換車續約
                    send_ord_all_email($ord, '訂閱換車通知', 1,'my8-2',1,'ry8-2',1,'ry8-2');*/
                elseif(!$renewtate_id || $renewtate_id==3)
                    //不續約
                    send_ord_all_email($ord, '訂閱不續約通知', 1,'mn8',1,'rn8',1,'rn8');
                elseif($renewtate_id==4)
                    //購車
                    send_ord_all_email($ord, '訂閱購車通知', 1,'my8-3',1,'ry8-3',1,'ry8-3');

                $ord->is_renewtate_setting_finish=1;
                $ord->update();
            }
        }
    }

    function send_ord_all_email(Ord $ord, $subject, $send_member='',$view1='', $send_babysitter='', $view2='', $sned_partner='', $view3='', $is_send_partner2='',$is_send_ordplace='') {
        //寄發Email通知 保姆 及 經銷商 會員選擇續約結果Email
        $msg='訂單編號：'.$ord->ord_no.'、已寄給->';
        if($send_member==1) {
            Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name, $subject, $view1));
            $msg.='會員:'.$ord->name.'、';
        }
        if($send_babysitter==1) {
            $partner = $ord->partner;
            $user = $ord->user;
            send_babysitter_ord_email($ord, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view2,$is_send_ordplace);
            $msg.='保姆、';
        }
        if($sned_partner==1) {
            $partner = $ord->partner;
            $user = $ord->user;
            if($partner) {
                if($is_send_ordplace==1)
                    Mail::send(new \App\Mail\SendMail\SendOrdPlaceEmail($ord, $partner->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                else
                    Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, $partner->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));

                if($partner->partneremails->count() > 0) {
                    foreach($partner->partneremails as $partneremail) {
                        if($partneremail->email) {
                            if($is_send_ordplace==1)
                                Mail::send(new \App\Mail\SendMail\SendOrdPlaceEmail($ord, $partneremail->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                            else
                                Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, $partneremail->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                        }
                    }
                }
                $msg.='車源商:'.$partner->title.'、';
            }
            if($is_send_partner2) {
                $partner2=$ord->partner2;
                if($partner2) {
                    if($partner2->email) {
                        if($is_send_ordplace==1)
                            Mail::send(new SendOrdPlaceEmail($ord, $partner2->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                        else
                            Mail::send(new SendOrdEmail($ord, $partner2->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                    }
                    if($partner2->partneremails->count() > 0) {
                        foreach($partner2->partneremails as $partneremail) {
                            if($partneremail->email) {
                                if($is_send_ordplace==1)
                                    Mail::send(new SendOrdPlaceEmail($ord, $partneremail->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                                else
                                    Mail::send(new SendOrdEmail($ord, $partneremail->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                            }
                        }
                    }
                    $msg.='原車所'.$partner2->title;
                }
            }
        }
        writeLog('已成功寄出Email',$msg,1);
    }

    function send_ord_all_email_test(Ord $ord, $subject, $send_member='',$view1='', $send_babysitter='', $view2='', $sned_partner='', $view3='', $is_send_partner2='',$is_send_ordplace='') {
        //寄發Email通知 保姆 及 經銷商 會員選擇續約結果Email
        $msg='訂單編號：'.$ord->ord_no.'、已寄給->';
        if($send_member==1) {
            Mail::send(new SendOrdEmail($ord, 'eric@eze23.com', '會員：'.$ord->name, $subject, $view1));
            $msg.='會員:'.$ord->name.'、';
        }
        if($send_babysitter==1) {
            $partner = $ord->partner;
            $user = $ord->user;
            send_babysitter_ord_email($ord, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view2,$is_send_ordplace);
            $msg.='保姆、';
        }
        if($sned_partner==1) {
            $partner = $ord->partner;
            $user = $ord->user;
            if($partner) {
                if($is_send_ordplace==1)
                    Mail::send(new \App\Mail\SendMail\SendOrdPlaceEmail($ord, 'eric@eze23.com', '車源商1：'.$partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                else
                    Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, 'eric@eze23.com', '車源商p1：'.$partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));

                if($partner->partneremails->count() > 0) {
                    foreach($partner->partneremails as $partneremail) {
                        if($partneremail->email) {
                            if($is_send_ordplace==1)
                                Mail::send(new \App\Mail\SendMail\SendOrdPlaceEmail($ord, 'eric@eze23.com', '車源商p1-：'.$partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                            else
                                Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, 'eric@eze23.com', '車源商p1-：'.$partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                        }
                    }
                }
                $msg.='車源商:'.$partner->title.'、';
            }
            if($is_send_partner2) {
                $partner2=$ord->partner2;
                if($partner2) {
                    if($partner2->email) {
                        if($is_send_ordplace==1)
                            Mail::send(new SendOrdPlaceEmail($ord, 'eric@eze23.com', $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                        else
                            Mail::send(new SendOrdEmail($ord, 'eric@eze23.com', $partner2->title, '(原車所p) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                    }
                    if($partner2->partneremails->count() > 0) {
                        foreach($partner2->partneremails as $partneremail) {
                            if($partneremail->email) {
                                if($is_send_ordplace==1)
                                    Mail::send(new SendOrdPlaceEmail($ord, 'eric@eze23.com', $partner2->title, '(原車所p) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                                else
                                    Mail::send(new SendOrdEmail($ord, 'eric@eze23.com', $partner2->title, '(原車所p) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' '.$subject, $view3));
                            }
                        }
                    }
                    $msg.='原車所'.$partner2->title;
                }
            }
        }
        //writeLog('已成功寄出Email',$msg,1);
    }

    /*function auto_send_remind_eamil_to_user_and_partner(){
        $ords=Ord::where('is_cancel',0)->where('state_id',3)->where('is_partner_remind_delivery_car_email',0)->get();
        if($ords){
            foreach($ords as $ord){
                $left_sub_days=getOrdDays($ord->id,'sub_date')*-1;
                if($left_sub_days<=10){
                    $user=$ord->user;
                    Mail::send(new \App\Mail\SendMail\SendOrdEmail($ord, $user->email, $user->title,'交車提醒通知','my4'));
                    //寄出提醒經銷商 剩10天要交車
                    $partner=$ord->partner;
                    if($partner){
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
                        $ord->is_partner_remind_delivery_car_email=1;
                        $ord->update();
                    }
                }
            }
        }

    }*/

    function clone_new_ord(Ord $orginal_ord) {
        $user=$orginal_ord->user;
        $cate=$orginal_ord->cate;
        $product=$orginal_ord->product;
        $proarea_id=$orginal_ord->proarea_id;
        $brandcat=$product->brandcat;
        $brandin=$product->brandin;

        //起租款
        $basic_fee=$cate->basic_fee;
        $mile_fee=$cate->mile_fee;
        $mile_pre_month=$cate->mile_pre_month;
        $renew_month=$orginal_ord->renew_month;
        if(!$renew_month)
            $renew_month=3;
        $payment_total=($basic_fee+($mile_fee*$mile_pre_month)) * $renew_month;
        $ord=new Ord();
        $ord->user_id=$user->id;
        $ord_no=Carbon::now()->format('ymd').rand(10000,99999);
        $ord->ord_no=$ord_no;
        $ord->checkout_no=$ord_no;
        $ord->is_renew_order=1;
        $ord->rent_month=$renew_month;
        $ord->renew_ord_id=$orginal_ord->id;
        $ord->renew_ord_no=$orginal_ord->ord_no;
        $ord->deposit=$cate->deposit;
        $ord->basic_fee=$cate->basic_fee;
        $ord->mile_fee=$cate->mile_fee;
        $ord->mile_pre_month=$cate->mile_pre_month;
        $ord->payment_total=$payment_total;
        $ord->subscriber_id=$orginal_ord->subscriber_id;
        $ord->cate_id=$cate->id;
        $ord->cate_title=$cate->title;
        $ord->partner_id=$product->partner_id;
        $ord->order_from=$orginal_ord->order_from;
        $ord->is_carplus=$orginal_ord->is_carplus;
        $ord->product_id=$product->id;
        $ord->delivery_address = $orginal_ord->delivery_address;
        $ord->return_delivery_address = $orginal_ord->return_delivery_address;
        $ord->model=$orginal_ord->model;
        $ord->plate_no=$orginal_ord->plate_no;
        $ord->milage=$orginal_ord->back_milage;
        $ord->proarea_id=$proarea_id;
        $ord->sub_date=$orginal_ord->expiry_date;
        $ord->expiry_date=date('Y-m-d',strtotime($ord->sub_date.' +'.(($renew_month*30)-1).' day'));
        if($ord->expiry_date<$ord->sub_date)
            $ord->expiry_date=date('Y-m-d',strtotime($ord->sub_date.' +89 day'));
        $ord->brandcat_name=$brandcat->title;
        $ord->brandin_name=$brandin->title;
        $ord->total=$cate->deposit;
        $ord->name=$user->name;
        $ord->phone=$user->phone;
        $ord->email=$user->email;
        $ord->address=$user->address;

        $ord->is_paid=$orginal_ord->is_paid;
        $ord->paid_date=date('Y-m-d H:i:s');
        $ord->is_creditpay_success=$orginal_ord->is_creditpay_success;
        $ord->creditpay_return_code=$orginal_ord->creditpay_return_code;
        $ord->creditpay_return_message=$orginal_ord->creditpay_return_message;
        $ord->state_id=2;

        $ord->save();

        //新增會員同車續約狀態
        $samecartate_id=$user->samecartate_id;
        if(!$samecartate_id)
            $samecartate_id=1;
        $samecartate_id++;
        $user->samecartate_id=$samecartate_id;
        $user->update();

        $orginal_ord->is_renewtate_setting_finish=1;
        $orginal_ord->update();

        return $ord;
    }

    function user_upload_count(\App\Model\frontend\User $user) {
        $cnt=0;
        if($user->idcard_image01)
            $cnt++;

        if($user->idcard_image02)
            $cnt++;

        if($user->driver_image01)
            $cnt++;

        if($user->driver_image02)
            $cnt++;
        return $cnt;
    }

    function check_auto_online_product() {
        $products=Product::where('ptate_id',4)->where('auto_online_date','<=',date('Y-m-d'))->get();
        foreach($products as $product) {
            //dd($product);
            $product->status=1;
            $product->is_renting=0;
            $product->ptate_id=3;
            $product->auto_online_date='';
            $product->update();
        }
    }

    function carplus_api($url, $data_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array('code'=>$return_code, 'result'=>$return_content);
    }

    function getChineseBirthday($birthday,$pattern='') {
        //取得台灣生日格式
        $chinese_year=date('Y', strtotime($birthday))-1911;
        $chinese_year=str_pad($chinese_year,3,"0",STR_PAD_LEFT);
        $chinese_month=date('m', strtotime($birthday));
        $chinese_day=date('d', strtotime($birthday));
        return $chinese_year.$pattern.$chinese_month.$pattern.$chinese_day;
    }

    function send_babysitter_subscriber_email(\App\Model\Subscriber $subscriber, $subject, $view) {
        $store_name = setting('store_name');
        for($i=1;$i<=4;$i++) {
            $email = setting('email0'.$i);
            if($email)
                Mail::send(new SendSubscriberEmail($subscriber, $email, $store_name, $subject, $view));
        }
    }

    function send_babysitter_user_email(\App\Model\frontend\User $user, $subject, $view) {
        $store_name = setting('store_name');
        for($i=1;$i<=4;$i++) {
            $email = setting('email0'.$i);
            if($email)
                Mail::send(new SendUserEmail($user, $email, $store_name, $subject, $view));
        }
        //Mail::send(new SendUserEmail($user, 'eric@eze23.com', $store_name, $subject, $view));
        writeLog('更新 使用者, 並送出Email:cy1 給保姆','會員ID：'.$user->id.' 姓名：'.$user->name.'',0);
    }

    function send_babysitter_ord_email(Ord $ord, $subject, $view, $is_send_ordplace='') {
        $store_name = setting('store_name');
        for($i=1;$i<=4;$i++) {
            $email = setting('email0'.$i);
            if($email) {
                if($is_send_ordplace==1)
                    Mail::send(new SendOrdPlaceEmail($ord, $email, $store_name, $subject, $view));
                else
                    Mail::send(new SendOrdEmail($ord, $email, $store_name, $subject, $view));
            }
        }
    }

    function send_babysitter_ord_email_test(Ord $ord, $subject, $view, $is_send_ordplace='') {
        $store_name = setting('store_name');
        for($i=1;$i<=4;$i++) {
            $email = setting('email0'.$i);
            if($email) {
                if($is_send_ordplace==1)
                    Mail::send(new SendOrdPlaceEmail($ord, $email, $store_name, $subject, $view));
                else
                    Mail::send(new SendOrdEmail($ord, $email, $store_name, $subject, $view));
            }
        }
    }

    function get_report_calc_precent($order_from, $dealer_id) {
        /*$ord=Ord::whereId($ord_id);
        if(!$ord)
            return -1;
        $product=$ord->product;
        if(!$product)
            return -1;*/


    }
