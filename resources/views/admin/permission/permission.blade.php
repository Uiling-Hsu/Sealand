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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">權限項目</h5>
                                {{--                                <span>各項參數權限項目</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">權限項目</a></li>
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
                                <span style="display: inline-block;padding-left: 10px">權限項目 列表</span>
                                <a href="{{ url('/admin/permission/create' ) }}" class="btn btn-primary float-md-right">新增 權限項目</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="draggable">
                                    <thead>
                                    <tr>
                                        <th>序號</th>
                                        <th>ID</th>
                                        <th>排序</th>
                                        <th style="text-align:center">權限名稱</th>
                                        <th style="text-align:center">權限中文標題</th>
                                        <th style="text-align:center">權限中文描述</th>
                                        <th>狀態</th>
                                        <th>動 作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Begin Form -->
                                    {!! Form::open(['url' => '/admin/permission/sort']) !!}
                                    @foreach($permissions as $key=>$permission)
                                        {!! Form::hidden('permission_id[]',$permission->id) !!}
                                        <tr @if(Request('bid')==$permission->id) {!! tableBgColor() !!} @endif class="data" draggable="true">
                                            <td style="width:5%;text-align:center">{{ $key+1 }}</td>
                                            <td class="id" style="width:5%;text-align:center">{{ $permission->id }}</td>
                                            <td class="sort">{{$permission->sort}}</td>
                                            <td style="width:15%">{!! $permission->slug !!}</td>
                                            <td style="width:15%">{!! $permission->name !!}</td>
                                            <td style="width:30%">{!! $permission->description !!}</td>
                                            <td style="width: 100px">
                                                <input type="checkbox" class="js-switch" id="status{{$key}}" {{$permission->status==1?'checked':''}} />
                                                <script>
                                                    $(function() {
                                                        $('#status{{$key}}').change(function() {
                                                            console.log('Toggle: ' + $(this).prop('checked'));
                                                            $.get('/admin/ajax_switch', {"value": $(this).prop('checked'),"db":'permissions',"id":'{{$permission->id}}',"field":'status'});
                                                        })
                                                    })
                                                </script>
                                            </td>
                                            <td style="width:15%">
                                                <div class="buttons">
                                                    <a href="{{ url('/admin/permission/'.$permission->id.'/edit' ) }}" class="btn btn-success">編輯</a>
                                                    <a href="{{ url('/admin/permission/delete/'.$permission->id ) }}" class="btn btn-danger float-md-right" onclick='return confirm("是否確定要刪除此筆資料?");'>刪除</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{--@if($permissions->count())
                                        <tr>
                                            <td></td>
                                            <td class="text-center">{!! Form::submit('更新排序',['class'=>'btn btn-primary']) !!}</td>
                                        </tr>
                                    @endif--}}
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
            $.get('/admin/ajax_sort', {"data": data,"db":'permissions'});
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