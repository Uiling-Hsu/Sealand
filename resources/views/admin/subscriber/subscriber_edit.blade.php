@extends('admin.layouts.adminapp')

@section('extra-css')
    <link rel="stylesheet" href="/back_assets/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css">

    <link rel="stylesheet" href="/back_assets/plugins/summernote/dist/summernote-bs4.css">
    <link rel="stylesheet" href="/back_assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/back_assets/plugins/mohithg-switchery/dist/switchery.min.css">
    <link rel="stylesheet" href="/back_assets/dist/css/theme.css">
    <link href="/back_assets/css/style.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/back_assets/css/custom.css">
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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">訂閱管理</h5>
                                {{--                                <span>各項參數訂閱管理編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">訂閱管理</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 1000px">
                        <div class="card-header">
                            <h3>
                                訂閱 配車管理 &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-dark" href="{{ url('/admin/subscriber?page='.Request('page').'&restore=1&bid='.$subscriber->id.'&search_brandcat_id='.Request('search_brandcat_id').'&search_brandin_id='.Request('search_brandin_id') ) }}">取消及回上一列表</a>
                            </h3>
                        </div>
                        <div class="card-body">


                            <!-- 方案類別 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('cate_id',"方案類別:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    <span style="font-size: 20px;font-weight: bold;">{{$cate->title}}</span><br>
                                    保證金(元): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->deposit)}}</span><br>
                                    月租基本費(元): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->basic_fee)}}</span><br>
                                    每公里費用(元): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->mile_fee,2)}}</span><br>
                                    每月基本里程數(公里): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->mile_pre_month)}}</span><br>
                                    {{--是否已通過審核：{!! $user->is_check==1?'<span style="color: green;font-size: 18px">是</span>':'<span style="color: red;">否</span>' !!}<br>--}}
                                </div>
                            </div>
                            <!-- 會員資料 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('name',"會員資料:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10" style="font-size: 16px;">
                                    {{--會員姓名：<a href="/admin/user/{{$user->id}}/edit" class="btn btn-primary" target="_blank">{{ $user->name }}</a><br>--}}
                                    會員姓名：{{ $user->name }}<br>
                                    手機：{{ $user->phone }}<br>
                                    Email：{{ $user->email }}<br>
                                    地址：{{ $user->address }}
                                </div>
                            </div>

                            <hr>
                            <!-- 持證類別 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('id_type',"持證類別:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {{$user->id_type==2?'居留證':'身份證'}}
                                </div>
                            </div>
                            <!-- 身份證 發證地點 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('ssite_id',"身份證 發證日期:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {{str_pad($user->id_year,3,"0",STR_PAD_LEFT).'-'.str_pad($user->id_month,2,"0",STR_PAD_LEFT).'-'.str_pad($user->id_day,2,"0",STR_PAD_LEFT)}}
                                </div>
                            </div>
                            <!-- 身份證 發證地點 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('ssite_id',"身份證 發證地點:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {{$user->ssite?$user->ssite->title:''}}
                                </div>
                            </div>
                            <!-- 身份證 領補換類別 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('applyreason',"身份證 領補換類別:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {{$user->applyreason}}
                                </div>
                            </div>
                            <!-- 身份證字號 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('idno',"身份證 字號:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10" style="font-size: 16px;">
                                    {{ $user->idno }}<br><br>
                                    @if($user->idcard_image01)
                                        {{ Html::image('/admin/subscriber/idcard_image01/'.$user->idcard_image01,null, ['style'=>'width:600px;border-radius: 10px']),[] }}
                                    @endif
                                    @if($user->idcard_image02)
                                        <br><br>{{ Html::image('/admin/subscriber/idcard_image02/'.$user->idcard_image02,null, ['style'=>'width:600px;border-radius: 10px']),[] }}
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <!-- 駕照 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('driver_image01',"駕照正反面:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10" style="font-size: 16px;">
                                    @if($user->driver_image01)
                                        {{ Html::image('/admin/subscriber/driver_image01/'.$user->driver_image01,null, ['style'=>'width:600px;border-radius: 10px']),[] }}
                                    @endif
                                    @if($user->driver_image02)
                                        <br><br>{{ Html::image('/admin/subscriber/driver_image02/'.$user->driver_image02,null, ['style'=>'width:600px;border-radius: 10px']),[] }}
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <!-- 駕照管轄編號 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('driver_no',"駕照管轄編號:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {{$user->driver_no}}
                                </div>
                            </div>
                            <hr>
                            <a name="list"></a>
                            <!-- 緊急連絡人 Form text Input -->
                            <div class="form-group row" style="font-size: 16px;">
                                {!! Form::label('emergency_contact',"緊急連絡人:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {{$user->emergency_contact}}
                                </div>
                            </div>

                            <div class="form-group row" style="font-size: 16px;">
                                {!! Form::label('emergency_phone',"緊急連絡電話:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {{$user->emergency_phone}}
                                </div>
                            </div>
                            <div>&nbsp;</div>
                            <hr>
                            <div>&nbsp;</div>
                            <!--保姆-->
                            @if(role('admin') || role('babysitter'))
                                <!-- Begin Form -->
                                {!! Form::model($subscriber,['url' => '/admin/subscriber/'.$subscriber->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}
                                    {!! Form::hidden('search_is_history',Request('search_is_history')) !!}
                                    <!-- 運作狀態 Form select Input -->
                                    <div class="form-group row">
                                        {!! Form::label('is_history',"運作狀態:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {!! Form::select('is_history', ['0'=>'運作中','1'=>'歷史單'] , null ,['class'=>'col-sm-2 form-control','style'=>'font-size:15px','id'=>'is_history']) !!}
                                            <div id="is_history_msg" style="color: green"></div>
                                            <script>
                                                $(document).on('change', '#is_history', function(){
                                                    var is_history = $('#is_history :selected').val();//注意:selected前面有個空格！
                                                    $.ajax({
                                                        url:"/admin/update_table_field",
                                                        method:"GET",
                                                        data:{
                                                            id: {{$subscriber->id}},
                                                            db:'subscribers',
                                                            field:'is_history',
                                                            value:is_history
                                                        },
                                                        success:function(res){
                                                            $('#is_history_msg').html('狀態更新成功');
                                                        }
                                                    })//end ajax
                                                });
                                            </script>
                                            @if($errors->has('is_history'))
                                                <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('is_history') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- 交車日期 Form text Input -->
                                    <div class="form-group row">
                                        {!! Form::label('sub_date',"交車日期:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {!! Form::text('sub_date', $subscriber->sub_date,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']); !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('pick_up_time',"前往取車時間::",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {!! Form::select('pick_up_time',$list_pick_up_times, null,['class'=>'form-control',]); !!}
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {!! Form::label('sub_date',"交車區域:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {!! Form::select('proarea_id',$list_proareas, null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']); !!}
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        {!! Form::label('is_cancel',"是否取消:",['class'=>'col-sm-2 form-control-label']) !!}
                                        <div class="col-sm-10">
                                            {!! Form::select('is_cancel',['0'=>'否','1'=>'是'], null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']); !!}
                                            @if($errors->has('is_cancel'))
                                                <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                     <i class="fa fa-warning"></i>{{ $errors->first('is_cancel') }}
                                                </div>
                                            @endif
                                            <div>&nbsp;</div>
                                            {!! Form::submit('更新',['class'=>'btn btn-success']) !!}
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                                <!--保姆-->
                            @else
                                <div class="form-group row">
                                    {!! Form::label('sub_date',"交車日期:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {{$subscriber->sub_date}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('sub_date',"交車區域:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {{$subscriber->proarea?$subscriber->proarea->title:''}}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {!! Form::label('is_cancel',"是否取消:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! $subscriber->is_cancel==1?'<span style="color: green">是</span>':'<span style="color: red">否</span>' !!}
                                    </div>
                                </div>
                            @endif
                            <!-- End of Form -->
                            <div>&nbsp;</div>
                            <hr>
                            <!-- 實際選擇車輛 Form text Input -->
                            @if(role('admin') || role('babysitter'))
                                <!-- 交車地點 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('delivery_address',"交車地點:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        @php
                                            $delivery_address=$subscriber->delivery_address;
                                            $product=$subscriber->product;
                                            if(!$delivery_address && $product){
                                                $partner=$product->partner;
                                                if($partner)
                                                    $delivery_address=$partner->title.'（'.$partner->address.'）';
                                            }
                                        @endphp
                                        @if(!$subscriber->delivery_address=='')
                                            <script>
                                                $.get('/admin/update_table_field', { "db":'subscribers',"id":'{{$subscriber->id}}',"field":'delivery_address',"value": '{{$delivery_address}}' });
                                            </script>
                                        @endif
                                        {!! Form::textarea('delivery_address', $subscriber->delivery_address?$subscriber->delivery_address:null,['id'=>'delivery_address','class'=>'form-control','onblur'=>'delivery_address_updateField();','rows'=>2]); !!}
                                        <div style="color: red;padding-top: 5px">( 輸入完離開欄位即自動更新資料 )</div>
                                        <script>
                                            function delivery_address_updateField() {
                                                var delivery_address = $("textarea#delivery_address").val();
                                                $.get('/admin/update_table_field', {"db":'subscribers',"id":'{{$subscriber->id}}',"field":'delivery_address',"value": delivery_address});
                                            }
                                        </script>
                                    </div>
                                </div>
                                <hr>
                                <!-- 還車地點 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('return_delivery_address',"還車地點:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        @php
                                            $return_delivery_address=$subscriber->return_delivery_address;
                                            $product=$subscriber->product;
                                            if(!$return_delivery_address && $product){
                                                $partner=$product->partner;
                                                if($partner)
                                                    $return_delivery_address=$partner->title.'（'.$partner->address.'）';
                                            }
                                        @endphp
                                        @if(!$subscriber->return_delivery_address=='')
                                            <script>
                                                $.get('/admin/update_table_field', { "db":'subscribers',"id":'{{$subscriber->id}}',"field":'return_delivery_address',"value": '{{$return_delivery_address}}' });
                                            </script>
                                        @endif
                                        {!! Form::textarea('return_delivery_address', $subscriber->return_delivery_address?$subscriber->return_delivery_address:null,['id'=>'return_delivery_address','class'=>'form-control','onblur'=>'return_updateField();','rows'=>2]); !!}
                                        <div style="color: red;padding-top: 5px">( 輸入完離開欄位即自動更新資料 )</div>
                                        <script>
                                            function return_updateField() {
                                                var return_delivery_address = $("textarea#return_delivery_address").val();
                                                $.get('/admin/update_table_field', {"db":'subscribers',"id":'{{$subscriber->id}}',"field":'return_delivery_address',"value": return_delivery_address});
                                            }
                                        </script>
                                    </div>
                                </div>
                                <hr>
                            @endif
                            <div class="form-group row" style="font-size: 16px;">
                                {!! Form::label('emergency_contact',"車輛資訊:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    @if($subscriber->product_id && (role('admin') || role('babysitter')))
                                        @php
                                            $product=$subscriber->product;
                                        @endphp
                                        @if($product)
                                            {{--@if($subscriber->is_history!=1)
                                                <a href="/admin/selectcar/{{$subscriber->id}}" class="btn btn-primary"><span style="position: relative;top: -2px">重新選取車輛</span></a><br><br>
                                            @endif--}}
                                            @if($product->partner)
                                                <span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->partner->title }}</span><br>
                                            @endif
                                            @if($product->cate)
                                                <span style="font-size: 20px;color: purple">{{$product->cate->title}}</span><br>
                                                <span style="color: purple">{{number_format($product->cate->basic_fee) }} 元</span><br>
                                                <span style="color: purple">{{number_format($product->cate->mile_fee,2) }} 元/每公里</span><br>
                                            @endif
                                            {{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
                                            編號：{{$product->model}}<br>
                                            <span style="color: black;font-weight: 300;">品牌:</span><span style="font-weight: bold;"> {{$product->brandcat?$product->brandcat->title:'' }}</span><br>
                                            <span style="color: black;font-weight: 300;">車型:</span><span style="font-weight: bold;"> {{$product->brandin?$product->brandin->title:''}}</span><br>
                                            <span style="color: black;font-weight: 300;">排氣量:</span><span style="font-weight: bold;"> {{ number_format($product->displacement) }}</span><br>
                                            <span style="color: black;font-weight: 300;">年份:</span><span style="font-weight: bold;"> {{ $product->year }}</span><br>
                                            <span style="color: black;font-weight: 300;">排檔:</span><span style="font-weight: bold;"> {{$product->progeartype?$product->progeartype->title:''}}</span><br>
                                            <span style="color: black;font-weight: 300;">座位數:</span><span style="font-weight: bold;"> {{$product->seatnum}}</span><br>
                                            <span style="color: black;font-weight: 300;">顏色:</span><span style="font-weight: bold;"> {{$product->procolor?$product->procolor->title:''}}</span><br>
                                            <span style="color: black;font-weight: 300;">里程數:</span><span style="font-weight: bold;"> {{ number_format($product->milage) }}</span><br>
                                            <span style="color: black;font-weight: 300;">交車區域:</span><span style="font-weight: bold;"> {{$product->proarea?$product->proarea->title:''}}</span><br><br>
                                            {{--@if($subscriber->is_history!=1)
                                                {!! Form::model($subscriber,['url' => '/admin/sub_trandfer_ord','enctype'=>'multipart/form-data'])  !!}
                                                    {!! Form::hidden('subscriber_id',$subscriber->id) !!}
                                                    {!! Form::submit('轉為正式訂單',['class'=>'btn btn-success','onclick'=>'return confirm("您是否確認已選好車輛，要將此訂閱單轉為：正式訂單？")']) !!}<br><br>
                                                {!! Form::close() !!}
                                            @else
                                                <div style="color: red">( 此訂閱單已產生訂單 )</div>
                                            @endif--}}
                                        @endif
                                    @endif

                                    <div style="font-weight: bold;font-size: 16px;">訂閱方案：{{$cate->title}}</div>
                                    <hr>
                                    @if($subscriber->is_cancel==0)
                                        @if(role('admin') || role('babysitter'))
                                            @if($product && $product->dealer_id!=1)
                                                <div style="background-color: #fff0f0;padding: 10px 20px">
                                                    <h5>自行審查：</h5>
                                                    <span>審查此方案是否通過？</span>
                                                    @php
                                                        $can_order_car=$subscriber->can_order_car;
                                                        $color='#777';
                                                        $bg_color='#eee';
                                                        $font_weight='400';
                                                        if($can_order_car==1){
                                                            $color='green';
                                                            $bg_color='#cdffcd';
                                                            $font_weight='bold';
                                                        }
                                                        elseif($can_order_car==0){
                                                            $color='red';
                                                            $bg_color='#ffd9d9';
                                                            $font_weight='bold';
                                                        }
                                                    @endphp
                                                    {!! Form::select('can_order_car', ['-1'=>'未審核','1'=>'通過','0'=>'不通過'] , $subscriber->can_order_car ,['class'=>'verify_checkbox','style'=>'border: solid 1px #ddd;padding: 5px;border-radius: 5px;color:'.$color.';background-color:'.$bg_color.';font-weight:'.$font_weight,'id'=>'subscriber','required','onchange'=>'can_order_car_updateField'.'();']) !!}
                                                    &nbsp;&nbsp;&nbsp;<span style="color: green;padding-top: 5px" id="can_order_car_msg"></span>
                                                    <script>
                                                        function can_order_car_updateField() {
                                                            var can_order_car = $('#subscriber :selected').val();
                                                            if(confirm('請注意！如果是不通過，則該訂閱車輛會重新上架。是否確認要變更審核狀態？？')) {
                                                                $.get('/admin/update_subscriber_table_field', {
                                                                    "db": 'subscribers',
                                                                    "id": '{{$subscriber->id}}',
                                                                    "field": 'can_order_car',
                                                                    "value": can_order_car
                                                                }).done(function(data) {
                                                                    //console.log(data);
                                                                    if( data==1 ) {
                                                                        $('#subscriber').css('color', 'green').css('font-weight', 'bold');
                                                                        $('#subscriber').css('background-color', '#cdffcd').css('font-weight', 'bold');
                                                                        $('#can_order_car_msg').html('狀態更新成功，請記得寄出通過信給會員').show().delay(10000).slideUp(300);
                                                                    }
                                                                    else if(data==0) {
                                                                        $('#subscriber').css('color', 'red').css('font-weight', 'bold');
                                                                        $('#subscriber').css('background-color', '#ffd9d9').css('font-weight', 'bold');
                                                                        $('#can_order_car_msg').html('狀態更新成功').show().delay(10000).slideUp(300);
                                                                    }
                                                                    else {
                                                                        $('#subscriber').css('color', '#777').css('font-weight', '400');
                                                                        $('#subscriber').css('background-color', '#eee').css('font-weight', 'bold');
                                                                        $('#can_order_car_msg').html('狀態更新成功').show().delay(10000).slideUp(300);
                                                                    }
                                                                });
                                                            }
                                                            else{
                                                                $('#subscriber').val({{$subscriber->can_order_car}});
                                                            }
                                                        }
                                                    </script>
                                                    <div style="padding: 10px 0">
                                                        <div style="padding-bottom: 10px;font-size: 16px;">方案審查完成，寄出Email通知會員：</div>
                                                        <div style="padding: 10px 0">
                                                            <a class="btn btn-success" href="{{ url('/admin/send_email/my2/'.$subscriber->id) }}" onclick="return confirm('是否確認要寄出方案通過Email?');">寄出方案通過Email給會員</a>&nbsp;
                                                        </div>
                                                        <!-- 是否已通知:格上? Form checkbox Input -->
                                                        <div class="form-group row" style="padding-top: 0">
                                                            {!! Form::label('is_my2_email',"是否已寄出 寄發方案審核通過 通知?",['class'=>'form-control-label','style'=>'font-size: 16px;font-weight: 400']) !!}
                                                            &nbsp;&nbsp;&nbsp;
                                                            @if($subscriber->is_my2_email==1)
                                                                <span style="color: green;font-size: 20px;">是</span>
                                                            @else
                                                                <span style="color: red;font-size: 20px;">否</span>
                                                            @endif
                                                        </div>

                                                        <hr>
                                                        <div style="padding: 10px 0">
                                                            <a class="btn btn-danger" href="{{ url('/admin/send_email/mn2/'.$subscriber->id.'?is_baby=1') }}" onclick="return confirm('是否確認要寄出方案審核不通過Email?');">寄出方案審核不通過Email</a>
                                                        </div>
                                                        <hr>
                                                        <!-- 是否已寄寄出訂閱開通通知:格上? Form checkbox Input -->
                                                        <div class="form-group row" style="padding-top: 0">
                                                            {!! Form::label('is_mn2_baby_email',"是否已寄出 寄發方案審核不通過 通知?",['class'=>'form-control-label','style'=>'font-size: 16px;font-weight: 400']) !!}
                                                            &nbsp;&nbsp;&nbsp;
                                                            @if($subscriber->is_mn2_baby_email==1)
                                                                <span style="color: green;font-size: 20px;">是</span>
                                                            @else
                                                                <span style="color: red;font-size: 20px;">否</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                            @else
                                                <h5>格上審查：</h5>
                                                @if($subscriber->can_order_car==1)
                                                    <div>
                                                        格上回覆審查結果：
                                                        <span style="color: green;font-size:24px;font-weight: bold">通過</span>
                                                    </div>
                                                @elseif($subscriber->can_order_car==0)
                                                    <div>
                                                        格上回覆審查結果：
                                                        <span style="color: red;font-size:24px;font-weight: bold">不通過</span>
                                                    </div>
                                                    <hr>
                                                    <div style="padding: 10px 0">
                                                        <a class="btn btn-danger" href="{{ url('/admin/send_email/mn2/'.$subscriber->id.'?is_baby=1') }}" onclick="return confirm('是否確認要寄出方案審核不通過Email?');">寄出方案審核不通過Email</a>
                                                    </div>
                                                    <!-- 是否已寄寄出訂閱開通通知:格上? Form checkbox Input -->
                                                    <div class="form-group row" style="padding-top: 0">
                                                        {!! Form::label('is_mn2_baby_email',"是否已寄出 方案審核不通過 通知?",['class'=>'form-control-label','style'=>'font-size: 16px;font-weight: 400']) !!}
                                                        &nbsp;&nbsp;&nbsp;
                                                        @if($subscriber->is_mn2_baby_email==1)
                                                            <span style="color: green;font-size: 20px;">是</span>
                                                        @else
                                                            <span style="color: red;font-size: 20px;">否</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span style="color: red">(格上尚未回覆審查結果)</span>
                                                @endif
                                            @endif
                                        @elseif(role('carplus_varify'))
                                            <span>審查此方案是否通過？</span>
                                            @php
                                                $can_order_car=$subscriber->can_order_car;
                                                $color='#777';
                                                $bg_color='#eee';
                                                $font_weight='400';
                                                if($can_order_car==1){
                                                    $color='green';
                                                    $bg_color='#cdffcd';
                                                    $font_weight='bold';
                                                }
                                                elseif($can_order_car==0){
                                                    $color='red';
                                                    $bg_color='#ffd9d9';
                                                    $font_weight='bold';
                                                }
                                            @endphp
                                            {!! Form::select('can_order_car', ['-1'=>'未審核','1'=>'通過','0'=>'不通過'] , $subscriber->can_order_car ,['class'=>'verify_checkbox','style'=>'border: solid 1px #ddd;padding: 5px;border-radius: 5px;color:'.$color.';background-color:'.$bg_color.';font-weight:'.$font_weight,'id'=>'subscriber','required','onchange'=>'can_order_car_updateField'.'();']) !!}
                                            &nbsp;&nbsp;&nbsp;<span style="color: green;padding-top: 5px" id="can_order_car_msg"></span>
                                            <script>
                                                function can_order_car_updateField() {
                                                    var can_order_car = $('#subscriber :selected').val();
                                                    if(confirm('請注意！如果是不通過，則該訂閱車輛會重新上架。是否確認要變更審核狀態？？')) {
                                                        $.get('/admin/update_subscriber_table_field', {
                                                            "db": 'subscribers',
                                                            "id": '{{$subscriber->id}}',
                                                            "field": 'can_order_car',
                                                            "value": can_order_car
                                                        }).done(function(data) {
                                                            //console.log(data);
                                                            if( data==1 ) {
                                                                $('#subscriber').css('color', 'green').css('font-weight', 'bold');
                                                                $('#subscriber').css('background-color', '#cdffcd').css('font-weight', 'bold');
                                                                $('#can_order_car_msg').html('狀態更新成功，請記得寄出通過信給冰宇及會員').show().delay(10000).slideUp(300);
                                                            }
                                                            else if(data==0) {
                                                                $('#subscriber').css('color', 'red').css('font-weight', 'bold');
                                                                $('#subscriber').css('background-color', '#ffd9d9').css('font-weight', 'bold');
                                                                $('#can_order_car_msg').html('狀態更新成功，請記得寄出不通過通知信給冰宇').show().delay(10000).slideUp(300);
                                                            }
                                                            else {
                                                                $('#subscriber').css('color', '#777').css('font-weight', '400');
                                                                $('#subscriber').css('background-color', '#eee').css('font-weight', 'bold');
                                                                $('#can_order_car_msg').html('狀態更新成功').show().delay(10000).slideUp(300);
                                                            }
                                                        });
                                                    }
                                                    else{
                                                        $('#subscriber').val({{$subscriber->can_order_car}});
                                                    }
                                                }
                                            </script>
                                            {{--<input type="checkbox" class="js-switch" id="status" {{$subscriber->can_order_car==1?'checked':''}} />
                                            <script>
                                                $(function() {
                                                    $('#status').change(function() {
                                                        //console.log('Toggle: ' + $(this).prop('checked'));
                                                        $.get('/admin/ajax_subscriber_switch', {"value": $(this).prop('checked'),"db":'subscribers',"id":'{{$subscriber->id}}',"field":'can_order_car'});
                                                    })
                                                })
                                            </script>--}}
                                            <div style="padding: 10px 0">
                                                <div style="padding-bottom: 10px;font-size: 16px;">方案審查完成，寄出Email通知冰宇及會員：</div>
                                                <div style="padding: 10px 0">
                                                    <a class="btn btn-success" href="{{ url('/admin/send_email/my2/'.$subscriber->id) }}" onclick="return confirm('是否確認要寄出方案通過Email?');">寄出方案通過Email給會員及冰宇</a>&nbsp;
                                                </div>
                                                <!-- 是否已通知:格上? Form checkbox Input -->
                                                <div class="form-group row" style="padding-top: 0">
                                                    {!! Form::label('is_my2_email',"是否已寄出 寄發方案審核通過 通知?",['class'=>'form-control-label','style'=>'font-size: 16px;font-weight: 400']) !!}
                                                    &nbsp;&nbsp;&nbsp;
                                                    @if($subscriber->is_my2_email==1)
                                                        <span style="color: green;font-size: 20px;">是</span>
                                                    @else
                                                        <span style="color: red;font-size: 20px;">否</span>
                                                    @endif
                                                </div>

                                                <hr>
                                                <div style="padding: 10px 0">
                                                    <a class="btn btn-danger" href="{{ url('/admin/send_email/mn2/'.$subscriber->id) }}" onclick="return confirm('是否確認要寄出拒絕Email?');">寄出方案拒絕Email到冰宇</a>
                                                </div>

                                                <!-- 是否已寄寄出訂閱開通通知:格上? Form checkbox Input -->
                                                <div class="form-group row" style="padding-top: 0">
                                                    {!! Form::label('is_mn2_email',"是否已寄出 寄發方案審核不通過 通知?",['class'=>'form-control-label','style'=>'font-size: 16px;font-weight: 400']) !!}
                                                    &nbsp;&nbsp;&nbsp;
                                                    @if($subscriber->is_mn2_email==1)
                                                        <span style="color: green;font-size: 20px;">是</span>
                                                    @else
                                                        <span style="color: red;font-size: 20px;">否</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <span style="color: grey;font-size: 20px;">(此訂閱單已取消)</span>
                                    @endif
                                </div>
                            </div>
                            <hr>
                            <!-- API回覆碼 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('ret_code',"API回覆碼:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('ret_code', $subscriber->ret_code,['class'=>'form-control','readonly']); !!}
                                    @if($errors->has('ret_code'))
                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                             <i class="fa fa-warning"></i>{{ $errors->first('ret_code') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- API回覆訊息結果 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('ret_message',"API回覆訊息結果:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('ret_message', $subscriber->ret_message,['class'=>'form-control','readonly']); !!}
                                    @if($errors->has('ret_message'))
                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                             <i class="fa fa-warning"></i>{{ $errors->first('ret_message') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if(getAdminUser()->id==1)
                                <!-- API回覆訊息結果 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('json',"Json:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('json', $subscriber->json,['class'=>'form-control']); !!}
                                        @if($errors->has('json'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                 <i class="fa fa-warning"></i>{{ $errors->first('json') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <hr>
                            {!! Form::model($subscriber,['url' => '/admin/subscriber/'.$subscriber->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}
                                <!-- 備註 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('memo',"備註(拒絕原因描述):",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('memo', null,['class'=>'form-control','id'=>'memo','rows'=>5,'onblur'=>'memo_updateField();']); !!}
                                        <script>
                                            function memo_updateField() {
                                                var memo = $("textarea#memo").val();
                                                $.get('/admin/update_table_field', {"db":'subscribers',"id":'{{$subscriber->id}}',"field":'memo',"value": memo});
                                            }
                                        </script>
                                    </div>
                                </div>
                                {{--<div class="form-group row">
                                    {!! Form::label('reject_reason',"會員提供資料不全的原因：(會隨資料補齊提醒Email寄出)",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('reject_reason', null,['id'=>'reject_reason','class'=>'form-control','rows'=>5,'onblur'=>'reject_reason_updateField();']); !!}
                                        <script>
                                            function reject_reason_updateField() {
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
                                </div>--}}
                                <!--  Form Submit Input -->
                                <hr class="style_one">
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('更新',['class'=>'btn btn-success']) !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{--@if(role('admin') || role('babysitter'))
                                        <a class="btn btn-info" href="{{ url('/admin/send_email/ry3/'.$subscriber->id ) }}" onclick="return confirm('您是否確認要寄出信件？');">寄出 方案已通過通知(保證金付清 通知</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                    @endif--}}
                                    <a class="btn btn-dark" href="{{ url('/admin/subscriber?page='.Request('page').'&search_is_history='.Request('search_is_history').'&bid='.$subscriber->id.'&search_brandcat_id='.Request('search_brandcat_id').'&search_brandin_id='.Request('search_brandin_id') ) }}">取消及回上一列表</a>
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
    {{--    <script src="/back_assets/js/form-components.js"></script>--}}
    <script src="/back_assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="/back_assets/plugins/summernote/dist/summernote-bs4.min.js"></script>
    <script src="/back_assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="/back_assets/plugins/jquery.repeater/jquery.repeater.min.js"></script>
    <script src="/back_assets/plugins/mohithg-switchery/dist/switchery.min.js"></script>
    <script src="/back_assets/dist/js/theme.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".btn-success2").click(function(){
                var html = $(".clone").html();
                $(".increment").after(html);
            });
            $("body").on("click",".btn-danger2",function(){
                $(this).parents(".control-group").remove();
            });
        });
    </script>

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