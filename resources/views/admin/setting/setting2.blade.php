@extends('admin.layouts.adminapp')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="/back_assets/extra-libs/multicheck/multicheck.css">
    <link href="/back_assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="/back_assets/css/style.min.css" rel="stylesheet">
    <link href="/back_assets/css/custom.css" rel="stylesheet">
@stop

@section('main-content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">參數設定</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">參數設定</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">編輯 參數</h5>
                <div class="card-body">
                    <div>&nbsp;</div>
                    {!! Form::open(['url' => '/admin/setting'])  !!}

                        <!-- 地址 Form text Input -->
                        <div class="form-group row">
                            {!! Form::label('store_name',"商店名稱:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
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
                            {!! Form::label('address',"地址:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
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
                            {!! Form::label('phone',"電話:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('phone', $phone,['class'=>'form-control']) !!}
                                @if($errors->has('phone'))
                                    <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                         <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 電話 Form text Input -->
                        <div class="form-group row">
                            {!! Form::label('fax',"傳真:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('fax', $fax,['class'=>'form-control']) !!}
                                @if($errors->has('fax'))
                                    <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                        <i class="fa fa-warning"></i>{{ $errors->first('fax') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Email Form text Input -->
                        <div class="form-group row">
                            {!! Form::label('email',"官網 Email:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('email', $email,['class'=>'form-control']) !!}
                                @if($errors->has('email'))
                                    <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                        <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Email Form text Input -->
                        <div class="form-group row">
                            {!! Form::label('email_contact',"聯絡我們 Email:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('email_contact', $email_contact,['class'=>'form-control']) !!}
                                @if($errors->has('email_contact'))
                                    <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                        <i class="fa fa-warning"></i>{{ $errors->first('email_contact') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 公司網址 Form text Input -->
                        <div class="form-group row">
                            {!! Form::label('website',"公司網址:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('website', $website,['class'=>'form-control']) !!}
                                @if($errors->has('website'))
                                    <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                        <i class="fa fa-warning"></i>{{ $errors->first('website') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- 我想詢問有關 Form text Input -->
                        <div class="form-group row">
                            {!! Form::label('contact_demand',"我想詢問有關:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('contact_demand', $contact_demand,['class'=>'form-control','rows'=>8]); !!}
                                @if($errors->has('contact_demand'))
                                    <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                        <i class="fa fa-warning"></i>{{ $errors->first('contact_demand') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Facebook 連結 Form text Input -->
                        {{--<div class="form-group row">
                            {!! Form::label('facebook_url',"Facebook 連結:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
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
                            {!! Form::label('line_url',"Line 連結:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
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
                            {!! Form::label('free_shipping',"滿額免運費:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
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
                            {!! Form::label('shipping',"運費:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
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
                            {!! Form::label('holiday',"過年日期設定:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
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
                            {!! Form::label('shopping_spec',"購物說明:",['class'=>'col-sm-2 form-control-label']) !!}
                            <div class="col-sm-10">
                                {!! Form::textarea('shopping_spec', $shopping_spec,['class'=>'form-control ckeditor']) !!}
                                @if($errors->has('shopping_spec'))
                                    <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                        <i class="fa fa-warning"></i>{{ $errors->first('shopping_spec') }}
                                    </div>
                                @endif
                            </div>
                        </div>--}}

                        <!--  Form Submit Input -->
                        <div class="form-group" style="text-align:center">
                            {!! Form::submit('更新',['class'=>'btn btn-primary']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('extra-js')
    <!-- this page js -->
    <script src="/back_assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="/back_assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="/back_assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="https://3mchangmau.com/assets_admin/scripts/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="https://3mchangmau.com/assets_admin/scripts/ckfinder/ckfinder.js" type="text/javascript"></script>
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
    </script>

@stop