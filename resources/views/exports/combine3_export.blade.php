@php
    $user=$ord->user;
@endphp
<table class="table table-striped table-bordered" border="1">
    <thead>
    <tr>
        <th colspan="5" style="font-size: 16px;">會員資料：</th>
    </tr>
    <tr>
        <th style="height: 20px;">承租人資訊</th>
        <th>承租人姓名</th>
        <th>承租人ID</th>
        <th>駕照管轄編號</th>
        <th>承租人出生年月日</th>
        <th>承租人市話</th>
        <th>承租人手機</th>
        <th>公司名稱</th>
        <th>公司統一編號</th>
        <th>地址</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="height: 20px;border: 1px solid #dee2e6;"></td>
        <td style="border: 1px solid #dee2e6;">{{$user->name}}</td>
        <td style="border: 1px solid #dee2e6;">{{$user->idno}}</td>
        <td style="border: 1px solid #dee2e6;">{{$user->driver_no}}</td>
        <td style="border: 1px solid #dee2e6;">{{str_replace('-','/',$user->birthday)}}</td>
        <td style="border: 1px solid #dee2e6;">{{$user->telephone}}</td>
        <td style="border: 1px solid #dee2e6;">{{$user->phone}}</td>
        <td style="border: 1px solid #dee2e6;">{{$user->company_name}}</td>
        <td style="border: 1px solid #dee2e6;">{{$user->company_no}}</td>
        <td style="border: 1px solid #dee2e6;">{{$user->address}}</td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="5" style="font-size: 16px;">車籍資料：</th>
        </tr>
        <tr>
            <th style="height: 20px;">車輛資訊</th>
            <th>車輛等級</th>
            <th>月租費率(月/元)</th>
            <th>里程費率(km/元)</th>
            <th>車輛編號(前車號)</th>
            <th>品牌</th>
            <th>車型</th>
            <th>排氣量</th>
            <th>車色</th>
            <th>排檔方式</th>
            <th>座位數</th>
            <th>燃料種類</th>
            <th>年份</th>
            <th>系統里程數(km)</th>
            <th>車輛所在據點</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="height: 20px;border: 1px solid #dee2e6;"></td>
            <td style="border: 1px solid #dee2e6;">{{$cate->title}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->basic_fee}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->mile_fee}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->plate_no}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->brandcat?$product->brandcat->title:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->brandin?$product->brandin->title:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->displacement}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->procolor?$product->procolor->title:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->progeartype?$product->progeartype->title:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->seatnum}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->profuel?$product->profuel->title:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->year}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->milage}}</td>
            <td style="border: 1px solid #dee2e6;">
                @if($product->partner2)
                    {{$product->partner2->title}}/{{$product->partner2->address}}
                @elseif($product->partner)
                    {{$product->partner->title}}/{{$product->partner->address}}
                @endif
            </td>
            {{--<td style="width: 5%;border: 1px solid #dee2e6;">{{$product->partner?$product->partner->address:''}}</td>--}}
        </tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
    </tbody>
</table>
<table class="table table-striped table-bordered" border="1">
    <thead>
    <tr>
        <th colspan="5" style="font-size: 16px;">訂單資料：</th>
    </tr>
    <tr>
        <th style="height: 20px;">訂單編號</th>
        <th>保證金</th>
        <th>支付狀態</th>
        <th>合約月租費(A)</th>
        <th>預付里程數(km)</th>
        <th>預付里程費(B)</th>
        <th>合計費用(A)+(B)</th>
        <th>支付狀態</th>
        <th>起租日(YYYY/MM/DD)</th>
        <th>迄租日(YYYY/MM/DD)</th>
        <th>交車時間</th>
        <th>還車時間</th>
        <th>預計交車日</th>
        <th>到期日</th>
        <th>取還車地點</th>
        {{--<th>地址</th>
        <th>站點電話</th>--}}
    </tr>
    </thead>
    @php
        $cate=$ord->cate;
        $partner=$ord->partner;
    @endphp
    <tbody>
    <tr>
        <td style="height: 20px;border: 1px solid #dee2e6;">{{$ord->ord_no}}</td>
        <td style="border: 1px solid #dee2e6;">{{$ord->deposit}}</td>
        <td style="border: 1px solid #dee2e6;">{{$ord->is_paid==1?'已付':'未付'}}</td>
        <td style="border: 1px solid #dee2e6;">{{$ord->basic_fee * $ord->rent_month}}</td>
        <td style="border: 1px solid #dee2e6;">{{$ord->mile_pre_month * $ord->rent_month}}</td>
        <td style="border: 1px solid #dee2e6;">{{$ord->mile_fee*$ord->mile_pre_month * $ord->rent_month}}</td>
        <td style="border: 1px solid #dee2e6;">{{$ord->payment_total}}</td>
        <td style="border: 1px solid #dee2e6;">&nbsp;</td>
        <td style="border: 1px solid #dee2e6;">&nbsp;</td>
        <td style="border: 1px solid #dee2e6;">&nbsp;</td>
        <td style="border: 1px solid #dee2e6;">&nbsp;</td>
        <td style="border: 1px solid #dee2e6;">&nbsp;</td>
        <td style="border: 1px solid #dee2e6;">{{str_replace('-','/',$ord->sub_date)}}</td>
        <td style="border: 1px solid #dee2e6;">{{str_replace('-','/',$ord->expiry_date)}}</td>
        <td style="border: 1px solid #dee2e6;">{{$partner?$partner->title:''}}/{{$partner?$partner->address:''}}</td>
        {{--<td style="border: 1px solid #dee2e6;">{{$ord->partner?$ord->partner->address:''}}</td>
        <td style="border: 1px solid #dee2e6;">{{$ord->partner?$ord->partner->phone:''}}</td>--}}
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    </tbody>
</table>