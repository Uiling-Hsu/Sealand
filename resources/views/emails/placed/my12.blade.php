@component('mail::message')
# 其他費用繳款提醒
<br><br>
**繳費期限：** {{ $user->fee_title }}

**E-Tag：** {{ number_format($user->e_tag) }}

**停車費：** {{ number_format($user->park_fee) }}

**罰單：** {{ number_format($user->ticket) }}

**保養費：** {{ number_format($user->maintain_fee) }}

@if($user->custom_fee>0)
**{{ $user->custom_title }}：** 金額：{{ number_format($user->custom_fee) }}
@endif

<span style="color: green;font-weight: bold;font-size: 20px;">
**金額總計：** {{ number_format($user->total) }}
</span>

<br>
<hr>
<br>
<a href="{{request()->root()}}/user/user_fee">自行繳費明細</a>
<br><br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>
@endcomponent

