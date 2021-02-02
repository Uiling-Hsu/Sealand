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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">後台管理帳號 變更密碼</h5>
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
                                <li class="breadcrumb-item"><a href="#">後台管理帳號 變更密碼</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>請輸入新密碼</h3></div>
                        <div class="card-body">
                            {!! Form::model($admin,['url' => '/admin/admin/password/'.$admin->id ,'method' => 'PATCH'])  !!}
                                {!! Form::hidden('flag','change_password') !!}
                                <!-- 密碼 Form text Input -->
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div class="form-group row">
                                    {!! Form::label('newpassword',"密碼:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::password('newpassword', ['class'=>'form-control','placeholder'=>'密碼顯示強度狀態必需為綠色字的 強 或 非常強','autocomplete'=>'disabled','data-indicator'=>'pwindicator','required']) !!}
                                        <div id="pwindicator" style="padding: 0 10px 0 20px">
                                            <div class="bar" style=""></div>
                                            <div class="label" id="pw_label"></div>
                                        </div>
                                        @if($errors->has('newpassword'))
                                            <div style="padding: 5px;color: red;">
                                                <i class="fa fa-warning"></i>{{ $errors->first('newpassword') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 確認密碼 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('newpassword_confirmation',"確認密碼:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::password('newpassword_confirmation',['class'=>'form-control']) !!}
                                        @if($errors->has('newpassword_confirmation'))
                                            <div style="padding: 5px;color: red;">
                                                <i class="fa fa-warning"></i>{{ $errors->first('newpassword_confirmation') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4 text-center">
                                        {!! Form::submit('重設密碼',['class'=>'btn btn-primary', 'onclick'=>"var pw_label=document.getElementById('pw_label').innerHTML;if(pw_label!='強' && pw_label!='非常強'){alert('密碼長度不可少於8碼，且至少包含大、小寫、特殊符號及數字，密碼顯示強度狀態必需符合 強 或 非常強。');return false;}else return true;"]) !!}
                                    </div>
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
            $("input[name='newpassword']").pwstrength({ texts: ['很弱', '弱', '中等', '強', '非常強'] });
        });
    </script>

@stop