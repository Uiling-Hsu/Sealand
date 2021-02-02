@component('mail::message')
# {{$ord->name}} / 續約訂單產生通知

<br>
**訂單編號:** {{ $ord->ord_no }}

**訂閱方案:** {{ $ord->cate_title }}

**月租費:** {{ number_format($ord->basic_fee) }}

**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}

<hr>
<div style="padding-top: 3px">&nbsp;</div>
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
<a href="{{setting('website')}}/admin/ord/{{$ord->id}}/edit">前往訂單管理</a>
<br><br>
@endcomponent

