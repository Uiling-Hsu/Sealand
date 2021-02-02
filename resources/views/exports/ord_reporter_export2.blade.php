<table class="table table-striped table-bordered" id="draggable" style="border:solid 1px #ccc">
    <thead>
    <tr>
        <th colspan="5" style="height: 50px;font-size: 30px;color: #22989c">Sealand 月結報表</th>
        <th colspan="3">製表日期：{{date('Y-m-d')}}</th>
    </tr>
    <tr>
        <th colspan="5" style="height: 25px;font-weight: bold;font-size: 16px;">合作廠商：{{$partner->title}}</th>
    </tr>
    <tr>
        <th colspan="3" style="height: 25px;font-weight: bold;font-size: 15px;">月報表年月：{{$ym}}</th>
    </tr>
    <tr>
        <td style="border:solid 1px #ccc">&nbsp;</td>
        <td colspan="13" style="background-color: #e3f5fd;height: 25px;text-align: center;border:solid 1px #ccc">服務費用</td>
        <td colspan="11" style="background-color: #fde9e9;border:solid 1px #ccc;text-align: center">代收費用</td>
        <td style="background-color: #ecfde9;border:solid 1px #ccc;text-align: center">應付金額</td>
    </tr>
    <tr>
        <th style="border:solid 1px #ccc;height: 40px;background-color: #e3f5fd;width: 5px">No.</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 15px">訂單編號</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 15px">付款日期</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 10px">合約月租費</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 10px">取車里程</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 10px">還車里程</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 10px">合計使用<br>里程(A)</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 10px">預付里程數<br>(B)</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 10px">差額里程數<br>(A)-(B)</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 10px">里程費率<br>KM/元</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 10px">補(退)金額</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 10px">總計費用</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 10px">平台服務費<br>(16%)</th>
        <th style="border:solid 1px #ccc;background-color: #e3f5fd;width: 10px">合作商費用<br>(N)</th>
        <th style="border:solid 1px #ccc;background-color: #fde9e9;width: 10px">e-tag <br>金額</th>
        <th style="border:solid 1px #ccc;background-color: #fde9e9;width: 10px">車損費用</th>
        <th style="border:solid 1px #ccc;background-color: #fde9e9;width: 10px">營業損失標題</th>
        <th style="border:solid 1px #ccc;background-color: #fde9e9;width: 10px">營業損失金額</th>
        <th style="border:solid 1px #ccc;background-color: #fde9e9;width: 10px">逾時租金</th>
        <th style="border:solid 1px #ccc;background-color: #fde9e9;width: 10px">超里程費用</th>
        <th style="border:solid 1px #ccc;background-color: #fde9e9;width: 10px">油費</th>
        <th style="border:solid 1px #ccc;background-color: #fde9e9;width: 10px">牽送車服務<br>費</th>
        <th style="border:solid 1px #ccc;background-color: #fde9e9;width: 10px">代收費用合<br>計</th>
        <th style="border:solid 1px #ccc;background-color: #fde9e9;width: 10px">代收刷卡服<br>務費用(3%)</th>
        <th style="border:solid 1px #ccc;background-color: #fde9e9;width: 10px">代收費用總<br>計(G)</th>
        <th style="border:solid 1px #ccc;background-color: #ecfde9;width: 15px">應付合作廠<br>商金額(N+G)</th>
    </tr>
    </thead>
    <tbody>
    @php
        $total=0;
    @endphp
    @foreach($start_ords as $key=>$start_ord)
        @php
            $basic_3fee=$start_ord->basic_fee * $ord->rent_month; //合約月租費
            $use_mile=$start_ord->back_milage-$start_ord->milage; //合計使用里程(A)
            $mile_3month=$start_ord->mile_pre_month * $ord->rent_month; //預付里程數(B)
            $sub_use_mile=$use_mile-$mile_3month; //差額里程數(A-B)
            $mile_fee=$start_ord->mile_fee; //里程費率Km/元
            $mile_fee_total=$sub_use_mile*$mile_fee; //補(退)金額(G)
            $fee_subtotal=$basic_3fee+($mile_3month*$mile_fee)+$mile_fee_total; //總計費用
            $platform_service_fee=$fee_subtotal * 0.16; //平台服務費(16%)
            $partner_service_fee=$fee_subtotal - $platform_service_fee; //合作商費用(N)

            $e_tag=$start_ord->e_tag; //e-tag 金額
            $damage_fee=$start_ord->damage_fee; //車損費用
            $business_loss=$start_ord->business_loss; //營業損失
            $delay_fee=$start_ord->delay_fee; //逾時租金
            $over_mile_fee=0; //超里程費用
            $fuel_cost=$start_ord->fuel_cost; //油費
            $service_charge=$start_ord->service_charge; //牽送車服務費
            $other_fee_total=$e_tag+$damage_fee+$business_loss+$delay_fee+$over_mile_fee+$fuel_cost+$service_charge;
            $credit_service_fee=-$other_fee_total*0.03; //代收刷卡服務費用(3%)
            $collection_subtotal=$other_fee_total+$credit_service_fee; //代收費用總計(G)
            $partner_subtotal=$partner_service_fee+$collection_subtotal;

            $total+=$partner_subtotal;
        @endphp
        <tr>
            {{--NO 訂單編號 合約月租費 取車里程 還車里程 合計使用里程(A) 預付里程數(B) 差額里程數(A)-(B) 里程費率KM/元 逾時租金 補(退)金額 總計費用 平台服務費(16%) 合作商費用(N) 代收費用合計 代收刷卡服務費用(3%) 代收費用總計(G) 應付合作廠商金額(N+G)--}}


            <td style="border:solid 1px black;text-align: right;height: 20px">{{$key+1}}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{$start_ord->ord_no}}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{$start_ord->paid2_date}}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($basic_3fee) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($start_ord->milage) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($start_ord->back_milage) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($use_mile) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($mile_3month) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($sub_use_mile) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ $mile_fee }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($mile_fee_total) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($fee_subtotal) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($platform_service_fee) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($partner_service_fee) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($e_tag) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($damage_fee) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ $start_ord->business_loss_title?$start_ord->business_loss_title:'營業損失' }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($business_loss) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($delay_fee) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($over_mile_fee) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($fuel_cost) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($service_charge) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($other_fee_total) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($credit_service_fee) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px">{{ number_format($collection_subtotal) }}</td>
            <td style="border:solid 1px #ccc;text-align: right;height: 20px;background-color: #ecfde9">{{ number_format($partner_subtotal) }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="24">&nbsp;</td>
        <td style="text-align: right;">總計：</td>
        <td style="color: purple;font-weight: bold;font-size: 20px;background-color: #ecfde9;text-align: right;">{{number_format($total)}}</td>
    </tr>
    </tbody>
</table>