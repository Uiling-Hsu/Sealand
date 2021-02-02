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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">後台管理帳號</h5>
                                {{--                                <span>各項參數後台管理帳號編輯</span>--}}
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
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>後台管理帳號 編輯</h3></div>
                        <div class="card-body">
                        {!! Form::model($admin,['url' => '/admin/admin/'.$admin->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}
                            {!! Form::hidden('flag','edit') !!}

                                <!-- 所屬經銷商 Form select Input -->
                                <div class="form-group row">
                                    {!! Form::label('partner_id',"所屬經銷商:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select('partner_id', $list_partners , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
                                        @if($errors->has('partner_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('partner_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('email',"Email:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::email('email', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('email'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 姓名 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('name',"姓名:",['class'=>'col-sm-2 form-control-label']) !!}
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

                                <!-- 姓名 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('phone',"電話:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('phone', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('phone'))
                                                <div style="padding: 5px;color: red;">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $roles=\App\Model\Role::whereStatus(1)->orderBy('sort')->get();
                                    $admin_roles=\App\Model\AdminRole::where('admin_id',$admin->id)->get();
                                    $adminid_arr=array();
                                    foreach($admin_roles as $admin_role)
                                        $adminid_arr[]=$admin_role->role_id;
                                @endphp
                                <!-- 角色指派 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('role_id[]',"角色指派:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10" style="font-size:16px">
                                        {{--@if($admin->id==2)--}}
                                        {{--<span>( 網站管理者 )</span>--}}
                                        {{--@else--}}
                                        @foreach($roles as $role)
                                            {!! Form::checkbox('role_id[]', $role->id, in_array($role->id,$adminid_arr)? 'checked':'' ,['style'=>'width:18px;height:18px;']) !!} {{ $role->name }} &nbsp;&nbsp;&nbsp;<br>
                                        @endforeach
                                        {{--@endif--}}
                                    </div>
                                </div>

                                <hr>
                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('更新',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-success" href="{{ url('/admin/admin?bid='.$admin->id ) }}">取消及回上一頁</a>
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