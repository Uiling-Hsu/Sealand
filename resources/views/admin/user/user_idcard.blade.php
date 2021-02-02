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
    <link rel="stylesheet" href="/css/jquery-ui-1.9.2.css" type="text/css" charset="utf-8" />

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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">會員管理</h5>
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
                                <li class="breadcrumb-item"><a href="#">會員管理</a></li>
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
                                <span style="display: inline-block;padding-left: 10px">會員身份證件</span>
                            </div>
                        </div>
                        <div style="padding: 20px 50px">
                            <a href="#" class="btn btn-info" onclick="window.history.go(-1); return false;" style="max-width: 100px">回上一頁</a>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-row">
                                        <div class="col-md-12" style="padding-top: 10px">
                                            @if($user->idcard_image01)
                                                <a href="/admin/user/idcard_image01/{{$user->idcard_image01}}" target="_blank">{{ Html::image('/admin/user/idcard_image01/'.$user->idcard_image01,null, ['style'=>'max-width:700px;padding:2px']),[] }}</a>
                                            @endif
                                            @if($user->idcard_image02)
                                                <a href="/admin/user/idcard_image02/{{$user->idcard_image02}}" target="_blank">{{ Html::image('/admin/user/idcard_image02/'.$user->idcard_image02,null, ['style'=>'max-width:700px;padding:2px']),[] }}</a>
                                            @endif
                                            @if($user->driver_image01)
                                                <hr><a href="/admin/user/driver_image01/{{$user->driver_image01}}" target="_blank">{{ Html::image('/admin/user/driver_image01/'.$user->driver_image01,null, ['style'=>'max-width:700px;padding:2px']),[] }}</a>
                                            @endif
                                            @if($user->driver_image02)
                                                <a href="/admin/user/driver_image02/{{$user->driver_image02}}" target="_blank">{{ Html::image('/admin/user/driver_image02/'.$user->driver_image02,null, ['style'=>'max-width:700px;padding:2px']),[] }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 20px 50px">
                            <a href="#" class="btn btn-info" onclick="window.history.go(-1); return false;" style="max-width: 100px">回上一頁</a>
                        </div>
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

@stop