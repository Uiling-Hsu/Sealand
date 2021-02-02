@component('mail::message')
<span style="color: red;font-size: 18px;">
訂單失效通知
</span>
<br>
@php
    $cate=$ord->cate;
    $proarea=$ord->proarea;
    $product=$ord->product;
@endphp

**由於繳款連結已超過有效期間，訂單已失效。<br>請重新訂閱，謝謝您。**

**訂閱方案:** {{ $cate->title }}

**月租費:** {{ $cate->basic_fee }}

{{--**訂閱價格:** {{ number_format($cate->basic_fee) }}--}}
@if($proarea)
**交車區域:** {{ $proarea->title }}
@endif
<br>
<hr>
<br>

**車輛資訊:**

@php
    $product=$ord->product;
@endphp
車型： {{$product->brandin?$product->brandin->title:''}}<br>
品牌： {{$product->brandcat?$product->brandcat->title:'' }}<br>
顏色： {{$product->procolor?$product->procolor->title:''}}<br>
排氣量： {{ number_format($product->displacement) }}<br>
年份： {{ $product->year }}<br>
里程： {{ number_format($product->milage) }}<br>
座位： {{$product->seatnum}}<br>
排檔： {{$product->progeartype?$product->progeartype->title:''}}<br>
<hr>
<br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>

@endcomponent

