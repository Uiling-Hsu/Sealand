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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">經銷商</h5>
                                {{--                                <span>各項參數經銷商編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">經銷商</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>經銷商 編輯</h3></div>
                        <div class="card-body">
                            {!! Form::model($partner,['url' => '/admin/partner/'.$partner->id ,'method' => 'PATCH','enctype'=>'multipart/form-data'])  !!}

                                <!-- 總經銷商 Form select Input -->
                                <div class="form-group row">
                                    {!! Form::label('dealer_id',"總經銷商:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select('dealer_id', $list_dealers , null ,['class'=>'form-control','required']) !!}
                                        @if($errors->has('dealer_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('dealer_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 交車區域 Form select Input -->
                                <div class="form-group row">
                                    {!! Form::label('proarea_id',"交車區域:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select('proarea_id', $list_proareas , null ,['class'=>'form-control','required']) !!}
                                        @if($errors->has('proarea_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('proarea_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- title Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('title',"名稱:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('title',null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('title'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('title') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Email Form email Input -->
                                <div class="form-group row">
                                    {!! Form::label('email',"Email:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::email('email', null,['class'=>'form-control']); !!}
                                        @if($errors->has('email'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 電話 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('phone',"電話:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('phone', null,['class'=>'form-control']); !!}
                                        @if($errors->has('phone'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 手機 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('cell_phone',"手機:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('cell_phone', null,['class'=>'form-control']); !!}
                                        @if($errors->has('cell_phone'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('cell_phone') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 地址 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('address',"地址:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('address', null,['class'=>'form-control']); !!}
                                        @if($errors->has('address'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('address') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 地址 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('contact_person',"聯絡人:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('contact_person', null,['class'=>'form-control']); !!}
                                        @if($errors->has('contact_person'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('contact_person') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if($partner->partneremails->count()>0)
                                    <hr>
                                    @foreach($partner->partneremails as $key=>$partneremail)
                                        <!-- image Form text Input -->
                                        @if($partneremail->email)
                                            <div id="delete_image_block{{$key}}">
                                                <div>&nbsp;</div>
                                                <div class="form-group row">
                                                    <label for="imgFile" class="col-sm-2 form-control-label">Email {{$key+1}}:</label>
                                                    <div class="col-sm-10">
                                                        {{$partneremail->email}} (ID:{{$partneremail->id}}) &nbsp;&nbsp;
                                                        <a href="javascript:void(0)" style="display: inline-block;color: red;border:solid 1px red;padding: 2px 8px" id="remove_image_btn{{$key}}"><i class="fa fa-times" aria-hidden="true"></i>刪除此Email</a>
                                                        <script>
                                                            $(function() {
                                                                $('#remove_image_btn{{$key}}').click(function() {
                                                                    if(confirm('是否確定要刪除此Email？')) {
                                                                        $.get('/admin/ajax_delete_record', {
                                                                            "db": 'partneremails',
                                                                            "id": '{{$partneremail->id}}'
                                                                        });
                                                                        $('#delete_image_block{{$key}}').fadeOut(1000, function() { $(this).remove(); });
                                                                    }
                                                                })
                                                            })
                                                        </script>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div>&nbsp;</div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                                {{--<div><a href="/admin/recipe/partneremail/create?recipe_id={{$recipe->id}}" class="btn btn-success">新增一張 其它圖片</a></div>--}}
                                <hr>
                                <h5 style="font-size: 16px;">新增其它 Email</h5>
                                <div>(可輸入1到多個Email, 空白的欄位不會新增)</div>
                                <div class="col-md-6" style="padding-top: 10px">
                                    <div class="input-group control-group increment" >
                                        Email: &nbsp;&nbsp;<input type="email" name="newEmail[]" class="form-control">&nbsp;&nbsp;&nbsp;
                                        <div class="input-group-btn" style="position: relative;top: 3px;">
                                            <button class="btn btn-success btn-success2" type="button"><i class="fa fa-plus"></i> 增加</button>
                                        </div>
                                    </div>
                                    <div class="clone hide">
                                        <div class="control-group input-group" style="margin-top:10px">
                                            Email: &nbsp;&nbsp;<input type="email" name="newEmail[]" class="form-control">&nbsp;&nbsp;&nbsp;
                                            {{--<div class="input-group-btn" style="position: relative;top: 3px;">
                                                <button class="btn btn-danger btn-danger2" type="button"><i class="fa fa-remove"></i> 移除</button>
                                            </div>--}}
                                        </div>
                                    </div>
                                </div>

                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('更新',['class'=>'btn btn-primary']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-success" href="{{ url('/admin/partner?bid='.$partner->id ) }}">取消及回上一列表</a>
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
    <script type="text/javascript">
        $(document).ready(function() {
            $(".btn-success2").click(function(){
                var html = $(".clone").html();
                $(".increment").after(html);
            });
            $("body").on("click",".btn-danger2",function(){
                $(this).parents(".control-group").remove();
            });
        });
    </script>
@stop