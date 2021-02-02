@component('mail::message')
# 您的留言及回覆訊息內容
<br>
親愛的先生/小姐，您好：<br>


您的相關資訊及訊息：

**姓名:** {{ $contact->name }}

**電話:** {{ $contact->phone }}

**Email:** {{ $contact->email }}

**訊息:** {{ nl2br($contact->message) }}

以下是我們的回覆：

<div style="color: #502d00;font-size: 16px;">{!!  nl2br($contact->reply_message) !!}</div>

@php
    $phone=setting('phone');
    $email=setting('email');
    $website=setting('website');
@endphp
<br><br>
如有還有其它任何問題，歡迎使用下列方式與客服人員聯絡！<br>
@if($phone)
    客服專線：{{$phone}}<br>
@endif
客服信箱：<br>
<a href="mailto:{{$email}}">{{$email}}</a><br>
官方網站：<br>
<a href="{{$website}}">{{$website}}</a><br>
<br>
<img src="{{env('APP_URL')}}/assets/images/qr_code.png" style="width: 100px;border: solid 1px #eee;">
<br>
{{setting('store_name')}} 敬上
@endcomponent
