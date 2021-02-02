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
                                    <h3 class="text-center" style="color: red">{{$retcode}}</h3>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div class="text-center" style="color: purple;font-size: 20px;">如有相關問題請電洽保姆：{{setting('phone')}}</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
    </div>
@endsection

@section('extra-js')

@endsection