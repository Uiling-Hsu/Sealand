@component('mail::message')
# 交車提醒
<br>

**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**訂閱方案:** {{ $ord->cate_title }}

{{--**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}--}}

**預計交車日：** {{ $ord->sub_date }}

@if($ord->pick_up_time)
**前往取車時間：** {{ $ord->pick_up_time }}
@endif
<br>
<br>

**車輛資訊:**

@php
    $product=$ord->product;
@endphp
{{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
@if($product)
車號：{{$ord->plate_no}}<br>
品牌： {{$product->brandcat?$product->brandcat->title:'' }}<br>
車型： {{$product->brandin?$product->brandin->title:''}}<br>
顏色： {{$product->procolor?$product->procolor->title:''}}<br>
里程數： {{ number_format($product->milage) }}<br>
@endif
<br><br>
**交車地點：** {{ $ord->delivery_address }}<br>
**還車地點：** {{ $ord->return_delivery_address }}

<br><br>
<hr>
Best regard,
{{setting('store_name')}}

@endcomponent

