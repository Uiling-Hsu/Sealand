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
    <script src="/back_assets/plugins/mohithg-switchery/dist/switchery.min.js"></script>
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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">最新消息</h5>
                                {{--                                <span>各項參數最新消息</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">最新消息</a></li>
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
                                <span style="display: inline-block;padding-left: 10px">最新消息 列表</span>
                                <a href="{{ url('/admin/hotin/create' ) }}" class="btn btn-primary float-md-right">新增 最新消息</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="text-align:center;width:80px"><span style="display: inline-block">全選{!! Form::checkbox('all_del[]', null, null,['id'=>'chkdelall','class'=>'form-control','style'=>'width: 15px; height: 15px;']) !!}</span> </th>
                                        {{--<th>排序</th>--}}
                                        <th style="text-align: center;">ID</th>
                                        <th>標題</th>
                                        <th>圖片/Youtube影片</th>
                                        <th>發佈日期</th>
                                        <th>狀態</th>
                                        <th>動 作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Begin Form -->
                                    {!! Form::open(['url' => '/admin/hotin/batch_update']) !!}
                                    {{-- {{ dd($hotins)}} --}}
                                    @foreach($hotins as $key=>$hotin)
                                        {!! Form::hidden('hotin_id[]',$hotin->id) !!}
                                        <tr @if(Request('bid')==$hotin->id) {!! tableBgColor() !!} @endif >
                                            <td style="text-align:center;width: 6%;">
                                                {!! Form::checkbox('isdel[]', $hotin->id, null ) !!} 刪除
                                            </td>
                                            {{--                                                <td style="width:10%">{!! Form::text('sort[]', $hotin->sort ,['class'=>'form-control','style'=>'width:80px','autocomplete'=>'off']) !!}</td>--}}
                                            <td style="text-align: center;">{{ $hotin->id }}</td>
                                            <td>{{ $hotin->title_tw }}</td>
                                            <td>
                                                @if($hotin->image)
                                                    <div class="hidden-xs hidden-sm hidden-md text-center">
                                                        {{ Html::image( $hotin->image, $hotin->title, ['style'=>'width:300px;border-radius: 10px']) }}
                                                    </div>
                                                @endif
                                                @if($hotin->youtube)
                                                    <div>&nbsp;</div>
                                                    <div class="video-container">
                                                        {!! $hotin->youtube !!}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>{{ Carbon\Carbon::parse($hotin->published_at)->format('Y-m-d') }}</td>
                                            <td>
                                                <input type="checkbox" class="js-switch" id="status{{$key}}" {{$hotin->status==1?'checked':''}} />
                                                <script>
                                                    $(function() {
                                                        $('#status{{$key}}').change(function() {
                                                            console.log('Toggle: ' + $(this).prop('checked'));
                                                            $.get('/admin/ajax_switch', {"value": $(this).prop('checked'),"db":'hotins',"id":'{{$hotin->id}}',"field":'status'});
                                                        })
                                                    })
                                                </script>
                                            </td>
                                            <td>
                                                <div class="buttons">
                                                    <a href="{{ url('/admin/hotin/'.$hotin->id.'/edit' ) }}" class="btn btn-success">編輯</a>
                                                    <a href="{{ url('/admin/hotin/delete/'.$hotin->id ) }}" class="btn btn-danger float-md-right" onclick='return confirm("是否確定要刪除此筆資料?\n請注意！如果刪除此筆資料，此資料下面的所有內容及段落都將一起刪除，請問是否確認要繼續刪除？?");'>刪除</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{--@if($hotins && $hotins->count())--}}
                                    {{--<tr>--}}
                                    {{--<td class="text-center">{!! Form::submit('更新排序',['class'=>'btn btn-primary']) !!}</td>--}}
                                    {{--</tr>--}}
                                    {{--@endif--}}
                                    @if($hotins && $hotins->count())
                                        <tr>
                                            <td class="text-center" colspan="2">{!! Form::submit('批次刪除及更新排序',['class'=>'btn btn-primary','onclick'=>'return confirm("是否確定要批次刪除及更新排序");']) !!}</td>
                                        </tr>
                                    @endif
                                    {!! Form::close() !!}
                                    </tbody>
                                </table>
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

        var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elem.forEach(function(html) {
            var switchery = new Switchery(html, {
                color: 'green',
                jackColor: '#fff'
            });
        });
    </script>
@stop