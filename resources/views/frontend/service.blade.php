@extends('frontend.layouts.app')

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
    <section class="header6 cid-rk37IKwQTv" id="header6-k" data-sortbtn="btn-primary" style="background-image: url(/assets/images/mbr-9-1920x1280.jpg);">
        <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(0, 0, 0);">
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6 col-md-8 align-center">
                    <h2 class="mbr-section-title align-center mbr-fonts-style mbr-white display-2">{!! $service->title_tw !!}</h2>
                </div>
            </div>
        </div>
    </section>
    {{--@include('frontend.layouts.partials.message')--}}

    <section class="mbr-section article content1 cid-rkcVCf9NRT" id="content1-24" data-sortbtn="btn-primary">
        <div class="container">
            <div class="media-container-row">
                <div class="mbr-text col-12 col-md-8 col-lg-10 mbr-fonts-style display-7" style="color: #333;font-weight: 300">
                    {!! $service->content_tw !!}
                </div>
            </div>
        </div>
    </section>
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