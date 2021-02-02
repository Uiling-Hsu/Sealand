@component('mail::message')
# 審核會員可訂閱方案通知

親愛的會員，您好! 您申請的訂閱方案已通過審核，保姆在配選車輛後會成立訂單通知。
<br><br>
您的訂閱ID：{{$subscriber->id}}
<br>
@php
    $user=$subscriber->user;
    $cate=$subscriber->cate;
    $proarea=$subscriber->proarea;
@endphp
@if($cate)
您的訂閱方案: {{$cate->title}}
<br>
您的訂閱價格: {{number_format($cate->basic_fee)}}
<br>
@if($proarea)
交車區域: {{ $proarea->title }}
@endif
@endif
<hr>
以下是您的相關資訊：

**會員ID:** {{ $user->id }}

**真實姓名:** {{ $user->name }}

**手機:** {{ $user->phone }}

**Email:** {{ $user->email }}

**身份證字號:** {{ $user->idno }}

<hr>
<br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>

<br>
<img src="{{env('APP_URL')}}/assets/images/qr_code.png" style="width: 100px;border: solid 1px #eee;">
<br>
@endcomponent
