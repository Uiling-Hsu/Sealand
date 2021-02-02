@component('mail::message')
# 訂閱開通通知

<br>
您已成功開通訂閱功能，可以開始您的訂閱!
<br><br>
<a href="{{request()->root()}}#list">前往訂閱</a>
<br><br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>

@endcomponent
