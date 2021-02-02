@component('mail::message')
# 匯款帳號後5碼回報通知

<br><br>
**訂單編號:** {{ $ord->ord_no }}

**帳號後5碼:** {{ $ord->upload_5code }}

**姓名:** {{ $ord->name }}

**電話:** {{ $ord->phone }}

**匯款金額:** {{ $ord->upload_total }}

**匯款日期:** {{ $ord->upload_date }}

**備註:** {{ $ord->upload_memo }}


@endcomponent
