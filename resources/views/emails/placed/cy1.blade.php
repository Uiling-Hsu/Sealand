@component('mail::message')
# {{$user->name}} / 會員資料審查通知

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

<a href="{{setting('website')}}/admin/user/{{$user->id}}/edit">前往會員管理</a>
@endcomponent
