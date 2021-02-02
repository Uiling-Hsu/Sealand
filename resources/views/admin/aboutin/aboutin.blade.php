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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">關於我們</h5>
                                {{--                                <span>各項參數關於我們</span>--}}
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
                    <div class="card">
                        <div class="">
                            <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                <span style="display: inline-block;padding-left: 10px">關於我們 列表</span>
                                <a href="{{ url('/admin/aboutin/create' ) }}" class="btn btn-primary float-md-right">新增 關於我們</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="draggable">
                                    <thead>
                                    <tr>
                                        <th style="text-align:center;width:8%"><span style="display: inline-block">全選{!! Form::checkbox('all_del[]', null, null,['id'=>'chkdelall','class'=>'form-control','style'=>'width: 15px; height: 15px;']) !!}</span> </th>
                                        <th>排序</th>
                                        <th style="text-align: center;">ID</th>
                                        {{--<th>名稱</th>--}}
                                        <th>標題</th>
                                        <th>圖片</th>
                                        {{--<th>發佈日期</th>--}}
                                        <th>狀態</th>
                                        <th>動 作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Begin Form -->
                                    {!! Form::open(['url' => '/admin/aboutin/batch_update']) !!}
                                    {{-- {{ dd($aboutins)}} --}}
                                    @foreach($aboutins as $key=>$aboutin)
                                        {!! Form::hidden('aboutin_id[]',$aboutin->id) !!}
                                        <tr @if(Request('bid')==$aboutin->id) {!! tableBgColor() !!} @endif class="data" draggable="true">
                                            <td style="text-align:center">
                                                {!! Form::checkbox('isdel[]', $aboutin->id, null ) !!} 刪除
                                            </td>
                                            <td class="sort">{{$aboutin->sort}}</td>
                                            <td class="id" style="text-align: center;">{{ $aboutin->id }}</td>
                                            {{--                                                <td>{{ $aboutin->name }}</td>--}}
                                            <td>{{ $aboutin->title_tw }}</td>
                                            <td style="width: 20%;">
                                                @if($aboutin->image)
                                                    {{ Html::image($aboutin->image,null, ['style'=>'width:200px;border-radius: 10px']),[] }}
                                                @endif
                                                @if($aboutin->youtube)
                                                    <div class="video-container">
                                                        <div style="position:relative;height:0;padding-bottom:56.21%">
                                                            {!! $aboutin->youtube !!}
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>
                                            {{--                                                <td>{{ Carbon\Carbon::parse($aboutin->published_at)->format('Y-m-d') }}</td>--}}
                                            <td>
                                                <input type="checkbox" class="js-switch" id="status{{$key}}" {{$aboutin->status==1?'checked':''}} />
                                                <script>
                                                    $(function() {
                                                        $('#status{{$key}}').change(function() {
                                                            console.log('Toggle: ' + $(this).prop('checked'));
                                                            $.get('/admin/ajax_switch', {"value": $(this).prop('checked'),"db":'aboutins',"id":'{{$aboutin->id}}',"field":'status'});
                                                        })
                                                    })
                                                </script>
                                            </td>
                                            <td>
                                                <div class="buttons">
                                                    <a href="{{ url('/admin/aboutin/'.$aboutin->id.'/edit' ) }}" class="btn btn-success">編輯</a>
                                                    <a href="{{ url('/admin/aboutin/delete/'.$aboutin->id ) }}" class="btn btn-danger float-md-right" onclick='return confirm("是否確定要刪除此筆資料?\n請注意！如果刪除此筆資料，此資料下面的所有內容及段落都將一起刪除，請問是否確認要繼續刪除？?");'>刪除</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{--@if($aboutins && $aboutins->count())--}}
                                    {{--<tr>--}}
                                    {{--<td class="text-center">{!! Form::submit('更新排序',['class'=>'btn btn-primary']) !!}</td>--}}
                                    {{--</tr>--}}
                                    {{--@endif--}}
                                    @if($aboutins && $aboutins->count())
                                        <tr>
                                            <td class="text-center">{!! Form::submit('批次刪除',['class'=>'btn btn-danger','onclick'=>'return confirm("是否確定要批次刪除?");']) !!}</td>
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
    {{--    <script src="/back_assets/js/form-advanced.js"></script>--}}
    <script src="/back_assets/js/drable.js"></script>
    <script>

        document.addEventListener('drop', function(event) {
            var id = document.querySelectorAll('.id');
            var data = [];

            for (var i = 0, len = id.length; i < len; i++) {
                data.push(id[i].innerHTML);
                id[i].parentNode.querySelector('.sort').innerHTML = i+1;
            }
            $.get('/admin/ajax_sort', {"data": data,"db":'aboutins'});
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