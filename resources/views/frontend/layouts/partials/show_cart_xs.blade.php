<table class="table table-striped" cellspacing="0">
    <thead>
    <tr class="table-heads">
        <th class="head-item mbr-fonts-style display-8" style="font-weight: 300">序號</th>
        <th class="head-item mbr-fonts-style display-8" style="font-weight: 300">購買商品</th>
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
            <td class="body-item mbr-fonts-style display-7" style="width: 100%;line-height: 30px;font-size: 15px">
                <a href="/product/{{$item->model->id}}">
                    <img src="{{$item->model->image}}" alt="{{$prod_name}}" style="width:100%;">
                </a>
                <div style="padding-top: 8px;"><a href="/product/{{$item->model->id}}">{{ $prod_name }}</a></div>
                <form>
                    ${{number_format($item->price)}} x {{ number_format($item->qty)}}
                    = ${{ number_format($item->subtotal) }}
                </form>
            </td>
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
            <td>&nbsp;</td>
            <td style="text-align: right">小計：${{ number_format($subtotal) }}</td>
        </tr>
        {{--<tr class="footer-area">--}}
        {{--<td>&nbsp;</td>--}}
        {{--<td style="color: red;text-align: right">折扣/優惠券：-200</td>--}}
        {{--<td style="">&nbsp;</td>--}}
        {{--</tr>--}}
        <tr class="footer-area">
            <td>&nbsp;</td>
            <td style="text-align: right">運費：${{ $shipping }}</td>
        </tr>
        @if(getNumbers()->get('white_point'))
            <tr class="footer-area">
                <td colspan="2" style="text-align: right;font-weight: 400;font-size: 16px;">
                    <span style="color:red">R點點數已折抵：<span class="display-7" style="color: red">- ${{getNumbers()->get('white_point')}}</span></span>
                </td>
            </tr>
        @endif
        <tr class="footer-area">
            <td style="background-color: #eee">&nbsp;</td>
            <td style="text-align: right;background-color: #eee">總計：${{ number_format($newTotal) }}</td>
        </tr>
    @endif
    </tbody>
</table>