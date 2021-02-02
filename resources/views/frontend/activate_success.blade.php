@extends('frontend.layouts.app')

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
                                    <h3 class="text-center">您已成功啟用帳號</h3>
                                    <hr>
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content" style="padding: 5px;line-height: 30px;">
                                            尚未開通訂閱功能，請至會員中心<a href="/user/user_update" class="btn btn-primary" target="_blank" style="padding: 5px 10px">修改基本資料</a>填寫完整會員資料與上傳證件 ，SeaLand將為您開通訂閱功能。
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
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