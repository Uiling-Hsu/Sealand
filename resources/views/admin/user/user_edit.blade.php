@extends('admin.layouts.adminapp')

@section('extra-css')
    <link rel="stylesheet" href="/back_assets/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="/back_assets/plugins/mohithg-switchery/dist/switchery.min.css">
    <link rel="stylesheet" href="/back_assets/dist/css/theme.css">
    <link rel="stylesheet" href="/back_assets/css/custom.css">
    <script src="/back_assets/src/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    {{--<script src="https://cdn.jsdelivr.net/npm/vue"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <style>
        .verify_checkbox{
            appearance: none;
            background-image: url(/back_assets/dist/img/down-arrow.svg);
            background-position: center right 15px;
            background-repeat: no-repeat;
            -webkit-background-size: 10px;
            background-size: 10px;
            border: 1px solid #eaeaea;
            border-radius: 5px;
            padding: 0 10px;
            background-color: #fff;
            height: 35px !important;
            width: 120px;
            font-size:16px;
        }
    </style>
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
                    <div class="card" style="max-width: 1000px">
                        <div class="card-header"><h3>會員 編輯</h3></div>
                        <div class="card-body">
                        {!! Form::model($user,['url' => '/admin/user/'.$user->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}
                        {!! Form::hidden('page',Request('page')) !!}

                        <!-- 姓名 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('name',"姓名:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('name', null,  ['class'=>'form-control']) !!}
                                    <div>
                                        @if($errors->has('name'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 性別 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('gender',"性別:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('gender', [''=>'請選擇','男'=>'男','女'=>'女'] , null ,['class'=>'form-control','style'=>'font-size:16px','required']) !!}
                                </div>
                            </div>

                            <!-- Email Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('email',"Email:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('email', null,  ['class'=>'form-control']) !!}
                                    <div>
                                        @if($errors->has('email'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
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
                                    {!! Form::text('phone', null,  ['class'=>'form-control']) !!}
                                    <div>
                                        @if($errors->has('phone'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 市話 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('telephone',"市話:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('telephone', null,  ['class'=>'form-control']) !!}
                                    <div>
                                        @if($errors->has('telephone'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('telephone') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 生日 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('birthday',"生日:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('birthday', null,['id'=>'birthday','class'=>'form-control','autocomplete'=>'off','readonly','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd'})",'required']); !!}
                                    <div>
                                        @if($errors->has('birthday'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('birthday') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 台灣生日 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('cbirthday',"台灣生日:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    <span style="padding-left: 13px">{{getChineseBirthday($user->birthday,'-')}}</span>
                                </div>
                            </div>

                            <hr>
                            <!-- 持證類別 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('id_type',"持證類別:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('id_type', ['1'=>'身份證','2'=>'居留證'] , null ,['class'=>'form-control']) !!}
                                    @if($errors->has('id_type'))
                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                            <i class="fa fa-warning"></i>{{ $errors->first('id_type') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- 手機 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('idno',"身份證字號:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('idno', null,  ['class'=>'form-control']) !!}
                                    <div>
                                        @if($errors->has('idno'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('idno') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 發證日期 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('id_day',"發證日:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    年：{!! Form::number('id_year', null,['id'=>'id_year','class'=>'','style'=>'width: 60px','autocomplete'=>'off','required']); !!}
                                    月：{!! Form::number('id_month', null,['id'=>'id_month','class'=>'','style'=>'width: 60px','autocomplete'=>'off','required']); !!}
                                    日：{!! Form::number('id_day', null,['id'=>'id_day','class'=>'','style'=>'width: 60px','autocomplete'=>'off','required']); !!}

                                </div>
                            </div>
                            <hr>
                            <!-- 身份証正面 Form image Input -->
                            <div class="form-group row">
                                {!! Form::label('imgFile_idcard_image01',"身份証正面：",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::file('imgFile_idcard_image01',['class'=>'form-control']); !!}<br>
                                    @if($user->idcard_image01)
                                        <div id="delete_idcard_image01_block">
                                            {{ Html::image('/admin/user/idcard_image01/'.$user->idcard_image01,null,['style'=>'max-width:600px']) }}&nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" style="display: inline-block;color: red;border:solid 1px red;padding: 2px 8px" id="remove_idcard_image01_btn"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            <script>
                                                $(function() {
                                                    $('#remove_idcard_image01_btn').click(function() {
                                                        if(confirm('是否確定要刪除此圖片？')) {
                                                            $.get('/admin/ajax_remove_image', {
                                                                "db": 'users',
                                                                "id": '{{$user->id}}',
                                                                "field": 'idcard_image01'
                                                            });
                                                            $('#delete_idcard_image01_block').fadeOut(1000, function() { $(this).remove(); });
                                                        }
                                                    })
                                                })
                                            </script>
                                        </div>
                                    @endif
                                </div>
                                {!! Form::hidden('idcard_image01',null) !!}
                            </div>
                            <!-- 身份證發證地點 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('ssite_id',"身份證發證地點:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('ssite_id', $list_ssites , null ,['class'=>'form-control']) !!}
                                    @if($errors->has('ssite_id'))
                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                            <i class="fa fa-warning"></i>{{ $errors->first('ssite_id') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- 身份證領補換類別 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('applyreason',"身份證領補換類別:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('applyreason', [''=>'請選擇','初發'=>'初發','補發'=>'補發','換發'=>'換發','其它(持居留證人士)'=>'其它(持居留證人士)'] , null ,['class'=>'form-control']) !!}
                                    @if($errors->has('applyreason'))
                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                            <i class="fa fa-warning"></i>{{ $errors->first('applyreason') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <!-- 身份証反面 Form image Input -->
                            <div class="form-group row">
                                {!! Form::label('imgFile_idcard_image02',"身份証反面：",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::file('imgFile_idcard_image02',['class'=>'form-control']); !!}<br>
                                    @if($user->idcard_image02)
                                        <div id="delete_idcard_image02_block">
                                            {{ Html::image('/admin/user/idcard_image02/'.$user->idcard_image02,null,['style'=>'max-width:600px']) }}&nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" style="display: inline-block;color: red;border:solid 1px red;padding: 2px 8px" id="remove_idcard_image02_btn"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            <script>
                                                $(function() {
                                                    $('#remove_idcard_image02_btn').click(function() {
                                                        if(confirm('是否確定要刪除此圖片？')) {
                                                            $.get('/admin/ajax_remove_image', {
                                                                "db": 'users',
                                                                "id": '{{$user->id}}',
                                                                "field": 'idcard_image02'
                                                            });
                                                            $('#delete_idcard_image02_block').fadeOut(1000, function() { $(this).remove(); });
                                                        }
                                                    })
                                                })
                                            </script>
                                        </div>
                                    @endif
                                </div>
                                {!! Form::hidden('idcard_image02',null) !!}
                            </div>

                            <!-- 地址 Form textarea Input -->
                            <div class="form-group row">
                                {!! Form::label('address',"地址:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('address', null,  ['class'=>'form-control']) !!}
                                    <div>
                                        @if($errors->has('address'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('address') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <!-- 駕照正面 Form image Input -->
                            <div class="form-group row">
                                {!! Form::label('imgFile_driver_image01',"駕照正面：",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::file('imgFile_driver_image01',['class'=>'form-control']); !!}<br>
                                    @if($user->driver_image01)
                                        <div id="delete_driver_image01_block">
                                            {{ Html::image('/admin/user/driver_image01/'.$user->driver_image01,null,['style'=>'max-width:600px']) }}&nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" style="display: inline-block;color: red;border:solid 1px red;padding: 2px 8px" id="remove_driver_image01_btn"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            <script>
                                                $(function() {
                                                    $('#remove_driver_image01_btn').click(function() {
                                                        if(confirm('是否確定要刪除此圖片？')) {
                                                            $.get('/admin/ajax_remove_image', {
                                                                "db": 'users',
                                                                "id": '{{$user->id}}',
                                                                "field": 'driver_image01'
                                                            });
                                                            $('#delete_driver_image01_block').fadeOut(1000, function() { $(this).remove(); });
                                                        }
                                                    })
                                                })
                                            </script>
                                        </div>
                                    @endif
                                </div>
                                {!! Form::hidden('driver_image01',null) !!}
                            </div>

                            <!-- 駕照管轄編號 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('driver_no',"駕照管轄編號:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('driver_no', null,  ['class'=>'form-control']) !!}
                                    <div>
                                        @if($errors->has('driver_no'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('driver_no') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <!-- 駕照反面 Form image Input -->
                            <div class="form-group row">
                                {!! Form::label('imgFile_driver_image02',"駕照反面：",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::file('imgFile_driver_image02',['class'=>'form-control']); !!}<br>
                                    @if($user->driver_image02)
                                        <div id="delete_driver_image02_block">
                                            {{ Html::image('/admin/user/driver_image02/'.$user->driver_image02,null,['style'=>'max-width:600px']) }}&nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" style="display: inline-block;color: red;border:solid 1px red;padding: 2px 8px" id="remove_driver_image02_btn"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            <script>
                                                $(function() {
                                                    $('#remove_driver_image02_btn').click(function() {
                                                        if(confirm('是否確定要刪除此圖片？')) {
                                                            $.get('/admin/ajax_remove_image', {
                                                                "db": 'users',
                                                                "id": '{{$user->id}}',
                                                                "field": 'driver_image02'
                                                            });
                                                            $('#delete_driver_image02_block').fadeOut(1000, function() { $(this).remove(); });
                                                        }
                                                    })
                                                })
                                            </script>
                                        </div>
                                    @endif
                                </div>
                                {!! Form::hidden('driver_image02',null) !!}
                            </div>

                            <hr>
                            <!-- 緊急連絡人 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('emergency_contact',"緊急連絡人:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('emergency_contact', null,  ['class'=>'form-control']) !!}
                                    <div>
                                        @if($errors->has('emergency_contact'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('emergency_contact') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 緊急連絡電話 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('emergency_phone',"緊急連絡電話:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('emergency_phone', null,  ['class'=>'form-control']) !!}
                                    <div>
                                        @if($errors->has('emergency_phone'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('emergency_phone') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 公司抬頭 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('company_name',"公司抬頭:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('company_name', null,  ['class'=>'form-control']) !!}
                                    <div>
                                        @if($errors->has('company_name'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('company_name') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- 公司統編 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('company_no',"公司統編:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('company_no', null,  ['class'=>'form-control']) !!}
                                    <div>
                                        @if($errors->has('company_no'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('company_no') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div style="padding: 10px;background-color: #fff2f2;" id="fee">
                                <h5 style="text-align: left;font-size: 16px;padding: 10px">其它費用:</h5>
                                <!-- 自訂標題 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('fee_title',"繳費期限:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('fee_title', null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <!-- E-Tag費用 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('e_tag',"E-Tag費用:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('e_tag', null,['class'=>'form-control','v-model'=>'e_tag']) !!}
                                    </div>
                                </div>

                                <!-- 停車費 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('park_fee',"停車費:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('park_fee', null,['class'=>'form-control','v-model'=>'park_fee']) !!}
                                    </div>
                                </div>

                                <!-- 罰單 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('ticket',"罰單:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('ticket', null,['class'=>'form-control','v-model'=>'ticket']) !!}
                                    </div>
                                </div>

                                <!-- 保養費 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('maintain_fee',"保養費:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('maintain_fee', null,['class'=>'form-control','v-model'=>'maintain_fee']) !!}
                                    </div>
                                </div>
                                <hr>
                                <!-- 自訂標題 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('custom_title',"自訂標題:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('custom_title', null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <!-- 自訂標題金額 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('custom_fee',"自訂標題金額:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('custom_fee', null,['class'=>'form-control','v-model'=>'custom_fee']) !!}
                                    </div>
                                </div>
                                <hr>
                                <!-- 金額總計 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('total',"金額總計:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('total', null,['class'=>'form-control','v-model'=>'total','readonly']) !!}
                                    </div>
                                </div>
                            </div>
                            <script>
                                var vm = new Vue({
                                    el: '#fee',
                                    data: {
                                        e_tag: {{$user->e_tag?$user->e_tag:0}},
                                        park_fee: {{$user->park_fee?$user->park_fee:0}},
                                        ticket: {{$user->ticket?$user->ticket:0}},
                                        maintain_fee: {{$user->maintain_fee?$user->maintain_fee:0}},
                                        custom_fee: {{$user->custom_fee?$user->custom_fee:0}},
                                    },
                                    computed: {
                                        total: function () {
                                            return parseInt(this.e_tag) + parseInt(this.park_fee) + parseInt(this.ticket) + parseInt(this.maintain_fee) + parseInt(this.custom_fee);
                                        }

                                    }
                                })
                            </script>
                            <hr>

                            <!-- 是否已通知:格上? Form checkbox Input -->
                            <div class="form-group row">
                                {!! Form::label('is_activate',"是否已啟用帳號?",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {{--{!! Form::checkbox('is_notify', null, $user->is_notify_email==1?'checked':'',['class'=>'','style'=>'width: 20px; height: 20px;','onclick'=>'return false;']) !!} &nbsp;&nbsp;&nbsp;(系統會自動更新狀態，僅供提示作用，不可編輯)--}}
                                    @if($user->is_activate==1)
                                        <span style="color: green;font-size: 20px;">是</span>
                                    @else
                                        <span style="color: red;font-size: 20px;">否</span>
                                    @endif
                                </div>
                            </div>
                            <hr>

                            <span>審查基本資料是否通過？</span>
                            @php
                                $is_check=$user->is_check;
                                $color='#777';
                                $bg_color='#eee';
                                $font_weight='400';
                                if($is_check==1){
                                    $color='green';
                                    $bg_color='#cdffcd';
                                    $font_weight='bold';
                                }
                                elseif($is_check==0){
                                    $color='red';
                                    $bg_color='#ffd9d9';
                                    $font_weight='bold';
                                }
                            @endphp
                            {!! Form::select('is_check', ['-1'=>'未審核','1'=>'通過','0'=>'不通過'] , $user->is_check ,['class'=>'verify_checkbox','style'=>'border: solid 1px #ddd;padding: 5px;border-radius: 5px;color:'.$color.';background-color:'.$bg_color.';font-weight:'.$font_weight,'id'=>'user','required','onchange'=>'updateUserField'.'();']) !!}
                            &nbsp;&nbsp;&nbsp;<span style="color: green;padding-top: 5px" id="is_check_msg"></span>
                            <script>
                                function updateUserField() {
                                    var is_check = $('#user :selected').val();
                                    if(confirm('是否確認要變更審核狀態？')) {
                                        $.get('/admin/update_user_table_field', {
                                            "db": 'users',
                                            "id": '{{$user->id}}',
                                            "field": 'is_check',
                                            "value": is_check
                                        }).done(function(data) {
                                            //console.log(data);
                                            if( data==1 ) {
                                                $('#user').css('color', 'green').css('font-weight', 'bold');
                                                $('#user').css('background-color', '#cdffcd').css('font-weight', 'bold');
                                            }
                                            else if(data==0) {
                                                $('#user').css('color', 'red').css('font-weight', 'bold');
                                                $('#user').css('background-color', '#ffd9d9').css('font-weight', 'bold');
                                            }
                                            else {
                                                $('#user').css('color', '#777').css('font-weight', '400');
                                                $('#user').css('background-color', '#eee').css('font-weight', 'bold');
                                            }
                                            $('#is_check_msg').html('狀態更新成功').show().delay(3000).slideUp(300);
                                        });
                                    }
                                    else{
                                        $('#user').val({{$user->is_check}});
                                    }
                                }
                            </script>


                            <!-- 是否已寄寄出訂閱開通通知:格上? Form checkbox Input -->
                            <div class="form-group row" style="padding-top: 20px">
                                {!! Form::label('is_my1_1_email',"是否已寄出訂閱開通通知?",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    @if($user->is_my1_1_email==1)
                                        <span style="color: green;font-size: 20px;">是</span>
                                    @else
                                        <span style="color: red;font-size: 20px;">否</span>
                                    @endif
                                </div>
                            </div>

                            <!-- 是否已通知:格上? Form checkbox Input -->
                            <div class="form-group row" style="padding-top: 0">
                                {!! Form::label('is_mn1_1_email',"是否已寄出資料補齊提醒通知?",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    @if($user->is_mn1_1_email==1)
                                        <span style="color: green;font-size: 20px;">是</span>
                                    @else
                                        <span style="color: red;font-size: 20px;">否</span>
                                    @endif
                                </div>
                            </div>

                            <!--  Form Submit Input -->
                            <div class="form-group" style="text-align:center">
                            @if(role('admin') || role('babysitter'))
                                <!-- 會員提供資料不全的原因： Form text Input -->
                                    <hr>
                                    <div class="form-group row">
                                        {!! Form::label('reject_reason',"會員提供資料不全的原因：(會隨資料補齊提醒Email寄出)",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {!! Form::textarea('reject_reason', null,['id'=>'reject_reason','class'=>'form-control','rows'=>5,'onblur'=>'updateField();']); !!}
                                            <script>
                                                function updateField() {
                                                    var reject_reason = $("textarea#reject_reason").val();
                                                    $.get('/admin/update_table_field', {"db":'users',"id":'{{$user->id}}',"field":'reject_reason',"value": reject_reason});
                                                }
                                            </script>
                                            @if($errors->has('reject_reason'))
                                                <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('reject_reason') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {!! Form::submit('更新',['class'=>'btn btn-success']) !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    @if($user->is_activate==1)
                                        {{--<a class="btn btn-info" href="{{ url('/admin/user_notify_email/'.$user->id) }}" onclick="return confirm('是否確認要寄出Email?');">資料確認及寄出Email通知格上</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--}}
                                        <a class="btn btn-warning" href="{{ url('/admin/send_email/my12/'.$user->id) }}"  onclick="return confirm('是否確認要寄出Email?');">寄出其他費用繳款提醒通知</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a class="btn btn-info" href="{{ url('/admin/send_email/my1_1/'.$user->id) }}"  onclick="return confirm('是否確認要寄出Email?');">寄出訂閱開通通知</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a class="btn btn-danger" href="{{ url('/admin/send_email/mn1_1/'.$user->id) }}" onclick="return confirm('是否確認要寄出Email?');">寄出資料補齊提醒通知</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    @else
                                        <span style="color: red">(會員帳號尚未啟用)</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    @endif


                                @endif
                                <a class="btn btn-secondary" href="{{ url('/admin/user?bid='.$user->id.'&page='.Request('page') ) }}">取消及回上一頁</a>
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
    <script src="/assets/datePicker/WdatePicker.js" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="/back_assets/src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="/back_assets/plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="/back_assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/back_assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="/back_assets/dist/js/theme.min.js"></script>
    {{--    <script src="/back_assets/js/form-components.js"></script>--}}
    <script src="/back_assets/plugins/mohithg-switchery/dist/switchery.min.js"></script>
    <script>
        var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elem.forEach(function(html) {
            var switchery = new Switchery(html, {
                color: 'green',
                jackColor: '#fff'
            });
        });
    </script>
@stop