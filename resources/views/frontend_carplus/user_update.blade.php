@extends('frontend_carplus.layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="/css/jquery-ui-1.9.2.css" type="text/css" charset="utf-8" />
@stop

@section('extra-top-js')

@stop

@section('content')
    <div role="main" class="main" style="padding-top: 120px;padding-bottom: 120px;background-image: url(/assets/images/flow_bg.jpg);">
        <div class="shop" style="padding-top: 20px">
            {{--@include('frontend.layouts.partials.message')--}}
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="featured-boxes">
                            <div class="row">
                                <div class="col-md-12" style="max-width: 600px;margin: 0 auto;background-color: #fff;border-radius: 20px;padding: 25px">
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <h3 class="text-center">會員基本資料</h3>
                                    <div>&nbsp;</div>
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content">
                                            <h4 class=" text-3 text-uppercase mb-3 text-right" style="color: red;font-weight: 400;">( * 必填欄位 )</h4>
                                            {!! Form::model($user,['url' => '/user/user_update','class'=>'form-horizontal','enctype'=>'multipart/form-data','name'=>'form1'])  !!}
                                            {!! Form::hidden('send_email',null,['id'=>'send_email']) !!}
                                            {{--<div class="form-row">
                                                <div class="form-group col">
                                                    <label class="font-weight-bold text-dark text-3">帳號 (Email) <span style="color: red;"> *</span></label>
                                                    <input type="text" name="idno" value="" class="form-control form-control-lg">
                                                </div>
                                            </div>--}}
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="email" class="font-weight-bold text-dark text-3">帳號 (Email，填入後即不能再修改)<span style="color: red;"> *</span></label>
                                                    {!! Form::email('email', null,['class'=>'form-control input',$user->email?'readonly':'']); !!}
                                                    <div style="padding-left: 10px; color:red" class="checkEmailMsg"></div>
                                                    @if($errors->has('email'))
                                                        <div class="alert alert-danger text-3" role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('email') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="name" class="font-weight-bold text-dark text-3">真實姓名 <span style="color: red;"> *</span></label>
                                                    @if($user->is_check!=1)
                                                        {!! Form::text('name', null,['class'=>'form-control input','id'=>'name']); !!}
                                                    @else
                                                        {!! Form::text('name', null,['class'=>'form-control input','id'=>'name','readonly']); !!}
                                                    @endif
                                                    @if($errors->has('name'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="idno" class="font-weight-bold text-dark text-3">性別<span style="color: red;"> *</span></label>
                                                    @if($user->is_check!=1)
                                                        {!! Form::select('gender', [''=>'請選擇','男'=>'男','女'=>'女'] , null ,['class'=>'form-control','style'=>'font-size:16px','required']) !!}
                                                    @else
                                                        {!! Form::select('gender', [''=>'請選擇','男'=>'男','女'=>'女'] , null ,['class'=>'form-control','style'=>'font-size:16px','disabled']) !!}
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="phone" class="font-weight-bold text-dark text-3">手機  (ex:0912345678)<span style="color: red;"> *</span></label>
                                                    {!! Form::text('phone', null,['class'=>'form-control input','id'=>'phone']); !!}
                                                    @if($errors->has('phone'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('phone') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="telephone" class="font-weight-bold text-dark text-3">市話  (ex:0222345678)</label>
                                                    {!! Form::text('telephone', null,['class'=>'form-control input','id'=>'telephone']); !!}
                                                    @if($errors->has('telephone'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('telephone') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="address" class="font-weight-bold text-dark text-3">地址 <span style="color: red;"> *</span></label>
                                                    @if($user->is_check!=1)
                                                        {!! Form::text('address', null,['class'=>'form-control input','id'=>'address','minlength'=>10,'required']); !!}
                                                    @else
                                                        {!! Form::text('address', null,['class'=>'form-control input','id'=>'address','minlength'=>10,'readonly']); !!}
                                                    @endif
                                                    @if($errors->has('address'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('address') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="birthday" class="font-weight-bold text-dark text-3">生日 <span style="color: red;"> *</span></label>
                                                    @if($user->birthday=='')
                                                        {!! Form::text('birthday', null,['id'=>'birthday','class'=>'form-control input','autocomplete'=>'off','readonly','onfocus'=>"WdatePicker({dateFmt:'yyyy-MM-dd'})"]); !!}
                                                    @else
                                                        {!! Form::hidden('birthday',null,['id'=>'birthday']) !!}
                                                        {{$user->birthday}}
                                                    @endif
                                                    @if($errors->has('birthday'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('birthday') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="idno" class="font-weight-bold text-dark text-3">持證類別 (身份證/居留證) <span style="color: red;"> *</span></label>
                                                    @if($user->is_check!=1)
                                                        {!! Form::select('id_type', ['1'=>'身份證','2'=>'居留證'] , null ,['class'=>'form-control','style'=>'font-size:16px','required']) !!}
                                                    @else
                                                        {!! Form::select('id_type', ['1'=>'身份證','2'=>'居留證'] , null ,['class'=>'form-control','style'=>'font-size:16px','disabled']) !!}
                                                    @endif
                                                    @if($errors->has('idno'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('idno') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="idno" class="font-weight-bold text-dark text-3">身份證/居留證 號碼 (填入後即不能再修改) <span style="color: red;"> *</span></label>
                                                    @if($user->is_check!=1)
                                                        {!! Form::text('idno', null,['class'=>'form-control input','id'=>'idno']); !!}
                                                    @else
                                                        {!! Form::text('idno', null,['class'=>'form-control input','id'=>'idno','readonly']); !!}
                                                    @endif
                                                    @if($errors->has('idno'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('idno') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr>
                                            <div style="color: red">(上傳的證照皆會加上："本證照圖片限Sealand網站訂閱車輛專用"的浮水印，請您安心。 )</div>
                                            <hr>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="idno" class="font-weight-bold text-dark text-3">身份證/居留證(正面){{$user->is_check==0?'上傳':''}} <span style="color: red;"> *</span></label>
                                                    @if($user->idcard_image01)
                                                        @if($user->is_check!=1)
                                                            {!! Form::file('imgFile_idcard_image01',['class'=>'form-control input']); !!}
                                                            <div>&nbsp;</div>
                                                        @endif
                                                        <img src="/user/idcard_image01/{{$user->idcard_image01}}" style="max-width: 500px" alt="">
                                                    @else
                                                        {!! Form::file('imgFile_idcard_image01',['id'=>'idcard_image01','class'=>'form-control input']); !!}
                                                        <img id="idcard_blah01" src="/assets/images/empty.jpg" alt="身份證(正面)上傳" />
                                                    @endif
                                                    @if($errors->has('imgFile_idcard_image01'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('imgFile_idcard_image01') }}
                                                        </div>
                                                    @endif
                                                    {{--<img src="/user/idcard_image01/{{$user->idcard_image01}}" alt="">--}}
                                                </div>
                                            </div>
                                            @if($user->is_check!=1)
                                                <h5 style="color: red;font-size: 15px;font-weight: 400;line-height: 25px;">( 注意：請填入正確的身份證 發證日期、發證地點 及 領補換類別，以免影響到您的審核結果及車輛訂閱權益。)</h5>
                                            @endif
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="id_year" class="font-weight-bold text-dark text-3">身份證 發證日期  <span style="color: red;"> *</span></label>&nbsp;&nbsp;<a
                                                            href="#" data-toggle="modal" data-target="#mbr-popup-25"><i class="fa fa-question-circle-o" aria-hidden="true" style="font-style: normal;font-size: 20px;font-weight: normal; color: red"></i> 說明</a>
                                                    @if($user->is_check!=1 && !$user->id_year && !$user->id_month && !$user->id_day)
                                                        <div>
                                                            年：{!! Form::number('id_year', null ,['class'=>'','style'=>'font-size:15px','style'=>'width: 60px']) !!}
                                                            月：{!! Form::number('id_month', null ,['class'=>'','style'=>'font-size:15px','style'=>'width: 60px']) !!}
                                                            日：{!! Form::number('id_day', null ,['class'=>'','style'=>'font-size:15px','style'=>'width: 60px']) !!}
                                                        </div>
                                                        <h5 style="color: red;font-size: 15px;font-weight: 400;line-height: 25px;">( 注意：除了持居留證者可不填寫發證日期外，持有台灣身份證者請務必填寫，否則會影響到您的審核結果及車輛訂閱權益。)</h5>
                                                    @elseif($user->id_year && $user->id_month && $user->id_day)
                                                        <input type="text" class="form-control" value="{{$user->id_year}}年{{$user->id_month}}月{{$user->id_day}}日" readonly>
                                                    @endif
                                                    @if($errors->has('id_year'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('id_year') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="driver_no" class="font-weight-bold text-dark text-3">身份證/居留證 發證地點  <span style="color: red;"> *</span></label>&nbsp;&nbsp;<a
                                                            href="#" data-toggle="modal" data-target="#mbr-popup-25"><i class="fa fa-question-circle-o" aria-hidden="true" style="font-style: normal;font-size: 20px;font-weight: normal; color: red"></i> 說明</a>
                                                    @if($user->is_check!=1)
                                                        {!! Form::select('ssite_id', $list_ssites , null ,['class'=>'form-control','style'=>'font-size:16px','required']) !!}
                                                    @else
                                                        {!! Form::select('ssite_id', $list_ssites , null ,['class'=>'form-control','style'=>'font-size:16px','disabled']) !!}
                                                    @endif
                                                    @if($errors->has('ssite_id'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('driver_no') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="driver_no" class="font-weight-bold text-dark text-3">身份證/居留證 領補換類別  <span style="color: red;"> *</span></label>&nbsp;&nbsp;<a
                                                            href="#" data-toggle="modal" data-target="#mbr-popup-25"><i class="fa fa-question-circle-o" aria-hidden="true" style="font-style: normal;font-size: 20px;font-weight: normal; color: red"></i> 說明</a>
                                                    @if($user->is_check!=1)
                                                        {!! Form::select('applyreason', [''=>'請選擇','初發'=>'初發','補發'=>'補發','換發'=>'換發','其它(持居留證人士)'=>'其它(持居留證人士)'] , null ,['class'=>'form-control','style'=>'font-size:16px','required']) !!}
                                                    @else
                                                        {!! Form::select('applyreason', [''=>'請選擇','初發'=>'初發','補發'=>'補發','換發'=>'換發','其它(持居留證人士)'=>'其它(持居留證人士)'] , null ,['class'=>'form-control','style'=>'font-size:16px','disabled']) !!}
                                                    @endif
                                                    @if($errors->has('driver_no'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('driver_no') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="idno" class="font-weight-bold text-dark text-3">身份證/居留證(反面){{$user->is_check==0?'上傳':''}} <span style="color: red;"> *</span></label>
                                                    @if($user->idcard_image02)
                                                        @if($user->is_check!=1)
                                                            {!! Form::file('imgFile_idcard_image02',['class'=>'form-control input']); !!}
                                                            <div>&nbsp;</div>
                                                        @endif
                                                        <img src="/user/idcard_image02/{{$user->idcard_image02}}" style="max-width: 500px" alt="">
                                                    @else
                                                        {!! Form::file('imgFile_idcard_image02',['id'=>'idcard_image02','class'=>'form-control input']); !!}
                                                        <img id="idcard_blah02" src="/assets/images/empty.jpg" alt="身份證(反面)上傳" />
                                                    @endif
                                                    @if($errors->has('imgFile_idcard_image02'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('imgFile_idcard_image02') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="idno" class="font-weight-bold text-dark text-3">駕照(正面){{$user->is_check==0?'上傳':''}} <span style="color: red;"> *</span></label>
                                                    @if($user->driver_image01)
                                                        @if($user->is_check!=1)
                                                            {!! Form::file('imgFile_driver_image01',['class'=>'form-control input']); !!}
                                                            <div>&nbsp;</div>
                                                        @endif
                                                        <img src="/user/driver_image01/{{$user->driver_image01}}" style="max-width: 500px" alt="">
                                                    @else
                                                        {!! Form::file('imgFile_driver_image01',['id'=>'driver_image01','class'=>'form-control input']); !!}
                                                        <img id="driver_blah01" src="/assets/images/empty.jpg" alt="駕照上傳(正面) " />
                                                    @endif
                                                    @if($errors->has('imgFile_driver_image01'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('imgFile_driver_image01') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="idno" class="font-weight-bold text-dark text-3">駕照(反面){{$user->is_check==0?'上傳':''}} <span style="color: red;"> *</span></label>
                                                    @if($user->driver_image02)
                                                        @if($user->is_check!=1)
                                                            {!! Form::file('imgFile_driver_image02',['class'=>'form-control input']); !!}
                                                            <div>&nbsp;</div>
                                                        @endif
                                                        <img src="/user/driver_image02/{{$user->driver_image02}}" style="max-width: 500px" alt="">
                                                    @else
                                                        {!! Form::file('imgFile_driver_image02',['id'=>'driver_image02','class'=>'form-control input']); !!}
                                                        <img id="driver_blah02" src="/assets/images/empty.jpg" alt="駕照上傳(反面) " />
                                                    @endif
                                                    @if($errors->has('imgFile_driver_image02'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('imgFile_driver_image02') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="driver_no" class="font-weight-bold text-dark text-3">駕照管轄編號  <span style="color: red;"> *</span></label>
                                                    @if($user->is_check!=1)
                                                        {!! Form::text('driver_no', null,['class'=>'form-control input','id'=>'driver_no']); !!}
                                                    @else
                                                        {!! Form::text('driver_no', null,['class'=>'form-control input','id'=>'driver_no','readonly']); !!}
                                                    @endif
                                                    @if($errors->has('driver_no'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('driver_no') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="emergency_contact" class="font-weight-bold text-dark text-3">緊急連絡人 <span style="color: red;"> *</span></label>
                                                    {!! Form::text('emergency_contact', null,['class'=>'form-control input','id'=>'emergency_contact']); !!}
                                                    @if($errors->has('emergency_contact'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('emergency_contact') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="emergency_phone" class="font-weight-bold text-dark text-3">緊急連絡人手機 <span style="color: red;"> *</span></label>
                                                    {!! Form::text('emergency_phone', null,['id'=>'emergency_phone','class'=>'form-control input']); !!}
                                                    @if($errors->has('emergency_phone'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('emergency_phone') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="company_name" class="font-weight-bold text-dark text-3">公司抬頭 </label>
                                                    {!! Form::text('company_name', null,['id'=>'company_name','class'=>'form-control input']); !!}
                                                    @if($errors->has('company_name'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('company_name') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="company_no" class="font-weight-bold text-dark text-3">公司統編 </label>
                                                    {!! Form::number('company_no', null,['id'=>'company_no','class'=>'form-control input']); !!}
                                                    @if($errors->has('company_no'))
                                                        <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                            <i class="fa fa-warning"></i>{{ $errors->first('company_no') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div>&nbsp;</div>
                                            <div class="form-row">
                                                <div class="form-group col-lg-12" style="text-align: center;">
                                                    <input type="submit" value="更新" class="btn btn-primary text-4" onclick="return chk_form();">
                                                    {{--<a href="#" onclick="return chk_form();">.</a>--}}
                                                    @if($user->is_check!=1)
                                                        <input type="submit" name="submit_send_email" value="通知保姆" class="btn btn-secondary text-4" onclick="return chk_form2();">
                                                    @endif
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal cid-sdF2KbblXf fade" tabindex="-1" role="dialog" data-overlay-color="#000000" data-overlay-opacity="0.8" data-on-timer-delay="0" id="mbr-popup-25" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <h5 class="modal-title mbr-fonts-style display-5">身份證：發證地點 及 領補換類別 說明</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" fill="currentColor">
                            <path d="M31.797 0.191c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.598 0.581 0.342 1.543 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM14.472 17.515c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.613 0.595 0.34 1.562 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM1.144 0.205c-0.584-0.587-1.544 0.336-0.942 0.942l30.654 30.651c0.613 0.625 1.563-0.325 0.942-0.942z"></path>
                        </svg>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="mbr-text mbr-fonts-style display-7">
                        請選擇正確的身份證 發證地點 及 領補換類別，以免影響到您的審核結果及訂閱權益
                    </p>

                    <div>
                        <div class="card-img mbr-figure">
                            <img src="/assets/images/id_spec.jpg" alt="" style="max-width: 600px">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="mbr-section-btn">
                        <a class="btn btn-md btn-primary display-4" href="#" data-dismiss="modal" aria-label="Close">
                            關閉
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="modal cid-s1wVL85TMP fade" tabindex="-1" role="dialog" data-on-timer-delay="0" data-overlay-color="#000000" data-overlay-opacity="0.8" id="mbr-popup-1h" aria-hidden="true" style="max-width: 700px;margin: 0 auto">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <h5 class="modal-title mbr-fonts-style display-5">身份證：發證地點 及 領補換類別 說明</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" fill="currentColor">
                            <path d="M31.797 0.191c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.598 0.581 0.342 1.543 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM14.472 17.515c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.613 0.595 0.34 1.562 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM1.144 0.205c-0.584-0.587-1.544 0.336-0.942 0.942l30.654 30.651c0.613 0.625 1.563-0.325 0.942-0.942z"></path>
                        </svg>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="mbr-text mbr-fonts-style display-7" style="text-align: left;">
                        <img src="/assets/images/id_spec.jpg" alt="" style="max-width: 600px">
                    </p>

                    <div>
                    </div>
                </div>

                <div class="modal-footer pt-0">
                    <div class="mbr-section-btn"><a class="btn btn-md btn-primary display-4" href="#" data-dismiss="modal" aria-label="Close">
                            關閉
                        </a></div>
                </div>
            </div>
        </div>
    </div>--}}

@endsection

@section('extra-js')
    <script src="/assets/datePicker/WdatePicker.js" type="text/javascript"></script>
    <script>
        var privacy_cnt=0;
        var member_cnt=0;

        (function(){
            $('.alert-danger').delay(10000).slideUp(300);
        })();

        function chk_form() {
            document.getElementById('send_email').value=null;
            if(chk_field())
                return true;
            else{
                return false;
            }
        }

        function chk_form2() {
            /*document.getElementById('send_email').value=1;
            if(privacy_cnt==0){
                alert("您必須閱讀:客戶隱私權政策");
                return false;
            }
            /!*if(member_cnt==0){
                alert("您必須閱讀:客戶服務條款");
                return false;
            }*!/
            if(terms.checked!=true) {
                alert("您必須勾選同意Sealand 客戶隱私權政策 才能繼續。");
                return false;
            }*/
            if(chk_field() && confirm('您是否確認資料皆已上傳及全部資料已填寫及更新完成，並發Email通知保姆審查資料？')){
                document.form1.submit();
            }
            else
                return false;
        }

        function chk_field() {


            var name=document.getElementById('name').value;
            var emergency_contact=document.getElementById('emergency_contact').value;
            var idno=document.getElementById('idno').value;
            var phone=document.getElementById('phone').value;
            var telephone=document.getElementById('telephone').value;
            var emergency_phone=document.getElementById('emergency_phone').value;
            var birthday=document.getElementById('birthday').value;

            var driver_no=document.getElementById('driver_no').value;
            var company_no=document.getElementById('company_no').value;
            var terms=document.getElementById('terms');
            var msg='';
            var cnt=0;

            /*var letters = new Array('A', 'B', 'C', 'D',
                'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M',
                'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V',
                'X', 'Y', 'W', 'Z', 'I', 'O',);

            if(letters.indexOf(idno.substring(0, 1))==-1){
                msg+='您輸入錯誤的 身份証字號，第一碼請輸入大寫字母。\n';
                cnt++;
            }*/
            if(idno.length==0){
                msg+='請輸入 身份証字號。\n';
                cnt++;
            }
            /*else if(idno.substring(1, 2)!=1 && idno.substring(1, 2)!=2){
                msg+='您輸入錯誤的 身份証字號。\n';
                cnt++;
            }
            else if(isNaN(idno.substring(1, 10))){
                msg+='您輸入錯誤的 身份証字號。\n';
                cnt++;
            }
            if(!isChinese(name)){
                msg+="姓名 請輸入中文姓名!!\n";
                cnt++;
            }*/
            /*if(!isChinese(emergency_contact)){
                msg+="緊急聯絡人 請輸入中文姓名!!\n";
                cnt++;
            }*/
            if(idno.length==0){
                msg+='請輸入 緊急聯絡人。\n';
                cnt++;
            }
            if(name!='' && emergency_contact!='') {
                if (name == emergency_contact) {
                    msg += "姓名 及 緊急聯絡人 不可相同\n";
                    cnt++;
                }
            }
            if(phone!='' && emergency_phone!='') {
                if(phone == emergency_phone){
                    msg+="手機 及 緊急聯絡人手機 不可相同\n";
                    cnt++;
                }
            }
            if(birthday.length==0){
                msg+="生日 不可空白!!\n";
                cnt++;
            }
            if(phone.length==0){
                msg+="手機 不可空白!!\n";
                cnt++;
            }
            /*if(phone.length!=10){
                msg+="手機 長度須為10, 不可加'-'\n";
                cnt++;
            }
            if(phone.substring(0,2)!='09'){
                msg+="請輸入正確的 手機號碼\n";
                cnt++;
            }*/
            if(isNaN(phone)){
                msg+="手機 不可輸入文字, 不可加'-'\n";
                cnt++;
            }
            if(telephone!=''){
                /*if(telephone.length!=9 && telephone.length!=10 ){
                    msg+="市話請加上區碼, 長度須為9～10碼, 不可加'-'\n";
                    cnt++;
                }*/
                if(isNaN(telephone)){
                    msg+="市話 不可輸入文字, 不可加'-'\n";
                    cnt++;
                }
            }
            if(emergency_phone.length==0){
                msg+="緊急連絡人手機 不可空白!!\n";
                cnt++;
            }
            /*if(emergency_phone.length!=10){
                msg+="緊急連絡人手機 長度須為10, 不可加'-'\n";
                cnt++;
            }
            if(emergency_phone.substring(0,2)!='09'){
                msg+="請輸入正確的 緊急連絡人手機號碼\n";
                cnt++;
            }*/
            if(isNaN(emergency_phone)){
                msg+="緊急連絡人手機 不可輸入文字, 不可加'-'\n";
                cnt++;
            }
            if(company_no!=''){
                if(company_no.length!=8 || isNaN(company_no)){
                    msg+="請輸入正確的公司統編\n";
                    cnt++;
                }
            }
            @if(!$user->idcard_image01)
            //身份證(正面)相片 身份證(反面)相片 駕照上傳(正面)相片 駕照上傳(反面)相片
            //idcard_image01 idcard_image02 driver_image01 driver_image02
            var idcard_image01=document.getElementById('idcard_image01').value;
            if(idcard_image01.length==0){
                msg+="請上傳 身份證(正面)相片\n";
                cnt++;
            }
                    @endif
                    @if(!$user->idcard_image02)
            var idcard_image02=document.getElementById('idcard_image02').value;
            if(idcard_image02.length==0){
                msg+="請上傳 身份證(反面)相片\n";
                cnt++;
            }
                    @endif
                    @if(!$user->driver_image01)
            var driver_image01=document.getElementById('driver_image01').value;
            if(driver_image01.length==0){
                msg+="請上傳 駕照(正面)相片\n";
                cnt++;
            }
                    @endif
                    @if(!$user->driver_image02)
            var driver_image02=document.getElementById('driver_image02').value;
            if(driver_image02.length==0){
                msg+="請上傳 駕照(反面)相片\n";
                cnt++;
            }
            @endif
            if(driver_no.length==0){
                msg+="駕照管轄編號\n";
                cnt++;
            }
            if(cnt>0){
                alert(msg);
                return false;
            }
            else
                return true;

        }

        /*function checkID(idStr){
            // 依照字母的編號排列，存入陣列備用。
            var letters = new Array('A', 'B', 'C', 'D',
                'E', 'F', 'G', 'H', 'J', 'K', 'L', 'M',
                'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V',
                'X', 'Y', 'W', 'Z', 'I', 'O');
            // 儲存各個乘數
            var multiply = new Array(1, 9, 8, 7, 6, 5,
                4, 3, 2, 1);
            var nums = new Array(2);
            var firstChar;
            var firstNum;
            var lastNum;
            var total = 0;
            // 撰寫「正規表達式」。第一個字為英文字母，
            // 第二個字為1或2，後面跟著8個數字，不分大小寫。
            var regExpID=/^[a-z](1|2)\d{8}$/i;
            // 使用「正規表達式」檢驗格式
            if (idStr.search(regExpID)==-1) {
                // 基本格式錯誤
                // alert("請填寫正確的身份證字號格式");
                return false;
            } else {
                // 取出第一個字元和最後一個數字。
                firstChar = idStr.charAt(0).toUpperCase();
                lastNum = idStr.charAt(9);
            }
            // 找出第一個字母對應的數字，並轉換成兩位數數字。
            for (var i=0; i<26; i++) {
                if (firstChar == letters[i]) {
                    firstNum = i + 10;
                    nums[0] = Math.floor(firstNum / 10);
                    nums[1] = firstNum - (nums[0] * 10);
                    break;
                }
            }
            // 執行加總計算
            for(var i=0; i<multiply.length; i++){
                if (i<2) {
                    total += nums[i] * multiply[i];
                } else {
                    total += parseInt(idStr.charAt(i-1)) *
                        multiply[i];
                }
            }
            // 和最後一個數字比對
            if ((10 - (total % 10))!= lastNum) {
                alert("您輸入錯誤的身份證字號");
                return false;
            }
            return true;
        }*/

        function isChinese(s) {
            for(var i = 0; i < s.length; i++) {
                if(s.charCodeAt(i) < 0x4E00 || s.charCodeAt(i) > 0x9FA5) {
                    return false;
                }
            }
            return true;
        }
    </script>
    <script>
        function idcard01(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#idcard_blah01').attr('src', e.target.result).css('max-width','450px').css('width','100%');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#idcard_image01").change(function(){
            idcard01(this);
        });

        function idcard02(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#idcard_blah02').attr('src', e.target.result).css('max-width','450px').css('width','100%');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#idcard_image02").change(function(){
            idcard02(this);
        });

        function driver01(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#driver_blah01').attr('src', e.target.result).css('max-width','450px').css('width','100%');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#driver_image01").change(function(){
            driver01(this);
        });

        function driver02(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#driver_blah02').attr('src', e.target.result).css('max-width','450px').css('width','100%');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#driver_image02").change(function(){
            driver02(this);
        });


    </script>
@endsection