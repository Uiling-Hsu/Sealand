@component('mail::message')
# 交車提醒通知
<br>
**預計交車日期:** {{ $ord->sub_date }}
<br>
@if($ord->pick_up_time)
**前往取車時間:** {{ $ord->pick_up_time }}<br>
@endif
**交車地點：** {{ $ord->delivery_address }}
<br>
<hr>
<br>

**車輛資訊:**

@php
    $product=$ord->product;
@endphp
車號：{{$ord->plate_no}}<br>
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
@endcomponent

