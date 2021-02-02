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

    <script src='/back_assets/customselect/jquery-customselect.js'></script>
    <link href='/back_assets/customselect/jquery-customselect.css' rel='stylesheet' />
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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">訂單</h5>
                                {{--                                <span>各項參數訂單編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">訂單</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>訂單 新增</h3></div>
                        <div class="card-body">
                        {!! Form::open(['url' => '/admin/ord','enctype'=>'multipart/form-data'])  !!}

                        <!-- 訂單 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('cate_id',"方案:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('cate_id', $list_cates , $search_cate_id ,['class'=>'form-control','style'=>'font-size:15px','required','onchange'=>'document.location.href="?search_cate_id="+this.value;']) !!}
                                    @if($errors->has('cate_id'))
                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                            <i class="fa fa-warning"></i>{{ $errors->first('cate_id') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- 交車區域 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('proarea_id',"交車區域:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('proarea_id', $list_proareas , $search_proarea_id ,['class'=>'form-control','style'=>'font-size:15px','required','onchange'=>'document.location.href="?search_cate_id='.$search_cate_id.'&search_proarea_id="+this.value;']) !!}
                                </div>
                            </div>

                            <!-- 交車區域 Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('partner_id',"交車地點:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('partner_id', $list_partners , $search_partner_id ,['class'=>'form-control','style'=>'font-size:15px','required']) !!}
                                </div>
                            </div>

                            <!-- title Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('product_id',"車號:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('product_id', $list_products?$list_products:[] , null ,['id'=>'product_select','class'=>'form-control custom-select','required']) !!}
                                    @if($errors->has('product_id'))
                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                            <i class="fa fa-warning"></i>{{ $errors->first('product_id') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- title Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('user_id',"會員:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('user_id', $list_users , null ,['id'=>'user_select','class'=>'form-control custom-select','required']) !!}
                                    @if($errors->has('user_id'))
                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                            <i class="fa fa-warning"></i>{{ $errors->first('user_id') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- 預計交車日期 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('sub_date',"預計交車日期:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('sub_date', null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']); !!}
                                    {{--{!! Form::text('sub_date', null,['class'=>'form-control datePicker']); !!}--}}
                                </div>
                            </div>

                            <div class="form-group row">
                                {!! Form::label('pick_up_time',"前往取車時間:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::select('pick_up_time',$list_pick_up_times, null,['class'=>'form-control',]); !!}
                                </div>
                            </div>

                            <!--  Form Submit Input -->
                            <div class="form-group" style="text-align:center">
                                {!! Form::submit('新增',['class'=>'btn btn-success']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                <a class="btn btn-dark" href="{{ url('/admin/cate' ) }}">取消及回上一列表</a>
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
    <script>window.jQuery || document.write('<script src="/back_assets/src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="/back_assets/plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="/back_assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/back_assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="/back_assets/dist/js/theme.min.js"></script>
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

        $(function() {
            $("#product_select").customselect();
            $("#user_select").customselect();
        });
    </script>
@stop