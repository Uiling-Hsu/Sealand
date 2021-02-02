@component('mail::message')
# 迄租款已付淸通知
<br>
您好! 會員已付淸迄租款。

**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**訂閱方案:** {{ $ord->cate_title }}

**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}

**已付 迄租款項 金額：** NT$ {{ number_format($ord->payment_backcar_total) }} 元
<br><br>
**還車地點：** {{ $ord->return_delivery_address }}
<br><br>

<a href="{{setting('website')}}/admin/ord/{{$ord->id}}/edit">前往訂單管理</a>
@endcomponent

