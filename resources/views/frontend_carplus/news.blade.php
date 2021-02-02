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
    <link rel="stylesheet" href="/css/pagination.css">
@stop

@section('content')
    <section class="header6 cid-rk37IKwQTv" id="header6-k" style="background-image: url(/assets/images/mbr-1-1920x1281.jpg);">
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
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    @forelse($hotins as $key=>$hotin)
        <section class="header10 cid-rkHua8wbyC" id="header10-1r" data-sortbtn="btn-primary" style="{{$key % 2==0?'background-color: #fff;':''}}">
            <div class="container">
                <div class="media-container-row">
                    <div class="media-content mb-4">
                        <h2 class="mbr-fonts-style mbr-section-title display-5" style="color: #663300">{{$hotin->title_tw}}</h2>
                        @if($hotin->url)
                            <div class="" style="color: #D36C08"><a href="{{$hotin->url}}">來源：{{$hotin->quote}}</a></div>
                        @endif
                        <p class="mbr-fonts-style display-7 mbr-light">
                            {!! nl2br($hotin->descript_tw) !!}
                        </p>
                        <div class="float-md-right" style="color: #D36C08">{{parseDate($hotin->published_at)}}</div>
                        <div class="mbr-section-btn">
                            <a class="btn btn-md btn-bgr btn-info-outline display-4" href="/news/{{$hotin->id}}">More</a>
                        </div>
                    </div>
                    <div class="mbr-figure" style="width: 40%;">
                        @if($hotin->image)
                            <img src="{{$hotin->image}}" alt="{{$hotin->title_tw}}" title="">
                        @endif
{{--                        @if($hotin->youtube)--}}
{{--                            <div class="video-container">--}}
{{--                                <div style="position:relative;height:0;padding-bottom:56.21%">--}}
{{--                                    {!! $hotin->youtube !!}--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        @endif--}}
                    </div>
                </div>
            </div>
        </section>
    @empty
    @endforelse
    <nav class="pagination-wrapper">
        {{ $hotins->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4-frontend') }}
    </nav>
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