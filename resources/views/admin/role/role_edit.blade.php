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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">角色管理</h5>
                                {{--                                <span>各項參數角色管理編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">角色管理</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>角色管理 編輯</h3></div>
                        <div class="card-body">
                            {!! Form::model($role,['url' => '/admin/role/'.$role->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}

                                <!-- 角色名稱 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('slug',"角色名稱:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('slug', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('slug'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('slug') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 角色中文標題 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('name',"角色中文標題:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('name', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('name'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 角色中文描述 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('description',"角色中文描述:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('description', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('description'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('description') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php
                                  $permissions=\App\Model\Permission::whereStatus(1)->orderBy('sort')->get();
                                @endphp
                                <!-- BBB Form checkbox Input -->
                                <div class="form-group row">
                                    {!! Form::label('permission_id[]',"角色管理指派:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10" style="font-size:16px">
                                        @if($role->id!=1)
                                            @foreach($permissions as $permission)
                                                {!! Form::checkbox('permission_id[]', $permission->id, in_array($permission->id,$roleid_arr)? 'checked':'' ,['style'=>'width:18px;height:18px;']) !!} {{ $permission->name }} <br>
                                            @endforeach
                                        @else
                                            <span>( 全部功能 )</span>
                                        @endif
                                    </div>
                                </div>

                                <hr>
                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('更新',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-success" href="{{ url('/admin/role?bid='.$role->id ) }}">取消及回上一頁</a>
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