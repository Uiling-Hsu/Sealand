@component('mail::message')
# 起租繳款通知
<br><br>
**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

@php
    $basic_fee=$ord->basic_fee;
    $mile_fee=$ord->mile_fee;
    $mile_pre_month=$ord->mile_pre_month;
    $payment_total=($basic_fee+($mile_fee*$mile_pre_month)) * $ord->rent_month;
@endphp
<span style="color: red"><br>起租款：<br>
( {{number_format($basic_fee)}} + ( {{$mile_fee}} x {{number_format($mile_pre_month)}} ) ) * {{$ord->rent_month}} = {{number_format($payment_total)}} 元
</span>
<br><br><br>
<a href="{{request()->root()}}/ord/{{$ord->id}}">起租繳款連結</a>
<hr>
<br>

客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{$email}}">{{$email}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>
@endcomponent

