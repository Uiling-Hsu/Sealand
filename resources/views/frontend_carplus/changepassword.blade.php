@extends('frontend_carplus.layouts.app')

@section('extra-css')

@stop

@section('content')
    <div role="main" class="main" style="padding-top: 120px;padding-bottom: 120px;background-image: url(/assets/images/flow_bg.jpg);">
        {{--@include('frontend.layouts.partials.message')--}}

        <div class="shop" style="padding-top: 20px">
            <div class="container">

                <div class="row">
                    <div class="col">
                        <div class="featured-boxes">
                            <div class="row">
                                <div class="col-md-12" style="max-width: 500px;margin: 0 auto;background-color: #fff;border-radius: 20px;padding: 25px">
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <h3 class="text-center">修改密碼</h3>
                                    <div>&nbsp;</div>
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content">
                                            <h4 class=" text-3 text-uppercase mb-3 text-right" style="color: red;font-weight: 400;">( * 必填欄位 )</h4>
                                            {!! Form::open(['route' => 'changePassword','class'=>'form-horizontal'])  !!}
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label for="new-password" class="font-weight-bold text-dark text-3">新密碼 ( 8-20碼英數混合，密碼強度至少為中等以上 ) <span style="color: red;"> *</span></label>
                                                        {!! Form::password('new-password',['class'=>'form-control input','id'=>'new-password', 'data-indicator'=>'pwindicator','minlength'=>'8','required'=>'required']); !!}
                                                        <div id="pwindicator" style="padding: 0 10px 0 20px">
                                                            <div class="bar" style=""></div>
                                                            <div class="label" id="pw_label"></div>
                                                        </div>
                                                        <script src="/js/jquery.pwstrength.js"></script>
                                                        <script type="text/javascript">
                                                            $(function () {
                                                                //啟用密碼強度指示器，並變更說明文字
                                                                $("input[name='new-password']").pwstrength({ texts: ['非常弱', '弱', '中等', '強', '非常強'] });
                                                            });
                                                        </script>
                                                        @if($errors->has('new-password'))
                                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                                <i class="fa fa-warning"></i>{{ $errors->first('new-password') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label for="new-password-confirm" class="font-weight-bold text-dark text-3">新確認密碼 <span style="color: red;"> *</span></label>
                                                        {!! Form::password('new-password-confirm',['class'=>'form-control input','id'=>'new-password-confirm','placeholder'=>'密碼','required'=>'required']); !!}
                                                        @if($errors->has('new-password-confirm'))
                                                            <div class="alert alert-danger " role="alert" style="margin-top:5px">
                                                                <i class="fa fa-warning"></i>{{ $errors->first('new-password-confirm') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-lg-7">
                                                        <div>
                                                            <input type="submit" value="確認修改" class="btn btn-primary float-right text-4" onclick="var pw_label=document.getElementById('pw_label').innerHTML;if(pw_label!='中等' && pw_label!='非常強' && pw_label!='強'){alert('密碼至少需填入8碼以上，並且至少使用英、數混合的字元，密碼強度至少需指示為：中等、強 或 非常強');return false;}else{return true;}">
                                                        </div>
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
@endsection

@section('extra-js')
    <script>
        (function(){
            $('.alert-danger').delay(10000).slideUp(300);
        })();
    </script>
@endsection