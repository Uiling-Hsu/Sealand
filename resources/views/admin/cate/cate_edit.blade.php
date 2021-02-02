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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">方案類別</h5>
                                {{--                                <span>各項參數方案類別編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">方案類別</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>方案類別 編輯</h3></div>
                        <div class="card-body">
                            {!! Form::model($cate,['url' => '/admin/cate/'.$cate->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}

                                <!-- title Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('title',"標題:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('title',null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('title'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('title') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- title Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('slug',"匯入代碼(A、B、C...):",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('slug',null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('slug'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('slug') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- title Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('deposit',"保證金(元):",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('deposit',null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('deposit'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('deposit') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- title Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('basic_fee',"月租基本費(元):",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('basic_fee',null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('basic_fee'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('basic_fee') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- title Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('mile_fee',"每公里費用(元):",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('mile_fee',null,['step'=>'any','class'=>'form-control','required']) !!}
                                        @if($errors->has('mile_fee'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('mile_fee') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- title Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('mile_pre_month',"每月基本里程數(公里):",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('mile_pre_month',1000,['class'=>'form-control','required']) !!}
                                        @if($errors->has('mile_pre_month'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('mile_pre_month') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 圖片 Form image Input -->
                                <div class="form-group row">
                                    {!! Form::label('imgFile',"圖片(桌機)：",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::file('imgFile',['class'=>'form-control']); !!}<br>
                                        @if($cate->image)
                                            <div id="delete_image_block">
                                                {{ Html::image($cate->image,null,['style'=>'width:200px']) }}&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" style="display: inline-block;color: red;border:solid 1px red;padding: 2px 8px" id="remove_image_btn"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                <script>
                                                    $(function() {
                                                        $('#remove_image_btn').click(function() {
                                                            if(confirm('是否確定要刪除此圖片？')) {
                                                                $.get('/admin/ajax_remove_image', {
                                                                    "db": 'cates',
                                                                    "id": '{{$cate->id}}',
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
                                    {!! Form::hidden('image_name',null) !!}
                                </div>

                                <!-- 圖片 Form image Input -->
                                <div class="form-group row">
                                    {!! Form::label('imgFile_xs',"圖片(手機)：",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::file('imgFile_xs',['class'=>'form-control']); !!}<br>
                                        @if($cate->image)
                                            <div id="delete_image_xs_block">
                                                {{ Html::image($cate->image_xs,null,['style'=>'width:200px']) }}&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" style="display: inline-block;color: red;border:solid 1px red;padding: 2px 8px" id="remove_image_xs_btn"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                <script>
                                                    $(function() {
                                                        $('#remove_image_xs_btn').click(function() {
                                                            if(confirm('是否確定要刪除此圖片？')) {
                                                                $.get('/admin/ajax_remove_image', {
                                                                    "db": 'cates',
                                                                    "id": '{{$cate->id}}',
                                                                    "field": 'image_xs'
                                                                });
                                                                $('#delete_image_xs_block').fadeOut(1000, function() { $(this).remove(); });
                                                            }
                                                        })
                                                    })
                                                </script>
                                            </div>
                                        @endif
                                    </div>
                                    {!! Form::hidden('image_xs_name',null) !!}
                                </div>

                                <!-- 圖片 Form image Input -->
                                <div class="form-group row">
                                    {!! Form::label('imgFile_temp',"圖片(訂閱頁面)：",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::file('imgFile_temp',['class'=>'form-control']); !!}<br>
                                        @if($cate->image)
                                            <div id="delete_image_temp_block">
                                                {{ Html::image($cate->image_temp,null,['style'=>'width:200px']) }}&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" style="display: inline-block;color: red;border:solid 1px red;padding: 2px 8px" id="remove_image_temp_btn"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                <script>
                                                    $(function() {
                                                        $('#remove_image_temp_btn').click(function() {
                                                            if(confirm('是否確定要刪除此圖片？')) {
                                                                $.get('/admin/ajax_remove_image', {
                                                                    "db": 'cates',
                                                                    "id": '{{$cate->id}}',
                                                                    "field": 'image_temp'
                                                                });
                                                                $('#delete_image_temp_block').fadeOut(1000, function() { $(this).remove(); });
                                                            }
                                                        })
                                                    })
                                                </script>
                                            </div>
                                        @endif
                                    </div>
                                    {!! Form::hidden('image_temp_name',null) !!}
                                </div>

                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('更新',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-success" href="{{ url('/admin/cate?bid='.$cate->id ) }}">取消及回上一列表</a>
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