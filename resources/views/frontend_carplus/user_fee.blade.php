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
                                <div class="col-md-12" style="max-width: 400px;margin: 0 auto;background-color: #fff;border-radius: 20px;padding: 30px 50px">
                                    <div>&nbsp;</div>
                                    <h3 class="text-center">會員自行繳費明細</h3>
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content" id="fee">
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="e_tag" class="font-weight-bold text-dark text-3"><span style="color: brown">繳費期限：{{$user->fee_title}}</span></label>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="e_tag" class="font-weight-bold text-dark text-3">E-Tag：{{ number_format($user->e_tag) }}</label>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="park_fee" class="font-weight-bold text-dark text-3">停車費：{{ number_format($user->park_fee) }}</label>
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="ticket" class="font-weight-bold text-dark text-3">罰單：{{ number_format($user->ticket) }}</label>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="maintain_fee" class="font-weight-bold text-dark text-3">保養費：{{ number_format($user->maintain_fee) }}</label>
                                                </div>
                                            </div>

                                            @if($user->custom_fee>0)
                                                <div class="form-row">
                                                    <div class="form-group col">
                                                        <label for="custom_fee" class="font-weight-bold text-dark text-3">{{ $user->custom_title }} 金額：{{ number_format($user->custom_fee) }}</label>
                                                    </div>
                                                </div>
                                            @endif
                                            <hr>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="custom_fee" class="font-weight-bold text-dark text-3">金額總計：<span style="color: red;font-size: 20px;">{{ number_format($user->total) }}</span></label>
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