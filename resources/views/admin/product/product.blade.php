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
        .search_cate{
            height: auto;min-height: 35px;
            width: 100%;
            border: 1px solid #eaeaea;
            padding: 0 10px;
            background-color: #fff;
            font-size: 15px;
            border-radius: 4px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
        }
    </style>
@stop

@section('content')
    <div class="main-content">
        @php
            $product_failure_message=session()->get('product_failure_message');
            $product_show_header_arr=session()->get('product_show_header_arr');
            $product_show_row_arr=session()->get('product_show_row_arr');
        @endphp
        @if($product_failure_message)
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <h5 style="color: red">匯入錯誤訊息:</h5>
            <div style="color: red">{!! $product_failure_message !!}</div>
            <div>&nbsp;</div>
            <a href="/admin/product" class="btn btn-primary">關閉訊息</a>
            @php
                session()->forget('product_failure_message');
            @endphp
            <hr>
        @elseif(count($product_show_header_arr)>0 && count($product_show_row_arr)>0 )
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <style>
                .tbl, .tbl tr, .tlb tr th, .tlb tr td{
                    border: solid 1px #ccc;
                }
            </style>
            <h4>匯入結果 ：</h4>
            <table class="tbl">
                <tr>
                    <th style="border: solid 1px #ccc;padding: 10px;font-size: 16px;">狀態</th>
                    @forelse($product_show_header_arr as $head_key=>$head)
                        <th style="border: solid 1px #ccc;padding: 10px;font-size: 16px;">{{$head}}</th>
                    @empty
                    @endforelse
                </tr>
                @forelse($product_show_row_arr as $shows)
                    <tr style="color: {{$shows[0]=='新增'?'green':'red'}}">
                        @if($shows)
                            @forelse($shows as $key=>$show)
                                <td style="border: solid 1px #ccc;padding: 10px;font-size: 16px;text-align: center;">{{$show}}</td>
                            @empty
                            @endforelse
                        @endif
                    </tr>
                @empty
                @endforelse
            </table>
            <div>&nbsp;</div>
            <a href="/admin/product" class="btn btn-primary">關閉訊息</a>
            @php
                session()->forget('product_show_header_arr');
                session()->forget('product_show_msg_arr');
            @endphp
            <hr>
        @endif
        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-settings bg-blue"></i>
                            <div class="d-inline">
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">車輛管理</h5>
                                {{--                                <span>各項參數車輛管理</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">車輛管理</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if(role('admin') || role('babysitter'))
                            <div style="padding-top: 30px">
                                <div class="row">
                                    <div class="col-md-8" style="padding-left: 50px;">
                                        <!-- Begin Form -->
                                    {!! Form::open(['url' => '/admin/product_import','enctype'=>'multipart/form-data'])  !!}
                                    <!-- 上傳及匯入 Form file Input -->
                                        <div class="form-group row">
                                            {!! Form::label('importFile',"批次匯入車輛:",['class'=>'col-sm-2 form-control-label']) !!}
                                            <div class="col-sm-10">
                                                {!! Form::file('importFile',['class'=>'form-control','style'=>'width: 600px;display: inline-block','required'=>'required']); !!}&nbsp;&nbsp;
                                                {!! Form::submit('匯入',['class'=>'btn btn-primary']) !!}
                                                @if($errors->has('importFile'))
                                                    <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                        <i class="fa fa-warning"></i>{{ $errors->first('importFile') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                    <!-- End of Form -->
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endif
                        <div class="">
                            <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                <span style="display: inline-block;padding-left: 10px">車輛 查詢及列表</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['url' => '/admin/product','name'=>'form_search','method'=>'GET'])  !!}
                                    {!! Form::hidden('download',null,['id'=>'download']) !!}
                                    <div class="form-row">
                                        @if($admin->hasRole('admin|babysitter'))
                                            <div class="form-group col-md-3">
                                                <label for="search_dealer_id">總經銷商</label>
                                                {!! Form::select('search_dealer_id', $list_dealers , $search_dealer_id ,['id'=>'partner','class'=>'form-control','style'=>'font-size:15px','onchange'=>'document.location.href="?search_dealer_id="+this.value;']) !!}
                                            </div>
                                        @endif
                                        <div class="form-group col-md-3">
                                            <label for="search_cate_id">方案類別(查詢專用)</label>
                                            {!! Form::select('search_cate_id', $list_cates , $search_cate_id ,['id'=>'cate','class'=>'form-control','style'=>'font-size:15px','onchange'=>'document.location.href="?search_partner_id="+document.getElementById("partner").value+"&search_cate_id="+this.value;']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_brandcat_id">品牌 (請先選擇方案類別)</label>
                                            {!! Form::select('search_brandcat_id', $list_brandcats , $search_brandcat_id ,['id'=>'brandcat','class'=>'form-control','style'=>'font-size:15px','onchange'=>'document.form_search.submit();']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_brandin_id">車型</label>
                                            {!! Form::select('search_brandin_id', $list_brandins , $search_brandin_id ,['id'=>'brandin','class'=>'form-control','style'=>'font-size:15px','onchange'=>'document.form_search.submit();']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_cate_id_arr">方案類別(匯出專用)</label>
                                            {!! Form::select('search_cate_id_arr[]', $list_cates , $search_cate_id_arr ,['id'=>'cate','class'=>'search_cate','multiple','size'=>'5']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_ptate_id">上架狀態</label>
                                            {!! Form::select('search_ptate_id', $list_ptates , null ,['class'=>'form-control','style'=>'font-size:13px']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_start_date">日期 起：</label>
                                            {!! Form::text('search_start_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_end_date">日期 迄：</label>
                                            {!! Form::text('search_end_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_model">編號</label>
                                            {!! Form::text('search_model', $search_model ,['id'=>'search_model','class'=>'form-control']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_plate_no">車號</label>
                                            {!! Form::text('search_plate_no', $search_plate_no ,['id'=>'search_plate_no','class'=>'form-control']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_start_updated_date">更新日期 起：</label>
                                            {!! Form::text('search_start_updated_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_end_updated_date">更新日期 迄：</label>
                                            {!! Form::text('search_end_updated_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_proarea_id">區域</label>
                                            {!! Form::select('search_proarea_id', $list_proareas, $search_proarea_id ,['id'=>'search_proarea_id','class'=>'form-control']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_id">ID</label>
                                            {!! Form::text('search_id', $search_id ,['id'=>'search_id','class'=>'form-control']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <div style="height: 28px;">&nbsp;</div>
                                            <button type="submit" class="btn btn-primary" onclick="document.getElementById('download').value=0">查詢</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="/admin/product" class="btn btn-success" onclick="document.getElementById('download').value=0">顯示全部資料</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            @if($products->count()>0)
                                                <button type="submit" onclick="if(confirm('是否確認要匯出Excel?')){document.getElementById('download').value=1;document.form_search.submit();}" class="btn btn-info">匯出Excel</button>
                                            @endif
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                <span style="display: inline-block;padding-left: 10px">車輛 列表: <span style="color: #AA0805">( 總資料筆數：{{$products->total()}} )</span></span>
                                <a href="{{ url('/admin/product/create' ) }}" class="btn btn-primary float-md-right">新增 車輛</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        {{--<th style="text-align:center;width:80px"><span style="display: inline-block">首頁顯示<br>(最多選4輛車)</span> </th>--}}
                                        {{--<th>排序</th>--}}
                                        <th>No</th>
                                        <th>ID</th>
                                        <th>經銷商(交車地點)</th>
                                        <th>方案類別</th>
                                        <th>車號、編號</th>
                                        <th>其它規格1</th>
                                        <th>其它規格2</th>
                                        <th>異動日</th>
                                        {{--<th>圖片</th>--}}
                                        <th>上架</th>
                                        <th>動 作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {!! Form::open(['url' => '/admin/product/batch_update'])  !!}
                                    {!! Form::hidden('page',Request('page')) !!}
                                    @foreach($products as $key=>$product)
                                        {!! Form::hidden('product_id[]',$product->id) !!}
                                        <tr @if(Request('bid')==($product->id)) {!! tableBgColor() !!} @endif>
                                            {{--<td style="text-align:center;width: 10%">
                                                <a name="list{{$key}}"></a>
                                                {!! Form::checkbox('is_home_show[]', $product->id, $product->home_show==1?'checked':'' ) !!}
                                            </td>--}}
                                            <td>{{$key+1}}</td>
                                            <td class="id">{{$product->id}}</td>
                                            <td style="width:15%;color: purple">
                                                @if($product->partner)
                                                    <span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->partner->title }}</span><br>
                                                @endif
                                                @if($product->partner2)
                                                    <br><span style="color: purple;font-size: 14px;font-weight: bold;">( 原經銷據點：{{$product->partner2->title }} )</span><br>
                                                @endif
                                            </td>
                                            <td style="width:15%">
                                                @if($product->cate)
                                                    <span style="font-size: 20px;color: purple">{{$product->cate->title}}</span><br>
                                                    <span style="color: purple">{{number_format($product->cate->basic_fee) }} 元</span><br>
                                                    <span style="color: purple">{{number_format($product->cate->mile_fee,2) }} 元/每公里</span><br>
                                                @endif
                                            </td>
                                            <td style="width:15%;color: purple">
                                                <span style="font-size: 20px;">車號：{{$product->plate_no}}</span>
                                                <hr>
                                                編號：{{$product->model}}<br>
                                            </td>
                                            <td style="width:10%;color: purple;text-align: left;">
                                                <span style="color: black;font-weight: 300;">品牌:</span><span style="font-weight: bold;"> {{$product->brandcat?$product->brandcat->title:'' }}</span><br>
                                                <span style="color: black;font-weight: 300;">車型:</span><span style="font-weight: bold;"> {{$product->brandin?$product->brandin->title:''}}</span><br>
                                                <span style="color: black;font-weight: 300;">排氣量:</span><span style="font-weight: bold;"> {{ number_format($product->displacement) }}</span><br>
                                                <span style="color: black;font-weight: 300;">年份:</span><span style="font-weight: bold;"> {{ $product->year }}</span><br>
                                                <span style="color: black;font-weight: 300;">排檔:</span><span style="font-weight: bold;"> {{$product->progeartype?$product->progeartype->title:''}}</span><br>
                                            </td>
                                            <td style="width:10%;color: purple;text-align: left;">
                                                <span style="color: black;font-weight: 300;">新車車價:</span><span style="font-weight: bold;"> {{$product->new_car_price}}</span><br>
                                                <span style="color: black;font-weight: 300;">中古車定價:</span><span style="font-weight: bold;"> {{$product->second_hand_price}}</span><br>
                                                <span style="color: black;font-weight: 300;">座位數:</span><span style="font-weight: bold;"> {{$product->seatnum}}</span><br>
                                                <span style="color: black;font-weight: 300;">顏色:</span><span style="font-weight: bold;"> {{$product->procolor?$product->procolor->title:''}}</span><br>
                                                <span style="color: black;font-weight: 300;">里程數:</span><span style="font-weight: bold;"> {{ number_format($product->milage) }}</span><br>
                                                <span style="color: black;font-weight: 300;">交車區域:</span><span style="font-weight: bold;"> {{$product->proarea?$product->proarea->title:''}}</span><br>
                                                @php
                                                    $proarea2=$product->proarea2;
                                                @endphp
                                                @if($proarea2)
                                                    <span style="color: black;font-weight: 300;">交車區域2:</span><span style="font-weight: bold;"> {{$product->proarea2->title}}</span><br>
                                                @endif
                                            </td>
                                            <td style="width: 13%">
                                                新增日期:<br>{{$product->created_at}}<br>
                                                更新日期:<br>{{$product->updated_at}}
                                            </td>
                                            {{--<td style="width:15%">
                                                @if($product->image)
                                                    <div class="hidden-xs hidden-sm hidden-md text-center">
                                                        {{ Html::image($product->image, $product->title, ['style'=>'width:150px']) }}
                                                    </div>
                                                    --}}{{--<div class="text-center">{{ $product->image }}</div>--}}{{--
--}}{{--                                                    {!! Form::text('image[]', $product->image,['class'=>'form-control']); !!}--}}{{--
                                                @endif
                                            </td>--}}
                                            <td style="width: 10%">
                                                {{--@php
                                                    $ord=$product->ord;
                                                    $state_id=null;
                                                    if($ord){
                                                        $state_id=$ord->state_id;
                                                        $is_cancel=$ord->is_cancel;
                                                    }

                                                @endphp
                                                @if(!$ord || $is_cancel==1 || $state_id>=11)
                                                    <input type="checkbox" class="js-switch" id="status{{$key}}" {{$product->status==1?'checked':''}} />
                                                    <script>
                                                        $(function() {
                                                            $('#status{{$key}}').change(function() {
                                                                console.log('Toggle: ' + $(this).prop('checked'));
                                                                $.get('/admin/ajax_product_switch', {"value": $(this).prop('checked'),"db":'products',"id":'{{$product->id}}',"field":'status'});
                                                            })
                                                        })
                                                    </script>
                                                    @if($product->auto_online_date)
                                                        <div style="padding-top: 10px">預計再上架日期：{{$product->auto_online_date}}</div>
                                                    @endif
                                                @elseif($ord->state_id==1)
                                                    <span style="color: red">出租中...</span>
                                                @else
                                                    <span style="color: red">已出租</span>
                                                @endif
                                                <hr>
                                                {{$product->ptate?$product->ptate->title:''}}/
                                                {{$product->status}}/
                                                {{$product->ptate_id}}--}}

                                                @if($product->ptate_id==1)
                                                    <span style="color: red">( {{$product->ptate?$product->ptate->title.'...':''}} )</span>
                                                    @php
                                                        $ord=$product->ord;
                                                    @endphp
                                                    @if($ord)
                                                        <div style="padding-top: 8px">{{$ord->created_at}}</div>
                                                        <div style="padding-top: 8px">訂單ID：{{$ord->id}}</div>
                                                        <div style="padding-top: 8px">訂單狀態：{{$ord->state?$ord->state->ftitle:''}}</div>
                                                    @endif
                                                @elseif($product->ptate_id==2)
                                                    <span style="color: red">( {{$product->ptate?$product->ptate->title:''}} )</span>
                                                    @php
                                                        $ord=$product->ord;
                                                    @endphp
                                                    @if($ord)
                                                        <div style="padding-top: 8px">{{substr($ord->paid_date,0,10)}}</div>
                                                        <div style="padding-top: 8px">訂單ID：{{$ord->id}}</div>
                                                        <div style="padding-top: 8px">{{$ord->state?$ord->state->ftitle:''}}</div>
                                                    @endif
                                                @else
                                                    @php
                                                        $ptate_id=$product->ptate_id;
                                                        $color='#777';
                                                        $bg_color='#eee';
                                                        $font_weight='400';
                                                        if($ptate_id==3){
                                                            $color='green';
                                                            $bg_color='#cdffcd';
                                                            $font_weight='bold';
                                                        }
                                                        elseif($ptate_id==4){
                                                            $color='red';
                                                            $bg_color='#ffd9d9';
                                                            $font_weight='bold';
                                                        }
                                                        /*elseif($ptate_id==5){
                                                            $color='#c78b00';
                                                            $bg_color='#ffeec8';
                                                            $font_weight='bold';
                                                        }*/
                                                    @endphp
                                                    {!! Form::select('ptate_id', $list_ptate_ids , $product->ptate_id ,['id'=>'ptate'.$key,'style'=>'border: solid 1px #ddd;padding: 5px;border-radius: 5px;color:'.$color.';background-color:'.$bg_color.';font-weight:'.$font_weight,'onchange'=>'ptate_id_updateField'.$key.'();']) !!}
                                                    @if($product->ptate_id==3)
                                                        @php
                                                            $diff=0;
                                                            if($product->online_date){
                                                                $time2=date('Y-m-d');
                                                                $time1=$product->online_date;
                                                                $diff=(strtotime($time2) - strtotime($time1)) / (60*60*24);
                                                            }
                                                        @endphp
                                                        @if($product->online_date)
                                                            <div style="padding-top: 8px">上架日：{{$product->online_date}}</div>
                                                            <div style="padding-top: 8px">已上架 {{number_format($diff)}} 天</div>
                                                        @endif
                                                    @elseif($product->ptate_id==6)
                                                        @php
                                                            $diff=0;
                                                            if($product->return_date){
                                                                $time2=date('Y-m-d');
                                                                $time1=$product->return_date;
                                                                $diff=(strtotime($time2) - strtotime($time1)) / (60*60*24);
                                                            }
                                                        @endphp
                                                        @if($product->return_date)
                                                            <div style="padding-top: 8px">還車日：<br>{{$product->return_date}}</div>
                                                            <div style="padding-top: 8px">已還車 {{number_format($diff)}} 天</div>
                                                        @endif
                                                    @endif
                                                    <div style="color: green;padding-top: 5px" id="ptate{{$key}}_msg"></div>
                                                    <div style="color: purple;padding-top: 5px" id="mediate_times{{$key}}_msg">
                                                        {{$product->ptate_id==4 && $product->mediate_times>0?'斡旋次數:'.$product->mediate_times:''}}
                                                        <div>{{$product->ptate_id==4 && $product->mediate_times>0?'斡旋日期:'.$product->mediate_date:''}}</div>
                                                    </div>
                                                    <div style="color: #777;padding-top: 5px" id="off_times{{$key}}_msg">
                                                        {{$product->ptate_id==5 && $product->off_times>0?'下架次數:'.$product->off_times:''}}
                                                        <div>{{$product->ptate_id==5 && $product->off_times>0?''.$product->off_date:''}}</div>
                                                    </div>
                                                    <div style="padding-top: 5px" id="auto_online_date_{{$key}}_msg">
                                                        @if($product->auto_online_date)
                                                            預計再上架日期：{{$product->auto_online_date}}
                                                        @endif
                                                    </div>
                                                    <script>
                                                        function ptate_id_updateField{{$key}}() {
                                                            var ptate_id = $('#ptate{{$key}} :selected').val();
                                                            if(confirm('是否確認要變更車輛狀態？')) {
                                                                $.get('/admin/ajax_product_select', {
                                                                    "db": 'products',
                                                                    "id": '{{$product->id}}',
                                                                    "field": 'ptate_id',
                                                                    "value": ptate_id
                                                                }).done(function(data) {
                                                                    if( data.value==3 ) {
                                                                        $('#ptate{{$key}}').css('color', 'green').css('font-weight', 'bold');
                                                                        $('#ptate{{$key}}').css('background-color', '#cdffcd').css('font-weight', 'bold');
                                                                        $('#auto_online_date_{{$key}}_msg').html('').show();
                                                                        $('#mediate_times{{$key}}_msg').html('').show();
                                                                        $('#off_times{{$key}}_msg').html('').show();
                                                                    }
                                                                    else if(data.value==4) {
                                                                        $('#ptate{{$key}}').css('color', 'red').css('font-weight', 'bold');
                                                                        $('#ptate{{$key}}').css('background-color', '#ffd9d9').css('font-weight', 'bold');
                                                                        $('#auto_online_date_{{$key}}_msg').html('預計再上架日期：'+data.auto_online_date).show();
                                                                        $('#mediate_times{{$key}}_msg').html('斡旋次數：'+data.mediate_times).show();
                                                                        $('#off_times{{$key}}_msg').html('').show();
                                                                    }
                                                                    else if(data.value==5){
                                                                        $('#ptate{{$key}}').css('color', '#777').css('font-weight', '400');
                                                                        $('#ptate{{$key}}').css('background-color', '#eee').css('font-weight', 'bold');
                                                                        $('#auto_online_date_{{$key}}_msg').html('').show();
                                                                        $('#mediate_times{{$key}}_msg').html('').show();
                                                                        $('#off_times{{$key}}_msg').html('下架次數：'+data.off_times).show();
                                                                    }
                                                                    $('#ptate{{$key}}_msg').html('狀態更新成功').show().delay(3000).slideUp(300);

                                                                });
                                                            }
                                                            else{
                                                                $('#ptate{{$key}}').val({{$product->ptate_id}});
                                                            }
                                                        }
                                                    </script>
                                                @endif
                                            </td>
                                            <td style="width: 20%;">
                                                {{--@if(!$ord || $is_cancel==1 || $state_id>=11)--}}
                                                @if($product->ptate_id>=3)
                                                    <a href="{{ url('/admin/product/'.$product->id.'/edit?page='.Request('page').'&search_brandcat_id='.$search_brandcat_id.'&search_brandin_id='.$search_brandin_id ) }}" class="btn btn-success">編輯</a>
                                                    @if($admin->hasRole('admin|babysitter') && $product->ptate_id==5)
                                                        <a href="{{ url('/admin/product/'.$product->id.'/delete' ) }}" class="btn btn-danger float-right" onclick="return confirm('是否確定要軟刪除？')">軟刪除</a>
                                                    @endif
                                                @else
                                                    @if($admin->hasRole('admin|babysitter'))
                                                        <a href="{{ url('/admin/product/'.$product->id.'/edit?page='.Request('page').'&search_brandcat_id='.$search_brandcat_id.'&search_brandin_id='.$search_brandin_id ) }}" class="btn btn-default">編輯</a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{--@if($products && $products->count())
                                        <tr>
                                            <td class="text-center">{!! Form::submit('首頁顯示設定',['class'=>'btn btn-primary','onclick'=>'return confirm("是否確定要首頁顯示設定?")']) !!}</td>
                                        </tr>
                                        --}}{{--return confirm("是否確定要批次刪除？");--}}{{--
                                    @endif--}}
                                    {!! Form::close() !!}
                                    </tbody>
                                </table>
                                <div>&nbsp;</div>
                                <div class="col-md-12">
                                    {{ $products->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4') }}
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
        /*document.addEventListener('drop', function(event) {
            var id = document.querySelectorAll('.id');
            var data = [];

            for (var i = 0, len = id.length; i < len; i++) {
                data.push(id[i].innerHTML);
                id[i].parentNode.querySelector('.sort').innerHTML = paddingLeft( i+1, 2 );
            }
            $.get('/admin/ajax_sort', {"data": data,"db":'products'});
        }, false);*/

        var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elem.forEach(function(html) {
            var switchery = new Switchery(html, {
                color: 'green',
                jackColor: '#fff'
            });
        });

        $('#chkdelall').click(function(){
            if($("#chkdelall").prop("checked")) {
                $("input[name='is_home_show[]']").each(function() {
                    $(this).prop("checked", true);
                });
            } else {
                $("input[name='is_home_show[]']").each(function() {
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

        /*$(document).on('change', '#brandcat', function(){
            var brandcat = $('#brandcat :selected').val();//注意:selected前面有個空格！
            $.ajax({
                url:"/admin/ajax_brand",
                method:"GET",
                data:{
                    brandcat:brandcat
                },
                success:function(res){
                    $('#brandin').html(res);
                }
            })//end ajax
        });*/
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