@extends('frontend.layouts.app')

@section('extra-css')

@stop

@section('content')
    {{--@include('frontend.layouts.partials.message')--}}
    <section class="carousel slide cid-s1vpPbj21V d-none d-lg-block" data-interval="false" id="slider1-v">
        <div class="full-screen">
            <div class="mbr-slider slide carousel" data-keyboard="false" data-ride="carousel" data-interval="5000" data-pause="true">
                {{--@if($sliders->count()>1)
                    <ol class="carousel-indicators">
                        @foreach($sliders as $key=>$slider)
                            <li data-app-prevent-settings="" data-target="#slider1-v" {!! $key==0?'class="active"':'' !!} data-slide-to="{{$key}}">
                            </li>
                        @endforeach
                    </ol>
                @endif--}}
                <div class="carousel-inner" role="listbox">
                    @foreach($sliders as $key=>$slider)

                        <div class="carousel-item slider-fullscreen-image {{$key==0?'active':''}}" data-bg-video-slide="false" style="background-image: url({{$slider->image}});{{$slider->url?'cursor:pointer':''}}"
                             @if($slider->url)
                                onclick="document.location.href='{{$slider->url}}';"
                             @endif
                        >
                            <div class="container container-slide">
                                <div class="image_wrapper">
                                    <img src="{{$slider->image}}" alt="" title="">
                                    <div class="carousel-caption justify-content-center">
                                        <div class="col-10 align-center">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
                @if($sliders->count()>1)
                    <a data-app-prevent-settings="" class="carousel-control carousel-control-prev" role="button" data-slide="prev" href="#slider1-v">
                        <span aria-hidden="true" class="mbri-left mbr-iconfont">

                        </span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a data-app-prevent-settings="" class="carousel-control carousel-control-next" role="button" data-slide="next" href="#slider1-v">
                        <span aria-hidden="true" class="mbri-right mbr-iconfont">

                        </span>
                        <span class="sr-only">Next</span>
                    </a>
                @endif
            </div>
        </div>

    </section>

    <section class="carousel slide cid-s1vpPbj21V d-lg-none" data-interval="false" id="slider1-v">
        <div class="full-screen">
            <div class="mbr-slider slide carousel" data-keyboard="false" data-ride="carousel" data-interval="5000" data-pause="true">
                {{--<ol class="carousel-indicators">
                    <li data-app-prevent-settings="" data-target="#slider1-v" class=" active" data-slide-to="0">
                    </li>
                </ol>--}}
                <div class="carousel-inner" role="listbox">
                    @foreach($sliders as $key=>$slider)

                        <div class="carousel-item slider-fullscreen-image {{$key==0?'active':''}}" data-bg-video-slide="false" style="background-image: url({{$slider->image_xs}});{{$slider->url?'cursor:pointer':''}}"
                            @if($slider->url)
                                onclick="document.location.href='{{$slider->url}}';"
                            @endif
                        >
                            <div class="container container-slide">
                                <div class="image_wrapper">
                                    <div class="carousel-caption justify-content-center">
                                        <div class="col-10 align-center">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
                {{--<a data-app-prevent-settings="" class="carousel-control carousel-control-prev" role="button" data-slide="prev" href="#slider1-v">
                <span aria-hidden="true" class="mbri-left mbr-iconfont">
                </span>
                    <span class="sr-only">Previous</span>
                </a>
                <a data-app-prevent-settings="" class="carousel-control carousel-control-next" role="button" data-slide="next" href="#slider1-v">
                <span aria-hidden="true" class="mbri-right mbr-iconfont">
                </span>
                    <span class="sr-only">Next</span>
                </a>--}}
            </div>
        </div>

    </section>

    <section class="extFeatures popup-btn-cards cid-sdLK5xM4n1 d-none d-lg-block" id="extFeatures59-2f" style="background-color: #56c2df;">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12" style="padding-top: 80px">
                    <h2 class="mbr-section-title pb-2 mbr-bold mbr-fonts-style align-center display-1" style="color: white">四大特點<br></h2>
                </div>
            </div>
            <div class="row justify-content-center pt-5 align-items-start">
                <div class="card p-3 col-12 col-md-6 col-lg-3 col-xl-3">
                    <div class="card-wrapper">
                        <div class="card-img" style="padding:0">
                            <img src="/assets/images/sealand0604-5-888x733.jpg" title="" alt="">
                        </div>
                    </div>
                </div>
                <div class="card p-3 col-12 col-md-6 col-lg-3 col-xl-3">
                    <div class="card-wrapper">
                        <div class="card-img" style="padding:0">
                            <img src="/assets/images/sealand0604-6-888x1006.jpg" title="" alt="">
                        </div>
                    </div>
                </div>
                <div class="card p-3 col-12 col-md-6 col-lg-3 col-xl-3">
                    <div class="card-wrapper">
                        <div class="card-img" style="padding:0">
                            <img src="/assets/images/sealand0604-7-888x1010.jpg" title="" alt="">
                        </div>
                    </div>
                </div>
                <div class="card p-3 col-12 col-md-6 col-lg-3 col-xl-3">
                    <div class="card-wrapper">
                        <div class="card-img" style="padding:0">
                            <img src="/assets/images/sealand0604-8-888x1277.jpg" title="" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="extFeatures popup-btn-cards cid-sdLK5xM4n1 d-lg-none" id="extFeatures59-2f" style="padding-top: 0;padding-bottom: 30px">
        <div class="container-fluid">
            <div class="row justify-content-center pt-5 align-items-start">
                <div class="card p-3 col-12 col-md-6 col-lg-4 col-xl-4">
                    <div class="card-wrapper">
                        <div class="card-img" style="padding: 0">
                            <img src="/assets/images/4_special.jpg" title="" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <a name="list"></a>
    <style>
        .cid-sdLK5xM4nO .card-img{
            transition: transform .2s;
            transform: scale(1);
        }
        .cid-sdLK5xM4nO .card-img:hover{
            transition: transform .2s;
            transform: scale(1.05);
        }
    </style>
    @php
        $user=getLoginUser();
    @endphp
    @if($cate13s)
        <section class="extFeatures popup-btn-cards cid-sdLK5xM4nO d-none d-lg-block" id="extFeatures59-2f" style="padding-top: 0;padding-bottom: 30px">
            <div class="container-fluid">
                <div class="row justify-content-center pt-5 align-items-start">
                    @foreach($cate13s as $key=>$cate)
                        <div class="card p-3 col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="card-wrapper" style="background-color: transparent;">
                                <a href="/temp/{{$cate->id}}" class="display-4" style="padding-top:0">
                                    <div class="card-img" style="padding: 0">
                                        <img src="{{$cate->image}}" alt="">
                                    </div>
                                </a>
                                {{--<div class="card-box" style="padding: 0">
                                        <img src="/assets/images/Sealand0604-16.jpg" style="max-width: 150px">
                                </div>--}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="extFeatures popup-btn-cards cid-sdLK5xM4nO d-lg-none" id="extFeatures59-2f">
            <div class="container-fluid">
                <div class="row justify-content-center pt-5 align-items-start">
                    @foreach($cate13s as $key=>$cate)
                        <div class="card p-3 col-12 col-md-6 col-lg-4 col-xl-4">
                            <div class="card-wrapper" style="background-color: transparent;">
                                <a href="/temp/{{$cate->id}}" class="display-4" style="padding-top:0">
                                    <div class="card-img" style="padding: 0">
                                        <img src="{{$cate->image_xs}}" alt="">
                                    </div>
                                </a>
                                {{--<div class="card-box" style="padding: 0">
                                    <img src="/assets/images/Sealand0604-16.jpg" style="max-width: 150px">
                                </div>--}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    {{--@if($cate45s)
        <section class="features3 cid-s13fCmFQDZ" id="features03-t" style="padding-bottom: 0;background-color: #eee;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                    </div>
                </div>
                <div class="row row-content justify-content-center">
                    @foreach($cate45s as $key=>$cate)
                        <div class="card p-3 col-12 col-md-6">
                            <div class="card-wrapper">
                                <div class="card-img">
                                    <img src="{{$cate->image}}" title="" alt="">
                                </div>
                                <div class="card-box" style="padding: 0">
                                    <a href="/temp/{{$cate->id}}" class="btn btn-primary-outline-2 display-4">
                                        <img src="/assets/images/Sealand0604-16.jpg" style="max-width: 150px">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif--}}

    {{--@if($cate67s)
        <section class="features3 cid-s13fCmFQDZ" id="features03-t" style="background-color: #eee;">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                    </div>
                </div>
                <div class="row row-content justify-content-center">
                    @foreach($cate67s as $key=>$cate)
                        <div class="card p-3 col-12 col-md-6">
                            <div class="card-wrapper">
                                <div class="card-img">
                                    <img src="{{$cate->image}}" title="" alt="">
                                </div>
                                <div class="card-box" style="padding: 0">
                                    <a href="/temp/{{$cate->id}}" class="btn btn-primary-outline-2 display-4">
                                        <img src="/assets/images/Sealand0604-16.jpg" style="max-width: 150px">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif--}}

    @if($dealers->count()>0)
        <section class="extFeatures cid-s12THEJrXk" id="extFeatures21-4" style="background-color: #59c2df;padding-top: 50px;padding-bottom: 45px">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12" style="padding-top: 40px">
                        <h2 class="mbr-section-title pb-2 mbr-bold mbr-fonts-style align-left disp-3">合作伙伴</h2>
                    </div>
                    @foreach($dealers as $dealer)
                        <div class="col-md-12" style="padding-top: 40px">
                            <h2 class="mbr-section-title pb-2 mbr-fonts-style align-left disp-3" style="font-weight: 300;">
                                {{$dealer->title}}</h2>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@section('extra-js')

@endsection