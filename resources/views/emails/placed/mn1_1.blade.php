@component('mail::message')
# 會員資料補齊通知

<br>
親愛的會員，您好!
<hr>
<p style="color: green">請補齊以下資料，謝謝您!</p>
@if($user->reject_reason!='')
<div style="font-size: 16px;color: red">
{!! nl2br($user->reject_reason) !!}
</div>
@endif

<br><br>
<a href="{{request()->root()}}/user/user_update"> 前往修改基本資料</a>
<br><br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>

@endcomponent
