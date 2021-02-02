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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">品牌</h5>
                                {{--                                <span>各項參數品牌編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">品牌</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 600px">
                        <div class="card-header"><h3>品牌 新增</h3></div>
                        <div class="card-body">
                        {!! Form::open(['url' => '/admin/brandcat','enctype'=>'multipart/form-data'])  !!}
                            {!! Form::hidden('cate_id',$cate->id) !!}
                            <!--  Form select Input -->
                            <div class="form-group row">
                                {!! Form::label('cate_id',"方案類別名稱:",['class'=>'col-sm-3 form-control-label']) !!}
                                <div class="col-sm-9">
                                    {{$cate->title}}
                                </div>
                            </div>

                            <!-- title Form text Input -->
                            <div class="form-group row">
                                {!! Form::label('title',"品牌名稱:",['class'=>'col-sm-3 form-control-label']) !!}
                                <div class="col-sm-9">
                                    {!! Form::text('title',null,['class'=>'form-control','required']) !!}
                                    @if($errors->has('title'))
                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                            <i class="fa fa-warning"></i>{{ $errors->first('title') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!--  Form Submit Input -->
                            <div class="form-group" style="text-align:center">
                                {!! Form::submit('新增',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                <a class="btn btn-success" href="{{ url('/admin/brandcat?search_cate_id='.$search_cate_id ) }}">取消及回上一列表</a>
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