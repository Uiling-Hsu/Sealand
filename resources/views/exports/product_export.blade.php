<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>方案 ID</th>
        <th>車輛等級</th>
        <th>月租費率(月/元)</th>
        <th>里程費率(km/元)</th>
        <th>編號 </th>
        <th>車號</th>
        <th>品牌</th>
        <th>車型</th>
        <th>排氣量</th>
        <th>車色</th>
        <th>排檔方式</th>
        <th>座位數</th>
        <th>燃料種類</th>
        <th>年份</th>
        <th>系統里程數(km)</th>
        <th>配備</th>
        <th>交車區域</th>
        <th>交車區域2</th>
        <th>經銷商ID</th>
        <th>車輛所在據點</th>
        <th>車輛狀態</th>
        <th>總經銷商</th>
        <th>車輛上架時間</th>
        <th>訂閱者</th>
        <th>新車車價</th>
        <th>中古車定價</th>
        <th>斡旋次數</th>
        <th>下架(隱藏)次數</th>
        <th>已上架天數</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $key=>$product)
        @php
            $user=null;
            $cate=$product->cate;
            /*$status_msg="上架中";
            if($product->status==0){
                if($product->is_renting==1){
                    $ord=$product->ord;
                    if($ord){
                        if($ord->is_paid==1)
                            $status_msg="出租中...";
                        else
                            $status_msg="已出租";
                    }
                }
                else
                    $status_msg="已下架";
            }*/
            $ord=$product->ord;
            if($ord){
                $user=$ord->user;
            }
            //已上架天數
            $diff=0;
            if($product->online_date){
                $time2=date('Y-m-d');
                $time1=$product->created_at;
                $diff=(strtotime($time2) - strtotime($time1)) / (60*60*24);
            }
        @endphp
        {{--@php
            $cate=$product->cate;
            $status_msg="上架中";
            if($product->status==0){
                if($product->ord)
                    dd($product->ord);
                if($product->is_renting==1)
                    $ord=$product->ord;
                    $status_msg="已出租";
                elseif($product->ord)
                else
                    $status_msg="已下架";
            }
        @endphp--}}
        <tr>
            <td style="border: 1px solid #dee2e6;">{{$key+1}}</td>
            <td style="border: 1px solid #dee2e6;">{{$cate->id}}</td>
            <td style="border: 1px solid #dee2e6;">{{$cate->title}}</td>
            <td style="border: 1px solid #dee2e6;">{{$cate->basic_fee}}</td>
            <td style="border: 1px solid #dee2e6;">{{$cate->mile_fee}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->model}}</td>
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
            <td style="border: 1px solid #dee2e6;">{{$product->equipment}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->proarea?$product->proarea->title:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->proarea2?$product->proarea2->title:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->partner_id}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->partner?$product->partner->title:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->ptate?$product->ptate->title:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->dealer_id}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->created_at}}</td>
            <td style="border: 1px solid #dee2e6;">{{$user?$user->name:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->new_car_price}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->second_hand_price}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->mediate_times>0?$product->mediate_times:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$product->off_times>0?$product->off_times:''}}</td>
            <td style="border: 1px solid #dee2e6;">{{$diff>0? number_format($diff):''}}</td>
            {{--<td style="width: 5%;border: 1px solid #dee2e6;">{{$product->partner?$product->partner->address:''}}</td>--}}
        </tr>
    @endforeach
    </tbody>
</table>
