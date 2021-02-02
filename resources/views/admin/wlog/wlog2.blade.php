@extends('admin.layouts.adminapp')

@section('extra-css')
    <link rel="stylesheet" type="text/css" href="/back_assets/extra-libs/multicheck/multicheck.css">
    <link href="/back_assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    {{--<link href="/back_assets/css/style.min.css" rel="stylesheet">--}}
    <link href="/back_assets/css/style.min.css" rel="stylesheet">
    <link href="/back_assets/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/jquery-ui-1.9.2.css" type="text/css" charset="utf-8" />
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
                <h4 class="page-title">LOG 記錄查詢</h4>
                <div class="ml-auto text-right">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">LOG 記錄查詢</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <style>.col-md-3{padding-bottom: 15px;}</style>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">LOG 記錄 查詢及列表</h5>
                <div class="card-body">
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
                <div class="card-body">
                    <div class="panel-heading" style="height:50px">
                        LOG 記錄 列表 , 最新排最上面: ( 資料筆數：{{$wlogs->count()}} )
                        {{--<a href="{{ url('/admin/ord/create' ) }}" class="btn btn-primary float-md-right">新增 LOG 記錄</a>--}}
                    </div>
                    <div class="table-responsive">
                        <div class="table-responsive">
                            <style>
                                td,th{text-align: left}
                            </style>
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                <tr>
                                    {{--<th>排序</th>--}}
                                    <th>No.</th>
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
                                        <td style="width: 12%;">{{ $wlog->created_at }}</td>
                                        <td style="width: 5%;">{{ $wlog->platform=='frontend'?'前台':'後台' }}</td>
{{--                                        <td style="width: 10%;">{{ $wlog->user?$wlog->user->name:'' }}</td>--}}
                                        <td style="width: 17%;">{{ $wlog->title }}</td>
                                        <td style="width: 55%;word-break: break-all">{{$wlog->content}}</td>
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
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <!-- this page js -->
    <script src="/back_assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="/back_assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="/back_assets/extra-libs/DataTables/datatables.min.js"></script>
    <script src="js/jquery-ui.min.js" type="text/javascript"></script>
    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
    </script>
    <script>
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

        $((function($){
            $.datepicker.regional['zh-TW'] = {
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
                monthNamesShort: ['一','二','三','四','五','六', '七','八','九','十','十一','十二'],
                monthStatus: '選擇月份',
                yearStatus: '選擇年份',
                weekHeader: '週',
                weekStatus: '年內週次',
                dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
                dayNamesShort: ['週日','週一','週二','週三','週四','週五','週六'],
                dayNamesMin: ['日','一','二','三','四','五','六'],
                dayStatus: '設置 DD 為一周起始',
                dateStatus: '選擇 m月 d日, DD',
                dateFormat: 'yy-mm-dd',
                firstDay: 1,
                initStatus: '請選擇日期',
                isRTL: false};
            $.datepicker.setDefaults($.datepicker.regional['zh-TW']);
        })(jQuery));

        $('.datePicker').datepicker();
    </script>
@endsection

