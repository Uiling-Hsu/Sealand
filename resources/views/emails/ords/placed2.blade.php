@component('mail::message')
# 起租款付淸通知
<br>
親愛的先生/小姐，您好：
我們已收到您的汽車訂閱 起租款！

**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**訂閱方案:** {{ $ord->cate_title }}

**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}

**已付 起租款 金額：** {{ number_format($ord->payment_total) }} 元

**預計交車日期:** {{ $ord->sub_date }}

**實際交車日期:** {{ $ord->real_sub_date }}

**到期日期:** {{ $ord->expiry_date }}

<br><br>
**交車地點：** {{ $ord->delivery_address }}<br>
**還車地點：** {{ $ord->return_delivery_address }}
<br><br>

客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>

<br>
<img src="{{env('APP_URL')}}/assets/images/qr_code.png" style="width: 100px;border: solid 1px #eee;">
<br>
@endcomponent

