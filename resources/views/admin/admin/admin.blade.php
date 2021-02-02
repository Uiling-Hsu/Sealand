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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">後台管理帳號</h5>
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
                                <li class="breadcrumb-item"><a href="#">後台管理帳號</a></li>
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
                                <span style="display: inline-block;padding-left: 10px">後台管理帳號 編輯</span>
                                <a href="{{ url('/admin/admin/create' ) }}" class="btn btn-primary float-md-right">新增 後台管理帳號</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th style="text-align:center">ID</th>
                                        <th style="text-align:center">Email</th>
                                        <th style="text-align:center">姓名</th>
                                        <th style="text-align:center">所屬角色</th>
                                        <th style="text-align:center">所屬經銷商</th>
                                        <th>狀態</th>
                                        <th>動 作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Begin Form -->
                                    {!! Form::open(['url' => '/admin/admin/sort']) !!}
                                    @foreach($admins as $key=>$admin)
                                        @if(($admin->id==1 && getAdminUser()->id==1) || $admin->id!=1)
                                            {!! Form::hidden('admin_id[]',$admin->id) !!}
                                            <tr @if(Request('bid')==$admin->id) {!! tableBgColor() !!} @endif >
                                                <td style="width:5%;text-align:center">{{ $admin->id }}</td>
                                                <td style="width:15%">{!! $admin->email !!}</td>
                                                <td style="width:10%">{!! $admin->name !!}</td>
                                                <td style="width:10%">
                                                    {{--@if($admin->id==2)--}}
                                                    {{--( 全部功能角色 )--}}
                                                    {{--@else--}}
                                                    @forelse($admin->roles as $key=>$role)
                                                        <i class="mdi mdi-checkbox-marked mdi-18px"></i> {{$role->name}}<br>
                                                    @empty
                                                    @endforelse
                                                    {{--@endif--}}
                                                </td>
                                                <td style="width:10%">
                                                    {{$admin->partner?$admin->partner->title:''}}
                                                </td>
                                                <td style="width: 8%">
                                                    <input type="checkbox" class="js-switch" id="status{{$key}}" {{$admin->status==1?'checked':''}} />
                                                    <script>
                                                        $(function() {
                                                            $('#status{{$key}}').change(function() {
                                                                console.log('Toggle: ' + $(this).prop('checked'));
                                                                $.get('/admin/ajax_switch', {"value": $(this).prop('checked'),"db":'admins',"id":'{{$admin->id}}',"field":'status'});
                                                            })
                                                        })
                                                    </script>
                                                </td>
                                                <td style="width:15%">
                                                    <div class="buttons">
                                                        <a href="{{ url('/admin/admin/'.$admin->id.'/edit' ) }}" class="btn btn-success">編輯</a>
                                                        <a href="{{ url('/admin/admin/'.$admin->id.'/password' ) }}" class="btn btn-info" style="font-size:13px">密碼變更</a>
                                                        <a href="{{ url('/admin/admin/'.$admin->id.'/delete' ) }}" class="btn btn-danger float-md-right" onclick='return confirm("是否確定要刪除此筆資料?");'>刪除</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    {{--@if($admins->count())
                                        <tr>
                                            <td></td>
                                            <td class="text-center">{!! Form::submit('更新排序',['class'=>'btn btn-primary']) !!}</td>
                                        </tr>
                                    @endif--}}
                                    {!! Form::close() !!}
                                    </tbody>
                                </table>
                                <div>&nbsp;</div>
                                <div class="col-md-12">
                                    {{ $admins->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4') }}
                                </div>
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
        // document.addEventListener('drop', function(event) {
        //     var id = document.querySelectorAll('.id');
        //     var data = [];
        //
        //     for (var i = 0, len = id.length; i < len; i++) {
        //         data.push(id[i].innerHTML);
        //         id[i].parentNode.querySelector('.sort').innerHTML = i+1;
        //     }
        //     $.get('/admin/ajax_sort', {"data": data,"db":'sliders'});
        // }, false);

        var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elem.forEach(function(html) {
            var switchery = new Switchery(html, {
                color: 'green',
                jackColor: '#fff'
            });
        });
    </script>
@stop