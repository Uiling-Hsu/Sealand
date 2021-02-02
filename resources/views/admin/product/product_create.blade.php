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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">車輛管理</h5>
                                {{--                                <span>各項參數車輛管理編輯</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">車輛管理</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="max-width: 800px">
                        <div class="card-header"><h3>車輛管理 新增</h3></div>
                        <div class="card-body">
                            {!! Form::open(['url' => '/admin/product/store','enctype'=>'multipart/form-data'])  !!}
                                {!! Form::hidden('page',Request('page')) !!}

                                <!-- 經銷商 Form select Input -->
                                <div class="form-group row">
                                    {!! Form::label('dealer_id',"總經銷商:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select('dealer_id', $list_dealers , null ,['class'=>'form-control','style'=>'font-size:15px','required']) !!}
                                        @if($errors->has('dealer_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('dealer_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 經銷商 Form select Input -->
                                <div class="form-group row">
                                    {!! Form::label('partner_id',"經銷商 (交車地點):",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select('partner_id', $list_partners , null ,['class'=>'form-control','style'=>'font-size:15px','required']) !!}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {!! Form::label('partner_id',"經銷商 (交車地點2):",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select('partner2_id', $list_partners , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
                                    </div>
                                </div>

                                <!-- 方案類別 Form select Input -->
                                <div class="form-group row">
                                    {!! Form::label('cate_id',"方案類別:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select('cate_id', $list_cates , null ,['id'=>'cate','class'=>'form-control','style'=>'font-size:15px','required']) !!}
                                        @if($errors->has('cate_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('cate_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 廠　牌 Form select Input -->
                                <div class="form-group row">
                                    <label for="brandcat_id" class="col-sm-2 form-control-label"><a href="/admin/brandcat" target="_blank" style="color: #007bff">品牌</a>:</label>
                                    <div class="col-sm-10">
                                        {!! Form::select('brandcat_id', $list_brandcats , null ,['id'=>'brandcat','class'=>'form-control','style'=>'font-size:15px','required']) !!}
                                        @if($errors->has('brandcat_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('brandcat_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <script>
                                    $(document).on('change', '#cate', function(){
                                        var cate = $('#cate :selected').val();//注意:selected前面有個空格！
                                        $.ajax({
                                            url:"/admin/ajax_brandcat",
                                            method:"GET",
                                            data:{
                                                cate:cate
                                            },
                                            success:function(res){
                                                $('#brandcat').html(res);
                                            }
                                        })//end ajax
                                    });
                                </script>

                                <!-- 車型 Form select Input -->
                                <div class="form-group row">
                                    <label for="brandin_id" class="col-sm-2 form-control-label"><a href="/admin/brandin" target="_blank" style="color: #007bff">車型</a>:</label>
                                    <div class="col-sm-10">
                                        {!! Form::select('brandin_id', $list_brandins , null ,['id'=>'brandin','class'=>'form-control','style'=>'font-size:15px','required']) !!}
                                        @if($errors->has('brandin_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('brandin_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <script>
                                    $(document).on('change', '#brandcat', function(){
                                        var brandcat = $('#brandcat :selected').val();//注意:selected前面有個空格！
                                        $.ajax({
                                            url:"/admin/ajax_brandin",
                                            method:"GET",
                                            data:{
                                                brandcat:brandcat
                                            },
                                            success:function(res){
                                                $('#brandin').html(res);
                                            }
                                        })//end ajax
                                    });
                                </script>

                                <!-- title Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('model',"編號:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('model',null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('model'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('model') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 車牌號碼 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('plate_no',"車牌號碼:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('plate_no',null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('plate_no'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('plate_no') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 排氣量 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('displacement',"排氣量:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('displacement',null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('displacement'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('displacement') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 年份 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('year',"年份:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('year',null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('year'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('year') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{--<!-- 目前殘值 Form text Input -->
                                <div class="form-group row">
                                    {!! Form::label('car_value',"目前殘值:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text('car_value',null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('car_value'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('car_value') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>--}}

                                <!-- 排檔 Form select Input -->
                                <div class="form-group row">
                                    <label for="progeartype_id" class="col-sm-2 form-control-label"><a href="/admin/progeartype" target="_blank" style="color: #007bff">排檔</a>:</label>
                                    <div class="col-sm-10">
                                        {!! Form::select('progeartype_id', $list_progeartypes , null ,['class'=>'form-control','style'=>'font-size:15px','required']) !!}
                                        @if($errors->has('progeartype_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('progeartype_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 燃料 Form select Input -->
                                <div class="form-group row">
                                    <label for="profuel_id" class="col-sm-2 form-control-label"><a href="/admin/profuel" target="_blank" style="color: #007bff">燃料</a>:</label>
                                    <div class="col-sm-10">
                                        {!! Form::select('profuel_id', $list_profuels , null ,['class'=>'form-control','style'=>'font-size:15px','required']) !!}
                                        @if($errors->has('profuel_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('profuel_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 座位數 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('seatnum',"座位數:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('seatnum', null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('seatnum'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('seatnum') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 顏色 Form select Input -->
                                <div class="form-group row">
                                    <label for="procolor_id" class="col-sm-2 form-control-label"><a href="/admin/procolor" target="_blank" style="color: #007bff">顏色</a>:</label>
                                    <div class="col-sm-10">
                                        {!! Form::select('procolor_id', $list_procolors , null ,['class'=>'form-control','style'=>'font-size:15px','required']) !!}
                                        @if($errors->has('procolor_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('procolor_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 里程數 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('milage',"里程數:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('milage', null,['class'=>'form-control','required']) !!}
                                        @if($errors->has('milage'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('milage') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 交車區域 Form select Input -->
                                <div class="form-group row">
                                    <label for="proarea_id" class="col-sm-2 form-control-label"><a href="/admin/proarea" target="_blank" style="color: #007bff">交車區域</a>:</label>
                                    <div class="col-sm-10">
                                        {!! Form::select('proarea_id', $list_proareas , null ,['class'=>'form-control','style'=>'font-size:15px','required']) !!}
                                        @if($errors->has('proarea_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('proarea_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 交車區域 Form select Input -->
                                <div class="form-group row">
                                    <label for="proarea_id" class="col-sm-2 form-control-label">
                                        @if(role('admin') || role('babysitter'))
                                            <a href="/admin/proarea" target="_blank">交車區域2</a>:
                                        @else
                                            交車區域2:
                                        @endif
                                    </label>
                                    <div class="col-sm-10">
                                        {!! Form::select('proarea2_id', $list_proareas , null ,['class'=>'form-control','style'=>'font-size:15px']) !!}
                                        @if($errors->has('proarea2_id'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('proarea2_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 新車車價 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('new_car_price',"新車車價:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('new_car_price', null,['class'=>'form-control']) !!}
                                        @if($errors->has('new_car_price'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('new_car_price') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- 中古車定價 Form number Input -->
                                <div class="form-group row">
                                    {!! Form::label('second_hand_price',"中古車定價:",['class'=>'col-sm-2 form-control-label']) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number('second_hand_price', null,['class'=>'form-control']) !!}
                                        @if($errors->has('second_hand_price'))
                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                <i class="fa fa-warning"></i>{{ $errors->first('second_hand_price') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- image Form text Input -->
                                {{--<div class="form-group row">
                                    <label for="imgFile" class="col-sm-2 form-control-label">主圖片: ( 寬:1000以上 )</label>
                                    <div class="col-sm-10">
                                        {!! Form::file('imgFile',['class'=>'form-control']); !!}<br>
                                    </div>
                                </div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>--}}

                                <!--  Form Submit Input -->
                                <div class="form-group" style="text-align:center">
                                    {!! Form::submit('新增',['class'=>'btn btn-success']) !!}&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-dark" href="{{ url('/admin/product?restore=1' ) }}">取消及回上一列表</a>
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