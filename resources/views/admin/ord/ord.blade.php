@extends('admin.layouts.adminapp')

@section('extra-css')
    <link rel="stylesheet" href="/back_assets/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="/back_assets/plugins/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/summernote/dist/summernote-bs4.css">
    <link rel="stylesheet" href="/back_assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/back_assets/plugins/mohithg-switchery/dist/switchery.min.css">
    <link rel="stylesheet" href="/back_assets/dist/css/theme.css">
    <link rel="stylesheet" href="/back_assets/css/custom.css">

    <script src="/back_assets/src/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="/css/jquery-ui-1.9.2.css" type="text/css" charset="utf-8" />
    <style>
        .temp_table{
            width: 100%;background-color: #f5f5f5;border-radius: 10px;
        }
        .temp_top_td{
            color: #e77100;text-align: center;font-size: 20px;font-weight: bold;border-bottom: solid 2px white;
        }
        .temp_title_td{
            width: 40%;border-right: solid 2px white;padding: 6px 20px;
        }
        .temp_content_td{
            width: 60%;border-right: solid 2px white;padding: 6px 15px;
        }
        .temp_button_td{
            text-align: center;font-size: 40px;font-weight: bold;padding: 5px;border-top: solid 2px white;
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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">訂單管理</h5>
                                {{--                                <span>各項參數訂閱訂單</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">訂單管理</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="">
                            <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                <span style="display: inline-block;padding-left: 10px">車輛 查詢及列表</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['url' => '/admin/ord','method'=>'GET','name'=>'form_search'])  !!}
                                    {!! Form::hidden('download',null,['id'=>'download']) !!}
                                    <div class="form-row">
                                        <div class="col-md-3" style="padding-top: 10px;padding-bottom: 10px;;background-color: #f6f6f6;">
                                            <label for="search_start_date">訂單日期 起：</label>
                                            {!! Form::text('search_start_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px;padding-bottom: 10px;;background-color: #f6f6f6;">
                                            <label for="search_end_date">訂單日期 迄：</label>
                                            {!! Form::text('search_end_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px;padding-bottom: 10px;;background-color: #f6f6f6;">
                                            <label for="search_date_field">日期欄位</label>
                                            {!! Form::select('search_date_field',
                                                [
                                                    ''=>'全部',
                                                    'created_at'=>'新增訂單日期',
                                                    'updated_at'=>'更新訂單日期',
                                                    'paid_date'=>'保證金付款日期',
                                                    'paid2_date'=>'起租付款日期',
                                                    'paid3_date'=>'迄租付款日期',
                                                    'cancel_date'=>'取消日期'
                                                ] , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px;padding-bottom: 10px;;background-color: #f6f6f6;">
                                            <label for="search_date_field">目的</label>
                                            {!! Form::select('search_purpose',
                                                [
                                                    ''=>'全部',
                                                    'is_paid'=>'保證金付款',
                                                    'is_paid2'=>'起租付款',
                                                    'is_paid3'=>'迄租付款',
                                                    'is_working'=>'有效訂單',
                                                    'renewtate_id1'=>'原車續約',
                                                    'renewtate_id2'=>'換車',
                                                    'renewtate_id3'=>'不續約',
                                                    'renewtate_id4'=>'購車'
                                                ] , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
                                        </div>

                                        {{--<div class="col-md-3" style="padding-top: 10px;">
                                            <label for="search_state_id">訂單狀態</label>
                                            {!! Form::select('search_state_id', $states , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
                                        </div>--}}
                                        <div class="col-md-3" style="padding-top: 10px">
                                            <label for="search_cate_id">方案</label>
                                            {!! Form::select('search_cate_id', $list_cates , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
                                        </div>
                                        @if(role('admin') || role('babysitter'))
                                            <div class="col-md-3" style="padding-top: 10px">
                                                <label for="search_dealer_id">總經銷商</label>
                                                {!! Form::select('search_dealer_id', $list_dealers , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
                                            </div>
                                        @endif
                                        @if(!role('partner'))
                                            <div class="col-md-3" style="padding-top: 10px">
                                                <label for="search_partner_id">經銷商</label>
                                                {!! Form::select('search_partner_id', $list_partners , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
                                            </div>
                                        @endif
                                        <div class="col-md-3" style="padding-top: 10px;">
                                            <label for="renew_month">續約租期</label>
                                            {!! Form::select('search_rent_month', [''=>'全部','1'=>'1個月','2'=>'2個月','3'=>'3個月'] , null ,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px;">
                                            <label for="search_date_field">續約期數</label>
                                            {!! Form::select('search_samecartate_id', [''=>'全部','2'=>'原車續約1','3'=>'原車續約2','4'=>'原車續約3'] , null ,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px;">
                                            <label for="search_is_cancel">是否取消</label>
                                            {!! Form::select('search_is_cancel', ['all'=>'全部','1'=>'是','0'=>'否'] , $search_is_cancel ,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px">
                                            <label for="search_state_id">訂單狀態</label>
                                            {!! Form::select('search_state_id', $list_states , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px">
                                            <label for="search_left_days">訂單快到期天數</label>
                                            @php
                                                $arr=array();
                                                $arr['']='';
                                                for($i=1;$i<=5;$i++)
                                                    $arr[$i]=$i.'天內到期';
                                                $arr[12]='12天內到期';
                                                $arr[20]='20天內到期';

                                            @endphp
                                            {!! Form::select('search_left_days', $arr , $search_left_days ,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px">
                                            <label for="search_plate_no">車號</label>
                                            {!! Form::text('search_plate_no',null,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px">
                                            <label for="search_model">車輛編號</label>
                                            {!! Form::text('search_model',null,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px">
                                            <label for="search_is_picok">輸入統編</label>
                                            {!! Form::select('search_company_no', [''=>'','1'=>'有','0'=>'無'] , $search_company_no ,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px">
                                            <label for="search_keyword">訂單編號、結帳單號(保證金、交車、還車)</label>
                                            {!! Form::text('search_keyword',null,['class'=>'form-control','placeholder'=>'可輸入字首、字中、字尾關鍵字']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px">
                                            <label for="search_user_keyword">會員姓名、電話、Email</label>
                                            {!! Form::text('search_user_keyword',null,['class'=>'form-control','placeholder'=>'可輸入字首、字中、字尾關鍵字']) !!}
                                        </div>
                                        <div class="col-md-3" style="padding-top: 10px">
                                            <div style="height: 28px;">&nbsp;</div>
                                            <button type="submit" class="btn btn-primary" onclick="document.getElementById('download').value=0">查詢</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="?clear=1" class="btn btn-success" onclick="document.getElementById('download').value=0">顯示全部資料</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            @if($ords->count()>0)
                                                &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" onclick="if(confirm('是否確認要匯出Excel?')){document.getElementById('download').value=1;}" class="btn btn-info">匯出Excel</button>
                                            @endif
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                <span style="display: inline-block;padding-left: 10px">訂單 列表 &nbsp;&nbsp;&nbsp;<span style="color: purple">( 訂單總筆數：{{$ords?number_format($ords->total()):0}} 筆 )</span></span>
                                @if(getAdminUser()->id==1 || getAdminUser()->id==18)
                                    <a href="{{ url('/admin/ord/create' ) }}" class="btn btn-primary float-md-right">新增 訂單</a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">NO.</th>
                                        <th style="text-align: center;" style="text-align: left;">訂單資訊</th>
                                        <th style="text-align: center;">會員資料</th>
                                        <th style="text-align: center;">方案類別</th>
                                        <th style="text-align: center;">交車區域 / <br>交車日期 / <br>到期日期/ <br>距到期天數</th>
                                        <th style="text-align: center;">訂閱車輛</th>
                                        <th style="text-align: center;">車輛規格</th>
                                        <th style="text-align: center;">動作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {!! Form::open(['url' => '/admin/ord/batch_update'])  !!}
                                    @foreach($ords as $key=>$ord)
                                        @php
                                            $user=$ord->user;
                                            $cate=$ord->cate;
                                            $product=$ord->product;
                                            $proarea=$ord->proarea;
                                            $subcars=$ord->subcars;
                                        @endphp
                                        {!! Form::hidden('ord_id[]',$ord->id) !!}
                                        <tr @if(Request('bid')==$ord->id) {!! tableBgColor() !!} @endif class="data">
                                            <td class="id" style="text-align: center;width: 3%">{{$key+1}}</td>
                                            <td style="text-align: left;width: 18%">
                                                <div style="padding-bottom: 10px">
                                                    @if(getOrdLeftDays($ord->id)<=5)
                                                        <span style="color: red;font-size: 30px;">●</span>
                                                    @endif
                                                    訂閱 ID：{{$ord->subscriber_id}}
                                                </div>
                                                <span style="font-weight: bold;color:purple;font-size: 20px;">訂單編號：{{$ord->ord_no}}</span><br>
                                                <div style="color: green">
                                                    @if($ord->is_renew_order==1)
                                                        續約租期：{{$ord->rent_month}} 個月
                                                    @else
                                                        <div style="color: {{$ord->is_renew_change_order==1?'#d47400':'green'}}">租期：3 個月
                                                    @endif
                                                    @if($ord->is_renew_order==1)
                                                        @php
                                                            $samecartate=$user->samecartate;
                                                        @endphp
                                                        @if($samecartate)
                                                            &nbsp;<span style="color: green">({{$samecartate->title}})</span>
                                                        @else
                                                            &nbsp;<span style="color: green">(同車續約單)</span>
                                                        @endif
                                                    @endif
                                                    @if($ord->is_renew_change_order==1)
                                                        <span style="color: #d47400;font-weight: 400;">(換車續約單)</span>
                                                    @endif
                                                </div>

                                                @if($ord->checkout_no)
                                                    保證金結帳單號：{{$ord->checkout_no}}<br>
                                                @endif
                                                @if($ord->checkout_no2)
                                                    <span style="color: green">交車結帳單號：{{$ord->checkout_no2}}<br>
                                                @endif
                                                @if($ord->checkout_no3)
                                                    還車結帳單號：{{$ord->checkout_no3}}<br>
                                                @endif
                                                @if($ord->is_renew_order==1 || $ord->is_renew_change_order==1)
                                                    <span style="color:{{$ord->is_renew_change_order==1?'#d47400':'green'}}"> 續約前單號：</span><a href="/admin/ord/{{$ord->renew_ord_id}}/edit" class="btn btn-{{$ord->is_renew_change_order==1?'warning':'success'}}" target="_blank">{{$ord->renew_ord_no}}</a>
                                                @endif
                                                <div style="color: purple;background-color: #fff2f4;font-size: 16px;margin: 5px;padding: 5px 10px;border: solid 1px #ccc;border-radius: 20px">{{$ord->state_id}}. {{$ord->state?$ord->state->ftitle:''}}</div>
                                                <span style="font-size: 16px;color: black">保證金：{{number_format($ord->deposit)}}</span>
                                                {!! $ord->is_paid==1?'<span style="color: green;font-size: 18px;font-weight:bold">➝ 已付款</span>':'<span style="color: red;font-size: 18px;font-weight:bold">➝ 未付款</span>' !!}
                                                <br>{{$ord->paid_date?'付款日：'.substr($ord->paid_date,0,10):''}}<br>
                                                @if($ord->state_id>1)
                                                    <span style="font-size: 16px;color: black">起租款：{{number_format($ord->payment_total)}}</span> {!! $ord->is_paid2==1?'<span style="color: green;font-size: 18px;font-weight:bold">➝ 已付款</span>':'<span style="color: red;font-size: 18px;font-weight:bold">➝ 未付款 </span>' !!}
                                                    <br>{{$ord->paid2_date?'付款日：'.substr($ord->paid2_date,0,10):''}}<br>
                                                @endif
                                                @if($ord->state_id>1)
                                                    <span style="font-size: 16px;color: black">迄租款：{{number_format($ord->payment_backcar_total)}}</span> {!! $ord->is_paid3==1?'<span style="color: green;font-size: 18px;font-weight:bold">➝ 已付款</span>':'<span style="color: red;font-size: 18px;font-weight:bold">➝ 未付款 </span>' !!}
                                                    <br>{{$ord->paid3_date?'付款日：'.substr($ord->paid3_date,0,10):''}}<br>
                                                @endif
                                            </td>
                                            <td style="word-break: break-all;width:15%;">
                                                @if(role('admin') || role('babysitter'))
                                                    會員姓名：<a href="/admin/user/{{$user->id}}/edit" class="btn btn-primary" target="_blank">{{ $user->name }}</a><br>
                                                    {{--&nbsp;&nbsp;<a class="btn btn-success" href="/admin/user_idcard/{{$user->id}}">證照</a>--}}
                                                @else
                                                    會員姓名：{{ $user->name }}
                                                @endif
                                                手機：{{ $user->phone }}<br>
                                                Email：{{ $user->email }}<br>
                                                {{--地址：{{ $user->address }}<br>--}}
                                                身份證字號：{{ $user->idno }}<br>
                                                @if($user->company_no)
                                                    <hr>
                                                    抬頭：{{$user->company_name}}<br>
                                                    統編：{{$user->company_no}}<br>
                                                @endif
                                            </td>
                                            <td style="width: 12%;text-align: left;">

                                                <div style="color: red;padding-bottom: 5px">訂單來源: {{$ord->order_from==2?'Sealand':'格上'}}</div>
                                                <span style="font-size: 18px;font-weight: bold;">{{$cate->title}}</span><br>
                                                月租基本費(元): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->basic_fee)}}</span><br>
                                                每公里費用(元): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->mile_fee,2)}}</span>
                                                <hr>訂單新增日期：<br>{{$ord->created_at}}<br>
                                                @if($ord->created_at != $ord->updated_at)
                                                    更新日期：<br>{{$ord->updated_at}}
                                                @endif
                                                @if($ord->state_id>=6 && $ord->state_id<=13)
                                                    <br>交車日期：{{$ord->real_sub_date}}
                                                @endif
                                                @if($ord->state_id>=11 && $ord->state_id<=13)
                                                    <br>還車日期：{{$ord->real_back_date}}
                                                @endif
                                                @if($ord->is_cancel==1)
                                                    <hr><span style="font-size: 24px;font-weight: bold;color: red">此訂單已取消</span>
                                                    <div style="font-size: 15px;color: red">取消時間：<br>{{$ord->cancel_date}}</div>
                                                    @if($ord->cancel_reason)
                                                        <div style="font-size: 15px;color: red">取消原因：{{$ord->cancel_reason}}</div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td style="width: 15%;">
                                                交車地點：<span style="font-weight: bold;">{{$ord->delivery_address}}</span>
                                                <hr>
                                                交車區域：{!! $proarea?$proarea->title:'<span style="color: red;font-size:20px;font-weight:bold">無</span>' !!}
                                                <hr>
                                                預計交車日：<br>{{$ord->sub_date}}&nbsp;&nbsp;&nbsp;{{$ord->pick_up_time}}
                                                @if($ord->real_sub_date)
                                                    <br>實際交車日：{{$ord->real_sub_date}}
                                                @endif
                                                @if($ord->real_sub_time)
                                                    {{$ord->real_sub_time}}
                                                @endif
                                                @if($ord->expiry_date)
                                                    <br>到期日：{{$ord->expiry_date}}
                                                @endif
                                                @if($ord->expiry_time)
                                                    {{$ord->expiry_time}}
                                                @endif
                                                <hr>
                                                @php
                                                    $left_days=getOrdLeftDays($ord->id);
                                                @endphp
                                                @if($ord->is_cancel==0 && $ord->state_id>=5 && $ord->state_id<10)
                                                    剩：
                                                    @if( $left_days<= setting('partner_renewal_confirm_days'))
                                                        <span style="color: red;font-weight: bold;font-size: 20px;">{{$left_days}} 天</span>
                                                    @else
                                                        <span>{{$left_days}} 天</span>
                                                    @endif
                                                @endif
                                                @if(role('partner'))
                                                    @if($ord->state_id==7)
                                                        @if($left_days<=setting('partner_renewal_confirm_days') && $left_days>=(setting('user_renewal_start_days')+1))
                                                            <hr>
                                                            <span>此車輛是否續約？</span>
                                                            @php
                                                                $is_car_renewal=$ord->is_car_renewal;
                                                                $color='#777';
                                                                $bg_color='#eee';
                                                                $font_weight='400';
                                                                if($is_car_renewal==1){
                                                                    $color='green';
                                                                    $bg_color='#cdffcd';
                                                                    $font_weight='bold';
                                                                }
                                                                elseif($is_car_renewal==0){
                                                                    $color='red';
                                                                    $bg_color='#ffd9d9';
                                                                    $font_weight='bold';
                                                                }
                                                            @endphp
                                                            {!! Form::select('is_car_renewal', ['-1'=>'未設定','1'=>'續約','0'=>'不續約'] , $ord->is_car_renewal ,['class'=>'verify_checkbox','style'=>'color:'.$color.';background-color:'.$bg_color.';font-weight:'.$font_weight,'id'=>'ord'.$key,'required','onchange'=>'is_car_renewal_updateField_'.$key.'();']) !!}
                                                            <script>
                                                                function is_car_renewal_updateField_{{$key}}() {
                                                                    var is_car_renewal = $('#ord{{$key}} :selected').val();
                                                                    if(confirm('是否確認要變更審核狀態？')) {
                                                                        $.get('/admin/update_table_field', {
                                                                            "db": 'ords',
                                                                            "id": '{{$ord->id}}',
                                                                            "field": 'is_car_renewal',
                                                                            "value": is_car_renewal
                                                                        }).done(function(data) {
                                                                            //console.log(data);
                                                                            if( data==1 ) {
                                                                                $('#ord{{$key}}').css('color', 'green').css('font-weight', 'bold');
                                                                                $('#ord{{$key}}').css('background-color', '#cdffcd').css('font-weight', 'bold');
                                                                            }
                                                                            else if(data==0) {
                                                                                $('#ord{{$key}}').css('color', 'red').css('font-weight', 'bold');
                                                                                $('#ord{{$key}}').css('background-color', '#ffd9d9').css('font-weight', 'bold');
                                                                            }
                                                                            else {
                                                                                $('#ord{{$key}}').css('color', '#777').css('font-weight', '400');
                                                                                $('#ord{{$key}}').css('background-color', '#eee').css('font-weight', 'bold');
                                                                            }
                                                                        });
                                                                    }
                                                                    else{
                                                                        $('#ord{{$key}}').val({{$ord->is_car_renewal}});
                                                                    }
                                                                }
                                                            </script>
                                                        @elseif($left_days<=setting('user_renewal_start_days'))
                                                            @if($ord->is_car_renewal==1)
                                                                <div style="color: green;font-size: 16px;">( 車源商已確認提供續約 )</div>
                                                            @else
                                                                <div style="color: red;font-size: 16px;">( 車源商已確認不提供續約 )</div>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                                @if($ord->state_id>=8 && $ord->renewtate)
                                                    <div style="text-align: left;color:brown;padding-top: 10px;font-size: 16px;">
                                                        訂單續約狀態：{{$ord->renewtate->title}}
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="width: 14%">
                                                @if($product)
                                                    @if($product->partner)
                                                        {{--<div>原車輛經銷商 ID：{{$product->partner->id}}</div>
                                                        <div style="{{$product->partner->id!=$ord->partner_id?'color: red;font-size:20px':''}}">訂單經銷商 ID：{{$ord->partner_id}}</div>--}}
                                                        <span style="color: purple;font-size: 20px;font-weight: bold;">{{$ord->partner->title }}</span><br>
                                                        @if($ord->partner2)
                                                            <span style="font-size: 16px;color: red">原: {{$ord->partner2->title }}</span><br>
                                                        @endif
                                                        <hr>
                                                    @endif
                                                    @if($product->cate)
                                                        <span style="font-size: 20px;color: purple">{{$product->cate->title}}</span><br>
                                                        <span style="color: purple">{{number_format($product->cate->basic_fee) }} 元</span><br>
                                                        <span style="color: purple">{{number_format($product->cate->mile_fee,2) }} 元/每公里</span><br>
                                                    @endif
                                                    @if(role('admin') || role('babysitter'))
                                                        車輛 ID：{{$product->id }}<br>
                                                    @endif
                                                    編號：{{$ord->model}}<br>
                                                    車號：{{$ord->plate_no}}
                                                    {{--@if($ord->is_paid==0 && $product->status==0)
                                                        <h5 style="color: red">(訂單未付款，但此車已下架)</h5>
                                                    @endif--}}
                                                @endif
                                            </td>
                                            <td>
                                                {{--<a href="/admin/subscriber/{{$ord->subscriber_id}}/edit" class="btn btn-info" target="_blank">前往 訂閱單</a>
                                                <hr>--}}
                                                @if($product)
                                                    @php
                                                        $brandcat_name='';
                                                        $brandcat=$product->brandcat;
                                                        if($brandcat)
                                                            $brandcat_name=$brandcat->title;

                                                        $brandin_name='';
                                                        $brandin=$product->brandin;
                                                        if($brandin)
                                                            $brandin_name=$brandin->title;

                                                        $procolor_name='';
                                                        $procolor=$product->procolor;
                                                        if($procolor)
                                                            $procolor_name=$procolor->title;

                                                        $milage=$product->milage;
                                                        if(!$milage)
                                                            $milage=0;
                                                        $milage=(int)number_format(floor($milage/1000))*1000;
                                                    @endphp
                                                    <table class="temp_table">
                                                        <tr>
                                                            <td colspan="2" class="temp_top_td" style="padding:5px">{{$brandin_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="temp_title_td" style="padding:5px">廠牌</td>
                                                            <td class="temp_content_td" style="padding:5px">{{$brandcat_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="temp_title_td" style="padding:5px">顏色</td>
                                                            <td class="temp_content_td" style="padding:5px">{{$procolor_name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="temp_title_td" style="padding:5px">排氣量</td>
                                                            <td class="temp_content_td" style="padding:5px">{{number_format($product->displacement)}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="temp_title_td" style="padding:5px">年份</td>
                                                            <td class="temp_content_td" style="padding:5px">{{$product->year}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="temp_title_td" style="padding:5px">里程</td>
                                                            <td class="temp_content_td" style="padding:5px">{{number_format($milage)}}</td>
                                                        </tr>
                                                        @if($product->equipment)
                                                            <tr>
                                                                <td class="temp_title_td" style="padding:5px">配備</td>
                                                                <td class="temp_content_td" style="padding:5px">{{$product->equipment}}</td>
                                                            </tr>
                                                        @endif
                                                    </table>
                                                @endif
                                            </td>
                                            {{--<td>
                                                <input type="checkbox" class="js-switch" id="status{{$key}}" {{$ord->status==1?'checked':''}} />
                                                <script>
                                                    $(function() {
                                                        $('#status{{$key}}').change(function() {
                                                            console.log('Toggle: ' + $(this).prop('checked'));
                                                            $.get('/admin/ajax_switch', {"value": $(this).prop('checked'),"db":'ords',"id":'{{$ord->id}}',"field":'status'});
                                                        })
                                                    })
                                                </script>
                                            </td>--}}
                                            <td>
                                                <div class="buttons">
                                                    <div>
                                                        @if(!role('carplus_varify'))
                                                            <a href="{{ url('/admin/ord/'.$ord->id.'/edit' ) }}" class="btn btn-success">編輯</a>
                                                        @endif
                                                    </div>
                                                    {{--<div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    <div>
                                                        @if(role('admin') || role('babysitter'))
                                                            <a href="{{ url('/admin/ord/'.$ord->id.'/delete' ) }}" class="btn btn-danger" onclick='return confirm("是否確定要刪除此筆資料?");'>刪除</a>
                                                        @endif
                                                    </div>--}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {!! Form::close() !!}
                                    </tbody>
                                </table>
                                <div>&nbsp;</div>

                                <div class="col-md-12">
                                    {{ $ords->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>

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
    <script src="/back_assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="/back_assets/plugins/summernote/dist/summernote-bs4.min.js"></script>
    <script src="/back_assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="/back_assets/plugins/jquery.repeater/jquery.repeater.min.js"></script>
    <script src="/back_assets/plugins/mohithg-switchery/dist/switchery.min.js"></script>
    <script src="/back_assets/dist/js/theme.min.js"></script>
    {{--    <script src="/back_assets/js/form-advanced.js"></script>--}}
    {{--<script src="/back_assets/js/drable.js"></script>--}}
    <script>

        var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elem.forEach(function(html) {
            var switchery = new Switchery(html, {
                color: 'green',
                jackColor: '#fff'
            });
        });

        $('#chkdelall').click(function(){
            if($("#chkdelall").prop("checked")) {
                $("input[name='isdel[]']").each(function() {
                    $(this).prop("checked", true);
                });
            } else {
                $("input[name='isdel[]']").each(function() {
                    $(this).prop("checked", false);
                });
            }
        });

        $('#chkall').click(function(){
            if($("#chkall").prop("checked")) {
                $("input[name='isread[]']").each(function() {
                    $(this).prop("checked", true);
                });
            } else {
                $("input[name='isread[]']").each(function() {
                    $(this).prop("checked", false);
                });
            }
        });
    </script>

    <script src="/js/jquery-ui.min.js" type="text/javascript"></script>
    <script>
        var availableDates = {!! getShowDateString() !!};
        $(function()
        {
            $('.datePicker').datepicker({
                dateFormat: "yy-mm-dd",
                clearText: '清除',
                clearStatus: '清除已選日期',
                closeText: '關閉',
                closeStatus: '不改變當前選擇',
                prevText: '<上月',
                prevStatus: '顯示上月',
                prevBigText: '<<',
                prevBigStatus: '顯示上一年',
                nextText: '下月>',
                nextStatus: '顯示下月',
                nextBigText: '>>',
                nextBigStatus: '顯示下一年',
                currentText: '今天',
                currentStatus: '顯示本月',
                monthNames: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
                monthNamesShort: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
                monthStatus: '選擇月份',
                yearStatus: '選擇年份',
                weekHeader: '週',
                weekStatus: '年內週次',
                dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
                dayNamesShort: ['週日','週一','週二','週三','週四','週五','週六'],
                dayNamesMin: ['日','一','二','三','四','五','六'],
                dayStatus: '設置 DD 為一周起始',
                dateStatus: '選擇 m月 d日, DD',
                firstDay: 1,
                initStatus: '請選擇日期',
                isRTL: false,
                onClose: function() {
                    $(this).trigger('blur');
                },
                changeMonth: true, changeYear: false});
        });


    </script>
@stop