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
    <link rel="stylesheet" href="/css/jquery-ui-1.9.2.css" type="text/css" charset="utf-8" />
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
                                {{--                                <span>各項參數訂單管理編輯</span>--}}
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
                    <div class="card" style="max-width: 800px">
                        <div class="card-header">
                            <h3>訂單 編輯</h3>&nbsp;&nbsp;&nbsp;&nbsp;
                            <a class="btn btn-secondary" href="{{ url('/admin/ord?bid='.$ord->id ) }}">取消及回上一列表</a>
                        </div>
                        <div class="card-body">
                        {!! Form::model($ord,['url' => '/admin/ord/'.$ord->id ,'method' => 'PATCH','enctype'=>'multipart/form-data','name'=>'form_update'])  !!}
                        {!! Form::hidden('list',null,['id'=>'list']) !!}
                        <!-- 方案類別 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('cate_id',"訂單資訊:",['class'=>'col-sm-3 form-control-label']) !!}
                                <div class="col-sm-9">
                                    訂閱 ID：{{$ord->subscriber_id}}<br>
                                    <span style="color: purple;font-size: 18px;font-weight: bold;">訂單編號：{{$ord->ord_no}}</span><br>
                                    @if($ord->checkout_no)
                                        保證金結帳單號：{{$ord->checkout_no}}<br>
                                    @endif
                                    @if($ord->checkout_no2)
                                        交車結帳單號：{{$ord->checkout_no2}}<br>
                                    @endif
                                    @if($ord->checkout_no3)
                                        還車結帳單號：{{$ord->checkout_no3}}<br>
                                    @endif
                                </div>
                            </div>

                            <!-- 方案類別 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('cate_id',"方案類別:",['class'=>'col-sm-3 form-control-label']) !!}
                                <div class="col-sm-9">
                                    <span style="font-size: 20px;font-weight: bold;">{{$cate->title}}</span><br>
                                    保證金(元): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->deposit)}}</span><br>
                                    月租基本費(元): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->basic_fee)}}</span><br>
                                    每公里費用(元): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->mile_fee,2)}}</span><br>
                                    每月基本里程數(公里): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->mile_pre_month)}}</span><br>
                                </div>
                            </div>
                            <!-- 會員資料 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('name',"會員資料:",['class'=>'col-sm-3 form-control-label']) !!}
                                <div class="col-sm-10" style="font-size: 16px;">
                                    會員姓名：
                                    @if(role('admin') || role('babysitter'))
                                        <a href="/admin/user/{{$user->id}}/edit" class="btn btn-primary" target="_blank">{{ $user->name }}</a>
                                    @else
                                        {{ $user->name }}
                                    @endif
                                    <br>手機：{{ $user->phone }}<br>
                                    Email：{{ $user->email }}<br>
                                    地址：{{ $user->address }}<br>
                                    身份証字號：{{ $user->idno }}<br>
                                    緊急連絡人：{{ $user->emergency_contact }}<br>
                                    緊急連絡電話：{{ $user->emergency_phone }}
                                </div>
                            </div>

                            <hr>
                            <br>
                            <!-- 實際選擇車輛 Form text Input -->
                            <div class="form-group row" style="font-size: 16px;">
                                {!! Form::label('emergency_contact',"車輛資訊:",['class'=>'col-sm-3 form-control-label']) !!}
                                <div class="col-sm-9">
                                    @if($product)
                                        {!! Form::select('partner_id', $list_partners , null ,['class'=>'form-control','style'=>'font-size:15px','required']) !!}<br>
                                        原經銷據點:
                                        {!! Form::select('partner2_id', $list_partner2s , null ,['class'=>'form-control','style'=>'font-size:15px','required']) !!}<br><br>
                                        @if($product->cate)
                                            <span style="font-size: 20px;color: purple">{{$product->cate->title}}</span><br>
                                            <span style="color: purple">{{number_format($product->cate->basic_fee) }} 元</span><br>
                                            <span style="color: purple">{{number_format($product->cate->mile_fee,2) }} 元/每公里</span><br>
                                        @endif
                                        {{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
                                        編號：{{$product->model}}<br>
                                        車號：{{$product->plate_no}}
                                        {{--@if($ord->is_paid==0 && $product->status==0)
                                            &nbsp;&nbsp;&nbsp;<a href="/admin/ordselcar/{{$ord->id}}" class="btn btn-primary"><span style="position: relative;top: -2px">重新選取車輛</span></a>

                                        @endif--}}
                                        <br>
                                        <span style="color: black;font-weight: 300;">品牌:</span><span style="font-weight: bold;"> {{$product->brandcat?$product->brandcat->title:'' }}</span><br>
                                        <span style="color: black;font-weight: 300;">車型:</span><span style="font-weight: bold;"> {{$product->brandin?$product->brandin->title:''}}</span><br>
                                        <span style="color: black;font-weight: 300;">排氣量:</span><span style="font-weight: bold;"> {{ number_format($product->displacement) }}</span><br>
                                        <span style="color: black;font-weight: 300;">年份:</span><span style="font-weight: bold;"> {{ $product->year }}</span><br>
                                        <span style="color: black;font-weight: 300;">排檔:</span><span style="font-weight: bold;"> {{$product->progeartype?$product->progeartype->title:''}}</span><br>
                                        <span style="color: black;font-weight: 300;">座位數:</span><span style="font-weight: bold;"> {{$product->seatnum}}</span><br>
                                        <span style="color: black;font-weight: 300;">顏色:</span><span style="font-weight: bold;"> {{$product->procolor?$product->procolor->title:''}}</span><br>
                                        <span style="color: black;font-weight: 300;">里程數:</span><span style="font-weight: bold;"> {{ number_format($product->milage) }}</span><br>
                                        <span style="color: black;font-weight: 300;">交車區域:</span><span style="font-weight: bold;"> {{$product->proarea?$product->proarea->title:''}}</span><br><br>
                                    @endif
                                </div>
                            </div>
                            <hr>
                        @if(role('admin') || role('babysitter'))
                            @if($product)
                                <!-- 是否取消 Form select Input -->
                                <div class="form-group row">
                                    <hr>
                                    {!! Form::label('is_cancel',"是否取消:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        @if($ord->is_cancel==0)
                                            {!! Form::select('is_cancel', [''=>'','1'=>'是','0'=>'否',] , null ,['class'=>'form-control']) !!}
                                            <span style="color: red">( 選擇後選擇後請記得按最下方按鈕更新 )</span>
                                        @else
                                            @if($ord->is_cancel==1)
                                                <span style="color: green;font-size: 20px;font-weight: bold;">是</span> &nbsp;&nbsp;&nbsp;( 取消時間:{{ $ord->cancel_date }} )
                                            @endif
                                            <div style="padding-top: 10px">
                                                取消原因：{!! Form::textarea('cancel_reason', null,['class'=>'form-control','rows'=>2]); !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <hr>

                                <!-- 訂單狀態 Form select Input -->
                                <a name="list"></a>
                                <div class="form-group row">
                                    {!! Form::label('state_id',"訂單狀態:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        @if($ord->is_cancel==1)
                                            <span style="color: red">訂單已取消</span>
                                        @else
                                            @if(role('admin') || role('babysitter'))
                                                {!! Form::select('state_id', $list_states , null ,['class'=>'form-control','style'=>'background-color:#fbebb1','onchange'=>'if(confirm("是否確認要改變訂單狀態？")){document.getElementById("list").value=1;document.form_update.submit();}else{this.selectedIndex='.($ord->state_id-1).';}']) !!}
                                            @else
                                                {!! Form::select('state_id', $list_onestep_states , null ,['class'=>'form-control','style'=>'background-color:#fbebb1','onchange'=>'if(confirm("是否確認要改變訂單狀態？")){document.getElementById("list").value=1;document.form_update.submit();}else{this.selectedIndex='.($ord->state_id-1).';}']) !!}
                                            @endif
                                        @endif
                                        <div style="padding: 10px 0">
                                            狀態對照表：
                                            <ul>
                                                @foreach($list_states as $key=>$list_state)
                                                    @if($key>0)
                                                        <li>
                                                            <span style="background-color: {{$key==$ord->state_id?'yellow':''}};">{{$key}}. {{$list_state}}</span>
                                                            {{$key==$ord->state_id?'→ (目前狀態)':''}}
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- 月租期數 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('deposit',"月租期數:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {{number_format($ord->rent_month)}} 個月
                                    </div>
                                </div>
                                <!-- 應付保證金 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('deposit',"應付保證金:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {{number_format($ord->deposit)}} 元
                                    </div>
                                </div>
                                <!-- 是否已付保證金 Form select Input -->
                                <div class="form-group row">
                                    {!! Form::label('is_paid',"是否已付保證金:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {!! Form::select('is_paid', ['0'=>'否','1'=>'是'] , null ,['class'=>'form-control','id'=>'is_paid']) !!}
                                        <div id="is_paid_msg" style="color: green"></div>
                                        <script>
                                            $(document).on('change', '#is_paid', function(){
                                                var is_paid = $('#is_paid :selected').val();//注意:selected前面有個空格！
                                                $.ajax({
                                                    url:"/admin/update_table_field",
                                                    method:"GET",
                                                    data:{
                                                        id: {{$ord->id}},
                                                        db:'ords',
                                                        field:'is_paid',
                                                        value:is_paid
                                                    },
                                                    success:function(res){
                                                        $('#is_paid_msg').html('更新成功');
                                                    }
                                                })//end ajax
                                            });
                                        </script>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('paid_date',"付保證金日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        <div style="color: green;padding-button: 5px;color: green;display: none" id="paid_date_msg">(更新成功)</div>
                                        {!! Form::text('paid_date', null,['id'=>'paid_date','class'=>'form-control datePicker','autocomplete'=>'off','readonly']); !!}
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    {!! Form::label('proarea_id',"交車區域:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        {{$ord->proarea?$ord->proarea->title:''}}
                                    </div>
                                </div>
                                <!-- 預計交車日期 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('sub_date',"預計交車日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        <div style="color: green;padding-button: 5px;color: green;display: none" id="sub_date_msg">(更新成功)</div>
                                        {!! Form::text('sub_date', null,['id'=>'sub_date','class'=>'form-control datePicker','autocomplete'=>'off','readonly','onblur'=>'sub_date_updateField();']); !!}
                                    </div>
                                    <script>
                                        function sub_date_updateField() {
                                            var sub_date = $("#sub_date").val();
                                            $.get('/admin/update_table_field', {
                                                "db": 'ords',
                                                "id": '{{$ord->id}}',
                                                "field": 'sub_date',
                                                "value": sub_date,
                                                success: function(d){
                                                    $('#sub_date_msg').show().delay(5000).slideUp(300); //will alert ok
                                                }
                                            });
                                        }
                                    </script>
                                </div>

                                <div class="form-group row">
                                    {!! Form::label('pick_up_time',"前往取車時間:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
                                        <div style="color: green;padding-button: 5px;color: green;display: none" id="pick_up_time_msg">(更新成功)</div>
                                        {!! Form::select('pick_up_time',$list_pick_up_times, null,['id'=>'pick_up_time','class'=>'form-control','onchange'=>'pick_up_time_updateField();']); !!}
                                    </div>
                                    <script>
                                        function pick_up_time_updateField() {
                                            var pick_up_time = $("#pick_up_time").val();
                                            $.get('/admin/update_table_field', {
                                                "db": 'ords',
                                                "id": '{{$ord->id}}',
                                                "field": 'pick_up_time',
                                                "value": pick_up_time,
                                                success: function(d){
                                                    $('#pick_up_time_msg').show().delay(5000).slideUp(300); //will alert ok
                                                }
                                            });
                                        }
                                    </script>
                                </div>
                                <hr>
                                @if($ord->state_id<6)
                                    <!-- 預計交車日期 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('expiry_date',"預計到期日:",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            <div style="color: green;padding-button: 5px;color: green;display: none" id="expiry_date_msg">(更新成功)</div>
                                            {!! Form::text('expiry_date', null,['id'=>'expiry_date','class'=>'form-control datePicker','autocomplete'=>'off','readonly','onblur'=>'expiry_date_updateField();']); !!}
                                            @if($errors->has('expiry_date'))
                                                <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('expiry_date') }}
                                                </div>
                                            @endif
                                        </div>
                                        <script>
                                            function expiry_date_updateField() {
                                                var expiry_date = $("#expiry_date").val();
                                                $.get('/admin/update_table_field', {
                                                    "db": 'ords',
                                                    "id": '{{$ord->id}}',
                                                    "field": 'expiry_date',
                                                    "value": expiry_date,
                                                    success: function(d){
                                                        $('#expiry_date_msg').show().delay(5000).slideUp(300); //will alert ok
                                                    }
                                                });
                                            }
                                        </script>
                                    </div>
                                @endif
                                    <h5>車號資訊</h5>
                                    <hr>
                                    <div class="form-group row">
                                        {!! Form::label('model',"編號(原車號)：",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            {{$ord->model}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('plate_no',"車牌號碼(新車號)：",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            {!! Form::text('plate_no', null,['class'=>'form-control','onblur'=>'plate_no_updateField1();','id'=>'plate_no1','autocomplete'=>'off']); !!}
                                            <div style="color: green;padding-top: 5px" id="plate1_no_msg"></div>
                                            <script>
                                                function plate_no_updateField1() {
                                                    var plate_no = $("#plate_no1").val();
                                                    $.get('/admin/update_table_field', {"db":'ords',"id":'{{$ord->id}}',"field":'plate_no',"value": plate_no});
                                                    $('#plate1_no_msg').html('( 更新成功 )').show().delay('5000').slideUp('500');
                                                }
                                            </script>
                                        </div>
                                    </div>
                                    <!-- 交車地點 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('delivery_address',"交車地點:",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            @php
                                                $delivery_address=$ord->delivery_address;
                                                if(!$delivery_address && $ord->partner)
                                                    $delivery_address=$ord->partner->title.'（'.$ord->partner->address.'）';
                                            @endphp
                                            {!! Form::textarea('delivery_address', $delivery_address,['class'=>'form-control','rows'=>2]); !!}
                                        </div>
                                    </div>
                                    <!-- 還車地點 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('return_delivery_address',"還車地點:",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            @php
                                                $return_delivery_address=$ord->return_delivery_address;
                                                if(!$return_delivery_address && $ord->partner)
                                                    $return_delivery_address=$ord->partner->title.'（'.$ord->partner->address.'）';
                                            @endphp
                                            {!! Form::textarea('return_delivery_address', $return_delivery_address,['class'=>'form-control','rows'=>2]); !!}
                                        </div>
                                    </div>
                                    @if($ord->is_cancel==0)
                                        @if($ord->state_id>=3)
                                            <hr>
                                            <h5>交車資訊</h5>
                                            <hr>
                                            <div class="form-group row">
                                                {!! Form::label('real_sub_date',"實際交車日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                                <div class="col-sm-9">
                                                    {!! Form::text('real_sub_date', null,['id'=>'real_sub_date','class'=>'form-control datePicker','autocomplete'=>'off','readonly','onblur'=>'real_sub_date_updateField();']); !!}
                                                    <div id="real_sub_date_msg" style="color: green"></div>
                                                    <div style="color: purple">(系統自動產生，非必要請必手動修改)</div>
                                                    <script>
                                                        function real_sub_date_updateField() {
                                                            var real_sub_date = $('#real_sub_date').val();//注意:selected前面有個空格！
                                                            $.ajax({
                                                                url: "/admin/update_table_field",
                                                                method: "GET",
                                                                data: {
                                                                    id: {{$ord->id}},
                                                                    db: 'ords',
                                                                    field: 'real_sub_date',
                                                                    value: real_sub_date
                                                                },
                                                                success: function (res) {
                                                                    $('#real_sub_date_msg').html('更新成功').delay(3000).slideUp(300);
                                                                }
                                                            })//end ajax
                                                        }
                                                    </script>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                {!! Form::label('real_sub_time',"實際交車時間:",['class'=>'col-sm-3 form-control-label']) !!}
                                                <div class="col-sm-9">
                                                    {!! Form::text('real_sub_time', null,['class'=>'form-control','autocomplete'=>'off']); !!}
                                                    <div style="color: purple">(系統自動產生，非必要請必手動修改)</div>
                                                </div>
                                            </div>

                                            <!-- 原車輛記錄里程 Form text Input -->
                                            <div class="form-group row">
                                                {!! Form::label('milage',"原車輛記錄里程",['class'=>'col-sm-3 form-control-label']) !!}
                                                <div class="col-sm-9">
                                                    {{$ord->milage?number_format($ord->milage):number_format($product->milage)}}
                                                </div>
                                            </div>
                                            <!-- 交車日期 Form text Input -->
                                            <div class="form-group row">
                                                {!! Form::label('milage',"取車里程",['class'=>'col-sm-3 form-control-label']) !!}
                                                <div class="col-sm-9">
                                                    {!! Form::number('milage', $ord->milage?$ord->milage:0,['class'=>'form-control','min'=>$product->milage,'required']); !!}
                                                </div>
                                            </div>


                                            {{--
                                                4: 已完成交車前作業
                                                5: 已付清當期租金、準備交車
                                                6: 已交車 (自動註記交車時間)
                                            --}}
                                            @if($ord->state_id>=4)
                                            <!-- 實際交車日期 Form text Input -->
                                                {{--<div class="form-group row">
                                                    {!! Form::label('real_sub_date',"實際交車日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        {!! Form::text('real_sub_date', null,['class'=>'form-control datePicker','autocomplete'=>'off']); !!}
                                                        <div style="color: purple">(系統自動產生，非必要請必手動修改)</div>
                                                    </div>
                                                </div>--}}
                                                @if($ord->state_id>=6)
                                                <!-- 實際交車時間 Form text Input -->
                                                    {{--<div class="form-group row">
                                                        {!! Form::label('real_sub_time',"實際交車時間:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::text('real_sub_time', null,['class'=>'form-control datePicker','autocomplete'=>'off']); !!}
                                                            <div style="color: purple">(系統自動產生，非必要請必手動修改)</div>
                                                        </div>
                                                    </div>--}}
                                                <!-- 交車日期 Form text Input -->

                                                    <div class="form-group row">
                                                        {!! Form::label('expiry_date',"到期日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::text('expiry_date', null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly','onblur'=>'expiry_date_updateField();']); !!}
                                                            <div id="expiry_date_msg" style="color: green"></div>
                                                            <div style="color: purple">(系統自動產生，非必要請必手動修改)</div>
                                                            <script>
                                                                function expiry_date_updateField() {
                                                                    var expiry_date = $('#expiry_date').val();//注意:selected前面有個空格！
                                                                    $.ajax({
                                                                        url: "/admin/update_table_field",
                                                                        method: "GET",
                                                                        data: {
                                                                            id: {{$ord->id}},
                                                                            db: 'ords',
                                                                            field: 'expiry_date',
                                                                            value: expiry_date
                                                                        },
                                                                        success: function (res) {
                                                                            $('#expiry_date_msg').html('更新成功').delay(3000).slideUp(300);
                                                                        }
                                                                    })//end ajax
                                                                }
                                                            </script>

                                                        </div>
                                                    </div>
                                                    @if($ord->is_cancel==0 && $ord->state_id>=6)
                                                        <div class="form-group row">
                                                            {!! Form::label('left_day',"到期剩餘天數:",['class'=>'col-sm-3 form-control-label']) !!}
                                                            <div class="col-sm-9">
                                                                {{getOrdLeftDays($ord->id)}} 天
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                            <!-- title Form text Input -->
                                                <div class="form-group row">
                                                    {!! Form::label('payment_total',"應付起租款:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        {!! number_format($ord->payment_total) !!} 元
                                                    </div>
                                                </div>
                                                <!-- 是否已付起租款 Form select Input -->
                                                <div class="form-group row">
                                                    {!! Form::label('is_paid2',"是否已付 起租款:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        {!! Form::select('is_paid2', ['0'=>'否','1'=>'是'] , null ,['class'=>'form-control','id'=>'is_paid2']) !!}
                                                        <div id="is_paid2_msg" style="color: green"></div>
                                                        <script>
                                                            $(document).on('change', '#is_paid2', function(){
                                                                var is_paid2 = $('#is_paid2 :selected').val();//注意:selected前面有個空格！
                                                                $.ajax({
                                                                    url:"/admin/update_table_field",
                                                                    method:"GET",
                                                                    data:{
                                                                        id: {{$ord->id}},
                                                                        db:'ords',
                                                                        field:'is_paid2',
                                                                        value:is_paid2
                                                                    },
                                                                    success:function(res){
                                                                        $('#is_paid2_msg').html('更新成功');
                                                                    }
                                                                })//end ajax
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                                <!-- 起租繳款日 Form select Input -->
                                                <div class="form-group row">
                                                    {!! Form::label('paid2_date',"起租繳款日:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        {!! Form::text('paid2_date', null ,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                                    </div>
                                                </div>
                                                <hr>
                                                <!-- 續約設定 Form select Input -->
                                                <div class="form-group row">
                                                    {!! Form::label('renewtate_id',"續約設定:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        {!! Form::select('renewtate_id', $list_renewtates , null ,['class'=>'form-control','id'=>'renewtate_id']) !!}
                                                        <div id="renewtate_id_msg" style="color: green"></div>
                                                        <script>
                                                            $(document).on('change', '#renewtate_id', function(){
                                                                var renewtate_id = $('#renewtate_id :selected').val();//注意:selected前面有個空格！
                                                                $.ajax({
                                                                    url:"/admin/update_table_field",
                                                                    method:"GET",
                                                                    data:{
                                                                        id: {{$ord->id}},
                                                                        db:'ords',
                                                                        field:'renewtate_id',
                                                                        value:renewtate_id
                                                                    },
                                                                    success:function(res){
                                                                        $('#renewtate_id_msg').html('續約設定更新成功');
                                                                    }
                                                                })//end ajax
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('is_renewal',"車輛續約:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9" style="font-size: 16px;color: purple">
                                                        @if($ord->is_car_renewal==0)
                                                            <span style="color: red">( 車源商已不提供續約 )</span>
                                                        @else
                                                            {{$ord->renewtate?$ord->renewtate->ftitle:''}}
                                                            <div>
                                                                @if($ord->state_id<11)
                                                                    續約月數： {!! Form::select('renew_month', ['3'=>'3個月','2'=>'2個月','1'=>'1個月'] , $ord->renew_month ,['id'=>'renew_month','style'=>'border: solid 1px #ddd;padding: 5px;border-radius: 5px;color:#555;background-color:#eee;font-weight:bold;width: 200px;font-size: 16px']) !!}
                                                                    <div style="color: red;font-size: 14px;padding-top: 5px">( 請確認客戶為同車續租才可調整此月份數 )</div>
                                                                    <div id="renew_month_msg" style="color: green"></div>
                                                                    <script>
                                                                        $(document).on('change', '#renew_month', function(){
                                                                            var renew_month = $('#renew_month :selected').val();//注意:selected前面有個空格！
                                                                            $.ajax({
                                                                                url:"/admin/update_table_field",
                                                                                method:"GET",
                                                                                data:{
                                                                                    id: {{$ord->id}},
                                                                                    db:'ords',
                                                                                    field:'renew_month',
                                                                                    value:renew_month
                                                                                },
                                                                                success:function(res){
                                                                                    $('#renew_month_msg').html('狀態更新成功');
                                                                                }
                                                                            })//end ajax
                                                                        });
                                                                    </script>
                                                                @else
                                                                    已設定續約月數： {{$ord->renew_month}} 個月
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if($ord->state_id>=8)
                                                    <hr>
                                                    <h5>還車資訊</h5>
                                                    <hr>
                                                    <div style="color: brown;background-color: #fff;">里程費用計算(G)</div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        {!! Form::label('real_sub_date',"取車日期：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{$ord->real_sub_date}} {{$ord->real_sub_time}}
                                                        </div>
                                                    </div>
                                                    <!-- 交車日期 Form text Input -->
                                                    <div class="form-group row">
                                                        {!! Form::label('real_back_date',"還車日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::text('real_back_date', $ord->real_back_date?$ord->real_back_date:date('Y-m-d'),['class'=>'form-control datePicker','autocomplete'=>'off','readonly']); !!}

                                                        </div>
                                                    </div>
                                                    <!-- 交車日期 Form text Input -->
                                                    <div class="form-group row">
                                                        {!! Form::label('real_back_time',"還車時間:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{--{!! Form::text('real_back_time', null,['class'=>'form-control','autocomplete'=>'off']); !!}--}}
                                                            {{$ord->real_back_time}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('milage',"取車里程：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{number_format($ord->milage)}}
                                                        </div>
                                                    </div>
                                                    <!-- 還車里程 Form text Input -->
                                                    <div class="form-group row">
                                                        {!! Form::label('back_milage',"還車里程:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::number('back_milage', null,['class'=>'form-control','min'=>$ord->milage,'required']); !!}
                                                        </div>
                                                    </div>
                                                    @php
                                                        //合計使用里程(A)
                                                        $use_mile=$ord->back_milage-$ord->milage;
                                                        //預付里程數(B)
                                                        $mile_3month=$ord->mile_pre_month * $ord->rent_month;
                                                        //差額里程數(A-B)
                                                        $sub_use_mile=$use_mile-$mile_3month;
                                                        //里程費率Km/元
                                                        $mile_fee=$ord->mile_fee;
                                                        //逾時租金
                                                        $delay_fee=$ord->delay_fee;
                                                        //補(退)金額(G)
                                                        $mile_fee_total=$sub_use_mile*$mile_fee+$delay_fee;
                                                    @endphp
                                                    {!! Form::hidden('mile_fee_total',$mile_fee_total) !!}
                                                    <div class="form-group row">
                                                        {!! Form::label('bm',"合計使用里程(A)：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{number_format($use_mile)}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('milage',"預付里程數(B)：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{number_format($mile_3month)}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('milage',"差額里程數(A-B)：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{number_format($sub_use_mile)}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('mile_fee',"里程費率Km/元：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{$mile_fee}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('delay_fee',"逾時租金：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{--{{number_format($ord->delay_fee)}}--}}
                                                            {!! Form::number('delay_fee', null,['class'=>'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('total',"補(退)金額(G)：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            <span style="font-weight: bold;font-size: 20px;">{{number_format($mile_fee_total)}}</span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div style="color: brown">其他費用(N)</div>
                                                    <hr>
                                                    @php
                                                        $e_tag=$ord->e_tag;
                                                        $damage_fee=$ord->damage_fee;
                                                        $business_loss=$ord->business_loss;
                                                        $fuel_cost=$ord->fuel_cost;
                                                        $service_charge=$ord->service_charge;
                                                        $other_fee_total=$e_tag+$damage_fee+$business_loss+$fuel_cost+$service_charge;
                                                        $payment_backcar_total=$mile_fee_total+$other_fee_total;
                                                    @endphp
                                                    {!! Form::hidden('other_fee_total',$other_fee_total) !!}
                                                    {!! Form::hidden('payment_backcar_total',$payment_backcar_total) !!}
                                                    <div class="form-group row">
                                                        {!! Form::label('e_tag',"E-Tag金額:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::number('e_tag', $ord->e_tag?$ord->e_tag:0,['class'=>'form-control']); !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        {!! Form::label('damage_fee',"車損費用:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::number('damage_fee', null,['class'=>'form-control']); !!}
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        {!! Form::label('business_loss_title',"自訂營業損失標題:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::text('business_loss_title', null,['class'=>'form-control']); !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        {!! Form::label('business_loss',"營業損失金額:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::number('business_loss', null,['class'=>'form-control']); !!}
                                                            <span style="color: red">( 如果多收輸入正值，如果少收請輸入負值 )</span>
                                                        </div>
                                                    </div>
                                                    <hr>

                                                    <div class="form-group row">
                                                        {!! Form::label('fuel_cost',"油費:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::number('fuel_cost', null,['class'=>'form-control']); !!}
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        {!! Form::label('service_charge',"牽送車服務費:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::number('service_charge', null,['class'=>'form-control']); !!}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('total',"應收金額合計：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            <span style="font-weight: bold;font-size: 20px;">{{number_format($other_fee_total)}}</span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        {!! Form::label('gn',"補收費用總計(G)+(N)：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            <span style="color: red;font-weight: bold;font-size: 20px;">{{number_format($payment_backcar_total)}}</span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        {!! Form::label('is_paid3',"是否已付 迄租款:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::select('is_paid3', ['0'=>'否','1'=>'是'] , null ,['class'=>'form-control','id'=>'is_paid3']) !!}
                                                            <div id="is_paid3_msg" style="color: green"></div>
                                                            <script>
                                                                $(document).on('change', '#is_paid3', function(){
                                                                    var is_paid3 = $('#is_paid3 :selected').val();//注意:selected前面有個空格！
                                                                    $.ajax({
                                                                        url:"/admin/update_table_field",
                                                                        method:"GET",
                                                                        data:{
                                                                            id: {{$ord->id}},
                                                                            db:'ords',
                                                                            field:'is_paid3',
                                                                            value:is_paid3
                                                                        },
                                                                        success:function(res){
                                                                            $('#is_paid3_msg').html('更新成功');
                                                                        }
                                                                    })//end ajax
                                                                });
                                                            </script>
                                                        </div>
                                                    </div>
                                                    <!-- 迄租繳款日 Form select Input -->
                                                    <div class="form-group row">
                                                        {!! Form::label('paid3_date',"迄租繳款日:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {!! Form::text('paid3_date', null ,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                                        </div>
                                                    </div>
                                                @endif <!--大於等於8-->
                                            @endif <!--大於等於4-->
                                        @endif <!--大於等於3-->
                                    @endif <!--大於等於2-->
                                @endif <!--if product-->
                            @else
                                @if($product)
                                    <!-- 是否取消 Form select Input -->
                                    <div class="form-group row">
                                        <hr>
                                        {!! Form::label('is_cancel',"是否取消:",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            @if($ord->is_cancel==1)
                                                是 (取消時間:{{ $ord->cancel_date }})
                                            @else
                                                否
                                            @endif
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- 訂單狀態 Form select Input -->
                                    <a name="list"></a>
                                    <div class="form-group row">
                                        {!! Form::label('state_id',"訂單狀態:",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            @if($ord->is_cancel==1)
                                                <span style="color: red">訂單已取消</span>
                                            @else
                                                @if($ord->state_id==1 || $ord->state_id==4 || $ord->state_id==6 || $ord->state_id==7 || ($ord->state_id==9 && $ord->payment_backcar_total>0) || $ord->state_id==11 || $ord->state_id==12 || $ord->state_id==13)
                                                    <div style="background-color:#fbebb1;padding: 10px">{{$ord->state?$ord->state->title:''}}</div>
                                                @else
                                                    {!! Form::select('state_id', $list_onestep_states , null ,['class'=>'form-control','style'=>'background-color:#fbebb1','onchange'=>'if(confirm("是否確認要改變訂單狀態？")){document.getElementById("list").value=1;document.form_update.submit();}else{this.selectedIndex='.($ord->state_id-1).';}']) !!}
                                                @endif
                                            @endif
                                            <div style="padding: 10px 0">
                                                狀態對照表：
                                                <ul>
                                                    @foreach($list_states as $key=>$list_state)
                                                        @if($key>0)
                                                            <li>
                                                                <span style="background-color: {{$key==$ord->state_id?'yellow':''}};">{{$key}}. {{$list_state}}</span>
                                                                {{$key==$ord->state_id?'→ (目前狀態)':''}}
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <!-- 應付保證金 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('deposit',"應付保證金:",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            {{number_format($ord->deposit)}} 元
                                        </div>
                                    </div>
                                    <!-- 是否已付保證金 Form select Input -->
                                    <div class="form-group row">
                                        {!! Form::label('is_paid',"是否已付保證金:",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            @if($ord->is_paid==1)
                                                是
                                            @else
                                                否
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group row">
                                        {!! Form::label('proarea_id',"交車區域:",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            {{$ord->proarea?$ord->proarea->title:''}}
                                        </div>
                                    </div>
                                    <!-- 預計交車日期 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('sub_date',"預計交車日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            {{$ord->sub_date}}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('pick_up_time',"前往取車時間:",['class'=>'col-sm-3 form-control-label']) !!}
                                        <div class="col-sm-9">
                                            {!! Form::select('pick_up_time',$list_pick_up_times, null,['class'=>'form-control',]); !!}
                                        </div>
                                    </div>
                                    @if($ord->state_id<6)
                                        <!-- 預計交車日期 Form text Input -->
                                        <div class="form-group row">
                                            {!! Form::label('expiry_date',"預計到期日:",['class'=>'col-sm-3 form-control-label']) !!}
                                            <div class="col-sm-9">
                                                {{$ord->expiry_date}}
                                            </div>
                                        </div>
                                    @endif
                                    @if($ord->state_id>=2 && $ord->is_cancel==0)
                                        <hr>
                                        <h5>交車資訊</h5>
                                        <hr>
                                        <div class="form-group row">
                                            {!! Form::label('model',"編號(原車號)：",['class'=>'col-sm-3 form-control-label']) !!}
                                            <div class="col-sm-9">
                                                {{$ord->model}}
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('plate_no',"車牌號碼(新車號)：",['class'=>'col-sm-3 form-control-label']) !!}
                                            <div class="col-sm-9">
                                                @if($ord->state_id==2)
                                                    {!! Form::text('plate_no', null,['class'=>'form-control','onblur'=>'plate_no_updateField2();','id'=>'plate_no2','autocomplete'=>'off']); !!}
                                                    <div style="color: green;padding-top: 5px" id="plate2_no_msg"></div>
                                                    <script>
                                                        function plate_no_updateField2() {
                                                            var plate_no = $("#plate_no2").val();
                                                            $.get('/admin/update_table_field', {"db":'ords',"id":'{{$ord->id}}',"field":'plate_no',"value": plate_no});
                                                            $('#plate2_no_msg').html('( 更新成功 )').show().delay('5000').slideUp('500');
                                                        }
                                                    </script>
                                                @else
                                                    {{$ord->plate_no}}
                                                @endif
                                            </div>
                                        </div>
                                        <!-- 交車地點 Form text Input -->
                                        <div class="form-group row">
                                            {!! Form::label('delivery_address',"交車地點:",['class'=>'col-sm-3 form-control-label']) !!}
                                            <div class="col-sm-9">
                                                @php
                                                    $delivery_address=$ord->delivery_address;
                                                    if(!$delivery_address && $ord->partner)
                                                        $delivery_address=$ord->partner->title.'（'.$ord->partner->address.'）';
                                                @endphp
                                                {!! Form::textarea('delivery_address', $delivery_address,['class'=>'form-control','rows'=>2]); !!}
                                            </div>
                                        </div>
                                        <!-- 還車地點 Form text Input -->
                                        <div class="form-group row">
                                            {!! Form::label('return_delivery_address',"還車地點:",['class'=>'col-sm-3 form-control-label']) !!}
                                            <div class="col-sm-9">
                                                @php
                                                    $return_delivery_address=$ord->return_delivery_address;
                                                    if(!$return_delivery_address && $ord->partner)
                                                        $return_delivery_address=$ord->partner->title.'（'.$ord->partner->address.'）';
                                                @endphp
                                                {!! Form::textarea('return_delivery_address', $return_delivery_address,['class'=>'form-control','rows'=>2]); !!}
                                            </div>
                                        </div>
                                        @if($ord->state_id>=3)

                                            {{--@if($ord->state_id==3)
                                                <!-- 實際交車日期 Form text Input -->
                                                <div class="form-group row">
                                                    {!! Form::label('real_sub_date',"實際交車日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        {!! Form::text('real_sub_date', $ord->real_sub_date?$ord->real_sub_date:date('Y-m-d'),['class'=>'form-control datePicker','autocomplete'=>'off','readonly']); !!}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="form-group row">
                                                    {!! Form::label('real_sub_date',"實際交車日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        {{$ord->real_sub_date}}
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('real_sub_time',"實際交車時間:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        {{$ord->real_sub_time}}
                                                    </div>
                                                </div>
                                            @endif--}}
                                        <!-- 原車輛記錄里程 Form text Input -->
                                            <div class="form-group row">
                                                {!! Form::label('milage',"原車輛記錄里程",['class'=>'col-sm-3 form-control-label']) !!}
                                                <div class="col-sm-9">
                                                    {{$ord->milage?number_format($ord->milage):number_format($product->milage)}}
                                                </div>
                                            </div>
                                            <!-- 交車日期 Form text Input -->
                                            @if($ord->state_id==3)
                                                <div class="form-group row">
                                                    {!! Form::label('milage',"取車里程:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        {!! Form::number('milage', $ord->milage?$ord->milage:0,['class'=>'form-control','min'=>$product->milage,'required']); !!}
                                                    </div>
                                                </div>
                                            @else
                                                <div class="form-group row">
                                                    {!! Form::label('milage',"取車里程",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        @if(role('carplus_company'))
                                                            {!! Form::number('milage', $ord->milage?$ord->milage:0,['class'=>'form-control','min'=>$product->milage,'required']); !!}
                                                        @else
                                                            {{number_format($ord->milage) }}
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif

                                            {{--
                                                4: 已完成交車前作業
                                                5: 已付清當期租金、準備交車
                                                6: 已交車 (自動註記交車時間)
                                            --}}
                                            @if($ord->state_id>=4)
                                            <!-- 實際交車日期 Form text Input -->
                                                <div class="form-group row">
                                                    {!! Form::label('real_sub_date',"實際交車日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        {{$ord->real_sub_date}}
                                                    </div>
                                                </div>
                                                @if($ord->state_id>=6)
                                                <!-- 實際交車時間 Form text Input -->
                                                    <div class="form-group row">
                                                        {!! Form::label('real_sub_time',"實際交車時間:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{$ord->real_sub_time}}
                                                        </div>
                                                    </div>
                                                    <!-- 交車日期 Form text Input -->
                                                    <div class="form-group row">
                                                        {!! Form::label('expiry_date',"到期日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{$ord->expiry_date}}
                                                        </div>
                                                    </div>
                                                    @if($ord->is_cancel==0 && $ord->state_id>=6)
                                                        <div class="form-group row">
                                                            {!! Form::label('left_day',"到期剩餘天數:",['class'=>'col-sm-3 form-control-label']) !!}
                                                            <div class="col-sm-9">
                                                                {{getOrdLeftDays($ord->id)}} 天
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                            <!-- title Form text Input -->
                                                <div class="form-group row">
                                                    {!! Form::label('payment_total',"應付起租款:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        {!! number_format($ord->payment_total) !!} 元
                                                    </div>
                                                </div>
                                                <!-- 是否已付保證金 Form select Input -->
                                                <div class="form-group row">
                                                    {!! Form::label('is_paid2',"是否已付 起租款:",['class'=>'col-sm-3 form-control-label']) !!}
                                                    <div class="col-sm-9">
                                                        @if($ord->is_paid2==1)
                                                            <span style="color: green;font-size: 20px;font-weight: bold;">是 </span>
                                                        @else
                                                            <span style="color: red;">否 </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if($ord->state_id>=8)
                                                    <hr>
                                                    <h5>還車資訊</h5>
                                                    <hr>
                                                    <div style="color: brown;background-color: #fff;">里程費用計算(G)</div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        {!! Form::label('real_sub_date',"取車日期：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{$ord->real_sub_date}} {{$ord->real_sub_time}}
                                                        </div>
                                                    </div>
                                                    <!-- 還車日期 Form text Input -->
                                                    <div class="form-group row">
                                                        {!! Form::label('real_back_date',"還車日期:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            @if($ord->state_id==8)
                                                                {!! Form::text('real_back_date', $ord->real_back_date?$ord->real_back_date:date('Y-m-d'),['class'=>'form-control datePicker','autocomplete'=>'off','readonly']); !!}
                                                            @else
                                                                {{$ord->real_back_date}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('real_back_time',"還車時間(系統自動註記):",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{$ord->real_back_time}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('milage',"取車里程：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{number_format($ord->milage)}}
                                                        </div>
                                                    </div>
                                                    <!-- 還車里程 Form text Input -->
                                                    <div class="form-group row">
                                                        {!! Form::label('back_milage',"還車里程:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            @if($ord->state_id==8)
                                                                {!! Form::number('back_milage', null,['class'=>'form-control','min'=>$ord->milage,'required']); !!}
                                                            @else
                                                                @if(role('carplus_company'))
                                                                    {!! Form::number('back_milage', null,['class'=>'form-control','min'=>$ord->milage,'required']); !!}
                                                                @else
                                                                    {{number_format($ord->back_milage)}}
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @php
                                                        $use_mile=$ord->back_milage-$ord->milage;
                                                        $mile_3month=$ord->mile_pre_month * $ord->rent_month;
                                                        $sub_use_mile=$use_mile-$mile_3month;
                                                        $mile_fee=$ord->mile_fee;
                                                        $delay_fee=$ord->delay_fee;
                                                        $mile_fee_total=$sub_use_mile*$mile_fee+$delay_fee;
                                                    @endphp
                                                    {!! Form::hidden('mile_fee_total',$mile_fee_total) !!}
                                                    <div class="form-group row">
                                                        {!! Form::label('bm',"合計使用里程(A)：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{number_format($use_mile)}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('milage',"預付里程數(B)：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{number_format($mile_3month)}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('milage',"差額里程數(A-B)：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{number_format($sub_use_mile)}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('mile_fee',"里程費率Km/元：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{$mile_fee}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('delay_fee',"逾時租金：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            {{number_format($ord->delay_fee)}}
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('total',"補(退)金額(G)：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            <span style="font-weight: bold;font-size: 20px;">{{number_format($mile_fee_total)}}</span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div style="color: brown">其他費用(N)</div>
                                                    <hr>
                                                    @php
                                                        $e_tag=$ord->e_tag;
                                                        $damage_fee=$ord->damage_fee;
                                                        $business_loss=$ord->business_loss;
                                                        $fuel_cost=$ord->fuel_cost;
                                                        $service_charge=$ord->service_charge;
                                                        $other_fee_total=$e_tag+$damage_fee+$business_loss+$fuel_cost+$service_charge;
                                                        $payment_backcar_total=$mile_fee_total+$other_fee_total;
                                                    @endphp
                                                    {!! Form::hidden('other_fee_total',$other_fee_total) !!}
                                                    {!! Form::hidden('payment_backcar_total',$payment_backcar_total) !!}
                                                    <div class="form-group row">
                                                        {!! Form::label('e_tag',"E-Tag金額:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            @if($ord->state_id==8)
                                                                {!! Form::number('e_tag', $ord->e_tag?$ord->e_tag:0,['class'=>'form-control']); !!}
                                                            @else
                                                                {{$ord->e_tag}}
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        {!! Form::label('damage_fee',"車損費用:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            @if($ord->state_id==8)
                                                                {!! Form::number('damage_fee', $ord->damage_fee?$ord->damage_fee:0,['class'=>'form-control']); !!}
                                                            @else
                                                                {{$ord->damage_fee}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        {!! Form::label('business_loss_title',"自訂營業損失標題:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            @if($ord->state_id==8)
                                                                {!! Form::text('business_loss_title', null,['class'=>'form-control']); !!}
                                                            @else
                                                                {{$ord->business_loss_title}}
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        {!! Form::label('business_loss',"營業損失金額:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            @if($ord->state_id==8)
                                                                {!! Form::number('business_loss', $ord->business_loss?$ord->business_loss:0,['class'=>'form-control']); !!}
                                                                <span style="color: red">( 如果多收輸入正值，如果少收請輸入負值 )</span>
                                                            @else
                                                                {{$ord->business_loss}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>

                                                    <div class="form-group row">
                                                        {!! Form::label('fuel_cost',"油費:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            @if($ord->state_id==8)
                                                                {!! Form::number('fuel_cost', $ord->fuel_cost?$ord->fuel_cost:0,['class'=>'form-control']); !!}
                                                            @else
                                                                {{$ord->fuel_cost}}
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        {!! Form::label('service_charge',"牽送車服務費:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            @if($ord->state_id==8)
                                                                {!! Form::number('service_charge', $ord->service_charge?$ord->service_charge:0,['class'=>'form-control']); !!}
                                                            @else
                                                                {{$ord->service_charge}}
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        {!! Form::label('total',"應收金額合計：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            <span style="font-weight: bold;font-size: 20px;">{{number_format($other_fee_total)}}</span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        {!! Form::label('gn',"補收費用總計(G)+(N)：",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            <span style="color: red;font-weight: bold;font-size: 20px;">{{number_format($payment_backcar_total)}}</span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="form-group row">
                                                        {!! Form::label('is_paid3',"是否已付 迄租款:",['class'=>'col-sm-3 form-control-label']) !!}
                                                        <div class="col-sm-9">
                                                            @if($ord->is_paid3==1)
                                                                <span style="color: green;font-size: 20px;font-weight: bold;">是 </span>
                                                            @else
                                                                <span style="color: red;">否 </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if($ord->renewtate_id)
                                                        <hr>
                                                        <div class="form-group row">
                                                            {!! Form::label('is_renewal',"車輛續約:",['class'=>'col-sm-3 form-control-label']) !!}
                                                            <div class="col-sm-9">
                                                                @if($ord->is_car_renewal==0)
                                                                    <span style="color: red">( 車源商已不提供續約 )</span>
                                                                @else
                                                                    {{$ord->renewtate?$ord->renewtate->ftitle:''}}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif <!--大於等於8-->
                                            @endif <!--大於等於4-->
                                        @endif <!--大於等於3-->
                                    @endif <!--大於等於2-->
                                @endif <!--if product-->
                            @endif <!--經銷商-->
                            <hr>
                            <!-- 備註 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('memo',"備註:",['class'=>'col-sm-3 form-control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::textarea('memo', null,['class'=>'form-control','rows'=>5]); !!}
                                </div>
                            </div>

                            <!--  Form Submit Input -->
                            <div class="form-group" style="text-align:center;line-height: 50px;">
                                {!! Form::submit('更新',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                @if(role('admin') || role('babysitter'))
                                    @if($ord->renewtate_id==1)
                                        <a class="btn btn-warning" href="{{ url('/admin/send_email/my8ry8/'.$ord->id ) }}" onclick="return confirm('您是否確認要產生同車續約單及寄出Email通知？');">同車續約及發Mail</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    @endif
                                    <a class="btn btn-info" href="{{ url('/admin/send_email/ry3_1/'.$ord->id ) }}" onclick="return confirm('您是否確認要寄出交車時間變更通知？');">訂單變更通知</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-success" href="{{ url('/admin/send_email/ry3/'.$ord->id ) }}" onclick="return confirm('您是否確認要寄出信件？');">保證金付清通知</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-warning" href="{{ url('/admin/send_email/ry10_1/'.$ord->id ) }}" onclick="return confirm('您是否確認要寄出信件？');">寄出迄租款無需繳款通知</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-info" href="{{ url('/admin/send_email/ry10/'.$ord->id ) }}" onclick="return confirm('您是否確認要寄出信件？');">寄出還車通知</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                @endif
                                <a class="btn btn-secondary" href="{{ url('/admin/ord?bid='.$ord->id ) }}">取消及回上一列表</a>
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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="/back_assets/src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="/back_assets/plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="/back_assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/back_assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="/back_assets/dist/js/theme.min.js"></script>
    {{--    <script src="/back_assets/js/form-components.js"></script>--}}
    <script src="{{ asset("/js/datePicker/WdatePicker.js") }}" type="text/javascript"></script>
    <script src="/js/jquery-ui.min.js" type="text/javascript"></script>
    <script>
                @php
                    $holidays = \App\Model\Holiday::orderBy('holiday_date')->get();
                @endphp

        var disabledDates = [
                    @if($holidays)
                            @foreach($holidays as $holiday)
                        "{{$holiday->holiday_date}}",
                    @endforeach
                    @endif
            ];

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
                //beforeShowDay: function(date){ return [date.getDay() !== 6 && date.getDay() !== 0,""]},
                beforeShowDay: function(date){
                    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [ disabledDates.indexOf(string) === -1 ]
                },
                changeMonth: true, changeYear: false});
        });

    </script>
@stop