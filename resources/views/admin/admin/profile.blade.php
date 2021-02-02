@extends('admin.layouts.adminapp')

@section('extra-css')
    <link rel="stylesheet" href="/back_assets/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="/back_assets/dist/css/theme.css">
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
                            <i class="ik ik-edit-2 bg-blue"></i>
                            <div class="d-inline">
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">更新基本資料</h5>
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
                        <div class="card-header"><h3>基本資料編輯</h3></div>
                        <div class="card-body">
                            {!! Form::model($profile,['url' => '/admin/profile'])  !!}
                                <!-- 帳號(Email) Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('email',"帳號(Email):",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::email('email', null,['class'=>'form-control','readonly']) !!}
                                        @if($errors->has('email'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 姓名 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('name',"姓名:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('name', null,['class'=>'form-control']) !!}
                                        @if($errors->has('name'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 手機 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('phone',"手機:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('phone', null,['class'=>'form-control']) !!}
                                        @if($errors->has('phone'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 姓名 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('address',"地址:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('address', null,['class'=>'form-control']) !!}
                                        @if($errors->has('address'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('address') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Line ID Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('lineid',"Line ID:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('lineid', null,['class'=>'form-control']) !!}
                                        @if($errors->has('lineid'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('lineid') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 公司名稱 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('company',"公司名稱:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('company', null,['class'=>'form-control']) !!}
                                        @if($errors->has('company'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('company') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 公司電話 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('company_phone',"公司電話:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('company_phone', null,['class'=>'form-control']) !!}
                                        @if($errors->has('company_phone'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('company_phone') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 公司電話分機 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('company_ext',"公司電話分機:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('company_ext', null,['class'=>'form-control']) !!}
                                        @if($errors->has('company_ext'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('company_ext') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

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
    <script>window.jQuery || document.write('<script src="/back_assets/src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="/back_assets/plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="/back_assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/back_assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="/back_assets/dist/js/theme.min.js"></script>
{{--    <script src="/back_assets/js/form-components.js"></script>--}}
@stop