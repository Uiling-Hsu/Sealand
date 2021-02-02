@extends('admin.layouts.adminapp')

@section('extra-css')
    <link rel="stylesheet" href="/back_assets/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="/back_assets/dist/css/theme.css">
    <link rel="stylesheet" href="/back_assets/css/custom.css">
    <script src="/back_assets/src/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
@stop

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-settings bg-blue"></i>
                            <div class="d-inline">
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">設定</h5>
{{--                                <span>各項參數設定</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">設定</a></li>
{{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>各項資料編輯</h3></div>
                        <div class="card-body">
                            {!! Form::open(['url' => '/admin/setting','enctype'=>'multipart/form-data'])  !!}
                                <!-- 地址 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('store_name',"商店名稱:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('store_name', $store_name,['class'=>'form-control']) !!}
                                        @if($errors->has('store_name'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('store_name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 地址 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('address',"地址:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('address', $address,['class'=>'form-control']) !!}
                                        @if($errors->has('address'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('address') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 電話 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('phone',"電話:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('phone', $phone,['class'=>'form-control']) !!}
                                        @if($errors->has('phone'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 電話 Form text Input -->
                                {{--<div class="form-group row">
                                    {!! Form::label('fax',"傳真:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('fax', $fax,['class'=>'form-control']) !!}
                                        @if($errors->has('fax'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('fax') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>--}}

                                <!-- Email Form text Input -->
                                {{--<div class="form-group row">
                                    {!! Form::label('email',"官網 Email:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('email', $email,['class'=>'form-control']) !!}
                                        @if($errors->has('email'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>--}}
                                <hr>
                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('email01',"保姆 Email 01:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('email01', $email01,['class'=>'form-control']) !!}
                                        @if($errors->has('email01'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('email01') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('email02',"保姆 Email 02:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('email02', $email02,['class'=>'form-control']) !!}
                                        @if($errors->has('email02'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('email02') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('email03',"保姆 Email 03:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('email03', $email03,['class'=>'form-control']) !!}
                                        @if($errors->has('email03'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('email03') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('email04',"保姆 Email 04:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('email04', $email04,['class'=>'form-control']) !!}
                                        @if($errors->has('email04'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('email04') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('email_contact',"聯絡我們 Email:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('email_contact', $email_contact,['class'=>'form-control']) !!}
                                        @if($errors->has('email_contact'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('email_contact') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('car_plus_email01',"格上徵信窗口 01 Email:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('car_plus_email01', $car_plus_email01,['class'=>'form-control']) !!}
                                        @if($errors->has('car_plus_email01'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('car_plus_email01') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('car_plus_email02',"格上徵信窗口 02 Email:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('car_plus_email02', $car_plus_email02,['class'=>'form-control']) !!}
                                        @if($errors->has('car_plus_email02'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('car_plus_email02') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <!-- Email Form text Input -->
                                {{--<div class="form-group row">
                                    {!! Form::label('ord_pass_days',"訂單剩餘天數(測試時專用):",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::number('ord_pass_days', $ord_pass_days,['class'=>'form-control']) !!}
                                        @if($errors->has('ord_pass_days'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('ord_pass_days') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>--}}

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('partner_renewal_confirm_days',"車源商續約設定起始日:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::number('partner_renewal_confirm_days', $partner_renewal_confirm_days,['class'=>'form-control']) !!}
                                        @if($errors->has('partner_renewal_confirm_days'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('partner_renewal_confirm_days') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('user_renewal_start_days',"會員續約設定起始日:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::number('user_renewal_start_days', $user_renewal_start_days,['class'=>'form-control']) !!}
                                        @if($errors->has('user_renewal_start_days'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('user_renewal_start_days') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('user_renewal_end_days',"會員續約設定結束日:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::number('user_renewal_end_days', $user_renewal_end_days,['class'=>'form-control']) !!}
                                        @if($errors->has('user_renewal_end_days'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('user_renewal_end_days') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('user_renewal_autosend_days',"系統信件發送日:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::number('user_renewal_autosend_days', $user_renewal_autosend_days,['class'=>'form-control']) !!}
                                        @if($errors->has('user_renewal_autosend_days'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('user_renewal_autosend_days') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- D+開始天數 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('d_from',"D+開始天數:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::number('d_from', $d_from,['class'=>'form-control']) !!}
                                        @if($errors->has('d_from'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                 <i class="fa fa-warning"></i>{{ $errors->first('d_from') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- D+結束天數 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('d_to',"D+結束天數:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::number('d_to', $d_to,['class'=>'form-control']) !!}
                                        @if($errors->has('d_to'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                 <i class="fa fa-warning"></i>{{ $errors->first('d_to') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <!-- 訂單失效時間(分鐘) Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('ord_limit_minutes',"訂單失效時間(分鐘):",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::number('ord_limit_minutes', $ord_limit_minutes,['class'=>'form-control']) !!}
                                        @if($errors->has('ord_limit_minutes'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                 <i class="fa fa-warning"></i>{{ $errors->first('ord_limit_minutes') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <!-- 公司網址 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('website',"Sealand網址:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        @if(getAdminUser()->id==1)
                                            {!! Form::text('website', $website,['class'=>'form-control']) !!}
                                        @else
                                            {!! Form::text('website', $website,['class'=>'form-control','readonly']) !!}
                                        @endif

                                        @if($errors->has('website'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('website') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>


                                <!-- 公司網址 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('website',"格上 APP 網址:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        @if(getAdminUser()->id==1)
                                            {!! Form::text('website_carplus', $website_carplus,['class'=>'form-control']) !!}
                                        @else
                                            {!! Form::text('website_carplus', $website_carplus,['class'=>'form-control','readonly']) !!}
                                        @endif

                                        @if($errors->has('website_carplus'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('website_carplus') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 頁首LOGO Form file Input -->
                                <div class="form-group row">
                                    {!! Form::label('headerLogoFile',"頁首LOGO:(230x80)",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::file('headerLogoFile',['class'=>'form-control']); !!}
                                        @if($header_logo)
                                            {{ Html::image($header_logo,null,['style'=>'width:300px']) }}
                                        @endif
                                        @if($errors->has('headerLogoFile'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('headerLogoFile') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- FAQ是否顯示在選單 Form select Input -->
                                <div class="form-group row">
                                    {!! Form::label('is_qa_display',"FAQ是否顯示在選單:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::select('is_qa_display', ['0'=>'否','1'=>'是',] , $is_qa_display ,['class'=>'form-control']) !!}
                                        @if($errors->has('is_qa_display'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                 <i class="fa fa-warning"></i>{{ $errors->first('is_qa_display') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 我想詢問有關 Form text Input -->
                                {{--<div class="form-group row">
                                    {!! Form::label('contact_demand',"我想詢問有關:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::textarea('contact_demand', $contact_demand,['class'=>'form-control','rows'=>8]); !!}
                                        @if($errors->has('contact_demand'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('contact_demand') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>--}}

                                <!-- Facebook 連結 Form text Input -->
                                {{--<div class="form-group row">
                                    {!! Form::label('facebook_url',"Facebook 連結:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('facebook_url', $facebook_url,['class'=>'form-control']) !!}
                                        @if($errors->has('facebook_url'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('facebook_url') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>--}}

                                <!-- Line 連結 Form text Input -->
                                {{--<div class="form-group row">
                                    {!! Form::label('line_url',"Line 連結:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('line_url', $line_url,['class'=>'form-control']) !!}
                                        @if($errors->has('line_url'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('line_url') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>--}}

                                <!-- Line 連結 Form text Input -->
                                {{--<div class="form-group row">
                                    {!! Form::label('free_shipping',"滿額免運費:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('free_shipping', $free_shipping,['class'=>'form-control']) !!}
                                        @if($errors->has('free_shipping'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('free_shipping') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Line 連結 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('shipping',"運費:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::text('shipping', $shipping,['class'=>'form-control']) !!}
                                        @if($errors->has('shipping'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('shipping') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>--}}

                                <!-- Line 連結 Form text Input -->
                                {{--<div class="form-group row">
                                    {!! Form::label('holiday',"過年日期設定:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::textarea('holiday', $holiday,['class'=>'form-control','rows'=>8]) !!}
                                        @if($errors->has('holiday'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('holiday') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>



                                <!-- 購物說明 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('shopping_spec',"購物說明:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::textarea('shopping_spec', $shopping_spec,['class'=>'form-control ckeditor']) !!}
                                        @if($errors->has('shopping_spec'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('shopping_spec') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>--}}
                                <hr>
                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('更新',['class'=>'btn btn-primary']) !!}
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('extra-js')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="/back_assets/src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="/back_assets/plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="/back_assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/back_assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="/back_assets/dist/js/theme.min.js"></script>
{{--    <script src="/back_assets/js/form-components.js"></script>--}}
@stop