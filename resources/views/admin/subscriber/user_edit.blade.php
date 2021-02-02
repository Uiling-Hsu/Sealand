@extends('admin.layouts.adminapp')

@section('extra-css')
    <link rel="stylesheet" href="/back_assets/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="/back_assets/plugins/mohithg-switchery/dist/switchery.min.css">
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
                                @if(role('admin') || role('babysitter'))
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

                                    <hr>
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

                                    {{--<hr>
                                    <h5>會員可訂閱方案</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" style="max-width: 600px">
                                            <thead>
                                            <tr>
                                                <th style="text-align: center;">No.</th>
                                                <th>方案</th>
                                                <th style="text-align:center">允許訂閱</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <!-- Begin Form -->
                                            {!! Form::open(['url' => '/admin/user/sort']) !!}
                                            @foreach($cates as $key=>$cate)
                                                @php
                                                    $usergate=\App\Model\Usergate::where('cate_id',$cate->id)->where('user_id',$user->id)->first();
                                                @endphp
                                                <tr>
                                                    <td style="width:20%;text-align: center;">{{$key+1}}</td>
                                                    <td style="width: 50%">
                                                        <span style="font-size: 20px;font-weight: bold;color: purple">{!! $cate->title !!}</span><br>
                                                        保證金: <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->deposit)}}</span>&nbsp;&nbsp;
                                                        月租: <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->basic_fee)}}</span>
                                                    </td>
                                                    <td style="width: 30%;text-align: center;">
                                                        <input type="checkbox" class="js-switch" id="status{{$key}}" {{$usergate && $usergate->status?'checked':''}} />
                                                        <script>
                                                            $(function() {
                                                                $('#status{{$key}}').change(function() {
                                                                    console.log('Toggle: ' + $(this).prop('checked'));
                                                                    $.get('/admin/ajax_switch', {"value": $(this).prop('checked'),"db":'usergates',"id":'{{$usergate?$usergate->id:''}}',"field":'status'});
                                                                })
                                                            })
                                                        </script>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            --}}{{--@if($users->count())
                                                <tr>
                                                    <td></td>
                                                    <td class="text-center">{!! Form::submit('更新排序',['class'=>'btn btn-primary']) !!}</td>
                                                </tr>
                                            @endif--}}{{--
                                            {!! Form::close() !!}
                                            </tbody>
                                        </table>
                                        <div>&nbsp;</div>
                                    </div>--}}
                                    <!-- 是否已通知:格上? Form checkbox Input -->
                                    <div class="form-group row">
                                        {!! Form::label('is_notify',"是否已啟用帳號?",['class'=>'col-sm-2 form-control-label']) !!}
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
                                    <!-- 是否已通知:格上? Form checkbox Input -->
                                    <div class="form-group row">
                                        {!! Form::label('is_temp_notify_email',"是否已寄Email通知?",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{--{!! Form::checkbox('is_notify', null, $user->is_notify_email==1?'checked':'',['class'=>'','style'=>'width: 20px; height: 20px;','onclick'=>'return false;']) !!} &nbsp;&nbsp;&nbsp;(系統會自動更新狀態，僅供提示作用，不可編輯)--}}
                                            @if($user->is_temp_notify_email==1)
                                                <span style="color: green;font-size: 20px;">是</span>
                                            @else
                                                <span style="color: red;font-size: 20px;">否</span>
                                            @endif
                                        </div>
                                    </div>

                                @else
                                    <!-- 姓名 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('name',"姓名:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->name}}
                                        </div>
                                    </div>

                                    <!-- Email Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('email',"Email:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->email}}
                                        </div>
                                    </div>

                                    <!-- 手機 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('phone',"手機:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->phone}}
                                        </div>
                                    </div>

                                    <!-- 市話 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('telephone',"市話:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->telephone}}
                                        </div>
                                    </div>

                                    <!-- 生日 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('birthday',"生日:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->birthday}}
                                        </div>
                                    </div>

                                    <!-- 地址 Form textarea Input -->
                                    <div class="form-group row">
                                        {!! Form::label('address',"地址:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->address}}
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- 手機 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('idno',"身份證字號:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->idno}}
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- 身份証正面 Form image Input -->
                                    <div class="form-group row">
                                        {!! Form::label('imgFile_idcard_image01',"身份証正面：",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            @if($user->idcard_image01)
                                                {{ Html::image('/admin/subscriber/idcard_image01/'.$user->idcard_image01,null,['style'=>'max-width:600px']) }}&nbsp;&nbsp;&nbsp;
                                            @endif
                                        </div>
                                        {!! Form::hidden('idcard_image01',null) !!}
                                    </div>
                                    <hr>
                                    <!-- 身份証反面 Form image Input -->
                                    <div class="form-group row">
                                        {!! Form::label('imgFile_idcard_image02',"身份証反面：",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            @if($user->idcard_image02)
                                                {{ Html::image('/admin/subscriber/idcard_image02/'.$user->idcard_image02,null,['style'=>'max-width:600px']) }}&nbsp;&nbsp;&nbsp;
                                            @endif
                                        </div>
                                        {!! Form::hidden('idcard_image02',null) !!}
                                    </div>

                                    <hr>

                                    <!-- 駕照正面 Form image Input -->
                                    <div class="form-group row">
                                        {!! Form::label('imgFile_driver_image01',"駕照正面：",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            @if($user->driver_image01)
                                                {{ Html::image('/admin/subscriber/driver_image01/'.$user->driver_image01,null,['style'=>'max-width:600px']) }}&nbsp;&nbsp;&nbsp;
                                            @endif
                                        </div>
                                        {!! Form::hidden('driver_image01',null) !!}
                                    </div>
                                    <hr>
                                    <!-- 駕照反面 Form image Input -->
                                    <div class="form-group row">
                                        {!! Form::label('imgFile_driver_image02',"駕照反面：",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            @if($user->driver_image02)
                                                {{ Html::image('/admin/subscriber/driver_image02/'.$user->driver_image02,null,['style'=>'max-width:600px']) }}&nbsp;&nbsp;&nbsp;
                                            @endif
                                        </div>
                                        {!! Form::hidden('driver_image02',null) !!}
                                    </div>

                                    <!-- 駕照管轄編號 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('driver_no',"駕照管轄編號:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->driver_no}}
                                        </div>
                                    </div>

                                    <hr>
                                    <!-- 緊急連絡人 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('emergency_contact',"緊急連絡人:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->emergency_contact}}
                                        </div>
                                    </div>

                                    <!-- 緊急連絡電話 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('emergency_phone',"緊急連絡電話:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->emergency_phone}}
                                        </div>
                                    </div>

                                    <!-- 公司抬頭 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('company_name',"公司抬頭:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->company_name}}
                                        </div>
                                    </div>

                                    <!-- 公司統編 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('company_no',"公司統編:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {{$user->company_no}}
                                        </div>
                                    </div>
                                    <hr>

                                @endif

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
                                            <hr>
                                        {!! Form::submit('更新',['class'=>'btn btn-success']) !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @if($user->is_activate==1)
                                            {{--<a class="btn btn-info" href="{{ url('/admin/user_notify_email/'.$user->id) }}" onclick="return confirm('是否確認要寄出Email?');">資料確認及寄出Email通知格上</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--}}
                                            <a class="btn btn-info" href="{{ url('/admin/user_temp_notify_email/'.$user->id) }}"  onclick="return confirm('是否確認要寄出Email?');">寄出請會員填寫需求單Email</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a class="btn btn-danger" href="{{ url('/admin/user_temp_reject_notify_email/'.$user->id) }}" onclick="return confirm('是否確認要寄出Email?');">寄出資料補齊提醒通知</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @else
                                            <span style="color: red">(會員帳號尚未啟用)</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        @endif
                                    {{--@elseif(role('carplus_varify'))
                                        <span style="padding-bottom: 10px;font-size: 16px;">方案審查完成，寄出Email通知冰宇及會員：</span>
                                        <a class="btn btn-success" href="{{ url('/admin/user_subscriber_ok_email/'.$user->id) }}" onclick="return confirm('是否確認要寄出方案通過Email?');">寄出方案通過Email</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a class="btn btn-danger" href="{{ url('/admin/user_subscriber_reject_email/'.$user->id) }}" onclick="return confirm('是否確認要寄出拒絕Email?');">寄出方案拒絕Email</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--}}
                                        <a class="btn btn-secondary" href="{{ url('/admin/user?bid='.$user->id.'&page='.Request('page') ) }}">取消及回上一頁</a>
                                    @endif
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