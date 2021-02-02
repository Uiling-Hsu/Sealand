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
                        <div class="card-header"><h3>前台輪播 新增</h3></div>
                        <div class="card-body">
                            {!! Form::open(['url' => '/admin/slider','enctype'=>'multipart/form-data'])  !!}

                                <!-- title Form text Input -->
                                <div class="form-group row">
                                    <label for="imgFile" class="col-sm-3 form-control-label">圖片:(1920x1150)</label>
                                    <div class="col-sm-9">
                                        {!! Form::file('imgFile',['class'=>'form-control']); !!}<br>
                                    </div>
                                </div>

                                <!-- image Form text Input -->
                                <div class="form-group row">
                                    <label for="imgFile" class="col-sm-3 form-control-label">圖片(手機):(630 x 1150)</label>
                                    <div class="col-sm-9">
                                        {!! Form::file('imgFile_xs',['class'=>'form-control']); !!}<br>
                                    </div>
                                </div>


                                <!-- 連結 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('url',"連結:",['class'=>'col-sm-3 form-control-label']) !!}
                                    <div class="col-sm-9">
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
                                    {!! Form::submit('新增',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-success" href="{{ url('/admin/slider' ) }}">取消及回上一列表</a>
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