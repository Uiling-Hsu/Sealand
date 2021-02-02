@component('mail::message')
# 審核會員可訂閱方案通知
<br>
您好!
<span style="color: red">會員所訂閱方案無法通過審核。再請會員重新點選其他方案!</span>
<br><br>
訂閱ID：{{$subscriber->id}}
<br>
@php
    $user=$subscriber->user;
    $cate=$subscriber->cate;
    $proarea=$subscriber->proarea;
@endphp
@if($cate)
訂閱方案: {{$cate->title}}
<br>
訂閱價格: {{number_format($cate->basic_fee)}}
<br>
@if($proarea)
交車區域: {{ $proarea->title }}
@endif
@endif
<hr>
以下是會員相關資訊：

**會員ID:** {{ $user->id }}

**真實姓名:** {{ $user->name }}

**手機:** {{ $user->phone }}

**Email:** {{ $user->email }}

**身份證字號:** {{ $user->idno }}
@if($subscriber->memo!='')
**拒絕原因:** {{ $subscriber->memo }}
@endif

<hr>
Best regard,
{{setting('store_name')}}

@endcomponent
