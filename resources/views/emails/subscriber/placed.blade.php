@component('mail::message')
# 訂閱資訊
<br>
親愛的先生/小姐，您好：
我們已收到您送出審核的車輛訂閱資料，我們會儘快回覆審核結果。

@php
    $user=$subscriber->user;
    $cate=$subscriber->cate;
    $proarea=$subscriber->proarea;
@endphp
**您的訂閱方案:** {{ $cate->title }}

@if($proarea)
**您的交車區域:** {{ $proarea->title }}
@endif

**預計交車日期:** {{ $subscriber->sub_date }}

**您的訂閱價格:** {{ number_format($cate->basic_fee) }}

**姓名:** {{ $user->name }}

**電話:** {{ $user->phone }}

**Email:** {{ $user->email }}



**車輛資訊:**

@php
    $product=$subscriber->product;
@endphp
{{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
車型： {{$product->brandin?$product->brandin->title:''}}<br>
排氣量： {{ number_format($product->displacement) }}<br>
年份： {{ $product->year }}<br>
排檔： {{$product->progeartype?$product->progeartype->title:''}}<br>
座位數： {{$product->seatnum}}<br>
顏色： {{$product->procolor?$product->procolor->title:''}}<br>
里程數： {{ number_format($product->milage) }}<br>
{{--@component('mail::subscribers', ['subscriber' => $subscriber])
訂閱清單
@endcomponent--}}
<div style="font-size: 16px;">
掃描以下 QR-CODE 加入LINE 好友。<br><br>
<img src="{{env('APP_URL')}}/assets/images/qr_code.png" style="width: 150px;border: solid 1px #eee;">
<br><br><br>

客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>
</div>

@endcomponent

