<?php

namespace App\Http\Controllers\admin\Email;

use App\Exports\UserExport;
//use App\Mail\RegisterNotiyPlaced;
use App\Mail\OnlyUserSubscriberReviewRejectNotifyPlaced;
use App\Mail\RejectNotiyPlaced;
use App\Mail\ReviewNotiyPlaced;
use App\Mail\SendMail\SendOrdEmail;
use App\Mail\SendMail\SendOrdPlaceEmail;
use App\Mail\SendMail\SendSubscriberEmail;
use App\Mail\SendUserDataAndCateNotifyPlaced;
use App\Mail\SendMail\SendUserEmail;
use App\Mail\UserSubscriberReviewOkNotifyPlaced;
use App\Mail\UserSubscriberReviewRejectNotifyPlaced;
use App\Mail\UserTempNotiyPlaced;
use App\Mail\UserTempRejectNotiyPlaced;
use App\Model\Cate;
use App\Model\frontend\User;
use App\Model\Ord;
use App\Model\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\User\AdminUserRequest;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class AdminEmailController extends Controller
{

    public function mn1_1(User $user)
    {
        $user->is_mn1_1_email=1;
        $user->update();
        writeLog('寄給會員 會員資料補齊 通知已成功送出','ID:'.$user->id.' 姓名:'.$user->name.' → is_mn1_1_email=1');
        Mail::send(new SendUserEmail($user, $user->email, $user->name, '會員資料補齊通知', 'mn1_1'));
        return redirect()->back()->with('success_message', '信件已成功送出。');
    }

    public function my1_1(User $user)
    {
        $user->is_my1_1_email=1;
        $user->update();
        writeLog('寄給會員 訂閱開通 通知已成功送出','ID:'.$user->id.' 姓名:'.$user->name.' → is_my1_1_email=1');
        Mail::send(new SendUserEmail($user, $user->email, $user->name, '訂閱開通通知', 'my1_1'));
        return redirect()->back()->with('success_message', '信件已成功送出。');
    }

    public function my2(Subscriber $subscriber)
    {
        $user=$subscriber->user;

        if($subscriber->can_order_car!=1)
            return redirect()->back()->with('failure_message','審查方案要設通過才可送出通知。');

        //產生訂單
        if(!$subscriber->ord_id) {
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
            //$ord->checkout_no = $ord_no;
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
            $ord->order_from=$subscriber->order_from;
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
                $user->update();
            }

            $ord->save();

            $product->ord_id = $ord->id;
            //$product->status = 0;
            //$product->is_renting = 1;
            $product->ptate_id=1;
            $product->update();

            $subscriber->ord_id = $ord->id;
            $subscriber->is_my2_email = 1;
            $subscriber->is_history = 1;
            $subscriber->update();
            writeLog('審核通過已產生一張訂單',$ord->toArray());
        }

        Mail::send(new SendSubscriberEmail($subscriber, $user->email, $user->name, $user->name.' 方案審核通過通知', 'my2'));
        writeLog('寄給會員 方案審核通過 通知已成功送出','會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id.' → is_my2_email=1');
        if($user && $user->id_type==1) {
            send_babysitter_subscriber_email($subscriber, $user->name.' 方案審核通過通知', 'cy2');
            writeLog('方案審核通過 通知已成功寄給保姆','會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id.' → is_my2_email=1');
        }
        return redirect()->back()->with('success_message', '信件已成功送出。');
    }

    public function mn2(Subscriber $subscriber)
    {
        $user=$subscriber->user;
        $is_baby=Request('is_baby');
        if($subscriber->can_order_car!=0)
            return redirect()->back()->with('failure_message','審查方案要設為：不通過，才可送出拒絕通知。');
        if($is_baby==1) {
            $subscriber->is_mn2_baby_email=1;
            $subscriber->is_history=1;

            $user=$subscriber->user;
            Mail::send(new SendSubscriberEmail($subscriber, $user->email, $user->name, '方案審核不通過通知',
                'mn2'));
            writeLog('方案審核不通過通知 已成功寄給會員','會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id.' → is_mn2_baby_email=1');
        }
        else {
            $subscriber->is_mn2_email=1;
            $subscriber->is_history=0;

            send_babysitter_subscriber_email($subscriber,$user->name.' 方案審核不通過通知', 'mn2');

            writeLog('方案審核不通過通知 已成功寄給經銷商','會員姓名：'.$user->name.' 訂閱ID：'.$subscriber->id.' → is_mn2_email=1');
        }
        $subscriber->update();
        return redirect()->back()->with('success_message', '信件已成功送出。');
    }

    public function ry3(Ord $ord, $is_partner=1) {
        if($is_partner) {
            $user=$ord->user;
            //經銷商
            $partner = $ord->partner;
            $partner = $ord->partner;
            $partner_name = '';
            $partner2_name = '';
            if($partner) {
                $partner_name = $partner->title;
                if($partner->email)
                    Mail::send(new SendOrdPlaceEmail($ord, $partner->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知', 'ry3'));
                if($partner->partneremails->count() > 0) {
                    foreach($partner->partneremails as $partneremail) {
                        if($partneremail->email)
                            Mail::send(new SendOrdPlaceEmail($ord, $partneremail->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知', 'ry3'));
                    }
                }
            }
            $partner2 = $ord->partner2;
            if($partner2) {
                $partner2_name = ', '.$partner2->title;
                if($partner2->email)
                    Mail::send(new SendOrdPlaceEmail($ord, $partner2->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知', 'ry3'));
                if($partner2->partneremails->count() > 0) {
                    foreach($partner2->partneremails as $partneremail) {
                        if($partneremail->email)
                            Mail::send(new SendOrdPlaceEmail($ord, $partneremail->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.' 保證金付清通知', 'ry3'));
                    }
                }
            }
        }
        else{
            Mail::send(new SendOrdEmail($ord, $ord->email, $ord->title, '保證金付清通知', 'ry3'));
        }
        writeLog('保證金付清通知 已成功寄給經銷商:'.$partner_name.$partner2_name,'會員姓名：'.$user->name.' 訂單ID：'.$ord->id.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id);
        return redirect()->back()->with('success_message', '信件已成功送出。');
    }

    public function ry3_1(Ord $ord,$is_partner=1) {
        //經銷商
        if($is_partner==1) {
            $user=$ord->user;
            $partner=$ord->partner;
            $partner_name = '';
            $partner2_name = '';
            if($partner) {
                $partner_name = $partner->title;
                Mail::send(new SendOrdPlaceEmail($ord, $partner->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.'/訂單變更通知', 'ry3-1'));
                if($partner->partneremails->count() > 0) {
                    foreach($partner->partneremails as $partneremail) {
                        if($partneremail->email)
                            Mail::send(new SendOrdPlaceEmail($ord, $partneremail->email, $partner->title, $partner->title.'/'.$ord->plate_no.'/'.$user->name.'/訂單變更通知', 'ry3-1'));
                    }
                }
            }
            $partner2 = $ord->partner2;
            if($partner2) {
                $partner2_name = ', '.$partner2->title;
                Mail::send(new SendOrdPlaceEmail($ord, $partner2->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.'/訂單變更通知', 'ry3-1'));
                if($partner2->partneremails->count() > 0) {
                    foreach($partner2->partneremails as $partneremail) {
                        if($partneremail->email)
                            Mail::send(new SendOrdPlaceEmail($ord, $partneremail->email, $partner2->title, '(原車所) '.$partner2->title.'/'.$ord->plate_no.'/'.$user->name.'/訂單變更通知', 'ry3-1'));
                    }
                }
            }
        }
        else{
            Mail::send(new SendOrdEmail($ord, $ord->email, $ord->name, '訂單變更通知', 'ry3-1'));
        }
        writeLog('訂單變更通知 已成功寄給經銷商:'.$partner_name.$partner2_name,'會員姓名：'.$user->name.' 訂單ID：'.$ord->id.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id);
        return redirect()->back()->with('success_message', '信件已成功送出。');
    }

    public function ry10_1(Ord $ord,$is_partner=1) {
        //Mail::send(new SendOrdEmail($ord, 'eric@eze23.com', $ord->name, '迄租款付清通知', 'my10'));
        send_ord_all_email($ord, '迄租款付清通知', 1, 'my10', 1, 'cy10', 1, 'cy10');
        $user=$ord->user;
        writeLog('迄租款付清通知，已寄Email 迄租款付清通知：my10->消費者、cy10->保姆、cy10->車源商。','會員姓名：'.$user->name.' 訂單ID：'.$ord->id.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id);
        return redirect()->back()->with('success_message', '信件已成功送出。');
    }

    public function ry10(Ord $ord,$is_partner=1) {
        //Mail::send(new SendOrdEmail($ord, 'eric@eze23.com', $ord->name, '已還車通知', 'ry10'));
        send_ord_all_email($ord, '已還車通知', 0, '', 0, '', 1, 'ry10');
        $user=$ord->user;
        writeLog('已還車通知，已寄Email：ry10->車源商。','會員姓名：'.$user->name.' 訂單ID：'.$ord->id.', 訂單編號：'.$ord->ord_no.', 車輛ID：'.$ord->product_id);
        return redirect()->back()->with('success_message', '信件已成功送出。');
    }

    public function my8ry8(Ord $ord)
    {
        /*$ord->state_id++;
        $ord->update();*/

        $renewtate_id=$ord->renewtate_id;
        if($renewtate_id==1) {
            $new_ord = clone_new_ord($ord);
            //同車續約
            send_ord_all_email($new_ord, '訂閱續約通知', 1, 'my8', 1, 'ry8', 1, 'ry8', '', 1);
        }
        return redirect()->back()->with('success_message', '已產生新的同車續約單，my8 cy8 ry8信件已成功送出。');
    }

    public function my12(User $user)
    {
        $user->is_mn1_1_email=1;
        $user->update();
        writeLog('寄給會員 其他費用繳款提醒 通知已成功送出','ID:'.$user->id.', 會員姓名：'.$user->name.' → is_mn1_1_email=1');
        Mail::send(new SendUserEmail($user, $user->email, $user->name, '其他費用繳款提醒通知', 'my12'));
        return redirect()->back()->with('success_message', '信件已成功送出。');
    }




}
