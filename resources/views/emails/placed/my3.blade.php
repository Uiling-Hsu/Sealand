@component('mail::message')
# 保證金付清通知
<br><br>
**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**預計交車日期:** {{ $ord->sub_date }}

@if($ord->pick_up_time)
**前往取車時間:** {{ $ord->pick_up_time }}
@endif

**交車地點：** {{ $ord->delivery_address }}

**已付保證金：** {{ number_format($ord->deposit) }} 元
<br>
<hr>
<br>
**訂閱方案:** {{ $ord->cate_title }}

**月租費:** {{ number_format($ord->basic_fee) }}

**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}
<br>
<hr>
<br>

**車輛資訊:**

@php
    $product=$ord->product;
@endphp
{{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
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

