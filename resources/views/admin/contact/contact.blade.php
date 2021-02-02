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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">聯絡我們</h5>
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
                                <li class="breadcrumb-item"><a href="#">聯絡我們</a></li>
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
                                <span style="display: inline-block;padding-left: 10px">聯絡我們 查詢</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['url' => '/admin/user','method'=>'GET'])  !!}
                                    <div class="form-row">
                                        <div class="col-md-4">
                                            <label for="search_keyword">姓名、Email、手機、市話</label>
                                            {!! Form::text('search_keyword',null,['class'=>'form-control']) !!}
                                        </div>
                                        <div class="form-group col-md-4 text-center">
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
                                <span style="display: inline-block;padding-left: 10px">聯絡我們 列表</span>
{{--                                <a href="{{ url('/admin/user/create' ) }}" class="btn btn-primary float-md-right">新增 聯絡我們</a>--}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr style="font-weight: bold;">
                                        <th style="text-align:center;width:100px">全選 &nbsp;{!! Form::checkbox('all_del[]', null, null,['id'=>'chkdelall','class'=>'form-control','style'=>'width: 15px; height: 15px;display: inline-block']) !!} </th>
                                        {{--<th>排序</th>--}}
                                        <th>ID</th>
                                        <th style="text-align:center">姓名</th>
                                        <th style="text-align:center">Email / 手機</th>
                                        <th style="text-align:center">詢問有關</th>
                                        <th style="text-align:center">訊息 / 回覆</th>
                                        <th>是否回覆</th>
                                        <th style="text-align:center">新增日期</th>
                                        <th>動 作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Begin Form -->
                                    {!! Form::open(['url' => '/admin/contact/batch_update']) !!}
                                    @foreach($contacts as $index=>$contact)
                                        {!! Form::hidden('contact_id[]',$contact->id) !!}
                                        <tr style="{{Request('bid')==$contact->id? tableBgColorNoStyleTag():''}} {{$contact->isread!=1?'font-weight:bold':''}}">
                                            <td style="text-align:center;width: 8%;">
                                                {!! Form::checkbox('isdel[]', $contact->id, null ) !!} 刪除
                                            </td>
                                            {{--<td style="width:10%">{!! Form::text('sort[]', $contact->sort ,['class'=>'form-control','style'=>'width:80px','autocomplete'=>'off']) !!}</td>--}}
                                            <td style="width:5%;text-align:center">{{ $contact->id }}<br>{{$contact->isread==1?'(已讀)':''}}</td>
                                            <td style="width:10%">{!! $contact->name !!}</td>
                                            <td style="width:15%">{!! $contact->email !!}<br>{!! $contact->phone !!}</td>
                                            <td style="width:10%">{!! $contact->contact_demand !!}</td>
                                            <td style="width:25%">
                                                {!! nl2br($contact->message) !!}
                                                @if($contact->reply_message)
                                                    <div style="border-top:solid 1px #999;color:brown">
                                                        回覆:{!! nl2br($contact->reply_message) !!}
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="width:5%">{!! Form::checkbox('isreply', null, $contact->isreply==1? 'true':'' ,['class'=>'form-control','style'=>'width: 20px; height: 20px;','id'=>'isreply', 'disabled'=>'disabled']) !!}</td>
                                            <td style="width:10%">{!! $contact->created_at !!}</td>
                                            <td style="width:15%">
                                                <div class="float-md-left" style="padding-top: 5px">
                                                    <a href="{{ url('/admin/contact/'.$contact->id.'/edit' ) }}" class="btn btn-success">檢視</a>
                                                </div>
                                                <div class="float-md-right" style="padding-top: 5px">
                                                    <a href="{{ url('/admin/contact/delete/'.$contact->id ) }}" class="btn btn-danger float-md-right" onclick='return confirm("是否確定要刪除此筆資料?");'>刪除</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($contacts->count())
                                        <tr>
                                            <td class="text-center">{!! Form::submit('批次刪除',['class'=>'btn btn-danger', "onclick"=>"return confirm('是否確定要刪除此筆資料?');"]) !!}</td>
                                        </tr>
                                    @endif
                                    {!! Form::close() !!}
                                    </tbody>
                                </table>
                                <div>&nbsp;</div>
                                <div class="col-md-12">
                                    {{ $contacts->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4') }}
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
@stop