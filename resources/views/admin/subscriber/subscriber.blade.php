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
            color: #e77100;text-align: center;font-size: 26px;font-weight: bold;padding: 15px 5px 10px 5px;border-bottom: solid 2px white;
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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">訂閱管理</h5>
                                {{--                                <span>各項參數訂閱管理</span>--}}
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
                    <div class="card" style="max-width: 1500px">
                        <div class="card">
                            <div class="">
                                <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                    <span style="display: inline-block;padding-left: 10px">訂閱單 查詢及列表</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        {!! Form::open(['url' => '/admin/subscriber','method'=>'GET'])  !!}
                                        <div class="form-row">
                                            <div class="col-md-4" style="padding-top: 10px">
                                                <label for="search_id">ID</label>
                                                {!! Form::text('search_id', $search_id ,['id'=>'model','class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-4" style="padding-top: 10px">
                                                <label for="search_sub_date">狀態</label>
                                                <!-- 狀態 Form select Input -->
                                                {!! Form::select('search_is_history', ['0'=>'運作中','1'=>'歷史單','2'=>'全部'] , $search_is_history ,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-4" style="padding-top: 10px">
                                                <label for="search_created_at">新增日期：</label>
                                                {!! Form::text('search_created_at',$search_created_at,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                            </div>
                                            <div class="col-md-4" style="padding-top: 10px">
                                                <label for="search_sub_date">審查狀態</label>
                                                <!-- 狀態 Form select Input -->
                                                {!! Form::select('search_can_order_car', [''=>'全部','1'=>'通過','0'=>'不通過','-1'=>'待審查'] , $search_can_order_car ,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-4" style="padding-top: 10px">
                                                <label for="search_is_cancel">是否取消</label>
                                                {!! Form::select('search_is_cancel', [''=>'','1'=>'是','0'=>'否'] , $search_is_cancel ,['class'=>'form-control','style'=>'font-size:13px']) !!}
                                            </div>
                                            <div class="col-md-4" style="padding-top: 10px">
                                                <label for="search_is_picok">輸入統編</label>
                                                {!! Form::select('search_company_no', [''=>'','1'=>'有','0'=>'無'] , $search_company_no ,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="col-md-4" style="padding-top: 10px">
                                                <label for="search_keyword">姓名、電話、Email</label>
                                                {!! Form::text('search_keyword',null,['class'=>'form-control']) !!}
                                            </div>
                                            <div class="form-group col-md-4 text-center">
                                                <div style="height: 28px;">&nbsp;</div>
                                                <button type="submit" class="btn btn-primary">查詢</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="?clear=1" class="btn btn-success">顯示全部資料</a>
                                                {{--<span class="form-group col-md-12 text-center"> ( 可輸入字首、字中、字尾的關鍵字 )</span>--}}
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                <span style="display: inline-block;padding-left: 10px">訂閱 列表: <span style="color: #AA0805">( 總資料筆數：{{$subscribers->total()}} )</span></span>
                                @if(role('admin') || role('babysitter'))
                                    <a href="{{ url('/admin/subscriber/create' ) }}" class="btn btn-primary float-md-right">新增 訂閱單</a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        {{--<th style="text-align:center;width:80px"><span style="display: inline-block">首頁顯示<br>(最多選4輛車)</span> </th>--}}
                                        {{--<th>排序</th>--}}
                                        <th>訂閱 ID</th>
                                        <th>會員資料</th>
                                        <th>方案類別 / 交車區域 / 交車日期</th>
                                        @if(role('admin') || role('babysitter'))
                                            <th style="text-align:center">車輛資訊</th>
                                        @endif
                                        <th style="text-align: center;">審核結果</th>
                                        @if(role('admin') || role('babysitter') || role('carplus_varify'))
                                            <th>動 作</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {!! Form::open(['url' => '/admin/subscriber/batch_update'])  !!}
                                    {!! Form::hidden('page',Request('page')) !!}
                                    @foreach($subscribers as $key=>$subscriber)
                                        @php
                                            $user=$subscriber->user;
                                            $cate=$subscriber->cate;
                                            $proarea=$subscriber->proarea;
                                            $subcars=$subscriber->subcars;
                                        @endphp
                                        {!! Form::hidden('subscriber_id[]',$subscriber->id) !!}
                                        <tr @if(Request('bid')==($subscriber->id)) {!! tableBgColor() !!} @endif>
                                            {{--<td style="text-align:center;width: 10%">
                                                <a name="list{{$key}}"></a>
                                                {!! Form::checkbox('is_home_show[]', $subscriber->id, $subscriber->home_show==1?'checked':'' ) !!}
                                            </td>--}}
                                            {{--<td class="sort">{{$subscriber->sort}}</td>--}}
                                            <td class="id" style="width: 5%">{{$subscriber->id}}</td>
                                            <td style="width:20%;color: purple">
                                                @if($user)
                                                    @if(role('admin') || role('babysitter') || role('carplus_varify') || role('carplus_company'))
                                                        會員姓名：<a href="/admin/subscriber_user/{{$user->id}}/edit" class="btn btn-primary" target="_blank">{{ $user->name }}</a><br>
                                                        {{--&nbsp;&nbsp;<a class="btn btn-success" href="/admin/user_idcard/{{$user->id}}">證照</a>--}}
                                                    @else
                                                        會員姓名：{{ $user->name }}
                                                    @endif
                                                    <br>手機：{{ $user->phone }}<br>
                                                    Email：{{ $user->email }}<br>
                                                    地址：{{ $user->address }}<br>
                                                    @if($user->company_no)
                                                        <hr>
                                                        公司抬頭：{{$user->company_name}}<br>
                                                        公司統編：{{$user->company_no}}<br>
                                                        <hr>
                                                    @endif
                                                    {{--是否已通過審核：{!! $user->is_check==1?'<span style="color: green;font-size: 18px">是</span>':'<span style="color: red;">否</span>' !!}<br>--}}
                                                @endif
                                            </td>
                                            <td style="width:20%;color: purple">
                                                @if($cate)
                                                    <span style="font-size: 20px;font-weight: bold;">{{$cate->title}}</span><br>
                                                    月租基本費(元): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->basic_fee)}}</span><br>
                                                    每公里費用(元): <span style="color: purple;font-size: 18px;font-weight: bold;"> {{number_format($cate->mile_fee,2)}}</span><br>
                                                @endif
                                                <hr>
                                                交車區域：{{$proarea?$proarea->title:''}}<br>
                                                交車日期：{{$subscriber->sub_date}}<br>
                                                <hr>
                                                <div style="color: {{$subscriber->is_history==0?'green':'red'}};font-weight: bold;font-size: 20px;">
                                                    @if($subscriber->is_history==0)
                                                        ( 運作中... )
                                                    @elseif($subscriber->is_history==1)
                                                        ( 歷史單 )
                                                    @endif
                                                </div>
                                                    <hr>
                                                    新增日期：<br>
                                                    {{$subscriber->created_at}}
                                                    @if($subscriber->created_at!=$subscriber->updated_at)
                                                        <hr>更新日期：<br>{{$subscriber->updated_at}}
                                                    @endif
                                            </td>
                                            @php
                                                $product=$subscriber->product;
                                            @endphp
                                            @if(role('admin') || role('babysitter'))
                                                <td style="width: 20%">
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
                                                                <td colspan="2" class="temp_top_td">{{$brandin_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="temp_title_td">廠牌</td>
                                                                <td class="temp_content_td">{{$brandcat_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="temp_title_td">顏色</td>
                                                                <td class="temp_content_td">{{$procolor_name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="temp_title_td">排氣量</td>
                                                                <td class="temp_content_td">{{number_format($product->displacement)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="temp_title_td">年份</td>
                                                                <td class="temp_content_td">{{$product->year}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="temp_title_td">里程</td>
                                                                <td class="temp_content_td">{{number_format($milage)}}</td>
                                                            </tr>
                                                            @if($product->equipment)
                                                                <tr>
                                                                    <td class="temp_title_td">配備</td>
                                                                    <td class="temp_content_td">{{$product->equipment}}</td>
                                                                </tr>
                                                            @endif
                                                        </table>
                                                    @endif
                                                </td>
                                            @endif
                                            <td style="width:12%;color: purple">
                                                @if($subscriber->is_cancel==1)
                                                    <span style="color: grey;font-size: 20px;">(已取消)</span>
                                                @else
                                                    @if($subscriber->can_order_car==1)
                                                        <div>
                                                            審核結果：<span style="color: green;font-size:24px;font-weight: bold">通過</span>
                                                        </div>
                                                    @elseif($subscriber->can_order_car==0)
                                                        <div>
                                                            審核結果：<span style="color: red;font-size:24px;font-weight: bold">不通過</span>
                                                        </div>
                                                    @else
                                                        @if($product && $product->dealer_id==1)
                                                            ( 待格上審核... )
                                                        @else
                                                            ( 待審核... )
                                                        @endif
                                                    @endif
                                                    @if($subscriber->ret_code)
                                                        <hr>
                                                        <div style="color: {{$subscriber->ret_code=='1'?'green':'red'}}">API回覆碼：{{$subscriber->ret_code}}</div>
                                                        <div style="color: {{$subscriber->ret_code=='1'?'green':'red'}}">API訊息：{{$subscriber->ret_message}}</div>
                                                    @endif
                                                @endif
                                            </td>
                                            @if(role('admin') || role('babysitter') || role('carplus_varify'))
                                                <td style="width: 10%;">
                                                    <div>
                                                    <a href="{{ url('/admin/subscriber/'.$subscriber->id.'/edit?search_is_history='.Request('search_is_history') ) }}" class="btn btn-success">編輯</a>
                                                    </div>
                                                    <div>
                                                    <div>&nbsp;</div>
                                                    <div>&nbsp;</div>
                                                    {{--@if(getAdminUser()->id==1)--}}
                                                        @php
                                                            //$cate_id=$subscriber->cates && $subscriber->cates->first()?$subscriber->cates->first()->id:'';
                                                        @endphp
                                                        <a href="{{ url('/admin/subscriber/'.$subscriber->id.'/delete?search_is_history='.Request('search_is_history') ) }}" class="btn btn-danger" onclick='return confirm("是否確定要刪除此筆資料?");'>刪除</a>
                                                    {{--@endif--}}
                                                    </div>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    {{--@if($subscribers && $subscribers->count())
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
                                    {{ $subscribers->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4') }}
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
            $.get('/admin/ajax_sort', {"data": data,"db":'subscribers'});
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