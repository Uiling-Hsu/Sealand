<?php

namespace App\Http\Controllers\admin\Setting;

use App\Model\Setting;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Setting\AdminSettingRequest;
use App\Http\Controllers\Controller;

class AdminSettingController extends Controller
{
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if(!has_permission('setting'))
                abort(403);
            return $next($request);
        });
    }

    public function index(){
        $store_name=Setting::where('key','store_name')->first()->val;
        $address=Setting::where('key','address')->first()->val;
        $phone=Setting::where('key','phone')->first()->val;
        $fax=Setting::where('key','fax')->first()->val;
        $email=Setting::where('key','email')->first()->val;
        $email01=Setting::where('key','email01')->first()->val;
        $email02=Setting::where('key','email02')->first()->val;
        $email03=Setting::where('key','email03')->first()->val;
        $email04=Setting::where('key','email04')->first()->val;
        $email_contact=Setting::where('key','email_contact')->first()->val;
        $car_plus_email01=Setting::where('key','car_plus_email01')->first()->val;
        $car_plus_email02=Setting::where('key','car_plus_email02')->first()->val;
        $website=Setting::where('key','website')->first()->val;
        $website_carplus=Setting::where('key','website_carplus')->first()->val;
        $facebook_url=Setting::where('key','facebook_url')->first()->val;
        $line_url=Setting::where('key','line_url')->first()->val;
        $free_shipping=Setting::where('key','free_shipping')->first()->val;
        $shipping=Setting::where('key','shipping')->first()->val;
        $shopping_spec=Setting::where('key','shopping_spec')->first()->val;
        $partner_renewal_confirm_days=Setting::where('key','partner_renewal_confirm_days')->first()->val;
        $user_renewal_start_days=Setting::where('key','user_renewal_start_days')->first()->val;
        $user_renewal_end_days=Setting::where('key','user_renewal_end_days')->first()->val;
        $user_renewal_autosend_days=Setting::where('key','user_renewal_autosend_days')->first()->val;
        $ord_pass_days=Setting::where('key','ord_pass_days')->first()->val;
        $holiday=Setting::where('key','holiday')->first()->val;
        $d_from=Setting::where('key','d_from')->first()->val;
        $d_to=Setting::where('key','d_to')->first()->val;
        $ord_limit_minutes=Setting::where('key','ord_limit_minutes')->first()->val;
        $header_logo=Setting::where('key','header_logo')->first()->val;
        $is_qa_display=Setting::where('key','is_qa_display')->first()->val;
        $contactDemand=Setting::where('key','contact_demand')->first();
        $contact_demand='';
        if($contactDemand)
            $contact_demand=$contactDemand->val;
        //dd($settings);
        return view('admin.setting.setting',
            compact(
                'store_name',
                'address',
                'phone',
                'fax',
                'email',
                'email01',
                'email02',
                'email03',
                'email04',
                'email_contact',
                'car_plus_email01',
                'car_plus_email02',
                'website',
                'website_carplus',
                'facebook_url',
                'line_url',
                'free_shipping',
                'shipping',
                'shopping_spec',
                'holiday',
                'd_from',
                'd_to',
                'ord_limit_minutes',
                'partner_renewal_confirm_days',
                'user_renewal_start_days',
                'user_renewal_end_days',
                'user_renewal_autosend_days',
                'ord_pass_days',
                'is_qa_display',
                'header_logo',
                'contact_demand'
            ));
    }

    public function update(AdminSettingRequest $request){
        if ($request->hasFile('headerLogoFile')){
            $image_width=230;
            $image_height=null;
            $upload_filename = upload_file($request->file('headerLogoFile'), 'setting', $image_width, $image_height);
            if($upload_filename==-1){
                Session::flash('failure_message', '上傳圖檔只限 *.jpg、*.jpeg 或 *.png 格式');
                return redirect()->back();
            }
            $setting = Setting::where('key', 'header_logo')->first();
            $setting->val = $upload_filename;
            $setting->update();
        }

        foreach($request->all() as $key=>$data){
            $setting = Setting::where('key', $key)->first();
            if($setting && $setting->val!=$data) {
                $setting->val = $data;
                $setting->update();
                writeLog('更新 設定',$setting->key.' → '.$data);
            }
        }

        Session::flash('success_message', '更新成功!');
        return redirect('admin/setting');
    }

}
