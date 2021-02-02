@extends('frontend_carplus.layouts.app')

@section('extra-css')

@stop

@section('extra-top-js')

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
                                    <h3 class="text-center" style="color: green">線上刷卡成功</h3>
                                    <div>&nbsp;</div>
                                    <div class="text-center" style="color: purple">
                                        @if($ord->is_paid3==1)
                                            您的 迄租款金額 已成功付款
                                        @elseif($ord->is_paid2==1)
                                            您的 起租款項金額 已成功付款
                                        @else
                                            您的 保證金 已成功付款
                                        @endif
                                    </div>
                                    <div>&nbsp;</div>
                                    <div style="text-align: center;">
                                        訂單編號：{{$ord->checkout_no}}
                                    </div>
                                    <div style="text-align: center;">
                                        訂單日期：{{substr($ord->created_at,0,10) }}
                                    </div>

                                    <div>&nbsp;</div>
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content" style="padding: 0 20px">
                                            <div class="form-row">
                                                <div class="form-group col">

                                                    @if($cate)
                                                        <h5>方案資訊：</h5>
                                                        <span style="font-size: 20px;color: purple">{{$cate->title}}</span><br>
                                                        <span style="color: purple">{{number_format($cate->basic_fee) }} 元/月</span><br>
                                                        <span style="color: purple">{{number_format($cate->mile_fee,2) }} 元/每公里</span><br>
                                                    @endif

                                                    {{--<div>
                                                        是否付款：{!! $ord->is_paid==1?'<span style="color:green">保證金已付</span>':'<span style="color:red">未付款</span>' !!}
                                                    </div>--}}
                                                </div>
                                            </div>
{{--                                            <div>交車區域：{{$proarea->title}}</div>--}}
{{--                                            <div>預定交車日期： {{$ord->sub_date}}</div>--}}
                                            <hr>
                                            @if($ord->state_id==2)
                                                <div style="color: green;font-size: 18px;padding: 10px 0">
                                                    {!! $ord->is_paid==1?'<span style="color: green">已付':'<span style="color: red">未付' !!} 保證金：{{number_format($ord->deposit)}} 元
                                                </div>
                                            @elseif($ord->state_id==5)
                                                <div style="color: green;font-size: 18px;padding: 10px 0">
                                                    {!! $ord->is_paid2==1?'<span style="color: green">已付':'<span style="color: red">未付' !!} 起租款：{{number_format($ord->payment_total)}} 元
                                                </div>
                                                <hr>
                                            @elseif($ord->state_id==10)
                                                <div style="color: green;font-size: 18px;padding: 10px 0 ">
                                                    {!! $ord->is_paid3==1?'<span style="color: green">已付':'<span style="color: red">未付' !!} 迄租款項：{{number_format($ord->payment_backcar_total)}} 元
                                                </div>
                                                <hr>
                                            @endif
                                            <h5>車輛資訊：</h5>
                                            {{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
                                            @if($product)
                                                <span style="color: black;font-weight: 300;">品牌:</span><span style="font-weight: bold;"> {{$product->brandcat?$product->brandcat->title:'' }}</span><br>
                                                <span style="color: black;font-weight: 300;">車型:</span><span style="font-weight: bold;"> {{$product->brandin?$product->brandin->title:''}}</span><br>
                                                <span style="color: black;font-weight: 300;">排氣量:</span><span style="font-weight: bold;"> {{ number_format($product->displacement) }}</span><br>
                                                <span style="color: black;font-weight: 300;">年份:</span><span style="font-weight: bold;"> {{ $product->year }}</span><br>
                                                <span style="color: black;font-weight: 300;">排檔:</span><span style="font-weight: bold;"> {{$product->progeartype?$product->progeartype->title:''}}</span><br>
                                                <span style="color: black;font-weight: 300;">座位數:</span><span style="font-weight: bold;"> {{$product->seatnum}}</span><br>
                                                <span style="color: black;font-weight: 300;">顏色:</span><span style="font-weight: bold;"> {{$product->procolor?$product->procolor->title:''}}</span><br>
                                                <span style="color: black;font-weight: 300;">里程數:</span><span style="font-weight: bold;"> {{ number_format($product->milage) }}</span><br><br>
                                            @endif
                                            <div class="form-row">
                                                <!--<div class="form-group col-lg-6">
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="rememberme">
                                                        <label class="custom-control-label text-2" for="rememberme">Remember Me</label>
                                                    </div>
                                                </div>-->
                                                <div class="form-group col-lg-12">
                                                    <div style="text-align: center;">
                                                        <a href="/ord_list" class="btn btn-primary text-3">前往 訂單列表</a>
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
            </div>
        </div>
    </div>
@endsection

@section('extra-js')

@endsection