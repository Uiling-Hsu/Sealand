@component('mail::message')
# 訂閱購車通知
<span style="color: red;font-weight: 300;">
請於到期日前至購車地點辦理購車手續，謝謝您!
</span>
<br><br>
**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**訂閱到期天數:** {{ getOrdLeftDays($ord->id) }} 天

**購車地點：** {{ $ord->return_delivery_address }}
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
<br><br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>
@endcomponent

