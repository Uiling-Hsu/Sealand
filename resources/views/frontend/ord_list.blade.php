@extends('frontend.layouts.app')

@section('extra-css')

@stop

@section('content')
    <section class="extFeatures cid-s12THEJrXk" id="extFeatures21-4" style="background-image: url(/assets/images/flow_bg.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2 class="mbr-section-title pb-2 mbr-bold mbr-fonts-style align-left display-1">我的訂單列表<br><br></h2>
                    {{--@if($ords->count()>0)
                        <div style="text-align: center;color: white">( 本列表為您已訂閱的車輛訂單 )</div>
                        <div style="text-align: center;">&nbsp;</div>
                    @endif--}}
                </div>
            </div>
            <div class="row row-content justify-content-center">
                <div class="card p-3 col-12" style="max-width: 600px">
                    @if($subscribers->count()>0)
                        @foreach($subscribers as $key=>$subscriber)
                            @php
                                $cate=$subscriber->cate;
                            @endphp
                            @if($cate)
                                <div style="padding-bottom: 15px">
                                    <div>
                                        <a href="/subscriber/{{$subscriber->id}}" class="btn btn-default" style="background-color: #fff;color: #848484;font-weight: 400;border-color: #848484;font-size: 1.1rem!important">
                                            訂閱ID：{{$subscriber->id}} <br>
                                            @if($subscriber->is_cancel==0)
                                                <div style="color: black">訂閱狀態：等待審核中...</div>
                                                <div>預計交車日期：{{$subscriber->sub_date}}</div>
                                            @else
                                                <span style="color: #aaa">( 訂閱單已自動取消 )</span>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <hr>
                            <div>&nbsp;</div>
                        @endforeach
                    {{--@else
                        <div style="color: white;text-align: center;">( 您目前暫無任何車輛訂單 )</div>--}}
                    @endif
                    @if($ords->count()>0)
                        @foreach($ords as $key=>$ord)
                            @php
                                $cate=$ord->cate;
                            @endphp
                            @if($cate)
                                <div style="padding-bottom: 15px">
                                    <div>
                                        <a href="/ord/{{$ord->id}}" class="btn btn-default" style="background-color: #fff;color: #848484;font-weight: 400;border-color: #848484;font-size: 1.1rem!important">
                                            訂單編號：{{$ord->ord_no}} <br>
                                            <span style="color: black">訂單狀態：{{$ord->state->ftitle}}</span> <br>
                                            @if($ord->is_cancel==0)
                                                @if($ord->is_paid==1)
                                                    <span style="color: green">( 保證金已付 )</span><br>
                                                    @if($ord->is_paid2==1)
                                                        <span style="color: green">( 起租款已付 )</span><br>
                                                        @if($ord->is_paid3==1)
                                                            <span style="color: green">( 迄租金額已付 )</span><br>
                                                        @endif
                                                    @endif
                                                @endif
                                                交車日期：{{$ord->sub_date}}
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div style="color: white;text-align: center;">( 您目前暫無任何訂單車輛 )</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                    @endif
                </div>
            </div>

        </div>
    </section>

@endsection

@section('extra-js')

@endsection