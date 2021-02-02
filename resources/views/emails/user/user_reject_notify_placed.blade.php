@component('mail::message')
# 資料補齊提醒通知

<br>
親愛的會員，您好!

<hr>
<p style="color: red">很抱歉您所提供的證件未確實，
請更新您的證件資料並重新送出你的訂閱需求。 謝謝您!</p>
<hr>

以下是您的相關資訊：

**會員ID:** {{ $user->id }}

**真實姓名:** {{ $user->name }}

**手機:** {{ $user->phone }}

**Email:** {{ $user->email }}


**生日:** {{ $user->birthday }}

**身份證字號:** {{ $user->idno }}

@php
$website=setting('website');
@endphp
@if($user->idcard_image01)
<br>
<img src="{{$website}}/user_send_email/idcard_image01/{{$user->idcard_image01}}" alt="">
@endif
@if($user->idcard_image02)
<br>
<img src="{{$website}}{{$user->idcard_image02}}" alt="">
@endif
@if($user->driver_image01)
<br>
<img src="{{$website}}{{$user->driver_image01}}" alt="">
@endif
@if($user->driver_image02)
<br>
<img src="{{$website}}{{$user->driver_image02}}" alt="">
@endif
<br>

**駕照管轄編號:** {{ $user->driver_no }}

<br>
**緊急聯絡人:** {{ $user->emergency_contact }}

**緊急聯絡人手機:** {{ $user->emergency_phone }}

<hr>
<br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>

<br>
Regards, <br>
{{setting('store_name')}}
@endcomponent
