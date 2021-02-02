@component('mail::message')
# 迄租繳款通知
<br><br>
**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

<hr>
@if($ord->payment_backcar_total>0)
**應付迄租款：** {{ number_format($ord->payment_backcar_total) }}
@else
**Sealand 應退還：** {{ number_format($ord->payment_backcar_total * (-1)) }}
@endif


@if($ord->payment_total>0)
<br>
<hr>
<br>
<a href="{{request()->root()}}/ord/{{$ord->id}}">迄租款繳款連結</a>
@endif
<br><br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>
@endcomponent

