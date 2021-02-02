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
    <section class="header6 cid-rk37IKwQTv" id="header6-k" style="background-image: url(/assets/images/mbr-8-1920x1280.jpg);">
        <div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(0, 0, 0);">
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6 col-md-8 align-center">
                    <h2 class="mbr-section-title align-center mbr-fonts-style mbr-white display-2">最新消息</h2>
                </div>
            </div>
        </div>
    </section>
    {{--@include('frontend.layouts.partials.message')--}}
    @forelse($hotin->hotin2s as $key=>$hotin2)
        <section class="features1 cid-{{$key==0?'rk3dKPL66e':'rk3dKnpq8H'}}" id="features1-p" style="padding-top: {{ $key==0?'50px':'0px' }};padding-bottom: 0">
            <div class="container">
                <div class="row main align-items-center">
                    <div class="col-md-6 image-element align-self-center">
                        <div class="img-wrap" style="width: 95%; height: 100%;">
                            @if($hotin2->image)
                                <img src="{{$hotin2->image}}" alt="" title="">
                            @endif
{{--                            @if($hotin2->youtube)--}}
{{--                                <div class="video-container">--}}
{{--                                    <div style="position:relative;height:0;padding-bottom:56.21%">--}}
{{--                                        {!! $hotin2->youtube !!}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            @endif--}}
                        </div>
                    </div>
                    <div class="col-md-6 text-element">
                        <div class="text-content">
                            <h2 class="mbr-title pt-2 mbr-fonts-style align-left display-3" style="line-height: 42px">
                                {{$hotin2->title_tw}}
                            </h2>
                            <div class="mbr-section-text">
                                <p class="mbr-text pt-3 mbr-light mbr-fonts-style display-7">{!! nl2br($hotin2->content_tw) !!}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    @empty
        <div>&nbsp;</div>
        <div>&nbsp;</div>
        <h2 class="mbr-title pt-2 mbr-fonts-style align-center display-6 mbr-light" style="color: red">( 暫無資料 )</h2>
    @endforelse
    <section class="mbr-section content11 cid-rk3sAmdPIW" id="content11-u">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-10">
                    <div class="mbr-section-btn align-center"><a class="btn btn-warning-outline display-4" onclick="window.history.go(-1); return false;">回上一頁列表</a></div>
                </div>
            </div>
        </div>
    </section>
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    <div>&nbsp;</div>

@endsection

@section('extra-js')
    <script src="/assets/popper/popper.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <!--<script src="/assets/smoothscroll/smooth-scroll.js"></script>-->
    <script src="/assets/touchswipe/jquery.touch-swipe.min.js"></script>
    <script src="/assets/viewportchecker/jquery.viewportchecker.js"></script>
    <script src="/assets/dropdown/js/script.min.js"></script>
    <script src="/assets/theme/js/script.js"></script>
    {{--<input name="animation" type="hidden">--}}
@endsection