@extends('frontend_carplus.layouts.app')

@section('extra-css')

@stop

@section('content')
    <section class="extFeatures cid-s12THEJrXk" id="extFeatures21-4" style="background-image: url(/assets/images/flow_bg.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2 class="mbr-section-title pb-2 mbr-bold mbr-fonts-style align-left display-1">我的訂閱列表<br><br></h2>
                    @if($subscribers->count()>0)
                        <div style="text-align: center;color: white">( 本訂閱單為您已送出，等待保姆配車中 )</div>
                        <div style="text-align: center;">&nbsp;</div>
                    @endif
                </div>
            </div>
            <div class="row row-content justify-content-center">
                <div class="card p-3 col-12" style="max-width: 600px">
                    <div>
                        @if($subscribers->count()>0)
                            @foreach($subscribers as $key=>$subscriber)
                                @php
                                    $cate=$subscriber->cate;
                                @endphp
                                @if($cate)
                                    <div style="padding-bottom: 15px">
                                        <div>
                                            <a href="/subscriber/{{$subscriber->id}}" class="btn btn-default" style="background-color: #fff;color: #848484;font-weight: 400;border-color: #848484;font-size: 1.1rem!important">{{$key+1}}.{{$cate->title}}</a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div style="color: white;text-align: center;">( 您目前暫無訂閱中車輛 )</div>
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

        </div>
    </section>

@endsection

@section('extra-js')

@endsection