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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">前台輪播</h5>
                                {{--                                <span>各項參數前台輪播編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">前台輪播</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>前台輪播 編輯</h3></div>
                        <div class="card-body">
                        {!! Form::model($slider,['url' => '/admin/slider/'.$slider->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}

                            <!-- image Form text Input -->
                            <div class="form-group row">
                                <label for="imgFile" class="col-sm-2 form-control-label">圖片:(1920x1150)</label>
                                <div class="col-sm-10">
                                    {!! Form::file('imgFile',['class'=>'form-control']); !!}<br>
                                    @if($slider->image)
                                        <div id="delete_image_block">
                                            {{ Html::image($slider->image,null,['style'=>'width:200px']) }}&nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" style="display: inline-block;color: red;border:solid 1px red;padding: 2px 8px" id="remove_image_btn"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            <script>
                                                $(function() {
                                                    $('#remove_image_btn').click(function() {
                                                        if(confirm('是否確定要刪除此圖片？')) {
                                                            $.get('/admin/ajax_remove_image', {
                                                                "db": 'sliders',
                                                                "id": '{{$slider->id}}',
                                                                "field": 'image'
                                                            });
                                                            $('#delete_image_block').fadeOut(1000, function() { $(this).remove(); });
                                                        }
                                                    })
                                                })
                                            </script>
                                        </div>
                                    @endif
                                </div>
                                {!! Form::hidden('image',null) !!}
                            </div>

                            <!-- image Form text Input -->
                            <div class="form-group row">
                                <label for="imgFile_xs" class="col-sm-2 form-control-label">圖片(手機):(630 x 1150)</label>
                                <div class="col-sm-10">
                                    {!! Form::file('imgFile_xs',['class'=>'form-control']); !!}<br>
                                    @if($slider->image_xs)
                                        <div id="delete_image_block_xs">
                                            {{ Html::image($slider->image_xs,null,['style'=>'width:200px']) }}&nbsp;&nbsp;&nbsp;
                                            <a href="javascript:void(0)" style="display: inline-block;color: red;border:solid 1px red;padding: 2px 8px" id="remove_image_btn_xs"><i class="fa fa-times" aria-hidden="true"></i></a>
                                            <script>
                                                $(function() {
                                                    $('#remove_image_btn_xs').click(function() {
                                                        if(confirm('是否確定要刪除此圖片？')) {
                                                            $.get('/admin/ajax_remove_image', {
                                                                "db": 'sliders',
                                                                "id": '{{$slider->id}}',
                                                                "field": 'image_xs'
                                                            });
                                                            $('#delete_image_block_xs').fadeOut(1000, function() { $(this).remove(); });
                                                        }
                                                    })
                                                })
                                            </script>
                                        </div>
                                    @endif
                                </div>
                                {!! Form::hidden('image',null) !!}
                            </div>


                            <!-- 連結 Form text Input -->
                            {{--<div class="form-group row">
                                {!! Form::label('btn_title_tw',"按鈕文字:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('btn_title_tw',null,['class'=>'form-control']) !!}
                                    @if($errors->has('btn_title_tw'))
                                        <div style="padding: 5px;color: red;">
                                            <i class="fa fa-warning"></i>{{ $errors->first('btn_title_tw') }}
                                        </div>
                                    @endif
                                </div>
                            </div>--}}

                            <!-- 連結 Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('url',"連結:",['class'=>'col-sm-2 form-control-label']) !!}
                                <div class="col-sm-10">
                                    {!! Form::text('url',null,['class'=>'form-control']) !!}
                                    @if($errors->has('url'))
                                        <div style="padding: 5px;color: red;">
                                            <i class="fa fa-warning"></i>{{ $errors->first('url') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!--  Form Submit Input -->
                            <div class="form-group" style="text-align:center">
                                {!! Form::submit('更新',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                <a class="btn btn-success" href="{{ url('/admin/slider?bid='.$slider->id ) }}">取消及回上一列表</a>
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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="/back_assets/src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="/back_assets/plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="/back_assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/back_assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="/back_assets/dist/js/theme.min.js"></script>
    {{--    <script src="/back_assets/js/form-components.js"></script>--}}
@stop