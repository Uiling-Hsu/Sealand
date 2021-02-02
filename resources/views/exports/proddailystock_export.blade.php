<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <?php
            if(!$search_date)
                $search_date=date('Y-m-d');
            if(!$search_days)
                $search_days=1;

            for($i=1;$i<=$search_days;$i++){
                $date[$i]=calculateDate($search_date,'+',$i);
            }

            ?>
            @for($i=1;$i<=count($date);$i++)
                <th style="text-align: center">{{$date[$i]}}</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            @endfor
        </tr>
        <tr>
            <th>商品ID</th>
            <th>品名</th>
            <th>規格ID</th>
            <th>規格</th>
            @for($i=1;$i<=count($date);$i++)
                <th>每日庫存量</th>
                <th>已訂量</th>
                <th style="color:red">剩餘</th>
            @endfor
        </tr>
    </thead>
    <tbody>
        <?php
            $bgc1='white';
            $bgc2='#FFF3B3';
        ?>
        @if($products)
            <?php
                $cnt=1;
            ?>
            @foreach($products as $key=>$product)
                @foreach($product->productstocks as $productstock)
                    <tr style="background-color:{{$key % 2 ==1 ? $bgc1:$bgc2}};">
                        <td style="width: 5%;border: 1px solid #dee2e6;">{{$product->id}}</td>
                        <td style="width: 15%;border: 1px solid #dee2e6;">{{$product->title_tw}}</td>
                        <td style="width: 5%;border: 1px solid #dee2e6;">{{$productstock->id}}</td>
                        <td style="width: 8%;border: 1px solid #dee2e6;border-right: 1px solid #aaa;">{{$productstock->optionin->title_tw}}</td>
                        @for($i=1;$i<=count($date);$i++)
                            <?php
                                $qty_arr=getDaliyQty($productstock->id,$date[$i]);
                            ?>
                            <td style="border: 1px solid #dee2e6">
                                {{$qty_arr[1]}}
                            </td>
                            <td style="border: 1px solid #dee2e6;">{{$qty_arr[0]>0?$qty_arr[0]:''}}</td>
                            <td style="border: 1px solid #dee2e6;;border-right:solid 1px #aaa;font-weight: bold;font-size: 16px;">{{$qty_arr[1]!=''?$qty_arr[1]-$qty_arr[0]:''}}</td>
                        @endfor
                    </tr>
                    <?php $cnt++; ?>
                @endforeach
            @endforeach
        @else

        @endif

    </tbody>
</table>