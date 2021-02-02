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

    <section class="table2 section-table cid-rk9j4Hkxwk d-none d-lg-block" id="table2-20" style="padding-top: 180px;">
        <div class="container-fluid">
            <div class="media-container-row align-center">
                <div class="col-12 col-md-12">
                    <h2 class="mbr-section-title mbr-fonts-style mbr-black display-5 mbr-light">請至頁面下方選擇 運送 及 付款 方式</h2>
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
    {!! Form::open(['route' => 'checkout.post' ])  !!}
        <section class="table2 section-table cid-rk9gCdR1kF" id="table2-1y">
            <div class="container-fluid">
                <div class="media-container-row align-center">
                    <div class="col-12 col-md-12">
                        <h2 class="mbr-section-title mbr-fonts-style mbr-black display-3">運送方式</h2>

                        <h3 class="mbr-section-subtitle mbr-light mbr-fonts-style pb-5 pt-3 display-5">請選擇以下的運送方式</h3>
                        <div class="table-wrapper" style="width: 54%;">
                            <div class="container-fluid">

                            </div>
                            <div class="container-fluid scroll">
                                <table class="table table-striped" cellspacing="0">
                                    <thead>
                                    <tr class="table-heads">
                                        <th class="head-item mbr-fonts-style display-8 text-left">
                                            &nbsp;&nbsp;&nbsp;<strong>運送方式</strong>
                                        </th>
                                        <th class="head-item mbr-fonts-style display-8 text-left">
                                            <strong>說明</strong>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($shippingtypes as $key=>$shippingtype)
                                        <tr>
                                            <td class="body-item mbr-fonts-style display-8 text-left" style="width:40%">
                                                <input type="radio" name="shippingtype_id" value="{{$shippingtype->id}}" {{$key==0?'checked':''}} required> {{$shippingtype->name}}
                                            </td>
                                            <td class="body-item mbr-fonts-style display-8 text-left">{!! $shippingtype->spec !!}</td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="container-fluid table-info-container">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <hr class="style_one">
        <section class="table2 section-table cid-rk9izjMYli" id="table2-1z">
            <div class="container-fluid">
                <div class="media-container-row align-center">
                    <div class="col-12 col-md-12">
                        <h2 class="mbr-section-title mbr-fonts-style mbr-black display-3">付款方式</h2>

                        <h3 class="mbr-section-subtitle mbr-light mbr-fonts-style pb-5 pt-3 display-5">請選擇以下的付款方式</h3>
                        <div class="table-wrapper" style="width: 54%;">
                            <div class="container-fluid">

                            </div>
                            <div class="container-fluid scroll">
                                <table class="table table-striped" cellspacing="0">
                                    <thead>
                                    <tr class="table-heads">
                                        <th class="head-item mbr-fonts-style display-8 text-left">
                                            &nbsp;&nbsp;&nbsp;<strong>付款方式</strong>
                                        </th>
                                        <th class="head-item mbr-fonts-style display-8 text-left">
                                            <strong>說明</strong>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($paymenttypes as $key=>$paymenttype)
                                        <tr>
                                            <td class="body-item mbr-fonts-style display-8 text-left" style="width:40%">
                                                <input type="radio" name="paymenttype_id" value="{{$paymenttype->id}}" {{$key==0?'checked':''}} required> {{$paymenttype->name}}
                                            </td>
                                            <td class="body-item mbr-fonts-style display-8 text-left">{!! $paymenttype->spec !!}</td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="container-fluid table-info-container">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mbr-section content11 cid-rk9k6HhHYz" id="content11-22">
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
@endsection