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
    <link rel="stylesheet" href="/css/jquery-ui-1.9.2.css" type="text/css" charset="utf-8" />

    <style>
        #draggable {
            background-color: white;
            border: 1px solid #cccccc;
            border-collapse: collapse;
            color: #000;
            text-align: center;
            width: 100%;
        }
        #draggable th {
            background-color: #ddd;
            border: 1px solid #cccccc;
            color: #000;
            padding: 5px;
        }
        #draggable td {
            border: 1px solid #cccccc;
            cursor: move;
            padding: 5px;
        }
    </style>
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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">會員管理</h5>
                                {{--                                <span>各項參數管理帳號</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">會員管理</a></li>
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
                                <span style="display: inline-block;padding-left: 10px">會員訂閱記錄 查詢及列表</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['url' => '/admin/u_reject','method'=>'GET'])  !!}
                                    {!! Form::hidden('search_has_reject',1) !!}
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="search_start_date">新增日期 起：</label>
                                            {!! Form::text('search_start_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_end_date">新增日期 迄：</label>
                                            {!! Form::text('search_end_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
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
                                            <label for="search_is_check">審查狀態</label>
                                            {!! Form::select('search_is_check',[''=>'','-1'=>'未審核','1'=>'已通過','0'=>'不通過'],$search_is_check,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="search_is_picok">證件照都已上傳</label>
                                            {!! Form::select('search_is_picok', [''=>'','1'=>'是'] , $search_is_picok ,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="search_is_activate">帳號已啟用</label>
                                            {!! Form::select('search_is_activate', [''=>'','1'=>'是','0'=>'否'] , $search_is_activate ,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="search_status">帳號有效</label>
                                            {!! Form::select('search_status', [''=>'','1'=>'有效','0'=>'無效'] , $search_status ,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="search_is_picok">輸入統編</label>
                                            {!! Form::select('search_company_no', [''=>'','1'=>'有','0'=>'無'] , $search_company_no ,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="search_keyword">姓名、Email、手機、市話</label>
                                            {!! Form::text('search_keyword',$search_keyword,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="form-group col-md-6 text-center">
                                            <div style="height: 28px;">&nbsp;</div>
                                            <button type="submit" class="btn btn-primary">查詢</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="?clear=1" class="btn btn-success">顯示全部資料</a>
                                            <span class="form-group col-md-12 text-center"> ( 可輸入字首、字中、字尾的關鍵字 )</span>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="">
                            <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                <span style="display: inline-block;padding-left: 10px">會員訂閱記錄 列表  &nbsp;&nbsp;&nbsp;<span style="color: purple"> 會員總筆數：{{$users?number_format($users->total()):0}} 筆 </span></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center;">No.</th>
                                        <th style="text-align:center">審查狀態</th>
                                        <th style="text-align:center">姓名</th>
                                        <th style="text-align:center">相關資訊</th>
                                        <th style="text-align:center">不通過原因</th>
                                        <th>註冊日期 / 更新日期</th>
                                        <th>帳號已啟用</th>
                                        <th>帳號有效</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Begin Form -->
                                    {!! Form::open(['url' => '/admin/user/sort']) !!}
                                        @foreach($users as $key=>$user)
                                            {!! Form::hidden('user_id[]',$user->id) !!}
                                            <tr @if(Request('bid')==$user->id) {!! tableBgColor() !!} @endif >
                                                <td style="text-align: center;">{{$key+1}}</td>
                                                <td style="width: 8%;text-align: center;">
                                                    @if($user->is_check==1)
                                                        <span style="color: darkgreen;font-size: 20px;">通過</span>
                                                    @elseif($user->is_check==0)
                                                        <span style="color: red;font-size: 20px;">不通過</span>
                                                    @endif
                                                </td>
                                                <td>{!! $user->name !!}</td>
                                                <td>
                                                    Email： {!! $user->email !!}<br>
                                                    手機：{!! $user->phone !!}<br>
    {{--                                                生日：{!! $user->birthday !!}<br>--}}
                                                    @if($user->address)
                                                        地址：{!! $user->address !!}<br>
                                                    @endif
                                                    @if($user->company_name)
                                                        公司抬頭：{!! $user->company_name !!}<br>
                                                    @endif
                                                    @if($user->company_no)
                                                        公司統編：{!! $user->company_no !!}<br>
                                                    @endif
                                                    @php
                                                        $user_upload_count=user_upload_count($user);
                                                    @endphp
                                                    @if($user_upload_count>0)
                                                        <div style="padding-top: 5px">
                                                            <a class="btn btn-success" href="/admin/user_idcard/{{$user->id}}">顯示證件照片：{{$user_upload_count}}</a>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td style="width:40%">
                                                    @php
                                                        $subscribers=$user->subscribers;
                                                    @endphp
                                                    @if($subscribers)
                                                        @foreach($subscribers as $subscriber)
                                                            @if($subscriber->memo)
                                                                訂閱 ID：{{$subscriber->id}}
                                                                <div style="color:red">拒編原因：{{$subscriber->memo}}</div>
                                                                <hr>
                                                            @endif
                                                            @if($subscriber->ret_code && $subscriber->ret_code>'1')
                                                                <div style="color:red">
                                                                    API 回覆碼：{{$subscriber->ret_code}}<br>
                                                                    API 回覆訊息：{{$subscriber->ret_message}}
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>
                                                <td>
                                                    {!! $user->created_at !!}
                                                    @if($user->created_at != $user->updated_at)
                                                        <br>{!! $user->updated_at !!}
                                                    @endif
                                                </td>
                                                <td style="text-align: center;">{!! $user->is_activate==1?'<span style="color: green;font-size: 18px">是</span>':'<span style="color: red;">否</span>' !!}</td>
                                                <td style="text-align: center;">
                                                    @if($user->status==1)
                                                        <span style="color: green;font-size: 20px;">是</span>
                                                    @else
                                                        <span style="color: red;font-size: 20px;">否</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    {!! Form::close() !!}
                                    </tbody>
                                </table>
                                <div>&nbsp;</div>
                                <div class="col-md-12">
                                    {{ $users->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4') }}
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
    <script src="/back_assets/js/drable.js"></script>
    <script>
        // document.addEventListener('drop', function(event) {
        //     var id = document.querySelectorAll('.id');
        //     var data = [];
        //
        //     for (var i = 0, len = id.length; i < len; i++) {
        //         data.push(id[i].innerHTML);
        //         id[i].parentNode.querySelector('.sort').innerHTML = i+1;
        //     }
        //     $.get('/admin/ajax_sort', {"data": data,"db":'sliders'});
        // }, false);

        var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elem.forEach(function(html) {
            var switchery = new Switchery(html, {
                color: 'green',
                jackColor: '#fff'
            });
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