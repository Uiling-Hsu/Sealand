@component('mail::message')
# 交車時間變更通知
<br>
您好!交車日期已變更。

**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**訂閱方案:** {{ $ord->cate_title }}

**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}

<span style="color: red">
**預計交車日期:** {{ $ord->sub_date }}
<span>


@if($ord->pick_up_time)
**前往取車時間:** {{ $ord->pick_up_time }}
@endif

**已付 保證金：** NT$ {{ number_format($ord->deposit) }} 元
<br>
<br>

**車輛資訊:**

@php
    $product=$ord->product;
@endphp
{{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
車型： {{$product->brandin?$product->brandin->title:''}}<br>
排氣量： {{ number_format($product->displacement) }}<br>
年份： {{ $product->year }}<br>
排檔： {{$product->progeartype?$product->progeartype->title:''}}<br>
座位數： {{$product->seatnum}}<br>
顏色： {{$product->procolor?$product->procolor->title:''}}<br>
里程數： {{ number_format($product->milage) }}<br>
<br><br>

@php
    $user=$ord->user;
@endphp
身份證正面照片：<br>
<img src="{{setting('website')}}/user_send_email/idcard_image01/{{$user->idcard_image01}}" alt=""><br><br>
身份證反面照片：<br>
<img src="{{setting('website')}}/user_send_email/idcard_image02/{{$user->idcard_image02}}" alt=""><br>

<a href="{{setting('website')}}/admin/ord/{{$ord->id}}/edit">前往訂單管理</a>
@endcomponent

