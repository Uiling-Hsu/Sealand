@component('mail::message')
# 會員資料補齊通知

<br>
親愛的會員，您好!

<hr>
<p style="color: red">請補齊以下資料，謝謝您!</p>
@if($user->reject_reason!='')
<div style="font-size: 16px;color: red">
{!! nl2br($user->reject_reason) !!}
</div>
<hr>
@endif

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
<img src="{{$website}}/user_send_email/idcard_image02/{{$user->idcard_image02}}" alt="">
@endif
@if($user->driver_image01)
<br>
<img src="{{$website}}/user_send_email/driver_image01/{{$user->driver_image01}}" alt="">
@endif
@if($user->driver_image02)
<br>
<img src="{{$website}}/user_send_email/driver_image02/{{$user->driver_image02}}" alt="">
@endif
<br>

**駕照管轄編號:** {{ $user->driver_no }}

<br>
**緊急聯絡人:** {{ $user->emergency_contact }}

**緊急聯絡人手機:** {{ $user->emergency_phone }}


客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>

<br>
<img src="{{env('APP_URL')}}/assets/images/qr_code.png" style="width: 100px;border: solid 1px #eee;">
<br>
@endcomponent
