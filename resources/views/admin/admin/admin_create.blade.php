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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">後台管理帳號</h5>
                                {{--                                <span>各項參數後台管理帳號編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">後台管理帳號</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>後台管理帳號 新增</h3></div>
                        <div class="card-body">
                            {!! Form::open(['url' => '/admin/admin','enctype'=>'multipart/form-data'])  !!}
                                {!! Form::hidden('flag','create') !!}

                                <!-- 所屬經銷商 Form select Input -->
                                <div class="form-group row">
                                    {!! Form::label('partner_id',"所屬經銷商:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select('partner_id', $list_partners , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
                                        @if($errors->has('partner_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                 <i class="fa fa-warning"></i>{{ $errors->first('partner_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('email',"Email:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::email('email', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('email'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 姓名 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('name',"姓名:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('name', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('name'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 姓名 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('phone',"電話:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('phone', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('phone'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 密碼 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('password',"密碼:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::password('password',['class'=>'form-control','placeholder'=>'密碼顯示強度狀態必需為綠色字的 強 或 非常強','autocomplete'=>'disabled','data-indicator'=>'pwindicator','required']) !!}
                                        <div id="pwindicator" style="padding: 0 10px 0 20px">
                                            <div class="bar" style=""></div>
                                            <div class="label" id="pw_label"></div>
                                        </div>
                                        @if($errors->has('password'))
                                            <div style="padding: 5px;color: red;">
                                                <i class="fa fa-warning"></i>{{ $errors->first('password') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 確認密碼 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('password_confirmation',"確認密碼:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::password('password_confirmation',['class'=>'form-control']) !!}
                                        @if($errors->has('password_confirmation'))
                                            <div style="padding: 5px;color: red;">
                                                <i class="fa fa-warning"></i>{{ $errors->first('password_confirmation') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('新增',['class'=>'btn btn-primary', 'onclick'=>"var pw_label=document.getElementById('pw_label').innerHTML;if(pw_label!='強' && pw_label!='非常強'){alert('密碼長度不可少於8碼，且至少包含大、小寫、特殊符號及數字，密碼顯示強度狀態必需符合 強 或 非常強。');return false;}else return true;"]) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-success" href="{{ url('/admin/admin' ) }}">取消及回上一頁</a>
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