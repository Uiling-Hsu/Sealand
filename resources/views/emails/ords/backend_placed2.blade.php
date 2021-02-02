@component('mail::message')
# 起租款已付淸通知
<br>
您好! 會員已付淸保證金。

**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**訂閱方案:** {{ $ord->cate_title }}

**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}

**已付 起租款 金額：** NT$ {{ number_format($ord->payment_total) }} 元

**預計交車日期:** {{ $ord->sub_date }}

**實際交車日期:** {{ $ord->real_sub_date }}

**實際交車時間:** {{ $ord->real_sub_time }}

**到期日期:** {{ $ord->expiry_date }}
<br><br>
**交車地點：** {{ $ord->delivery_address }}<br>
**還車地點：** {{ $ord->return_delivery_address }}
<br><br>

<a href="{{setting('website')}}/admin/ord/{{$ord->id}}/edit">前往訂單管理</a>
@endcomponent

