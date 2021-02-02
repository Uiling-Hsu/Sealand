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
                                <div class="col-md-12" style="max-width: 600px;margin: 0 auto;background-color: #fff;border-radius: 20px;padding: 25px">
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <h3 class="text-center">
                                        訂閱單檢視
                                    </h3>
                                    <div>&nbsp;</div>
                                    <div style="text-align: center;">
                                        <img src="{{$cate->image}}" title="" alt="" style="width: 100%;border: solid 1px #eee;max-width: 400px">
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content" style="padding: 0 20px">
                                            <div>&nbsp;</div>
                                            <div class="form-row">
                                                <div class="col-12">
                                                    @if($subscriber->is_cancel==1)
                                                        (此單已取消)
                                                    @else
                                                        <label for="email" class="font-weight-bold text-dark text-3">訂閱狀態：</label>
                                                        <!-- aaa Form select Input -->
                                                        等待審核中...
                                                    @endif
                                                </div>
                                                <div class="col-12">
                                                    <label for="email" class="font-weight-bold text-dark text-3">交車區域： </label>
                                                    <!-- aaa Form select Input -->
                                                    {{$proarea->title}}
                                                </div>
                                                <div class="col-12">
                                                    <label for="name" class="font-weight-bold text-dark text-3">預計交車日期： </label>
                                                    {{$subscriber->sub_date}}
                                                </div>
                                                @if($subscriber->pick_up_time)
                                                    <div class="col-12">
                                                        <label for="name" class="font-weight-bold text-dark text-3">預計交車時間： </label>
                                                        {{$subscriber->pick_up_time}}
                                                    </div>
                                                @endif
                                            </div>

                                            <hr>
                                            @if($subscriber->is_cancel==0)
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
                                                        <a href="/ord_list" class="btn btn-primary text-3">回訂閱及訂單列表</a>
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