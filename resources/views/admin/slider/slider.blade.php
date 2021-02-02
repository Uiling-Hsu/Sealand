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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">首頁輪播</h5>
                                {{--                                <span>各項參數首頁輪播</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">首頁輪播</a></li>
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
                                <span style="display: inline-block;padding-left: 10px">首頁輪播 列表</span>
                                <a href="{{ url('/admin/slider/create' ) }}" class="btn btn-primary float-md-right">新增 首頁輪播</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="draggable">
                                    <thead>
                                    <tr>
                                        <th style="text-align:center;width:80px"><span style="display: inline-block">全選{!! Form::checkbox('all_del[]', null, null,['id'=>'chkdelall','class'=>'form-control','style'=>'width: 15px; height: 15px;']) !!}</span> </th>
                                        <th>排序</th>
                                        <th>ID</th>
                                        <th>圖片(桌機)</th>
                                        <th>圖片(手機)</th>
{{--                                        <th>標題 / 文字</th>--}}
                                        <th>連結</th>
                                        <th>狀態</th>
                                        <th>動 作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {!! Form::open(['url' => '/admin/slider/batch_update'])  !!}
                                        @foreach($sliders as $key=>$slider)
                                            {!! Form::hidden('slider_id[]',$slider->id) !!}
                                            <tr @if(Request('bid')==$slider->id) {!! tableBgColor() !!} @endif class="data" draggable="true">
                                                <td style="text-align:center;width: 100px;">
                                                    {!! Form::checkbox('isdel[]', $slider->id, null ) !!} 刪除
                                                </td>
                                                <td class="sort">{{$slider->sort}}</td>
                                                <td class="id">{{$slider->id}}</td>
                                                <td>
                                                    @if($slider->image)
                                                        <div class="hidden-xs hidden-sm hidden-md text-center">
                                                            {{ Html::image($slider->image, $slider->title, ['style'=>'width:200px']) }}
                                                        </div>
                                                        {{--<div class="text-center">{{ $slider->image }}</div>--}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($slider->image_xs)
                                                        <div class="hidden-xs hidden-sm hidden-md text-center">
                                                            {{ Html::image($slider->image_xs, $slider->title, ['style'=>'width:100px']) }}
                                                        </div>
                                                        {{--<div class="text-center">{{ $slider->image }}</div>--}}
                                                    @endif
                                                </td>
                                                {{--<td>
                                                    {!! $slider->title_tw !!}<br><br>
                                                    {!! $slider->descript_tw !!}
                                                </td>--}}
{{--                                                <td>{!! $slider->btn_title_tw !!}<br>{!! $slider->url !!}</td>--}}
                                                <td>{!! $slider->url !!}</td>
                                                <td>
                                                    <input type="checkbox" class="js-switch" id="status{{$key}}" {{$slider->status==1?'checked':''}} />
                                                    <script>
                                                        $(function() {
                                                            $('#status{{$key}}').change(function() {
                                                                console.log('Toggle: ' + $(this).prop('checked'));
                                                                $.get('/admin/ajax_switch', {"value": $(this).prop('checked'),"db":'sliders',"id":'{{$slider->id}}',"field":'status'});
                                                            })
                                                        })
                                                    </script>
                                                </td>
                                                <td style="text-align: left;padding: 10px">
                                                    <div class="float-md-left" style="padding-top: 5px">
                                                        <a href="{{ url('/admin/slider/'.$slider->id.'/edit' ) }}" class="btn btn-success">編輯</a>
                                                    </div>
                                                    <div class="float-md-right" style="padding-top: 5px">
                                                        <a href="{{ url('/admin/slider/'.$slider->id.'/delete' ) }}" class="btn btn-danger " onclick='return confirm("是否確定要刪除此筆資料?");'>刪除</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if($sliders && $sliders->count())
                                            <tr>
                                                <td class="text-center">{!! Form::submit('批次刪除',['class'=>'btn btn-danger','onclick'=>'return confirm("是否確定要批次刪除");']) !!}</td>
                                            </tr>
                                        @endif
                                    {!! Form::close() !!}
                                    </tbody>
                                </table>
                                <div>&nbsp;</div>
                                <div class="col-md-12">
                                    {{ $sliders->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4') }}
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
        document.addEventListener('drop', function(event) {
            var id = document.querySelectorAll('.id');
            var data = [];

            for (var i = 0, len = id.length; i < len; i++) {
                data.push(id[i].innerHTML);
                id[i].parentNode.querySelector('.sort').innerHTML = i+1;
            }
            $.get('/admin/ajax_sort', {"data": data,"db":'sliders'});
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