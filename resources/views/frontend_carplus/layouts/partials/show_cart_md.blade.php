<table class="table table-striped" cellspacing="0">
    <thead>
    <tr class="table-heads">
        <th class="head-item mbr-fonts-style display-7">序號</th>
        <th class="head-item mbr-fonts-style display-7">圖片</th>
        <th class="head-item mbr-fonts-style display-7">品名</th>
        <th class="head-item mbr-fonts-style display-7">價格</th>
        <th class="head-item mbr-fonts-style display-7">數量</th>
        <th class="head-item mbr-fonts-style display-7">小計</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $carts=Cart::instance('default')->content();
    $cnt=1;
    ?>
    @forelse ($carts as $item)
        <?php
        $prod_name=$item->options->prod_name;
        ?>
        <tr>
            <td class="body-item mbr-fonts-style display-7">{{$cnt++}}</td>
            <td class="body-item mbr-fonts-style display-7">
                <a href="/product/{{$item->model->id}}">
                    <img src="{{$item->model->image}}" alt="{{$prod_name}}">
                </a>
            </td>
            <td class="body-item mbr-fonts-style display-7">
                <a href="/product/{{$item->model->id}}">{{ $prod_name }}</a>
            </td>
            <td class="body-item mbr-fonts-style display-7">${{number_format($item->price)}}</td>
            <td class="body-item mbr-fonts-style display-7">{{ number_format($item->qty)}}</td>
            <td class="body-item mbr-fonts-style display-7">${{ number_format($item->subtotal) }}</td>
        </tr>
    @empty

    @endforelse
    @if($carts->count()>0)
        <?php
        $shipping=getNumbers()->get('shipping');
        $free_shipping=getNumbers()->get('free_shipping');
        $subtotal=getNumbers()->get('subtotal');
        $discount=getNumbers()->get('discount');
        $newSubtotal=getNumbers()->get('newSubtotal');
        $newTotal=getNumbers()->get('newTotal');
        ?>
        <tr class="footer-area">
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right">金額小計：</td>
            <td class="body-item mbr-fonts-style display-7">${{ number_format($subtotal) }}</td>
        </tr>
        {{--<tr class="footer-area">--}}
        {{--<td></td>--}}
        {{--<td></td>--}}
        {{--<td>&nbsp;</td>--}}
        {{--<td style="text-align: right">折扣/優惠券：</td>--}}
        {{--<td style="color: red">-200</td>--}}
        {{--<td>&nbsp;</td>--}}
        {{--</tr>--}}
        <tr class="footer-area">
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right">運費：</td>
            <td class="body-item mbr-fonts-style display-7">${{ $shipping }}</td>
        </tr>
        @if(getNumbers()->get('white_point'))
            <tr class="footer-area">
                <td colspan="5" style="text-align: right;font-weight: 400;font-size: 16px;">
                    <span style="color:red">R點點數已折抵：</span>
                </td>
                <td class="body-item mbr-fonts-style display-7" style="font-weight: 700;font-size: 15px;">
                    <span class="display-7" style="color: red">- {{getNumbers()->get('white_point')}}</span>
                </td>
            </tr>
        @endif
        <tr class="footer-area" style="background-color: #eee">
            <td></td>
            <td></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td style="text-align: right;font-weight: 500;font-size: 20px;">金額總計：</td>
            <td class="body-item mbr-fonts-style display-7" style="background-color: #eee;font-weight: 700;font-size: 20px;">${{ number_format($newTotal) }}</td>
        </tr>
    @endif
    </tbody>
</table>