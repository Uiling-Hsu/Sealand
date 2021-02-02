@component('mail::message')
# 訂閱換車通知
{{--<span style="color: red;font-weight: 300;">
請至SeaLand選擇您要換的車輛，謝謝您!
</span>--}}
<br><br>
**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**換車地點：** {{ $ord->return_delivery_address }}
<br>
<hr>
<br>
**原訂單：**
@php
    $product=$ord->product;
    $orginal_ord=\App\Model\Ord::whereId($ord->renew_ord_id)->first();
    $orginal_product=null;
    if($orginal_ord)
        $orginal_product=$orginal_ord->product;
@endphp
@if($orginal_ord && $orginal_product)
車號：{{$orginal_ord->plate_no}}<br>
車型： {{$orginal_product->brandin?$orginal_product->brandin->title:''}}<br>
品牌： {{$orginal_product->brandcat?$orginal_product->brandcat->title:'' }}<br>
顏色： {{$orginal_product->procolor?$orginal_product->procolor->title:''}}<br>
排氣量： {{ number_format($orginal_product->displacement) }}<br>
年份： {{ $orginal_product->year }}<br>
里程： {{ number_format($orginal_product->milage) }}<br>
座位： {{$orginal_product->seatnum}}<br>
排檔： {{$orginal_product->progeartype?$orginal_product->progeartype->title:''}}<br>
@endif
<br>
<hr>
<br>
**新訂單：**

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

