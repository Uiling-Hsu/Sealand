@component('mail::message')
# 訂單已取消通知
<br>
親愛的先生/小姐，您好：<br>
您的已取消訂單。

**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**訂閱方案:** {{ $ord->cate_title }}

**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}

<br>
<br>

**車輛資訊:**

@php
    $product=$ord->product;
@endphp
{{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
品牌： {{$product->brandcat?$product->brandcat->title:'' }}<br>
車型： {{$product->brandin?$product->brandin->title:''}}<br>
排氣量： {{ number_format($product->displacement) }}<br>
年份： {{ $product->year }}<br>
排檔： {{$product->progeartype?$product->progeartype->title:''}}<br>
座位數： {{$product->seatnum}}<br>
顏色： {{$product->procolor?$product->procolor->title:''}}<br>
里程數： {{ number_format($product->milage) }}<br>
<br><br>

客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>

<br>
<img src="{{env('APP_URL')}}/assets/images/qr_code.png" style="width: 100px;border: solid 1px #eee;">
<br>
@endcomponent

