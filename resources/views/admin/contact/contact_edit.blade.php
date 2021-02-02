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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">聯絡我們</h5>
                                {{--                                <span>各項參數聯絡我們編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">聯絡我們</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>聯絡我們 編輯</h3></div>
                        <div class="card-body">
                            {!! Form::model($contact,['url' => '/admin/contact/'.$contact->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}
                                {!! Form::hidden('page',Request('page')) !!}
                                {!! Form::hidden('flag',0,['id'=>'flag']) !!}
                                <!-- 姓名 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('name',"姓名:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('name', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('name'))
                                                <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('name') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('email',"Email:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('email', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('email'))
                                                <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 手機 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('phone',"手機:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('phone', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('phone'))
                                                <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 手機 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('contact_demand',"詢問有關:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('contact_demand', null,  ['class'=>'form-control']) !!}
                                        <div>
                                            @if($errors->has('contact_demand'))
                                                <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('contact_demand') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 手機 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('message',"訊息:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('message', null,  ['class'=>'form-control','rows'=>6]) !!}
                                        <div>
                                            @if($errors->has('message'))
                                                <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                    <i class="fa fa-warning"></i>{{ $errors->first('message') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- 訊息內容 Form textarea Input -->
                                <div class="form-group row">
                                    {!! Form::label('reply_message',"回覆內容:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea('reply_message', null,['class'=>'form-control','rows'=>6]) !!}
                                        @if($errors->has('reply_message'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('reply_message') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 是否已回覆 Form checkbox Input -->
                                <div class="form-group row">
                                    {!! Form::label('isreply',"是否已回覆:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::checkbox('isreply', null, $contact->isreply==1? 'true':'' ,['class'=>'form-control','style'=>'width: 20px; height: 20px;','id'=>'isreply', 'disabled'=>'disabled']) !!}
                                    </div>
                                </div>

                                <hr>
                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('寄出回覆郵件',['class'=>'btn btn-success','onclick'=>'document.getElementById("flag").value=1;return confirm("是否確認要寄出回覆郵件?");']) !!} &nbsp;&nbsp;&nbsp;&nbsp;
                                    {!! Form::submit('存檔及回到列表',['class'=>'btn btn-primary']) !!} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="/admin/contact?bid={{$contact->id}}&page={{Request('page')}}">取消儲存及返回列表</a>
                                    {{-- <a class="btn btn-warning" href="{{ URL::previous() }}">返回</a> --}}
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