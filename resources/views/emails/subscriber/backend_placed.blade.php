@component('mail::message')
# 會員已送出訂閱單通知
<br>
您好：
會員已送出車輛訂閱資料。

@php
    $user=$subscriber->user;
    $cate=$subscriber->cate;
    $proarea=$subscriber->proarea;
@endphp
**姓名:** {{ $user->name }}

**電話:** {{ $user->phone }}

**Email:** {{ $user->email }}

**訂閱方案:** {{ $cate->title }}

**月租費:** {{ $cate->basic_fee }}

**訂閱價格:** {{ number_format($cate->basic_fee) }}

@if($proarea)
**交車區域:** {{ $proarea->title }}
@endif

**預計交車日期:** {{ $subscriber->sub_date }}

**前往取車時間:** {{ $subscriber->pick_up_time }}

**訂閱清單：**

@component('mail::subscribers', ['subscriber' => $subscriber])
訂閱清單
@endcomponent
<br><br>

<a href="{{setting('website')}}/admin/subscriber/{{$subscriber->id}}/edit">前往訂閱車輛管理</a>

@endcomponent

