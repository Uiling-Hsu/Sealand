<?php

namespace App\Http\Controllers\frontend;

use App\Http\Requests\Contact\AdminContactRequest;
use App\Mail\ContactPlaced;
use App\Mail\Upload5CodePlaced;
use App\Model\Contact;
use App\Model\Faq;
use App\Model\frontend\User;
use App\Model\Ord;
use App\Model\Setting;
use App\Notifications\ContactSendSuccessfully;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    function index($tab_name='') {
        $tab=Request('tab');
        if(!$tab)
            $tab='tab3-1';
        if($tab_name=='ord')
            $tab='tab3-7';
        elseif($tab_name=='contact')
            $tab='tab3-11';
        $ords=new Ord();
        $user=new User();
        if(isUserLogin()){
            $user=Auth::guard('user')->user();
            $ords = Ord::where('user_id', $user->id)
                ->where('is_cancel',0)
                ->orderBy('created_at','DESC');
            $list_ords=$ords->get()->pluck('ord_no','ord_no')->prepend('','');
            $ords=$ords->paginate(5);
        }
        $faqs=Faq::whereStatus(1)->orderBy('sort')->get();
        $shopping_spec=Setting::where('key','shopping_spec')->first()->val;
        return view('frontend.customer',compact('tab','user', 'ords','list_ords','faqs','shopping_spec'));
    }

    function to_tab($tab) {
        session()->put('tab',$tab);
        return redirect()->route('customer');
    }

    function ord_search(Request $request) {
        $tab='tab3-7';
        $phone=$request->phone;
        $delivery_phone=$request->delivery_phone;
        $ord = Ord::where('ord_no', $request->ord_no)
            ->where(function ($query) use ($phone, $delivery_phone) {
                $query->where('phone', $phone)
                    ->orWhere('delivery_phone', $delivery_phone);
            })->first();
        $user=new User();
        if(isUserLogin())
            $user=Auth::guard('user')->user();
        $faqs=Faq::whereStatus(1)->orderBy('sort')->get();
        $shopping_spec=Setting::where('key','shopping_spec')->first()->val;
        return view('frontend.customer',compact('ord','tab','faqs','user','shopping_spec'));
    }

    function upload5code(Request $request) {
        $tab='tab3-10';
        $ord = Ord::where('ord_no', $request->ord_no)->first();

        if(!$ord) {
            session()->flash('failure_message', '您輸入錯誤的訂單編號，請重新確認一次！');
            return redirect()->back();
        }
        else{
            $ord->upload_5code=$request->upload_5code;
            $ord->upload_total=$request->upload_total;
            $ord->upload_date=$request->upload_date;
            $ord->upload_memo=$request->upload_memo;
            $ord->update();
            Mail::send(new Upload5CodePlaced($ord));
            session()->flash('success_message', '匯款帳號後5碼已上傳成功。');

            //return view('frontend.customer',compact('ord','tab'));
            return redirect('customer?tab='.$tab);
        }
    }

    function contact_post(AdminContactRequest $request) {
        $tab='tab3-11';
        $message=$request->message;
        if(!strpos($message,'http') && !strpos($message,'bit.ly') && !strpos($message,'drive.google.com')) {
            $inputs = $request->all();
            $contact = Contact::create($inputs);
            //$contact->notify(new ContactSendSuccessfully($contact));
            Mail::send(new ContactPlaced($contact));
        }
        session()->flash('success_message', '您的訊息已成功送出，我們將儘快回覆您的訊息。');
        return redirect('customer?tab='.$tab);

    }
}
