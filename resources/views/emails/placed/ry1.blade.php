@component('mail::message')
# 訂閱審核通知
<br>
@php
    $user=$subscriber->user;
    $cate=$subscriber->cate;
    $proarea=$subscriber->proarea;
@endphp
**姓名:** {{ $user->name }}

**電話:** {{ $user->phone }}

**Email:** {{ $user->email }}

**訂閱方案:** {{ $cate->title }}

**月租費:** {{ $cate->basic_fee }}

@if($proarea)
**交車區域:** {{ $proarea->title }}
@endif

**預計交車日:** {{ $subscriber->sub_date }}

**前往取車時間:** {{ $subscriber->pick_up_time }}

<br><br>
@php
    $product=$subscriber->product;
@endphp
@if($product)
**車輛資訊:**
{{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
車型：{{$product->brandin?$product->brandin->title:''}}<br>
品牌：{{$product->brandcat?$product->brandcat->title:''}}<br>
顏色：{{$product->procolor?$product->procolor->title:''}}<br>
排氣量： {{ number_format($product->displacement) }}<br>
年份：{{ $product->year }}<br>
里程：{{ number_format($product->milage) }}<br>
座位：{{$product->seatnum}}<br>
排檔：{{$product->progeartype?$product->progeartype->title:''}}<br>
@endif
<br><br>
<a href="{{setting('website')}}/admin/subscriber/{{$subscriber->id}}/edit">前往訂閱車輛管理</a>
<br><br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>
@endcomponent

