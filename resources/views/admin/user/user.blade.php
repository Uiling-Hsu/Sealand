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
                                <span style="display: inline-block;padding-left: 10px">會員 查詢及列表</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['url' => '/admin/user','method'=>'GET'])  !!}
                                        {!! Form::hidden('download',null,['id'=>'download']) !!}
                                        <div class="form-row">
                                            <div class="col-md-3" style="padding-top: 10px;padding-bottom: 10px;;background-color: #f6f6f6;">
                                                <label for="search_start_date">日期 起：</label>
                                                {!! Form::text('search_start_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                            </div>
                                            <div class="col-md-3" style="padding-top: 10px;padding-bottom: 10px;;background-color: #f6f6f6;">
                                                <label for="search_end_date">日期 迄：</label>
                                                {!! Form::text('search_end_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly']) !!}
                                            </div>
                                            <div class="col-md-3" style="padding-top: 10px;padding-bottom: 10px;;background-color: #f6f6f6;">
                                                <label for="search_date_field">查詢日期起訖欄位</label>
                                                {!! Form::select('search_date_field', ['created_at'=>'新增日期','updated_at'=>'更新日期','check_date'=>'審查通過日期','upload_date'=>'上傳證件日期'] , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
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
                                                <button type="submit" class="btn btn-primary" onclick="document.getElementById('download').value=0">查詢</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <a href="?clear=1" class="btn btn-success" onclick="document.getElementById('download').value=0">顯示全部資料</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                @if($users->count()>0)
                                                    <button type="submit" onclick="if(confirm('是否確認要匯出Excel?')){document.getElementById('download').value=1;document.form_search.submit();}" class="btn btn-info">匯出Excel</button>
                                                @endif
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
                                <span style="display: inline-block;padding-left: 10px">會員 列表  &nbsp;&nbsp;&nbsp;<span style="color: purple">( 會員總筆數：{{$users?number_format($users->total()):0}} 筆 , 未審核：{{$user_not_check_count}} , <span style="color: red">未通過：{{$user_not_pass_count}} )</span></span></span>
                                {{--<a href="{{ url('/admin/user/create' ) }}" class="btn btn-primary float-md-right">新增 會員</a>--}}
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
                                        {{--<th style="text-align:center">身份證</th>--}}
                                        <th>註冊日期 / 更新日期</th>
                                        <th>帳號已啟用</th>
                                        <th>帳號有效</th>
                                        <th>動 作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Begin Form -->
                                    {!! Form::open(['url' => '/admin/user/sort']) !!}
                                    @foreach($users as $key=>$user)
                                        {!! Form::hidden('user_id[]',$user->id) !!}
                                        <tr @if(Request('bid')==$user->id) {!! tableBgColor() !!} @endif >
                                            <td style="text-align: center;">{{$key+1}}</td>
                                            <td>
                                                @if($user->is_check==1)
                                                    <span style="color: darkgreen;font-size: 20px;">通過</span>
                                                    {{--<div>通過日期：{{$user->check_date}}</div>--}}
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
                                            {{--<td>
                                                @if($user->idcard_image01)
                                                    <a href="/admin/user/idcard_image01/{{$user->idcard_image01}}" target="_blank">{{ Html::image('/admin/user/idcard_image01/'.$user->idcard_image01,null, ['style'=>'max-width:500px;padding:2px']),[] }}</a>
                                                    <div>&nbsp;</div>
                                                    <div style="padding-left: 20px">
                                                        <!-- 發證地點 Form select Input -->
                                                        <div class="form-group row">
                                                            <div class="col-sm-3">
                                                                {!! Form::label('ssite_id',"發證地點:",['class'=>'form-control-label']) !!}
                                                            </div>
                                                            <div class="col-sm-9">
                                                                {!! Form::select('ssite_id', $list_ssites , $user->ssite_id ,['class'=>'verify_checkbox','style'=>'border: solid 1px #ddd;padding: 5px;border-radius: 5px;width: 100%','id'=>'ssite'.$key,'required','onchange'=>'updateUserField'.$key.'();']) !!}
                                                                &nbsp;&nbsp;&nbsp;<span style="color: green;padding-top: 5px" id="ssite_id_msg{{$key}}"></span>
                                                                <script>
                                                                    function updateUserField{{$key}}() {
                                                                        var ssite_id = $('#ssite{{$key}} :selected').val();
                                                                        $.get('/admin/update_table_field', {
                                                                            "db": 'users',
                                                                            "id": '{{$user->id}}',
                                                                            "field": 'ssite_id',
                                                                            "value": ssite_id
                                                                        }).done(function(data) {
                                                                            $('#ssite_id_msg{{$key}}').html('狀態更新成功').show();
                                                                        });
                                                                    }
                                                                </script>
                                                            </div>
                                                        </div>
                                                        <!-- 領補換類別 Form select Input -->
                                                        <div class="form-group row">
                                                            <div class="col-sm-3">
                                                                {!! Form::label('applyreason',"領補換類別:",['class'=>'form-control-label']) !!}
                                                            </div>
                                                            <div class="col-sm-9">
                                                                {!! Form::select('applyreason', [''=>'請選擇','初發'=>'初發','補發'=>'補發','換發'=>'換發',] , $user->applyreason ,['class'=>'verify_checkbox','style'=>'border: solid 1px #ddd;padding: 5px;border-radius: 5px;width: 100%','id'=>'applyreason'.$key,'required','onchange'=>'updateUserApplyreasonField'.$key.'();']) !!}
                                                                &nbsp;&nbsp;&nbsp;<span style="color: green;padding-top: 5px" id="applyreason_msg{{$key}}"></span>
                                                                <script>
                                                                    function updateUserApplyreasonField{{$key}}() {
                                                                        var applyreason = $('#applyreason{{$key}} :selected').text();
                                                                        $.get('/admin/update_table_field', {
                                                                            "db": 'users',
                                                                            "id": '{{$user->id}}',
                                                                            "field": 'applyreason',
                                                                            "value": applyreason
                                                                        }).done(function(data) {
                                                                            $('#applyreason_msg{{$key}}').html('狀態更新成功').show();
                                                                        });
                                                                    }
                                                                </script>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>--}}
                                            <td>
                                                {!! $user->created_at !!}
                                                @if($user->created_at != $user->updated_at)
                                                    <br>{!! $user->updated_at !!}
                                                @endif
                                            </td>
                                            <td style="text-align: center;">{!! $user->is_activate==1?'<span style="color: green;font-size: 18px">是</span>':'<span style="color: red;">否</span>' !!}</td>
                                            <td style="text-align: center;">
                                                @if(role('admin') || role('babysitter'))
                                                    <input type="checkbox" class="js-switch" id="status{{$key}}" {{$user->status==1?'checked':''}} />
                                                    <script>
                                                        $(function() {
                                                            $('#status{{$key}}').change(function() {
                                                                console.log('Toggle: ' + $(this).prop('checked'));
                                                                $.get('/admin/ajax_switch', {"value": $(this).prop('checked'),"db":'users',"id":'{{$user->id}}',"field":'status'});
                                                            })
                                                        })
                                                    </script>
                                                @else
                                                    @if($user->status==1)
                                                        <span style="color: green;font-size: 20px;">是</span>
                                                    @else
                                                        <span style="color: red;font-size: 20px;">否</span>
                                                    @endif
                                                @endif
                                            </td>
                                            {{-- <td style="width:30%">{!! nl2br($user->content) !!}</td> --}}
                                            <td style="width:10%">
                                                <div class="float-md-left" style="padding-top: 5px">
                                                    <a href="{{ url('/admin/user/'.$user->id.'/edit?page='.Request('page') ) }}" class="btn btn-success">編輯</a>
                                                </div>
                                                @if(role('admin') || role('babysitter'))
                                                    <div class="float-md-right" style="padding-top: 5px">
                                                        <a href="{{ url('/admin/user/delete/'.$user->id.'?page='.Request('page') ) }}" class="btn btn-danger float-md-right" onclick='return confirm("是否確定要刪除此筆資料?");'>刪除</a>
                                                    </div>
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