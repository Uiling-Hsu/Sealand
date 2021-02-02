@extends('admin.layouts.adminapp')

@section('extra-css')
    <link rel="stylesheet" href="/back_assets/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css">
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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">FAQ</h5>
                                {{--                                <span>各項參數FAQ編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">FAQ</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>FAQ 編輯</h3></div>
                        <div class="card-body">
                            {!! Form::model($faqin,['url' => '/admin/faqin/'.$faqin->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}

                                <!-- 分類 Form select Input -->
                                <div class="form-group row">
                                    {!! Form::label('faqcat_id',"類別:",['class'=>'col-md-2 form-control-label']) !!}
                                    <div class="col-md-10">
                                        @if($list_faqcats)
                                            {!! Form::select('faqcat_id', $list_faqcats, $faqin->faqcat_id, ['id'=>'search_faqcat_id','class'=>'form-control']) !!}
                                        @else
                                            <label class="label label-danger">尚未有類別可選</label>
                                        @endif
                                    </div>
                                </div>

                                <!-- 標題 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('title_tw',"問題:",['class'=>'col-sm-2 form-control-label']) !!}
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

                                <!-- 簡短說明 Form textarea Input -->
                                <div class="form-group row">
                                    {!! Form::label('descript_tw',"回答:",['class'=>'col-sm-2 form-control-label']) !!}
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
                                    <label for="imgFile" class="col-sm-2 form-control-label">圖片:</label>
                                    <div class="col-sm-10">
                                        {!! Form::file('imgFile',['class'=>'form-control']); !!}<br>
                                        @if($faqin->image)
                                            <div id="delete_image_block">
                                                {{ Html::image($faqin->image,null,['style'=>'width:200px']) }}&nbsp;&nbsp;&nbsp;
                                                <a href="javascript:void(0)" style="display: inline-block;color: red;border:solid 1px red;padding: 2px 8px" id="remove_image_btn"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                <script>
                                                    $(function() {
                                                        $('#remove_image_btn').click(function() {
                                                            if(confirm('是否確定要刪除此圖片？')) {
                                                                $.get('/admin/ajax_remove_image', {
                                                                    "db": 'faqins',
                                                                    "id": '{{$faqin->id}}',
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

                                <hr>
                                <!-- Youtube 連結 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('youtube',"Youtube 連結:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('youtube', null,['class'=>'form-control', 'rows'=>'5']) !!}
                                        @if($faqin->youtube)
                                            <div>&nbsp;</div>
                                            <div class="video-container">
                                                {!! $faqin->youtube !!}
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
                                    <a class="btn btn-success" href="{{ url('/admin/faqin?search_faqcat_id='.$faqin->faqcat_id.'&bid='.$faqin->id ) }}"> 取消儲存及回主列表</a>
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