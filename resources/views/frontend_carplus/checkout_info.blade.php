@extends('frontend_carplus.layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="/assets/web/assets/mobirise-icons/mobirise-icons.css">
    <link rel="stylesheet" href="/assets/soundcloud-plugin/style.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="/assets/socicon/css/styles.css">
    <link rel="stylesheet" href="/assets/animatecss/animate.min.css">
    <link rel="stylesheet" href="/assets/dropdown/css/style.css">
    <link rel="stylesheet" href="/assets/theme/css/style.css">
    <link rel="stylesheet" href="/assets/mobirise/css/mbr-additional.css" type="text/css">
    <link rel="stylesheet" href="/assets/custom/css/style.css">
    <link rel="stylesheet" href="/assets/custom/css/hr.css">
    <style>
        input:focus,textarea:focus{
            outline:none
        }
    </style>
    <script src="/assets/web/assets/jquery/jquery.min.js"></script>
@stop

@section('content')
    <section class="header6 cid-rk37IKwQTv" id="header6-k" style="background-image: url(/assets/images/mbr-10-1920x1280.jpg);">
        <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(0, 0, 0);">
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6 col-md-8 align-center">
                    <h2 class="mbr-section-title align-center mbr-fonts-style mbr-white display-2">結帳</h2>
                </div>
            </div>
        </div>

    </section>
    {{--@include('frontend.layouts.partials.message')--}}
    {{--桌機版--}}
    <section class="table2 section-table cid-rk9j4Hkxwk d-none d-lg-block" id="table2-20" style="padding-top: 180px;">
        <div class="container-fluid">
            <div class="media-container-row align-center">
                <div class="col-12 col-md-12">
                    <h2 class="mbr-section-title mbr-fonts-style mbr-black display-5 mbr-light">請至頁面下方填入您的運送資訊</h2>
                    <div>&nbsp;</div>
                    <h2 class="mbr-section-title mbr-fonts-style mbr-black display-3">購物車商品</h2>
                    <div class="underline align-center pb-3">
                        <div class="line"></div>
                    </div>
                    <div class="table-wrapper pt-5" style="width: 88%;">
                        <div class="container-fluid">
                        </div>
                        <div class="container-fluid scroll">
                            @include('frontend.layouts.partials.show_cart_md')
                        </div>
                        <div class="container-fluid table-info-container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--手機版--}}
    <section class="table2 section-table cid-rk9j4Hkxwk d-lg-none" id="table2-20" style="padding-top: 120px;">
        <div class="container-fluid" style="padding: 0">
            <div class="media-container-row align-center">
                <div class="col-12 col-md-12">
                    <h2 class="mbr-section-title mbr-fonts-style mbr-black display-3">購物車商品</h2>
                    <div class="underline align-center pb-3">
                        <div class="line"></div>
                    </div>
                    <div class="table-wrapper pt-5 d-lg-none" style="width:100%;">
                        <div class="container-fluid" style="padding: 0">
                        </div>
                        <div class="container-fluid scroll" style="padding: 0">
                            @include('frontend.layouts.partials.show_cart_xs')
                        </div>
                        <div class="container-fluid table-info-container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <hr class="style_one">
    @if($user)
        {!! Form::model($user,['route' => 'checkout.info.post'])  !!}
    @else
        {!! Form::open(['route' => 'checkout.info.post'])  !!}
    @endif
        <section class="table2 section-table cid-rk9gCdR1kF" id="table2-1y" style="padding-top: 20px;padding-bottom: 20px;">
            <div class="container-fluid">
                <div class="media-container-row align-center">
                    <div class="col-12 col-md-12">
                        <h2 class="mbr-section-title mbr-fonts-style mbr-black display-3">您選擇的運送方式及付款方式</h2>
                        <div>&nbsp;</div>
                        <div class="table-wrapper" style="width: 54%;">
                            <div class="container-fluid scroll">
                                <table class="table table-striped" cellspacing="0">
                                    <tr>
                                        <td class="head-item mbr-fonts-style display-8 text-left">
                                            <strong>運送方式：{{$shippingtype->name}}</strong>
                                        </td>
                                        <td class="head-item mbr-fonts-style display-8 text-left">
                                            <strong>{!! $shippingtype->spec !!}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="head-item mbr-fonts-style display-8 text-left">
                                            <strong>付款方式：{{$paymenttype->name}}</strong>
                                        </td>
                                        <td class="head-item mbr-fonts-style display-8 text-left">
                                            <strong>{!! $paymenttype->spec !!}</strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr class="style_one">

        <section class="cid-rk37T39pkf" id="form3-l" style="padding-top: 30px;padding-bottom: 30px;">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="form-1 col-md-6 col-lg-6">
                        <h1 class="mbr-fonts-style align-center display-5 mbr-light">訂購人資訊</h1>
                        <div class="align-center mbr-light" style="color:red">( * 為必填欄位 )</div>
                        <hr>
                        <div class="row input-main">
                            <div class="col-md-6 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="name">姓名 <span style="color:red">*</span></label>
                                {!! Form::text('name', null,['class'=>'field display-7','id'=>'name','required'=>'required']); !!}
                                @if ($errors->has('name'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="phone">手機 <span style="color:red">*</span></label>
                                {!! Form::text('phone', null,['class'=>'field display-7','id'=>'phone','required'=>'required']); !!}
                                @if ($errors->has('phone'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row input-main">
                            <div class="col-md-12 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="email">E-mail <span style="color:red">*</span></label>
                                {!! Form::email('email', null,['class'=>'field display-7','id'=>'email','style'=>'width: 98%','required'=>'required']); !!}
                                @if ($errors->has('email'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row input-main">
                            <div class="col-md-12 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="address">聯絡地址 <span style="color:red">*</span></label>
                                {!! Form::text('address', null,['class'=>'field display-7','id'=>'address','style'=>'width: 98%','required'=>'required']); !!}
                                @if ($errors->has('address'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <hr class="style_one">
                        <div>&nbsp;</div>
                        <h1 class="mbr-fonts-style align-center display-5 mbr-light">收貨人資訊</h1>
                        <div class="align-center mbr-light" style="color:red">( * 為必填欄位 )</div>
                        <hr>
                        <div>
                            <input type="checkbox" id="chkCopyField">
                            <label for="checkbox-7">  收貨人同訂購人資訊請打勾</label>
                        </div>
                        <div>&nbsp;</div>

                        <div class="row input-main">
                            <div class="col-md-6 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="delivery_name">收貨人姓名 <span style="color:red">*</span></label>
                                {!! Form::text('delivery_name', null,['class'=>'field display-7','id'=>'delivery_name','required'=>'required']); !!}
                                @if ($errors->has('delivery_name'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('delivery_name') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="delivery_phone">收貨人手機 <span style="color:red">*</span></label>
                                {!! Form::text('delivery_phone', null,['class'=>'field display-7','id'=>'delivery_phone','required'=>'required']); !!}
                                @if ($errors->has('delivery_phone'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('delivery_phone') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row input-main">
                            <div class="col-md-12 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="delivery_email">收貨人 E-mail <span style="color:red">*</span></label>
                                {!! Form::email('delivery_email', null,['class'=>'field display-7','id'=>'delivery_email','style'=>'width: 98%','required'=>'required']); !!}
                                @if ($errors->has('delivery_email'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('delivery_email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row input-main">
                            <div class="col-md-12 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="delivery_address">送貨地址 <span style="color:red">*</span></label>
                                {!! Form::text('delivery_address', null,['class'=>'field display-7','id'=>'delivery_address','style'=>'width: 98%','required'=>'required']); !!}
                                @if ($errors->has('delivery_address'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('delivery_address') }}</div>
                                @endif
                            </div>
                        </div>
                        @if(isUserLogin())
                            <div>
                                <input type="checkbox" name="chkSaveData" id="chkSaveData">
                                <label for="checkbox-7">  儲存以上收貨人資訊</label>
                            </div>
                        @endif
                        <hr>
                        <div class="row input-main">
                            <div class="col-md-12 form-group" data-for="memo">
                                <label class="form-label-outside mbr-fonts-style display-7" for="memo">備註</label>
                                {!! Form::textarea('memo', null,['class'=>'field display-7','style'=>'border:solid 1px #ddd','id'=>'memo','placeholder'=>'','rows'=>'3']); !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mbr-section content11 cid-rk9k6HhHYz" id="content11-22" style="padding-top: 20px;">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10">
                        <div class="mbr-section-btn align-center">
                            <a class="btn btn-info-outline display-4" href="/product_list">繼續購物</a>
                            <a class="btn btn-primary-outline display-4" href="/cart">回購物車</a>
                            <button class="btn btn-primary display-4" type="submit" style="border-radius: 30px">前往結帳下一步</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    {!! Form::close() !!}
@endsection

@section('extra-js')
    <script src="/assets/popper/popper.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <!--<script src="/assets/smoothscroll/smooth-scroll.js"></script>-->
    <script src="/assets/touchswipe/jquery.touch-swipe.min.js"></script>
    <script src="/assets/viewportchecker/jquery.viewportchecker.js"></script>
    <script src="/assets/datatables/jquery.data-tables.min.js"></script>
    <script src="/assets/datatables/data-tables.bootstrap4.min.js"></script>
    <script src="/assets/dropdown/js/script.min.js"></script>
    <script src="/assets/theme/js/script.js"></script>
    <script>
        $('#chkCopyField').on('click', function () {
            if ($(this).is(':checked')) {
                $('#delivery_name').val($('#name').val());
                $('#delivery_phone').val($('#phone').val());
                $('#delivery_telephone').val($('#telephone').val());
                $('#delivery_email').val($('#email').val());
                $('#delivery_address').val($('#address').val());
            }
        });
    </script>
@endsection