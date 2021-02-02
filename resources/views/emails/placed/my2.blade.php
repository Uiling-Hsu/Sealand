    @component('mail::message')
# 方案審核通過通知
<br>
@php
    $cate=$subscriber->cate;
    $proarea=$subscriber->proarea;
    $product=$subscriber->product;
    $ord=$subscriber->ord;
    $minute_30=date('Y-m-d H:i:s', strtotime('+30 minute', strtotime($ord->created_at)));
    if($ord->is_pass_by_api==1)
        $limit_minutes=setting('ord_limit_minutes');
    else
        $limit_minutes=480;
    $expired_at=date('Y-m-d H:i:s', strtotime('+'.$limit_minutes.' minute', strtotime($ord->created_at)));
@endphp

**訂閱方案:** {{ $cate->title }}

**月租費:** {{ $cate->basic_fee }}

{{--**訂閱價格:** {{ number_format($cate->basic_fee) }}--}}
@if($proarea)
**交車區域:** {{ $proarea->title }}
@endif

**交車地點:** {{ $subscriber->delivery_address }}

{{--
**前往交車日:** {{ $subscriber->sub_date }}

**前往取車時間:** {{ $subscriber->pick_up_time }}
--}}

<br><br>
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
<a href="{{request()->root()}}/ord/{{$ord->id}}">保證金繳款連結</a>
<div style="color: red;font-size: 15px">( 請於 {{$expired_at}} 前付淸保證金後，訂單始生效 )</div>
<br><br>
客服電話：{{setting('phone')}}<br>
客服信箱：<a href="mailto:{{setting('email')}}">{{setting('email')}}</a><br>
官方網站：<a href="{{request()->root()}}">{{request()->root()}}</a><br>
@endcomponent

