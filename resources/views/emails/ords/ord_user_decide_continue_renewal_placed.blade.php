component('mail::message')
# 會員已決定要續約車輛通知
<br>
您好! 會員已確認續訂您提供的車輛。

**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**訂閱方案:** {{ $ord->cate_title }}

**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}

**訂閱到期剩餘天數:** {{ getOrdLeftDays($ord->id) }} 天

<br>
<br>

**車輛資訊:**

@php
    $product=$ord->product;
@endphp
{{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
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

<a href="{{setting('website')}}/admin/ord?search_keyword={{$ord->ord_no}}">前往訂單檢視</a>
@endcomponent

