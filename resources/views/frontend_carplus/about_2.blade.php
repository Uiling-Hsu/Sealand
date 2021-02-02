@extends('frontend_carplus.layouts.app')

@section('extra-css')
    <style>
        .btn-secondary, .btn-secondary:active, .btn-secondary.active {
            background-color: #f1901c !important;
            border-color: #f1901c !important;
            color: #ffffff !important;
        }
        .btn-secondary:hover, .btn-secondary:focus, .btn-secondary.focus {
            color: #ffffff !important;
            background-color: #f1901c !important;
            border-color: #f1901c !important;
        }
        .mbr-section-btn a.btn:not(.btn-form):hover, .mbr-section-btn a.btn:not(.btn-form):focus {
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
        }
        .btn-secondary-outline:hover, .btn-secondary-outline:focus, .btn-secondary-outline.focus {
            color: #ffffff;
            background-color: #f1901c;
            border-color: #f1901c;
        }
    </style>
@stop

@section('content')
    <section class="extFeatures cid-s12THEJrXk" id="extFeatures21-4" style="background-image: url(/assets/images/flow_bg.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2 class="mbr-section-title pb-2 mbr-bold mbr-fonts-style align-left display-1">訂閱流程<br><br></h2>
                </div>
            </div>
            <section class="extAccordion cid-s93fxRVX62" id="extAccordion2-1z" style="padding-top: 0">
                <div class="container" style="padding-right: 0;padding-left: 0">
                    <div class="row justify-content-center mbr-section-btn align-center pt-3" style="text-align: center;">
                        <a href="/about_1" class="btn btn-md btn-secondary-outline disp-9">訂閱流程</a>
                        <a href="/about_2" class="btn btn-md btn-secondary disp-9">訂閱須知</a>
                    </div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div class="row justify-content-center pt-4">
                        <div class="col-md-10 col-lg-8 content-block" style="background-color: #fff;">
                            <div style="padding: 20px;border-bottom: solid 1px #57c2df;text-align: center;font-size: 24px;color: #57c2df">
                                何謂汽車訂閱?
                            </div>
                            <div style="padding: 20px;font-size: 14px;color: black;line-height: 25px;">
                                車訂閱是一種更靈活的租賃方式,每個人能夠根據自己的喜好自由換乘多款車型,最大的特點則是只需支付訂閱之月租費用及里程費用,這些費用已包含了保險、維修、保養以及稅費,從擁有制邁向使用制,按季收費,靈活的租賃與解約流程,適應現代消費者簡單、便利、快捷的消費理念,享受生活,輕鬆遨遊。
                            </div>
                            <div style="">
                                <img src="/assets/images/訂閱須知/訂閱須知_01.jpg" alt="" style="width: 100%">
                            </div>
                        </div>
                    </div>
                    {{--@for($i=1;$i<=11;$i++)
                        <div class="row justify-content-center pt-4">
                            <div class="col-md-10 col-lg-8 content-block">
                                <img src="/assets/images/訂閱須知/訂閱須知_{{str_pad($i,2,"0",STR_PAD_LEFT)}}.jpg" alt="" style="width: 100%">
                            </div>
                        </div>
                    @endfor--}}
                </div>
            </section>
        </div>
    </section>

@endsection

@section('extra-js')

@endsection