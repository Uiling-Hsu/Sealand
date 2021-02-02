@extends('frontend_carplus.layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.css">
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
    <link rel="stylesheet" href="/css/jquery-ui-1.9.2.css" type="text/css" charset="utf-8" />
    <style>
        .contact_demand{
            border: 1px solid #ddd;
            border-radius: 16px;
            background-color: #efefef;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding: 18px 25px;
            width: 98%;
        }
    </style>
@stop

@section('content')
    <section class="cid-rk37T39pkf" id="form3-l" style="padding-top: 180px;">
        {{--@include('frontend.layouts.partials.message')--}}
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="form-1 col-md-6 col-lg-6">
                    <h1 class="mbr-fonts-style mbr-section-title align-center display-5 mbr-light">匯款帳號後5碼回傳</h1>
                    <div class="align-center mbr-light" style="color:red">( 請填寫以下欄位資訊, * 為必填欄位 )</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    @if($ord)
                        {!! Form::model($ord,['url' => '/upload5code','class'=>'form-horizontal'])  !!}
                    @else
                        {!! Form::open(['url' => '/upload5code','class'=>'form-horizontal'])  !!}
                    @endif
                        <h2 class="mbr-fonts-style display-5 mbr-light">轉帳資料(選填)：</h2>
                        <hr class="style_one">
                        <div class="row input-main">
                            <div class="col-md-6 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="ord_no">訂單編號<span class="fa fa-caret-down mbr-iconfont mbr-iconfont-btn"></span></label>
                                {!! Form::select('ord_no', $list_ords , null ,['class'=>'contact_demand field display-7','id'=>'ord_no','required'=>'required','onchange'=>'document.location.href="/upload5code/"+this.value+"#list"']) !!}
                                @if ($errors->has('ord_no'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('ord_no') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="upload_5code">帳號後五碼</label>
                                {!! Form::text('upload_5code', null,['class'=>'field display-7','id'=>'upload_5code','placeholder'=>'']); !!}
                                @if ($errors->has('upload_5code'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('upload_5code') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row input-main">
                            <div class="col-md-6 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="upload_total">匯款金額</label>
                                {!! Form::number('upload_total', null,['class'=>'field display-7','id'=>'upload_total','placeholder'=>'']); !!}
                                @if ($errors->has('upload_total'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('upload_total') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 input-wrap">
                                <label class="form-label-outside mbr-fonts-style display-7" for="upload_date">匯款日期</label>
                                {!! Form::text('upload_date', date('Y-m-d'),['class'=>'field display-7','id'=>'upload_date','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd'})",'required']); !!}
                                @if ($errors->has('upload_date'))
                                    <div style="font-size: 15px;color: red;padding-top: 10px;padding-left: 10px;">{{ $errors->first('upload_date') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row input-main">
                            <div class="col-md-12 form-group">
                                <label class="form-label-outside mbr-fonts-style display-7" for="upload_memo">備註</label>
                                {!! Form::textarea('upload_memo', null,['class'=>'field display-7','style'=>'border:solid 1px #ddd','id'=>'upload_memo','placeholder'=>'','rows'=>'3']); !!}
                            </div>
                        </div>
                        <div>&nbsp;</div>
                        <div class="row input-main">
                            <div class="col-md-12 btn-row">
                                <span class="input-group-btn"><button type="submit" class="btn btn-form btn-primary display-4" style="-webkit-border-radius: 30px;-moz-border-radius: 30px;border-radius: 30px;"><span class="mbri-edit mbr-iconfont mbr-iconfont-btn"></span>上傳</button></span>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('extra-js')
    <script src="/assets/popper/popper.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/dropdown/js/script.min.js"></script>
    <script src="/assets/touchswipe/jquery.touch-swipe.min.js"></script>
    <script src="/assets/viewportchecker/jquery.viewportchecker.js"></script>
    <!--<script src="/assets/smoothscroll/smooth-scroll.js"></script>-->
    <script src="/assets/theme/js/script.js"></script>
    <script src="/assets/formoid/formoid.min.js"></script>
    <script src="{{ asset("/js/datePicker/WdatePicker.js") }}" type="text/javascript"></script>
@endsection