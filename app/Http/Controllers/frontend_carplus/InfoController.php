<?php

namespace App\Http\Controllers\frontend_carplus;

use App\Http\Requests\Contact\AdminContactRequest;
use App\Mail\ContactPlaced;
use App\Mail\Upload5CodePlaced;
use App\Model\Aboutin;
use App\Model\Cate;
use App\Model\Contact;
use App\Model\Dealer;
use App\Model\Faqcat;
use App\Model\Faqin;
use App\Model\Flowcat;
use App\Model\Flowin;
use App\Model\frontend\User;
use App\Model\Hotin;
use App\Model\Ord;
use App\Model\Product;
use App\Model\Service;
use App\Model\Setting;
use App\Model\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;

class InfoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //$aboutin=Aboutin::whereStatus(1)->orderBy('sort')->first();
        $sliders=Slider::whereStatus(1)->orderBy('sort')->get();
        $dealers=Dealer::whereStatus(1)->orderBy('sort')->get();
        //$cnt=9;
        $cate13s=Cate::where('is_display',1)->orderBy('sort')->get();
        //$cate13s=Cate::whereStatus(1)->where('id',$cnt++)->orWhere('id',$cnt++)->orWhere('id',$cnt++)->orderBy('sort')->get();
        //$cate45s=Cate::whereStatus(1)->where('id',$cnt++)->orWhere('id',$cnt++)->orderBy('sort')->get();
        //$cate67s=Cate::whereStatus(1)->where('id',$cnt++)->orWhere('id',$cnt++)->orderBy('sort')->get();
        //$products=Product::whereStatus('1')->orderBy('created_at','DESC')->take(4)->get();
        //$hotins=Hotin::whereStatus('1')->orderBy('created_at','DESC')->take(2)->get();
        //$promoins=Hotin::whereStatus('1')->orderBy('created_at','DESC')->take(2)->get();

        return view('frontend_carplus.index',compact('sliders','dealers','cate13s'));
    }

    function about() {
        $aboutins=Aboutin::whereStatus(1)->orderBy('sort')->get();
        return view('frontend_carplus.about',compact('aboutins'));
    }

    function channel() {
        $channelins=Channelin::whereStatus(1)->orderBy('sort')->get();
        return view('frontend_carplus.channel',compact('channelins'));
    }

    function internet() {
        $internetins=Internetin::whereStatus(1)->orderBy('sort')->get();
        return view('frontend_carplus.internet',compact('internetins'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function news(){
        $hotins=Hotin::where('status','1')->orderBy('published_at','DESC')->paginate(6);
        return view('frontend_carplus.news',compact('hotins'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function news_in(Hotin $hotin)
    {
        if(!$hotin)
            abort(404);
        return view('frontend_carplus.news_in',compact('hotin'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function promo(){
        $promoins=Promoin::where('status','1')->orderBy('published_at','DESC')->paginate(6);
        return view('frontend_carplus.promo',compact('promoins'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function promo_in(Promoin $promoin)
    {
        if(!$promoin)
            abort(404);
        return view('frontend_carplus.promo_in',compact('promoin'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function story(){
        $list_storycats=Storycat::whereStatus(1)->orderBy('sort')->get();
        $storycat_id=Request('storycat_id');
        if(!$storycat_id && $list_storycats) {
            $storycat_id=$list_storycats[0]->id;
            $storyins = Storyin::where('storycat_id', $storycat_id)->where('status', '1')->orderBy('sort')->paginate(6);
        }
        else
            $storyins=Storyin::where('storycat_id',$storycat_id)->where('status','1')->orderBy('sort')->paginate(6);
        return view('frontend_carplus.story',compact('storyins','list_storycats','storycat_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function story_in(Storyin $storyin)
    {
        if(!$storyin)
            abort(404);
        return view('frontend_carplus.story_in',compact('storyin'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function service(Service $service)
    {
        if(!$service)
            abort(404);
        return view('frontend_carplus.service',compact('service'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function faq(){
        $list_faqcats=Faqcat::whereStatus(1)->orderBy('sort')->get();
        $faqcat_id=Request('faqcat_id');
        if(!$faqcat_id && $list_faqcats) {
            $faqcat_id=$list_faqcats[0]->id;
            $faqins = Faqin::where('faqcat_id', $faqcat_id)->where('status', '1')->orderBy('sort')->get();
        }
        else
            $faqins=Faqin::where('faqcat_id',$faqcat_id)->where('status','1')->orderBy('sort')->get();
        return view('frontend_carplus.faq',compact('faqins','list_faqcats','faqcat_id'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function flow(){
        $list_flowcats=Flowcat::whereStatus(1)->orderBy('sort')->get();
        $flowcat_id=Request('flowcat_id');
        if(!$flowcat_id && $list_flowcats) {
            $flowcat_id=$list_flowcats[0]->id;
            $flowins = Flowin::where('flowcat_id', $flowcat_id)->where('status', '1')->orderBy('sort')->get();
        }
        else
            $flowins=Flowin::where('flowcat_id',$flowcat_id)->where('status','1')->orderBy('sort')->get();
        return view('frontend_carplus.flow',compact('flowins','list_flowcats','flowcat_id'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contact(){
        $contact_demand=Setting::where('key', 'contact_demand')->first();
        $contact_demand_arr=array();
        if($contact_demand) {
            $contact_demand_arr[''] = '(請點擊選擇)：';
            foreach(explode(PHP_EOL, $contact_demand->val) as $key => $contact_demand_list) {
                $contact_demand_list = str_replace(array( "\r", "\n", "\r\n", "\n\r" ), '', $contact_demand_list);
                $contact_demand_list = str_replace(array( "\r", "\n", "\r\n", "\n\r" ), '', $contact_demand_list);
                $contact_demand_arr[ $contact_demand_list ] = $contact_demand_list;
            }
        }
        return view('frontend_carplus.contact',compact('contact_demand_arr'));
    }

    function contact_post(AdminContactRequest $request) {
	    $client = new \GuzzleHttp\Client();
	    $result = $client->post('https://www.google.com/recaptcha/api/siteverify', [
		    'form_params' => [
			    'secret'   => env('INVISIBLE_RECAPTCHA_SECRETKEY'),
			    'response' => $request->get('g-recaptcha-response')
		    ]
	    ]);
	    $result = json_decode($result->getBody(), true);
	    if(isset($result['success']) && $result['success']) {
	        $message=$request->message;
	        if(!strpos($message,'http') && !strpos($message,'bit.ly') && !strpos($message,'drive.google.com')) {
	            $inputs = $request->all();
	            $contact = Contact::create($inputs);
	            //$contact->notify(new ContactSendSuccessfully($contact));
	            Mail::send(new ContactPlaced($contact));
	        }
	        session()->flash('success_message', '您的訊息已成功送出，我們將儘快回覆您的問題。');
	        return redirect('/');
	    }
	    else{
		    return redirect()->back()->with('modal_failure_message', '表單驗証錯誤');
	    }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload5code($ord_no=''){
        if(isUserLogin()){
            $user=getLoginUser();
            $ords = Ord::where('user_id', $user->id)
                ->where('is_cancel',0)
                ->orderBy('created_at','DESC');
            $list_ords=$ords->get()->pluck('ord_no','ord_no')->prepend('','');

            if($ord_no)
                $ord=Ord::where('ord_no',$ord_no)->first();
            else
                $ord=new Ord;
        }
        return view('frontend_carplus.upload5code',compact('list_ords','ord'));
    }

    function upload5code_post(Request $request) {
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
            //return view('frontend_carplus.customer',compact('ord','tab'));
            return redirect()->back();
        }
    }

	function privacy() {
		return view('frontend_carplus.privacy');
    }

	function member_policy() {
		return view('frontend_carplus.member_policy');
    }

	function activate_success() {
		return view('frontend_carplus.activate_success');
    }

    function licenceFileShow($field, $slug)
    {
        $user=getLoginUser();
        $image_user=User::where($field,$slug)->select('id')->first();
        if($image_user->id==$user->id) {
            $storagePath = storage_path('app/user/'.$slug);
            return Image::make($storagePath)->response();
        }
        else{
            return '';
        }

    }

    function licenceMailFileShow($field, $slug)
    {
        $storagePath = storage_path('app/user/'.$slug);
        return Image::make($storagePath)->response();
    }

}
