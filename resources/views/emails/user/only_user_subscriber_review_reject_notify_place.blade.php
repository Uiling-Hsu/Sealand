@component('mail::message')
# 審核會員可訂閱方案通知
<br>
@php
    $user=$subscriber->user;
    $cate=$subscriber->cate;
    $proarea=$subscriber->proarea;
@endphp
親愛的會員，您好!
<span style="color: red">您所訂閱的方案：{{$cate->title}}，無法通過審核。再請您重新點選其他方案!</span>
<br><br>
訂閱ID：{{$subscriber->id}}
<br>
@if($cate)
訂閱方案: {{$cate->title}}
<br>
@if($proarea)
交車區域: {{ $proarea->title }}
@endif
<br>
訂閱價格: {{number_format($cate->basic_fee)}}
<br>
@endif
<hr>
以下是會員相關資訊：

**會員ID:** {{ $user->id }}

**真實姓名:** {{ $user->name }}

**手機:** {{ $user->phone }}

**Email:** {{ $user->email }}

**身份證字號:** {{ $user->idno }}

<hr>
<br><br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>

<br>
<img src="{{env('APP_URL')}}/assets/images/qr_code.png" style="width: 100px;border: solid 1px #eee;">
<br>

@endcomponent
