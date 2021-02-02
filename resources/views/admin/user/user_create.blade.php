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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">會員</h5>
                                {{--                                <span>各項參數會員編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">會員</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>會員 新增</h3></div>
                        <div class="card-body">
                            {!! Form::open(['url' => '/admin/user','enctype'=>'multipart/form-data'])  !!}

                                <!-- 姓名 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('name',"姓名:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('name', null,  ['class'=>'form-control','required']) !!}
                                        <div>
                                            @if($errors->has('name'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('email',"Email:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('email', null,  ['class'=>'form-control','required']) !!}
                                        <div>
                                            @if($errors->has('email'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 手機 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('phone',"手機:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('phone', null,  ['class'=>'form-control','required']) !!}
                                        <div>
                                            @if($errors->has('phone'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 手機 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('birthday',"生日:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('birthday', null,  ['class'=>'form-control','required']) !!}
                                        <div>
                                            @if($errors->has('birthday'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('birthday') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 地址 Form textarea Input -->
                                <div class="form-group row">
                                    {!! Form::label('address',"地址:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('address', null,  ['class'=>'form-control','rows'=>'3']) !!}
                                        <div>
                                            @if($errors->has('address'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('address') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 送貨姓名 Form text Input -->
                                {{--<div class="form-group row">
                                    {!! Form::label('name',"送貨姓名:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('name', null,  ['class'=>'form-control','required]) !!}
                                        <div>
                                            @if($errors->has('name'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 訂單Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('email',"訂單Email:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('email', null,  ['class'=>'form-control','required]) !!}
                                        <div>
                                            @if($errors->has('email'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 送貨手機 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('phone',"送貨手機:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('phone', null,  ['class'=>'form-control','required]) !!}
                                        <div>
                                            @if($errors->has('phone'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 送貨市話 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('telephone',"送貨市話:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('telephone', null,  ['class'=>'form-control','required]) !!}
                                        <div>
                                            @if($errors->has('telephone'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('telephone') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 送貨地址 Form textarea Input -->
                                <div class="form-group row">
                                    {!! Form::label('address',"送貨地址:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('address', null,  ['class'=>'form-control','rows'=>'3']) !!}
                                        <div>
                                            @if($errors->has('address'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('address') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>--}}

                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('新增',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-success" href="{{ url('/admin/user' ) }}">取消及回上一頁</a>
                                </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('extra-js')

    <script src="/js/jquery.pwstrength.js"></script>
    <script type="text/javascript">
        $(function () {
            //啟用密碼強度指示器，並變更說明文字
            $("input[name='password']").pwstrength({ texts: ['很弱', '弱', '中等', '強', '非常強'] });
        });
    </script>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@stop