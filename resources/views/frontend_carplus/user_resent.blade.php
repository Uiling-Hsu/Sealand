@extends('frontend_carplus.layouts.app')

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
                                    <h3 class="text-center">申請重寄帳號啟用信函</h3>
                                    <div>&nbsp;</div>
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content">
                                            <h4 class=" text-3 text-uppercase mb-3 text-right" style="color: red;font-weight: 400;">( * 必填欄位 )</h4>
                                            {!! Form::open(['url' => '/user/resent','class'=>'form-horizontal'])  !!}
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label class="font-weight-bold text-dark text-3">帳號(Email) <span style="color: red;"> *</span></label>
                                                        {!! Form::email('email', null,['class'=>'form-control input form-control-md','id'=>'email','placeholder'=>'請輸入您註冊的電子郵件','required'=>'required']); !!}
                                                        @if($errors->has('email'))
                                                            <div class="alert alert-danger text-3" role="alert" style="margin-top:5px">
                                                                <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-lg-7">
                                                        <div>
                                                            <input type="submit" value="送出" class="btn btn-primary float-right text-4">
                                                        </div>
                                                    </div>
                                                </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
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