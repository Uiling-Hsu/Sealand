@component('mail::message')
# 訂閱續約通知
<span style="color: red;font-weight: 300;">
您好，會員確認續約此車輛
</span>
<br><br>
**續約訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**續約地點：** {{ $ord->return_delivery_address }}
<br>
<hr>
**續約起租日：** {{$ord->sub_date}}

**續約迄租日：** {{$ord->expiry_date}}
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

@endcomponent

