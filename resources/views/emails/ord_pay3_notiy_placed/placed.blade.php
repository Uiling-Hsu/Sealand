@component('mail::message')
@if($ord->payment_backcar_total>0)
# 迄租繳款通知
@endif
<br>
親愛的先生/小姐，您好：
<br>
以下為您的訂單資訊：

**訂單編號:** {{ $ord->ord_no }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**Email:** {{ $ord->email }}

**訂閱方案:** {{ $ord->cate_title }}

**交車區域:** {{ $ord->proarea?$ord->proarea->title:'' }}
<br><br>
@if($ord->payment_backcar_total>0)
<span style="color: red">**應付迄租款：** {{ number_format($ord->payment_backcar_total) }} 元</span>
@endif
<div>&nbsp;</div>

<a href="{{setting('website')}}/ord/{{$ord->id}}">訂單{{$ord->payment_backcar_total>0?'繳款':''}}頁面連結</a>

客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>

<br>
<img src="{{env('APP_URL')}}/assets/images/qr_code.png" style="width: 100px;border: solid 1px #eee;">
<br>
@endcomponent

