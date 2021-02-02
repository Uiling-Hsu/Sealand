@extends('frontend.layouts.app')

@section('extra-css')

@stop

@section('extra-top-js')
    <script src="https://www.google.com/recaptcha/api.js"></script>
@stop

@section('content')
    <div role="main" class="main">
        {{--@include('frontend.layouts.partials.message')--}}
        <section class="page-header page-header-modern page-header-background page-header-background-md overlay overlay-color-dark overlay-show overlay-op-7" style="background-image: url(/assets/images/mbr-43.jpg);">
            <div class="container">
                <div class="row mt-5">
                    <div class="col-md-12 align-self-center p-static order-2 text-center">
                        <!--                                <div class="text-5 text-color-white" style="color: white">About <strong>Us</strong></div>-->
                        <div class="text-7 text-color-white" style="padding-top: 10px">聯絡 <strong>我們</strong></div>
                    </div>
                    <div class="col-md-12 align-self-center order-1">
                        <ul class="breadcrumb breadcrumb-light d-block text-center">
                            <li class="text-4"><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <div class="container">

            <div class="row py-4">
                <div class="col-lg-12" style="max-width: 800px;margin: 0 auto">

                    <div class="overflow-hidden mb-1">
                        <h2 class="font-weight-normal text-7 mt-2 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200"><strong class="font-weight-extra-bold">聯絡我們</strong> 表單</h2>
                    </div>
                    <div class="overflow-hidden mb-4 pb-3">
                        <p class="mb-0 appear-animation text-3" data-appear-animation="maskUp" data-appear-animation-delay="400">請填寫以下表單資訊，我們會儘快回覆您的訊息。</p>
                    </div>

                    @if(isUserLogin())
                        @php
                            $user=getLoginUser();
                        @endphp
                        {!! Form::model($user,['url' => '/contact','class'=>'form-horizontal','id'=>'form'])  !!}
                    @else
                        {!! Form::open(['url' => '/contact','class'=>'form-horizontal','id'=>'form'])  !!}
                    @endif

                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label class="required font-weight-bold text-dark text-2">姓名</label>
                                {!! Form::text('name', null,['class'=>'form-control','id'=>'name','required'=>'required']); !!}
                                @if($errors->has('name'))
                                    <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                        <i class="fa fa-warning"></i>{{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group col-lg-6">
                                <label class="required font-weight-bold text-dark text-2">Email</label>
                                {!! Form::email('email', null,['class'=>'form-control','id'=>'email','required'=>'required']); !!}
                                @if($errors->has('email'))
                                    <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                        <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="font-weight-bold text-dark text-2">電話</label>
                                {!! Form::text('phone', null,['class'=>'form-control','id'=>'phone','required'=>'required']); !!}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <label class="required font-weight-bold text-dark text-2">訊息</label>
                                {!! Form::textarea('message', null,['class'=>'form-control','id'=>'message','required'=>'required','rows'=>5]); !!}
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col">
                                <input type="submit" value="送出" class="g-recaptcha btn btn-primary btn-modern" data-sitekey="{{env('INVISIBLE_RECAPTCHA_SITEKEY')}}" data-callback="OnSubmitFunction">
                            </div>
                        </div>
                    {!! Form::close() !!}

                </div>
                {{--<div class="col-lg-6">

                    <div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="800">
                        <h4 class="mt-2 mb-1">聯絡 <strong>資訊</strong></h4>
                        <ul class="list list-icons list-icons-style-2 mt-2">
                            --}}{{--<li><i class="fas fa-map-marker-alt top-6"></i> <strong class="text-dark">地址:</strong> 1234 Street Name, City Name, United States</li>--}}{{--
                            <li><i class="fas fa-phone top-6"></i> <strong class="text-dark">電話:</strong> (123) 456-789</li>
                            <li><i class="fas fa-envelope top-6"></i> <strong class="text-dark">Email:</strong> <a href="mailto:mail@example.com">mail@example.com</a></li>
                        </ul>
                    </div>

                    <!--<div class="appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="950">
                        <h4 class="pt-5">Business <strong>Hours</strong></h4>
                        <ul class="list list-icons list-dark mt-2">
                            <li><i class="far fa-clock top-6"></i> Monday - Friday - 9am to 5pm</li>
                            <li><i class="far fa-clock top-6"></i> Saturday - 9am to 2pm</li>
                            <li><i class="far fa-clock top-6"></i> Sunday - Closed</li>
                        </ul>
                    </div>-->

                    <h4 class="pt-5">交通 <strong>資訊</strong></h4>
                    <p class="lead mb-0 text-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

                </div>--}}

            </div>

        </div>


        <!-- Google Maps - Go to the bottom of the page to change settings and map location. -->
        {{--<div class="google-map mt-0">
            <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.tw/maps?f=q&amp;hl=zh-TW&amp;geocode=&amp;q=台北市內湖區瑞光路1號&amp;z=16&amp;output=embed&amp;t="></iframe>
        </div>--}}

    </div>
@endsection

@section('extra-js')
    <script>
        function OnSubmitFunction(token) {
            document.getElementById('form').submit();
        }
    </script>
@endsection