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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">關於我們</h5>
                                {{--                                <span>各項參數關於我們編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">關於我們</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>關於我們 編輯</h3></div>
                        <div class="card-body">
                            {!! Form::model($aboutin,['url' => '/admin/aboutin/'.$aboutin->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}

                                <!-- 標題 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('title_tw',"標題:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('title_tw', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('title_tw'))
                                                <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('title_tw') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 內容1 Form textarea Input -->
                                <div class="form-group row">
                                    {!! Form::label('descript_tw',"內容:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('descript_tw', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('descript_tw'))
                                                <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('descript_tw') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 圖片 Form radio Input -->
                                <div class="form-group row">
                                    <label for="imgFile1" class="col-sm-2 form-control-label">圖片:</label>
                                    <div class="col-sm-10">
                                        {!! Form::file('imgFile1',['class'=>'form-control']); !!}<br>
                                        @if($aboutin->image)
                                            <span>{{ Html::image($aboutin->image,null,['class'=>'img-responsive','style'=>'width:300px;border-radius: 10px']) }}</span>
                                            <div style='padding-top:15px;width:500px;text-align:center'>
                                                <a href="{{ url('/admin/aboutin/del_img/'.$aboutin->id ) }}" class="btn btn-danger" onclick='return confirm("是否確定要刪除此圖片?");'>刪除此圖</a>
                                            </div>
                                        @endif
                                    </div>
                                    {!! Form::hidden('image',null) !!}
                                </div>
                                <hr>

                                <!-- Youtube 連結 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('youtube',"Youtube 連結:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-6">
                                        {!! Form::textarea('youtube', null,['class'=>'form-control', 'rows'=>'5']) !!}
                                        @if($aboutin->youtube)
                                            <div>&nbsp;</div>
                                            <div class="video-container">
                                                {!! $aboutin->youtube !!}
                                            </div>
                                        @endif
                                        @if($errors->has('youtube'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('youtube') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div style="font-size: 15px;color: red;padding: 5px 0 20px 0">(請注意：圖片及Youtube請擇一輸入)</div>
                                <hr>

                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('更新',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-success" href="{{ url('/admin/aboutin?bid='.$aboutin->id ) }}"> 取消儲存及回主列表</a>
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