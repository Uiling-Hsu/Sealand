@component('mail::message')
# 起租款 繳款通知
<br>
親愛的先生/小姐，您好：
<br>
以下為您的訂單資訊：

**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**訂閱方案:** {{ $ord->cate_title }}

**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}

@if($ord->pick_up_time)
**前往取車時間:** {{ $ord->pick_up_time }}
@endif

**保證金：** {{ number_format($ord->deposit) }} 元

<span style="color: red">**此次應付起租款：** {{ number_format($ord->payment_total) }} 元</span>
@php
    $basic_fee=$ord->basic_fee;
    $mile_fee=$ord->mile_fee;
    $mile_pre_month=$ord->mile_pre_month;
    $payment_total=($basic_fee+($mile_fee*$mile_pre_month)) * $ord->rent_month;
@endphp
<span style="color: red"><br>計算如下：<br>
( {{number_format($basic_fee)}} + ( {{$mile_fee}} x {{number_format($mile_pre_month)}} ) ) * 3 = {{number_format($payment_total)}} 元</span>

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

<a href="{{setting('website')}}/ord/{{$ord->id}}">訂單繳款頁面連結</a>

客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>

<br>
<img src="{{env('APP_URL')}}/assets/images/qr_code.png" style="width: 100px;border: solid 1px #eee;">
<br>
@endcomponent

