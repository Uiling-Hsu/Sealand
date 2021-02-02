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
                        <div class="card-header"><h3>最新消息 編輯</h3></div>
                        <div class="card-body">
                            {!! Form::model($hotin,['url' => '/admin/hotin/'.$hotin->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}

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
                                        @if($hotin->image)
                                            {{ Html::image($hotin->image,null, ['style'=>'width:500px;border-radius: 10px']),[] }}
                                            <div style="padding-top:15px;width:500px;text-align:center">
                                                <a href="{{ url('/admin/hotin/del_img/'.$hotin->id ) }}" class="btn btn-danger" onclick='return confirm("是否確定要刪除此圖片?");'>刪除此圖</a>
                                            </div>
                                        @endif
                                    </div>
                                    {!! Form::hidden('image_name',null) !!}
                                </div>

                                <hr>
                                <!-- Youtube 連結 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('youtube',"Youtube 連結:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('youtube', null,['class'=>'form-control', 'rows'=>'5']) !!}
                                        @if($hotin->youtube)
                                            <div>&nbsp;</div>
                                            <div class="video-container">
                                                {!! $hotin->youtube !!}
                                            </div>
                                        @endif
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
                                        {!! Form::text('published_at', date_format(date_create($hotin->published_at),"Y-m-d"),['class'=>'form-control','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd'})"]); !!}
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
                                    {!! Form::submit('更新',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-info" href="{{ url('/admin/hotin?bid='.$hotin->id ) }}"> 取消及回上一列表</a>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div style="color: red;">&nbsp;&nbsp;&nbsp;(請注意：以下還有最新消息明細)</div>
            <hr class="style_one">
            <a name="list"></a>
            <div class="row">
                <div class="col-md-12" style="max-width: 1200px">
                    <div class="card">
                        <div class="">
                            <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                <span style="display: inline-block;padding-left: 10px">最新消息段落 列表:</span>
                                <a href="{{ url('/admin/hotin2/create/'.$hotin->id ) }}" class="btn btn-primary float-md-right">新增 段落</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="draggable">
                                    <thead>
                                    <tr>
                                        <th>序號</th>
                                        <th>排序</th>
                                        <th>ID</th>
                                        <th style="text-align:center">圖片 / 影片</th>
                                        <th style="text-align:center">標 題</th>
                                        {{-- <th style="text-align:center">內 容</th> --}}
                                        <th>動 作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Begin Form -->
                                    {!! Form::open(['url' => '/admin/hotin2/sort']) !!}
                                    {!! Form::hidden('hotin_id',$hotin->id) !!}
                                    @foreach($hotin2s as $key=>$hotin2)
                                        {!! Form::hidden('hotin2_id[]',$hotin2->id) !!}
                                        <tr @if(Request('bid')==$hotin2->id) {!! tableBgColor() !!} @endif class="data" draggable="true">
                                            <td style="text-align:center">{{ $key+1 }}</td>
                                            <td class="sort">{{$hotin2->sort}}</td>
                                            <td class="id">{{$hotin2->id}}</td>
                                            <td style="width:10%">
                                                @if($hotin2->image)
                                                    <div class="hidden-xs hidden-sm hidden-md text-center">
                                                        {{ Html::image( $hotin2->image, $hotin2->title, ['style'=>'width:300px;border-radius: 10px']) }}
                                                    </div>
                                                @endif
                                                @if($hotin2->youtube)
                                                    <div>&nbsp;</div>
                                                    <div class="video-container">
                                                        {!! $hotin2->youtube !!}
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="text-align: left;">{!! nl2br($hotin2->title_tw) !!}</td>
                                            {{-- <td style="width:30%">{!! nl2br($hotin2->content) !!}</td> --}}
                                            <td>
                                                <div class="buttons">
                                                    <a href="{{ url('/admin/hotin2/'.$hotin2->id.'/edit' ) }}" class="btn btn-success">編輯</a>
                                                    <a href="{{ url('/admin/hotin2/delete/'.$hotin2->id ) }}" class="btn btn-danger float-md-right" onclick='return confirm("是否確定要刪除此筆資料?");'>刪除</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($hotin2s->count())
                                        <tr>
                                            <td></td>
                                            <td class="text-center">{!! Form::submit('更新排序',['class'=>'btn btn-primary']) !!}</td>
                                        </tr>
                                    @endif
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
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="/back_assets/src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="/back_assets/plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="/back_assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/back_assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="/back_assets/dist/js/theme.min.js"></script>
    {{--    <script src="/back_assets/js/form-components.js"></script>--}}
    <script src="/back_assets/js/drable.js"></script>
    <script>

        document.addEventListener('drop', function(event) {
            var id = document.querySelectorAll('.id');
            var data = [];

            for (var i = 0, len = id.length; i < len; i++) {
                data.push(id[i].innerHTML);
                id[i].parentNode.querySelector('.sort').innerHTML = i+1;
            }
            $.get('/admin/ajax_sort', {"data": data,"db":'hotin2s'});
        }, false);

        var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elem.forEach(function(html) {
            var switchery = new Switchery(html, {
                color: 'green',
                jackColor: '#fff'
            });
        });
    </script>
@stop