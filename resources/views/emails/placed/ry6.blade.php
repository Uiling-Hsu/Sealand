@component('mail::message')
# 已交車通知
<br><br>
**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**已付起租款：** {{ number_format($ord->payment_total) }} 元

**實際交車日期:** {{ $ord->real_sub_date }}

**實際交車時間:** {{ $ord->real_sub_time }}

**到期日:** {{ $ord->expiry_date }}
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

<a href="{{setting('website')}}/admin/ord/{{$ord->id}}/edit">前往訂單管理</a>
@endcomponent

