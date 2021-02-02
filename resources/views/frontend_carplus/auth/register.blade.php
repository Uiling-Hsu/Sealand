@extends('frontend_carplus.layouts.app')

@section('extra-css')

@stop

@section('extra-top-js')
    <script src="https://www.google.com/recaptcha/api.js"></script>
@stop

@section('content')
    <div role="main" class="main" style="padding-top: 120px;padding-bottom: 120px;background-image: url(/assets/images/flow_bg.jpg);">
        {{--@include('frontend.layouts.partials.message')--}}
        <div class="shop" style="padding-top: 20px">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="featured-boxes">
                            <div class="row">
                                <div class="col-md-12" style="max-width: 500px;margin: 0 auto;background-color: #fff;border-radius: 20px;padding: 25px">
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <h3 class="text-center">會員註冊</h3>
                                    <div>&nbsp;</div>
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content">
                                            <h4 class=" text-3 text-uppercase mb-3 text-right" style="color: red;font-weight: 400;">( * 必填欄位 )</h4>
                                            {!! Form::open(['url' => '/user/saveregister','class'=>'form-horizontal','id'=>'form'])  !!}
                                            {{--<div class="form-row">
                                                <div class="form-group col">
                                                    <label class="font-weight-bold text-dark text-3">帳號 (Email) <span style="color: red;"> *</span></label>
                                                    <input type="text" name="idno" value="" class="form-control input form-control-lg">
                                                </div>
                                            </div>--}}
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="email" class="font-weight-bold text-dark text-3">帳號 (Email) <span style="color: red;"> *</span></label>
                                                    <input type="email" name="email" id="email" value="" class="form-control input" onblur="chkIsUseEmail();" required>
                                                    <div style="padding-left: 10px; color:red" class="checkEmailMsg" id="checkEmailMsg"></div>
                                                    @if($errors->has('email'))
                                                        <div class="alert alert-danger text-3" role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="name" class="font-weight-bold text-dark text-3">姓名 <span style="color: red;"> *</span></label>
                                                    <input type="text" name="name" id="name" value="" class="form-control input" required>
                                                    @if($errors->has('name'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="phone" class="font-weight-bold text-dark text-3">手機 <span style="color: red;"> *</span></label>
                                                    <input type="text" name="phone" id="phone" value="" class="form-control input" required>
                                                    @if($errors->has('phone'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="password" class="font-weight-bold text-dark text-3">密碼 <span style="color: red;"> *</span></label>
                                                    {!! Form::password('password',['class'=>'form-control input','id'=>'password', 'data-indicator'=>'pwindicator','minlength'=>'8','required'=>'required']); !!}
                                                    <div id="pwindicator" style="padding: 0 10px 0 20px">
                                                        <div class="bar" style=""></div>
                                                        <div class="label" id="pw_label"></div>
                                                    </div>
                                                    <script src="/js/jquery.pwstrength.js"></script>
                                                    <script type="text/javascript">
                                                        $(function () {
                                                            //啟用密碼強度指示器，並變更說明文字
                                                            $("input[name='password']").pwstrength({ texts: ['非常弱', '弱', '中等', '強', '非常強'] });
                                                        });
                                                    </script>
                                                    @if($errors->has('password'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('password') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="password_confirmation" class="font-weight-bold text-dark text-3">確認密碼 <span style="color: red;"> *</span></label>
                                                    <input type="password" name="password_confirmation" id="password_confirmation" value="" class="form-control input" required>
                                                    @if($errors->has('password_confirmation'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('password_confirmation') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-12">
                                                    {{--<div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="is_newsletter" class="custom-control-input" id="newsletter" {{$user->is_newsletter==1?'checked':''}}>
                                                        <label class="custom-control-label text-2" for="newsletter">我願意收到 Sealand 租車電子報並享多重會員折扣訊息(如壽星優惠...等)</label>
                                                    </div>--}}
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="terms">
                                                        <label class="custom-control-label text-2" for="terms">我同意 Sealand <a href="#" onclick="privacy_cnt=1" data-toggle="modal" data-target="#mbr-popup-1h">客戶隱私權政策</a></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <!--<div class="form-group col-lg-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="rememberme">
                                                        <label class="custom-control-label text-2" for="rememberme">Remember Me</label>
                                                    </div>
                                                </div>-->
                                                <div class="form-group col-lg-7">
                                                    <div>
                                                        <input type="submit" value="註冊" class="g-recaptcha btn btn-primary float-right text-4" data-sitekey={{env('INVISIBLE_RECAPTCHA_SITEKEY')}} data-callback="OnSubmitFunction" onclick="return chk_form();">
                                                    </div>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                            <h5 class="text-3"><a href="/user/login">會員登入</a></h5>
                                        </div>
                                    </div>
                                    {{--<div class="text-center">
                                        <span class="text-4">快速登入：</span>
                                        <a href="#" type="button" class="btn btn-modern btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Facebook 登入" style="padding: 0.533rem 0.933rem;">
                                            <i class="fa fa-facebook text-8 text-primary" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" type="button" class="btn btn-modern btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Google 登入" style="padding: 0.533rem 0.933rem;">
                                            <i class="fa fa-google text-8 text-primary" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" type="button" class="btn btn-modern btn-default text-6 text-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Line 登入" style="height: 45px;padding: 0.25rem 0.933rem;">
                                            Line
                                        </a>
                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal cid-s1wVL85TMP fade" tabindex="-1" role="dialog" data-on-timer-delay="0" data-overlay-color="#000000" data-overlay-opacity="0.8" id="mbr-popup-1h" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <h5 class="modal-title mbr-fonts-style display-5">客戶隱私權政策</h5>
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" fill="currentColor">
                            <path d="M31.797 0.191c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.598 0.581 0.342 1.543 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM14.472 17.515c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.613 0.595 0.34 1.562 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM1.144 0.205c-0.584-0.587-1.544 0.336-0.942 0.942l30.654 30.651c0.613 0.625 1.563-0.325 0.942-0.942z"></path>
                        </svg>
                    </button>--}}
                </div>

                <div class="modal-body">
                    <p class="mbr-text mbr-fonts-style display-7" style="text-align: left;">{!! nl2br('
                                非常歡迎您光臨「汽車租賃平台」（以下簡稱本網站），為了讓您能夠安心使用本網站的各項服務與資訊，特此向您說明本網站的隱私權保護政策，以保障您的權益，請您詳閱下列內容：

一、隱私權保護政策的適用範圍
隱私權保護政策內容，包括本網站如何處理在您使用網站服務時收集到的個人識別資料。隱私權保護政策不適用於本網站以外的相關連結網站，也不適用於非本網站所委託或參與管理的人員。

二、個人資料的蒐集、處理及利用方式
當您造訪本網站或使用本網站所提供之功能服務時，我們將視該服務功能性質，請您提供必要的個人資料，並在該特定目的範圍內處理及利用您的個人資料；非經您書面同意，本網站不會將個人資料用於其他用途。
本網站在您使用服務信箱、問卷調查等互動性功能時，會保留您所提供的姓名、電子郵件地址、聯絡方式及使用時間等。
於一般瀏覽時，伺服器會自行記錄相關行徑，包括您使用連線設備的IP位址、使用時間、使用的瀏覽器、瀏覽及點選資料記錄等，做為我們增進網站服務的參考依據，此記錄為內部應用，決不對外公佈。
為提供精確的服務，我們會將收集的問卷調查內容進行統計與分析，分析結果之統計數據或說明文字呈現，除供內部研究外，我們會視需要公佈統計數據及說明文字，但不涉及特定個人之資料。
三、資料之保護
本網站主機均設有防火牆、防毒系統等相關的各項資訊安全設備及必要的安全防護措施，加以保護網站及您的個人資料採用嚴格的保護措施，只由經過授權的人員才能接觸您的個人資料，相關處理人員皆簽有保密合約，如有違反保密義務者，將會受到相關的法律處分。
如因業務需要有必要委託其他單位提供服務時，本網站亦會嚴格要求其遵守保密義務，並且採取必要檢查程序以確定其將確實遵守。
四、網站對外的相關連結
本網站的網頁提供其他網站的網路連結，您也可經由本網站所提供的連結，點選進入其他網站。但該連結網站不適用本網站的隱私權保護政策，您必須參考該連結網站中的隱私權保護政策。

五、與第三人共用個人資料之政策
本網站絕不會提供、交換、出租或出售任何您的個人資料給其他個人、團體、私人企業或公務機關，但有法律依據或合約義務者，不在此限。

前項但書之情形包括不限於：

經由您書面同意。
法律明文規定。
為免除您生命、身體、自由或財產上之危險。
與公務機關或學術研究機構合作，基於公共利益為統計或學術研究而有必要，且資料經過提供者處理或蒐集著依其揭露方式無從識別特定之當事人。
當您在網站的行為，違反服務條款或可能損害或妨礙網站與其他使用者權益或導致任何人遭受損害時，經網站管理單位研析揭露您的個人資料是為了辨識、聯絡或採取法律行動所必要者。
有利於您的權益。
本網站委託廠商協助蒐集、處理或利用您的個人資料時，將對委外廠商或個人善盡監督管理之責。
六、Cookie之使用
為了提供您最佳的服務，本網站會在您的電腦中放置並取用我們的Cookie，若您不願接受Cookie的寫入，您可在您使用的瀏覽器功能項中設定隱私權等級為高，即可拒絕Cookie的寫入，但可能會導至網站某些功能無法正常執行 。

七、隱私權保護政策之修正
本網站隱私權保護政策將因應需求隨時進行修正，修正後的條款將刊登於網站上。
                            ') !!}
                    </p>

                    <div>
                    </div>
                </div>

                <div class="modal-footer pt-0">
                    <div class="mbr-section-btn"><a class="btn btn-md btn-primary display-4" href="#" data-dismiss="modal" aria-label="Close">
                            關閉
                        </a></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal cid-s1wY0ECT2q fade" tabindex="-1" role="dialog" data-on-timer-delay="0" data-overlay-color="#000000" data-overlay-opacity="0.8" id="mbr-popup-1i" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <h5 class="modal-title mbr-fonts-style display-5">客戶服務條款</h5>
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" fill="currentColor">
                            <path d="M31.797 0.191c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.598 0.581 0.342 1.543 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM14.472 17.515c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.613 0.595 0.34 1.562 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM1.144 0.205c-0.584-0.587-1.544 0.336-0.942 0.942l30.654 30.651c0.613 0.625 1.563-0.325 0.942-0.942z"></path>
                        </svg>
                    </button>--}}
                </div>

                <div class="modal-body">
                    <p class="mbr-text mbr-fonts-style display-7" style="text-align: left;">{!! nl2br('
                                非常歡迎您光臨「汽車租賃平台」（以下簡稱本網站），為了讓您能夠安心使用本網站的各項服務與資訊，特此向您說明本網站的隱私權保護政策，以保障您的權益，請您詳閱下列內容：

一、隱私權保護政策的適用範圍
隱私權保護政策內容，包括本網站如何處理在您使用網站服務時收集到的個人識別資料。隱私權保護政策不適用於本網站以外的相關連結網站，也不適用於非本網站所委託或參與管理的人員。

二、個人資料的蒐集、處理及利用方式
當您造訪本網站或使用本網站所提供之功能服務時，我們將視該服務功能性質，請您提供必要的個人資料，並在該特定目的範圍內處理及利用您的個人資料；非經您書面同意，本網站不會將個人資料用於其他用途。
本網站在您使用服務信箱、問卷調查等互動性功能時，會保留您所提供的姓名、電子郵件地址、聯絡方式及使用時間等。
於一般瀏覽時，伺服器會自行記錄相關行徑，包括您使用連線設備的IP位址、使用時間、使用的瀏覽器、瀏覽及點選資料記錄等，做為我們增進網站服務的參考依據，此記錄為內部應用，決不對外公佈。
為提供精確的服務，我們會將收集的問卷調查內容進行統計與分析，分析結果之統計數據或說明文字呈現，除供內部研究外，我們會視需要公佈統計數據及說明文字，但不涉及特定個人之資料。
三、資料之保護
本網站主機均設有防火牆、防毒系統等相關的各項資訊安全設備及必要的安全防護措施，加以保護網站及您的個人資料採用嚴格的保護措施，只由經過授權的人員才能接觸您的個人資料，相關處理人員皆簽有保密合約，如有違反保密義務者，將會受到相關的法律處分。
如因業務需要有必要委託其他單位提供服務時，本網站亦會嚴格要求其遵守保密義務，並且採取必要檢查程序以確定其將確實遵守。
四、網站對外的相關連結
本網站的網頁提供其他網站的網路連結，您也可經由本網站所提供的連結，點選進入其他網站。但該連結網站不適用本網站的隱私權保護政策，您必須參考該連結網站中的隱私權保護政策。

五、與第三人共用個人資料之政策
本網站絕不會提供、交換、出租或出售任何您的個人資料給其他個人、團體、私人企業或公務機關，但有法律依據或合約義務者，不在此限。

前項但書之情形包括不限於：

經由您書面同意。
法律明文規定。
為免除您生命、身體、自由或財產上之危險。
與公務機關或學術研究機構合作，基於公共利益為統計或學術研究而有必要，且資料經過提供者處理或蒐集著依其揭露方式無從識別特定之當事人。
當您在網站的行為，違反服務條款或可能損害或妨礙網站與其他使用者權益或導致任何人遭受損害時，經網站管理單位研析揭露您的個人資料是為了辨識、聯絡或採取法律行動所必要者。
有利於您的權益。
本網站委託廠商協助蒐集、處理或利用您的個人資料時，將對委外廠商或個人善盡監督管理之責。
六、Cookie之使用
為了提供您最佳的服務，本網站會在您的電腦中放置並取用我們的Cookie，若您不願接受Cookie的寫入，您可在您使用的瀏覽器功能項中設定隱私權等級為高，即可拒絕Cookie的寫入，但可能會導至網站某些功能無法正常執行 。

七、隱私權保護政策之修正
本網站隱私權保護政策將因應需求隨時進行修正，修正後的條款將刊登於網站上。
                            ') !!}
                    </p>

                    <div>
                    </div>
                </div>

                <div class="modal-footer pt-0">
                    <div class="mbr-section-btn">
                        <a class="btn btn-md btn-primary display-4" href="#" data-dismiss="modal" aria-label="Close">
                            關閉
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script>
        var privacy_cnt=0;
        function chk_form() {
            var checkEmailMsg=document.getElementById('checkEmailMsg');
            var name=document.getElementById('name').value;
            var password = document.getElementById('password').value;
            var password_confirmation = document.getElementById('password_confirmation').value;
            //檢查手機
            var phone=document.getElementById('phone').value;
            var pw_label=document.getElementById('pw_label').innerHTML;
            var msg='';
            var cnt=0;
            if(checkEmailMsg.innerHTML!=''){
                msg+='您輸入的Email已經註冊過了！\n';
                cnt++;
            }
            /*if(!isChinese(name)){
                msg+="姓名 請輸入中文姓名!!\n";
                cnt++;
            }*/
            if(name.length==0){
                msg+="姓名不可空白!!\n";
                cnt++;
            }
            if(phone.length==0){
                msg+="手機不可空白!!\n";
                cnt++;
            }
            /*else if(phone.length!=10){
                msg+="手機長度須為10, 不可加'-'\n";
                cnt++;
            }else if(phone.substring(0,2)!='09'){
                msg+="請輸入正確的手機號碼\n";
                cnt++;
            }*/
            else if(isNaN(phone)){
                msg+="手機不可輸入文字, 不可加'-'\n";
                cnt++;
            }
            if(pw_label!='中等' && pw_label!='非常強' && pw_label!='強'){
                msg+='密碼至少需填入8碼以上，並且至少使用英、數混合的字元，密碼強度至少需指示為：中等、強 或 非常強\n';
                cnt++;
            }
            if(password!=password_confirmation){
                msg+="密碼及確認密碼不相同\n";
                cnt++;
            }
            if(privacy_cnt==0){
                msg+="您必須閱讀:客戶隱私權政策\n";
                cnt++;
            }
            if(terms.checked!=true){
                msg+="您必須勾選同意Sealand 客戶隱私權政策 與 客戶服務條款 才能繼續。\n";
                cnt++;
            }
            if(cnt>0){
                alert(msg);
                return false;
            }
            else
                return true;
        }

        function chkIsUseEmail() {
            var email = $("input[name=email]").val();
            $.ajax({
                type: 'get',
                url: '/chkIsUseEmailPost',
                data: {email: email},
                success: function (data) {
                    var msg = '';
                    if (data.is_used)
                        msg = ' ( 此Email已經註冊過了 )';
                    $('.checkEmailMsg').html(msg);
                    // alert(data.data.msg + msg);
                }
            })
        }

        function isChinese(s) {
            for(var i = 0; i < s.length; i++) {
                if(s.charCodeAt(i) < 0x4E00 || s.charCodeAt(i) > 0x9FA5) {
                    return false;
                }
            }
            return true;
        }

        function OnSubmitFunction(token) {
            document.getElementById('form').submit();
        }

        (function(){
            $('.alert-danger').delay(10000).slideUp(300);
        })();
    </script>
@endsection