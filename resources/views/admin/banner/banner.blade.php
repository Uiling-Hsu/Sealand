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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">內頁上方 Banner</h5>
                                {{--                                <span>各項參數內頁上方 Banner</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">內頁上方 Banner</a></li>
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
                                <span style="display: inline-block;padding-left: 10px">內頁上方 Banner 列表</span>
                                @if(getAdminUser()->id==1)
                                    <a href="{{ url('/admin/banner/create' ) }}" class="btn btn-primary float-md-right">新增 內頁上方 Banner</a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
{{--                                        <th style="text-align:center;width:80px"><span style="display: inline-block">全選{!! Form::checkbox('all_del[]', null, null,['id'=>'chkdelall','class'=>'form-control','style'=>'width: 15px; height: 15px;']) !!}</span> </th>--}}
{{--                                        <th>排序</th>--}}
                                        <th>區塊名稱</th>
                                        <th>區塊英文名稱</th>
                                        <th>圖片</th>
                                        {{--<th>連結/按鈕文字</th>--}}
                                        <th>狀態</th>
                                        <th>動 作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    {!! Form::open(['url' => '/admin/banner/batch_update'])  !!}
                                    @foreach($banners as $key=>$banner)
                                        {!! Form::hidden('banner_id[]',$banner->id) !!}
                                        <tr @if(Request('bid')==$banner->id) {!! tableBgColor() !!} @endif >
                                            {{--<td style="text-align:center;width: 100px;">
                                                {!! Form::checkbox('isdel[]', $banner->id, null ) !!} 刪除
                                            </td>--}}
{{--                                            <td>{!! Form::text('sort[]', $banner->sort ,['class'=>'form-control','style'=>'width:100px']) !!}</td>--}}
                                            <td>
                                                {!! $banner->title_tw !!}
                                            </td>
                                            <td>
                                                {!! $banner->title_en !!}
                                            </td>
                                            <td>
                                                @if($banner->image)
                                                    <div class="hidden-xs hidden-sm hidden-md text-center">
                                                        {{ Html::image($banner->image, $banner->title, ['style'=>'width:250px;border-radius: 10px']) }}
                                                    </div>
                                                    {{--<div class="text-center">{{ $banner->image }}</div>--}}
                                                @endif
                                            </td>
                                            {{--<td>--}}
                                            {{--{!! $banner->url !!}<br>--}}
                                            {{--按鈕文字：{!! $banner->btn_title !!}--}}
                                            {{--</td>--}}
                                            <td>
                                                <input type="checkbox" class="js-switch" id="status{{$key}}" {{$banner->status==1?'checked':''}} />
                                                <script>
                                                    $(function() {
                                                        $('#status{{$key}}').change(function() {
                                                            console.log('Toggle: ' + $(this).prop('checked'));
                                                            $.get('/admin/ajax_switch', {"value": $(this).prop('checked'),"db":'banners',"id":'{{$banner->id}}',"field":'status'});
                                                        })
                                                    })
                                                </script>
                                            </td>
                                            <td>
                                                <div class="buttons">
                                                    <a href="{{ url('/admin/banner/'.$banner->id.'/edit' ) }}" class="btn btn-success">編輯</a>
                                                    <a href="{{ url('/admin/banner/'.$banner->id.'/delete' ) }}" class="btn btn-danger float-md-right" onclick='return confirm("是否確定要刪除此筆資料?");'>刪除</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
{{--                                    @if($banners && $banners->count())--}}
{{--                                        <tr>--}}
{{--                                            <td class="text-center" colspan="2">{!! Form::submit('批次刪除及更新排序',['class'=>'btn btn-primary','onclick'=>'return confirm("是否確定要批次刪除及更新排序");']) !!}</td>--}}
{{--                                        </tr>--}}
{{--                                    @endif--}}
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
    <script src="/back_assets/dist/js/theme.min.js"></script>
    {{--    <script src="/back_assets/js/form-advanced.js"></script>--}}
    <script>
        var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elem.forEach(function(html) {
            var switchery = new Switchery(html, {
                color: 'green',
                jackColor: '#fff'
            });
        });
    </script>
@stop