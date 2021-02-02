@component('mail::message')
# 起租款付淸通知
<br><br>
**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**已付起租款：** {{ number_format($ord->payment_total) }} 元

**實際交車日期:** {{ $ord->real_sub_date }}

**實際交車時間:** {{ $ord->real_sub_time }}

**到期日期:** {{ $ord->expiry_date }}
<br>
<hr>
<br>

客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>
@endcomponent

