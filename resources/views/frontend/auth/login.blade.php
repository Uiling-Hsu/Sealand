@extends('frontend.layouts.app')

@section('extra-css')

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
                                    <h3 class="text-center">會員登入</h3>
                                    <div>&nbsp;</div>
                                    {{--@php
                                        if (isset($_COOKIE["cookie"])){
                                            foreach ($_COOKIE["cookie"] as $name => $value){
                                                echo "$name : $value <br />";
                                            }
                                        }
                                            dd('ok');
                                    @endphp--}}
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content">
                                            <h4 class="text-3 text-uppercase mb-3 text-right" style="color: red;font-weight: 400;">( * 必填欄位 )</h4>
                                            {!! Form::open(['url' => '/user/authenticate','class'=>'form-horizontal'])  !!}
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label class="font-weight-bold text-dark text-3">帳號(Email) <span style="color: red;"> *</span></label>
                                                        {!! Form::email('email', $email?$email:'',['class'=>'form-control input','id'=>'email','placeholder'=>'','required']); !!}
                                                        @if($errors->has('email'))
                                                            <div class="alert alert-danger text-3" role="alert" style="margin-top:5px">
                                                                <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <a class="float-right" href="/user/password/reset">( 忘記密碼? )</a>
                                                        <label class="font-weight-bold text-dark text-3">密碼 <span style="color: red;"> *</span></label>
                                                        <input type="password" name="password" class="form-control input" id="password" placeholder="密碼" value="{{$password?$password:''}}" required>
                                                        @if($errors->has('password'))
                                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                                <i class="fa fa-warning"></i>{{ $errors->first('password') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <input type="checkbox" name="remember_me" {{$remember_me?'checked':''}}> &nbsp;記住帳號密碼
                                                    </div>
                                                </div>

                                                <div class="form-row">
                                                    <div class="form-group col-lg-7">
                                                        <div>
                                                            <input type="submit" value="登入" class="btn btn-primary float-right text-4" data-loading-text="Loading..." >
                                                        </div>
                                                    </div>
                                                </div>
                                            {!! Form::close() !!}
                                            <h5 class="text-3"><a href="/user/register">會員註冊</a></h5>
                                        </div>
                                    </div>
                                    {{--<div class="text-center">
                                        <span class="text-4">快速登入：</span>
                                        <a href="/login/facebook" type="button" class="btn btn-modern btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Facebook 登入" style="padding: 0.533rem 0.933rem;">
                                            <i class="fa fa-facebook text-8 text-primary" aria-hidden="true"></i>
                                        </a>
                                        <a href="/login/google" type="button" class="btn btn-modern btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Google 登入" style="padding: 0.533rem 0.933rem;">
                                            <i class="fa fa-google text-8 text-primary" aria-hidden="true"></i>
                                        </a>
                                        <a href="{{$line_url}}" type="button" class="btn btn-modern btn-default text-6 text-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Line 登入" style="height: 45px;padding: 0.25rem 0.933rem;">
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
@endsection

@section('extra-js')
    <script>
        (function(){
            $('.alert-danger').delay(10000).slideUp(300);
        })();
    </script>
@endsection