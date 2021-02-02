<table class="table" style="width: 100%">
    <thead>
        <tr style="border-top: solid 1px #ccc;">
            <th scope="col" style="text-align: left">商品項目</th>
            <th scope="col">價格</th>
            <th scope="col">數量</th>
            <th scope="col" style="text-align: right;">小計</th>
            <th scope="col" class="hidden-xs hidden-sm"></th>
        </tr>
    </thead>
    <tbody>

        @foreach($ord->products as $product)
            <tr>
                <td>
                    &nbsp;&nbsp;{{$product->pivot->product_name}}
                </td>
                <td>
                    {{$product->pivot->ordPrice}}
                </td>
                <td style="text-align: center">
                    {{$product->pivot->quantity}}
                </td>
                <td style="width: 15%;text-align: right;">
                    {{$product->pivot->sum}}
                </td>
                <td style="width: 15%;" class="hidden-xs hidden-sm">
                    &nbsp;
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="5">
                <hr>
            </td>
        </tr>
        @if($ord->discount>0)
            <tr>
                <td colspan="2" style="text-align: right;">
                    商品金額小計：
                </td>
                <td class="hidden-xs hidden-sm">
                    &nbsp;
                </td>
                <td style="text-align: right;">
                    {{' $'.number_format($ord->subtotal)}}
                </td>
                <td style="width: 10%;" class="hidden-xs hidden-sm">
                    &nbsp;
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: right;color: red">
                    @if($ord->is_user_discount)
                        會員95折優惠：
                    @else
                        企業代號/優惠券折扣：
                    @endif
                </td>
                <td class="hidden-xs hidden-sm">
                    &nbsp;
                </td>
                <td style="text-align: right;color: red">
                    - {{' $'.number_format($ord->discount)}}
                </td>
                <td style="width: 10%;" class="hidden-xs hidden-sm">
                    &nbsp;
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="2" style="text-align: right;">
                商品金額總計：
            </td>
            <td class="hidden-xs hidden-sm">
                &nbsp;
            </td>
            <td style="text-align: right;">
                {{' $'.number_format($ord->subtotal-$ord->discount)}}
            </td>
            <td style="width: 10%;" class="hidden-xs hidden-sm">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;border: none;">
                運費：
            </td>
            <td class="hidden-xs hidden-sm" style="border: none;">
                &nbsp;
            </td>
            <td style="text-align: right;border: none;">
                {{' $'.number_format($ord->ship_fee)}}
            </td>
            <td style="width: 10%;border: none" class="hidden-xs hidden-sm">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;border: none;">
                訂單金額總計：
            </td>
            <td class="hidden-xs hidden-sm" style="border: none;">
                &nbsp;
            </td>
            <td style="text-align: right;border: none;">
                {{' $'.number_format($ord->total)}}
            </td>
            <td style="width: 10%;border: none" class="hidden-xs hidden-sm">
                &nbsp;
            </td>
        </tr>
    </tbody>
</table>