@component('mail::message')
# 車輛已還車
<br>
您好:<br>
提醒您此車輛已還車!

**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**訂閱方案:** {{ $ord->cate_title }}

**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}

**還車日期：** {{ $ord->real_back_date }} {{$ord->real_back_time}}
<br>
<br>

**車輛資訊:**

@php
    $product=$ord->product;
@endphp
{{--{{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}--}}
車號：{{$ord->plate_no}}<br>
品牌： {{$product->brandcat?$product->brandcat->title:'' }}<br>
車型： {{$product->brandin?$product->brandin->title:''}}<br>
排氣量： {{ number_format($product->displacement) }}<br>
年份： {{ $product->year }}<br>
排檔： {{$product->progeartype?$product->progeartype->title:''}}<br>
座位數： {{$product->seatnum}}<br>
顏色： {{$product->procolor?$product->procolor->title:''}}<br>
里程數： {{ number_format($product->milage) }}<br>
<br><br>
**還車地點：** {{ $ord->return_delivery_address }}

<br><br>
<hr>
Best regard,
{{setting('store_name')}}

@endcomponent

