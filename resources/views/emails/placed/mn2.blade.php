@component('mail::message')
<span style="color: red">方案審核不通過通知</span>
<br>
@php
    $cate=$subscriber->cate;
    $proarea=$subscriber->proarea;
    $product=$subscriber->product;
@endphp

**訂閱方案:** {{ $cate->title }}

**月租費:** {{ $cate->basic_fee }}

{{--**訂閱價格:** {{ number_format($cate->basic_fee) }}--}}
@if($proarea)
**交車區域:** {{ $proarea->title }}
@endif

{{--
**前往交車日:** {{ $subscriber->sub_date }}

**前往取車時間:** {{ $subscriber->pick_up_time }}
--}}

<br><br>
@if($product)
**車輛資訊:**
{{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
車型：{{$product->brandin?$product->brandin->title:''}}<br>
品牌：{{$product->brandcat?$product->brandcat->title:''}}<br>
顏色：{{$product->procolor?$product->procolor->title:''}}<br>
排氣量： {{ number_format($product->displacement) }}<br>
年份：{{ $product->year }}<br>
里程：{{ number_format($product->milage) }}<br>
座位：{{$product->seatnum}}<br>
排檔：{{$product->progeartype?$product->progeartype->title:''}}<br>
@endif
<br><br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>
@endcomponent

