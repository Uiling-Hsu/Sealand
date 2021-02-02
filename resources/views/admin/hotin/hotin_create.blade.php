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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">最新消息</h5>
                                {{--                                <span>各項參數最新消息編輯</span>--}}
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
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>最新消息 新增</h3></div>
                        <div class="card-body">
                            {!! Form::open(['url' => '/admin/hotin','enctype'=>'multipart/form-data'])  !!}

                                <!-- 標題 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('title_tw',"標題:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('title_tw', null,['class'=>'form-control']) !!}
                                        @if($errors->has('title_tw'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('title_tw') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 簡短說明 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('descript_tw',"簡短說明:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('descript_tw', null,['class'=>'form-control']) !!}
                                        @if($errors->has('descript_tw'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('descript_tw') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 圖片 Form image Input -->
                                <div class="form-group row">
                                    {!! Form::label('imgFile',"圖片：",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::file('imgFile',['class'=>'form-control']); !!}<br>
                                    </div>
                                </div>

                                <hr>
                                <!-- Youtube 連結 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('youtube',"Youtube 連結:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-4">
                                        {!! Form::textarea('youtube', null,['class'=>'form-control', 'rows'=>'5']) !!}
                                    </div>
                                </div>
                                <div style="font-size: 15px;color: red;padding: 5px 0 20px 0">(請注意：圖片及Youtube請擇一輸入)</div>

                                <div class="form-group row">
                                    {!! Form::label('quote',"引用:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('quote',null,['class'=>'form-control']) !!}
                                        @if($errors->has('quote'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('quote') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {!! Form::label('quote_url',"引用網址:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('quote_url',null,['class'=>'form-control']) !!}
                                        @if($errors->has('quote_url'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('quote_url') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {!! Form::label('published_at',"發佈日期:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('published_at', date("Y-m-d"),['class'=>'form-control','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd'})"]); !!}
                                        @if($errors->has('published_at'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('published_at') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <hr>

                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('新增',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-success" href="{{ url('/admin/hotin' ) }}">取消及回上一列表</a>
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