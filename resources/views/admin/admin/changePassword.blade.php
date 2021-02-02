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
                            <i class="ik ik-edit-2 bg-blue"></i>
                            <div class="d-inline">
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">變更密碼</h5>
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
                                <li class="breadcrumb-item"><a href="#">變更密碼</a></li>
{{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>請輸入原始密碼及新密碼</h3></div>
                        <div class="card-body">
                            {!! Form::open(['route' => 'admin.changePassword','class'=>'form-horizontal'])  !!}
                                <!-- 帳號(Email) Form text Input -->
                                <div>&nbsp;</div>
                                <div class="form-group row">
                                    {!! Form::label('current-password',"原始密碼:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::password('current-password', ['class'=>'form-control','placeholder'=>'請輸入原始密碼','required']) !!}
                                        @if($errors->has('current-password'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('current-password') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div>&nbsp;</div>
                                <hr>
                                <div>&nbsp;</div>

                                <!-- 姓名 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('new-password',"新密碼:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::password('new-password', ['class'=>'form-control','placeholder'=>'密碼顯示強度狀態必需為綠色字的 強 或 非常強','autocomplete'=>'disabled','data-indicator'=>'pwindicator','required']) !!}
                                        <div id="pwindicator" style="padding: 0 10px 0 20px">
                                            <div class="bar" style=""></div>
                                            <div class="label" id="pw_label"></div>
                                        </div>
                                        @if($errors->has('new-password'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('new-password') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- 手機 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('new-password-confirm',"新確認密碼:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::password('new-password-confirm', ['class'=>'form-control','placeholder'=>'請輸入確認密碼','required']) !!}
                                        @if($errors->has('new-password-confirm'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('new-password-confirm') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('更新',['class'=>'btn btn-primary', 'onclick'=>"var pw_label=document.getElementById('pw_label').innerHTML;if(pw_label!='強' && pw_label!='非常強'){alert('密碼長度不可少於8碼，且至少包含大、小寫、特殊符號及數字，密碼顯示強度狀態必需符合 強 或 非常強。');return false;}else return true;"]) !!}
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
    <script src="/js/jquery.pwstrength.js"></script>
    <script type="text/javascript">
        $(function () {
            //啟用密碼強度指示器，並變更說明文字
            $("input[name='new-password']").pwstrength({ texts: ['很弱', '弱', '中等', '強', '非常強'] });
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