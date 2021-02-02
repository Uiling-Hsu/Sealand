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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">經銷商</h5>
                                {{--                                <span>各項參數經銷商</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">經銷商</a></li>
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
                                <span style="display: inline-block;padding-left: 10px">經銷商 列表</span>
                                <a href="{{ url('/admin/partner/create' ) }}" class="btn btn-primary float-md-right">新增 經銷商</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="draggable">
                                    <thead>
                                    <tr>
                                        <th>排序</th>
                                        <th>ID</th>
                                        <th>交車區域</th>
                                        <th>總經銷商</th>
                                        <th>經銷商名稱</th>
                                        <th>Email</th>
                                        <th>狀態</th>
                                        {{--<th>電話/手機/地址/聯絡人</th>--}}
                                        <th>動 作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {!! Form::open(['url' => '/admin/partner/batch_update'])  !!}
                                    @foreach($partners as $key=>$partner)
                                        {!! Form::hidden('partner_id[]',$partner->id) !!}
                                        <tr @if(Request('bid')==$partner->id) {!! tableBgColor() !!} @endif class="data" draggable="true">
                                            <td class="sort">{{$partner->sort}}</td>
                                            <td class="id">{{$partner->id}}</td>
                                            <td style="word-break: break-all;width:15%;font-weight: bold;font-size: 18px;color:purple">
                                                {!! $partner->proarea?$partner->proarea->title:'' !!}<br>
                                            </td>
                                            <td class="id">{{$partner->dealer?$partner->dealer->title:''}}</td>
                                            <td style="word-break: break-all;width:15%;font-weight: bold;font-size: 18px;color:purple">
                                                {!! $partner->title !!}<br>
                                            </td>
                                            <td style="word-break: break-all;width:15%">
                                                {!! $partner->email !!}<br>
                                            </td>
                                            {{--<td style="width: 25%;text-align: left;">
                                                電話: <span style="color: purple;font-weight: bold;"> {{$partner->phone}}</span><br>
                                                手機: <span style="color: purple;font-weight: bold;"> {{$partner->cell_phone}}</span><br>
                                                地址: <span style="color: purple;font-weight: bold;"> {{$partner->address}}</span><br>
                                                聯絡人: <span style="color: purple;font-weight: bold;"> {{$partner->contact_person}}</span>
                                            </td>--}}
                                            {{--<td>
                                                @if($partner->image)
                                                    <div class="hidden-xs hidden-sm hidden-md text-center">
                                                        {{ Html::image($partner->image, $partner->title, ['style'=>'width:250px']) }}
                                                    </div>
                                                @endif
                                            </td>--}}
                                            <td>
                                                <input type="checkbox" class="js-switch" id="status{{$key}}" {{$partner->status==1?'checked':''}} />
                                                <script>
                                                    $(function() {
                                                        $('#status{{$key}}').change(function() {
                                                            console.log('Toggle: ' + $(this).prop('checked'));
                                                            $.get('/admin/ajax_switch', {"value": $(this).prop('checked'),"db":'partners',"id":'{{$partner->id}}',"field":'status'});
                                                        })
                                                    })
                                                </script>
                                            </td>
                                            <td style="width:12%">
                                                <div class="buttons">
                                                    <a href="{{ url('/admin/partner/'.$partner->id.'/edit' ) }}" class="btn btn-success">編輯</a>
                                                    <a href="{{ url('/admin/partner/'.$partner->id.'/delete' ) }}" class="btn btn-danger float-md-right" onclick='return confirm("是否確定要刪除此筆資料?");'>刪除</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {!! Form::close() !!}
                                    </tbody>
                                </table>
                                <div>&nbsp;</div>
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
        document.addEventListener('drop', function(event) {
            var id = document.querySelectorAll('.id');
            var data = [];

            for (var i = 0, len = id.length; i < len; i++) {
                data.push(id[i].innerHTML);
                id[i].parentNode.querySelector('.sort').innerHTML = paddingLeft( i+1, 2 );
            }
            $.get('/admin/ajax_sort', {"data": data,"db":'partners'});
        }, false);

        var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elem.forEach(function(html) {
            var switchery = new Switchery(html, {
                color: 'green',
                jackColor: '#fff'
            });
        });

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
    </script>
@stop