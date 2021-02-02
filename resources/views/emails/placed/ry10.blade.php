@component('mail::message')
# 已還車通知
<br>
**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

@if($ord->payment_backcar_total>0)
**已付迄租款：** {{ number_format($ord->payment_backcar_total) }}
@else
**Sealand 應退還：** {{ number_format($ord->payment_backcar_total * (-1)) }}
@endif

**實際還車日:** {{ $ord->real_back_date }}

**實際還車時間:** {{ $ord->real_back_date }}

**到期日:** {{ $ord->expiry_date }}

@endcomponent

