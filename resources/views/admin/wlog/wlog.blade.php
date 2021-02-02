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
        td,th{text-align: left}
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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">LOG 記錄</h5>
                                {{--                                <span>各項參數LOG 記錄</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">LOG 記錄</a></li>
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
                                <span style="display: inline-block;padding-left: 10px">LOG 記錄 查詢及列表</span>
                            </div>
                        </div>
                        <div class="card-body" style="padding-bottom: 5px">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>&nbsp;</div>
                                    {!! Form::open(['url' => '/admin/wlog','method'=>'GET'])  !!}
                                    <div class="form-row">
                                        <div class="col-md-3">
                                            <label for="search_start_date">日期 起：</label>
                                            {!! Form::text('search_start_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="search_end_date">日期 迄：</label>
                                            {!! Form::text('search_end_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="search_state_id">前台/後台</label>
                                            {!! Form::select('search_platform', [''=>'全部','frontend'=>'前台','backend'=>'後台',] , $search_platform ,['class'=>'form-control','style'=>'font-size:13px']) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label for="search_keyword">LOG 記錄關鍵字查詢</label>
                                            {!! Form::text('search_keyword',null,['class'=>'form-control']) !!}
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 text-center">
                                            <div style="height: 28px;">&nbsp;</div>
                                            <button type="submit" class="btn btn-primary">查詢</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="?clear=1" class="btn btn-success">顯示全部資料</a>
                                        </div>
                                        <div class="form-group col-md-12 text-center"> ( LOG 記錄的關鍵字可輸入字首、字中、字尾 )</div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="card-body">
                            <div class="panel-heading" style="height:50px">
                                LOG 記錄 列表 , 最新排最上面&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <span style="color:purple">資料筆數：{{number_format($wlogs->total())}}</span>
                                {{--<a href="{{ url('/admin/ord/create' ) }}" class="btn btn-primary float-md-right">新增 LOG 記錄</a>--}}
                            </div>
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                        <tr>
                                            {{--<th>排序</th>--}}
                                            <th>No.</th>
                                            <th>Log ID</th>
                                            <th>記錄日期</th>
                                            <th>平台</th>
                                            {{--                                    <th>操作者</th>--}}
                                            <th>標題</th>
                                            <th>內容</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($wlogs as $key=>$wlog)
                                            <tr>
                                                <td style="width: 1%;">{{ $key+1 }}</td>
                                                <td>{{ $wlog->id }}</td>
                                                <td style="width: 12%;">{{ $wlog->created_at }}</td>
                                                <td style="width: 5%;">{{ $wlog->platform=='frontend'?'前台':'後台' }}</td>
                                                {{--                                        <td style="width: 10%;">{{ $wlog->user?$wlog->user->name:'' }}</td>--}}
                                                <td style="width: 17%;">{{ $wlog->title }}</td>
                                                <td style="width: 55%;word-break: break-all">{!! $wlog->content !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div>&nbsp;</div>
                                <div class="col-md-12">
                                    {{ $wlogs->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4') }}
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