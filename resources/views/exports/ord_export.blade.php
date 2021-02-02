<table class="table table-striped table-bordered" border="1">
    <thead>
    <tr>
        <th>訂單編號</th>
        <th>訂單狀態</th>
        <th>保證金結帳單號</th>
        <th>保證金付款時間</th>
        <th>交車結帳單號</th>
        <th>起租款付款時間</th>
        <th>還車結帳單號</th>
        <th>迄租款付款時間</th>
        <th>會員姓名</th>
        <th>生日</th>
        <th>身份證字號</th>
        <th>方案種類</th>
        <th>預計交車日</th>
        <th>實際交車日</th>
        <th>保證金是否已付</th>
        <th>是否取消</th>
        <th>保證金金額</th>
        <th>月租費</th>
        <th>里程費</th>
        <th>起租款是否已付</th>
        <th>起租款金額</th>
        <th>車號</th>
        <th>車輛ID</th>
        <th>客戶電話</th>
        <th>客戶地址</th>
        <th>公司抬頭</th>
        <th>公司統編</th>
        <th>品牌</th>
        <th>車型</th>
        <th>續約設定</th>
    </tr>
    </thead>
    <tbody>
    @foreach($ords as $ord)
        @php
            $cate=$ord->cate;
            $user=$ord->user;
            $partner=$ord->partner;
            $state=$ord->state;
        @endphp
        <tr>
            <td style="border: 1px solid #dee2e6;">{{$ord->ord_no}}</td>
            <td style="border: 1px solid #dee2e6;">{{$state?$state->title:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->checkout_no}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->paid_date}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->checkout_no2}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->paid2_date}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->checkout_no3}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->paid3_date}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user->name}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user->birthday}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user->idno}}</td>
            <td style="border: 1px solid #dee2e6;">{{$cate->title}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->sub_date}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->real_sub_date}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->is_paid==1?'已付':''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->is_cancel==1?'是':''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->deposit}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->basic_fee}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->mile_fee}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->is_paid2==1?'已付':''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->payment_total}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->plate_no}}</td>
            <td style="border: 1px solid #dee2e6;">{{$ord->product_id}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user->phone}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user->address}}</td>
            <td style="border: 1px solid #dee2e6;">{{ $user?$user->company_name:'' }}</td>
            <td style="border: 1px solid #dee2e6;">{{ $user?$user->company_no:'' }}</td>
            <td style="border: 1px solid #dee2e6;">{{ $ord->brandcat_name }}</td>
            <td style="border: 1px solid #dee2e6;">{{ $ord->brandin_name }}</td>
            <td style="border: 1px solid #dee2e6;">{{ $ord->renewtate?$ord->renewtate->title:'' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
