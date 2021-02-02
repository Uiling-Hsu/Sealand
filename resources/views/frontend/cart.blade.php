@extends('frontend.layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="/assets/web/assets/mobirise-icons/mobirise-icons.css">
    <link rel="stylesheet" href="/assets/soundcloud-plugin/style.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="/assets/socicon/css/styles.css">
    <link rel="stylesheet" href="/assets/animatecss/animate.min.css">
    <link rel="stylesheet" href="/assets/dropdown/css/style.css">
    <link rel="stylesheet" href="/assets/theme/css/style.css">
    <link rel="stylesheet" href="/assets/mobirise/css/mbr-additional.css" type="text/css">
    <link rel="stylesheet" href="/assets/custom/css/style.css">
    <link rel="stylesheet" href="/assets/custom/css/hr.css">
    <script src="/assets/web/assets/jquery/jquery.min.js"></script>
    <style>
        .remove-btn{
            background-color: #fff;
        }
        .remove-btn:hover{
            background-color: #FFE5EF;
        }
        .white_point_number{
            border: 1px solid #ddd;
            border-radius: 22px;
            background-color: white;
            padding: 5px 10px;
            width: 100px;
            text-align:right
        }
    </style>
@stop

@section('content')
    {{--<section class="header6 cid-rk37IKwQTv" id="header6-k" style="background-image: url(/assets/images/mbr-9-1920x1280.jpg);">--}}
        {{--<div class="mbr-overlay" style="opacity: 0.5; background-color: rgb(0, 0, 0);">--}}
        {{--</div>--}}
        {{--<div class="container-fluid">--}}
            {{--<div class="row justify-content-center">--}}
                {{--<div class="col-12 col-lg-6 col-md-8 align-center">--}}
                    {{--<h3 class="mbr-section-subtitle align-center mbr-fonts-style mbr-light pb-3 mbr-white display-5"><strong>SHOPPING CART LIST</strong></h3>--}}
                    {{--<h2 class="mbr-section-title align-center mbr-fonts-style mbr-white display-2">購物車</h2>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}
    {{--<a name="list"></a>--}}
    <?php
        $update_msg='';
        if(session()->has('success_update'))
            $update_msg=session('success_update');
    ?>
    <section class="table2 section-table cid-rk9j4Hkxwk d-none d-lg-block" id="table2-20" style="padding-top: 180px;">
        {{--@include('frontend.layouts.partials.message')--}}
        <div class="container-fluid">
            <div class="media-container-row align-center">
                <div class="col-12 col-md-12">
                    <h2 class="mbr-section-title mbr-fonts-style mbr-black display-3">購物車商品</h2>
                    <div class="underline align-center pb-3">
                        <div class="line"></div>
                    </div>
                    @if($update_msg)
                        <div class="update_msg">
                            <div style="color: green;background-color: #fff;font-size: 18px;">
                                <h2 class="mbr-section-title mbr-fonts-style display-7 mbr-regular">{{$update_msg}}</h2>
                            </div>
                        </div>
                        <script>
                            (function(){
                                $('.update_msg').delay(10000).slideUp(300);
                            })();
                        </script>
                    @endif
                    <div class="table-wrapper pt-5" style="width: 88%;">
                        <div class="container-fluid">
                        </div>
                        <div class="container-fluid scroll">
                            <table class="table table-striped" cellspacing="0">
                                <thead>
                                <tr class="table-heads">
                                    <th class="head-item mbr-fonts-style display-7">序號</th>
                                    <th class="head-item mbr-fonts-style display-7">圖片</th>
                                    <th class="head-item mbr-fonts-style display-7">品名</th>
                                    <th class="head-item mbr-fonts-style display-7">價格</th>
                                    <th class="head-item mbr-fonts-style display-7">數量</th>
                                    <th class="head-item mbr-fonts-style display-7">小計</th>
                                    <th class="head-item mbr-fonts-style display-7">移除</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $carts=Cart::instance('default')->content();
                                    $cnt=1;
                                    $max_can_use_rpoint_total=0;
                                ?>
                                @forelse ($carts as $item)
                                    @if($item && $item->model)
                                        <?php
                                            $prod_name=$item->options->prod_name;
                                            $productstock_id=$item->options->productstock_id;
                                            $productstock=\App\Model\ProductStock::whereId($productstock_id)->first();
                                            if($productstock) {
                                                $productstock_rpoint = $productstock->r_point;
                                                $max_can_use_rpoint_total += $productstock_rpoint * $item->qty;
                                            }
                                            $max_qty=getCanBuyQty($productstock_id);
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
                                            <td class="body-item mbr-fonts-style display-7">
                                                <form>
                                                    <select class="quantity" data-id="{{ $item->rowId }}">
                                                        @for($i = 1; $i <= $max_qty ; $i++)
                                                            <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </form>
                                            </td>
                                            <td class="body-item mbr-fonts-style display-7">${{ number_format($item->subtotal) }}</td>
                                            <style>
                                                .remove-btn{
                                                    background-color: #fff;
                                                }
                                                .remove-btn:hover{
                                                    background-color: #FFE5EF;
                                                }
                                            </style>
                                            {!! Form::open(['url' => route('cart.destroy', $item->rowId),'id'=>'remove_form'])  !!}
                                                {{ method_field('DELETE') }}
                                                {!! Form::hidden('prod_name',$item->name) !!}
                                                <td class="body-item mbr-fonts-style display-7">
                                                    <button type="submit" class="remove-btn" style="border-radius: 7px;outline: none;cursor:pointer" onclick="return confirm('是否確認要移除本商品？');">
                                                        <span class="fa fa-remove mbr-iconfont mbr-iconfont-btn"></span>
                                                    </button>
                                                </td>
                                            {!! Form::close() !!}
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="7" style="text-align: center">
                                                <div>&nbsp;</div>
                                                <div>&nbsp;</div>
                                                <div class="mbr-section-btn align-center">
                                                    <h4 class="display-7" style="color: darkred">購物車內目前沒有任何商品 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary display-8" href="/product_list">繼續購物</a></h4>
                                                </div>
                                                <div>&nbsp;</div>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align: center">
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div class="mbr-section-btn align-center">
                                                <h4 class="display-7" style="color: darkred">購物車內目前沒有任何商品 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary display-8" href="/product_list">繼續購物</a></h4>
                                            </div>
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>
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
                                        <td>&nbsp;</td>
                                    </tr>
                                    {{--<tr class="footer-area">--}}
                                        {{--<td></td>--}}
                                        {{--<td></td>--}}
                                        {{--<td>&nbsp;</td>--}}
                                        {{--<td style="text-align: right">折扣/優惠券：</td>--}}
                                        {{--<td style="color: red">-200</td>--}}
                                        {{--<td>&nbsp;</td>--}}
                                        {{--<td>&nbsp;</td>--}}
                                    {{--</tr>--}}
{{--                                    <tr class="footer-area">--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td>&nbsp;</td>--}}
{{--                                        <td>&nbsp;</td>--}}
{{--                                        <td style="text-align: right">運費：</td>--}}
{{--                                        <td class="body-item mbr-fonts-style display-7">${{ $shipping }}</td>--}}
{{--                                        <td>&nbsp;</td>--}}
{{--                                    </tr>--}}
                                    @if(isUserLogin() && getPoints('white')>0)
                                        <?php
                                            $whitepoint=getPoints('white');
                                            if($max_can_use_rpoint_total>$whitepoint)
                                                $max_can_use_rpoint_total=$whitepoint;
                                        ?>
                                        <tr class="footer-area">
                                            <td colspan="5" style="text-align: right;font-weight: 400;font-size: 16px;">
                                                @if(getNumbers()->get('white_point'))
                                                    <span style="color:red">R點點數已折抵：</span>
                                                @else
                                                    請輸入要折抵的點數：
                                                    <div style="font-size: 15px;">( 您最多可使用的R點為: <span style="color: green">{{number_format($max_can_use_rpoint_total)}} 點</span> )</div>
                                                @endif
                                            </td>
                                            <td class="body-item mbr-fonts-style display-7" style="font-weight: 700;font-size: 15px;">
                                                @if(getNumbers()->get('white_point'))
                                                    <span class="display-7" style="color: red">- {{getNumbers()->get('white_point')}}</span>
                                                @else
                                                    @if($max_can_use_rpoint_total>0)
                                                        {!! Form::open(['url' => route('whitepoint.store'),'id'=>'form_point_store'])  !!}
                                                        {!! Form::number('white_point', 0,['class'=>'field display-7 white_point_number','min'=>'0','max'=>number_format($max_can_use_rpoint_total),'id'=>'white_point','placeholder'=>'','required'=>'required']); !!}  點
                                                        <div class="mbr-section-btn align-center">
                                                            <button type="submit" class="btn btn-primary-outline display-4" style="padding: 8px 12px;font-weight: 400;font-size: 15px;border-radius: 30px" onclick="var white_point=document.getElementById('white_point').value;if(white_point>0 && white_point<={{$max_can_use_rpoint_total}}) return confirm('您是否確認要折抵R點點數');else{alert('點數要大於0 或小於 {{$max_can_use_rpoint_total}}');return false;}">我要折抵點數</button>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    @else
                                                        <div style="color: red;font-weight: normal;">( 您的R點 點數為0無法折抵 )</div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td style="text-align: center">
                                                @if(getNumbers()->get('white_point'))
                                                    {!! Form::open(['url' => route('whitepoint.destroy'),'id'=>'form_point_delete'])  !!}
                                                    {{method_field('delete')}}
                                                    <button type="submit" class="btn btn-danger-outline display-4" style="padding: 8px 12px;font-weight: 400;font-size: 15px;border-radius: 30px" onclick="return confirm('您是否確認要取消點數折抵？');">取消點數折抵</button>
                                                    {!! Form::close() !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
{{--                                    <tr class="footer-area" style="background-color: #eee">--}}
{{--                                        <td></td>--}}
{{--                                        <td></td>--}}
{{--                                        <td>&nbsp;</td>--}}
{{--                                        <td>&nbsp;</td>--}}
{{--                                        <td style="text-align: right;font-weight: 500;font-size: 20px;">金額總計：</td>--}}
{{--                                        <td class="body-item mbr-fonts-style display-7" style="background-color: #eee;font-weight: 700;font-size: 20px;">${{ number_format($newTotal) }}</td>--}}
{{--                                        <td>&nbsp;</td>--}}
{{--                                    </tr>--}}
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="container-fluid table-info-container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="table2 section-table cid-rk9j4Hkxwk d-lg-none" id="table2-20" style="padding-top: 120px;">
        <div class="container-fluid" style="padding: 0">
            <div class="media-container-row align-center">
                <div class="col-12 col-md-12">
                    <h2 class="mbr-section-title mbr-fonts-style mbr-black display-3">購物車商品</h2>
                    <div class="underline align-center pb-3">
                        <div class="line"></div>
                    </div>
                    @if($update_msg)
                        <div class="update_msg">
                            <div style="color: green;background-color: #fff;font-size: 18px;">
                                <h2 class="mbr-section-title mbr-fonts-style display-7 mbr-regular">{{$update_msg}}</h2>
                            </div>
                        </div>
                        <script>
                            (function(){
                                $('.update_msg').delay(10000).slideUp(300);
                            })();
                        </script>
                    @endif
                    <div class="table-wrapper pt-5 d-lg-none" style="width:100%;">
                        <div class="container-fluid" style="padding: 0">
                        </div>
                        <div class="container-fluid scroll" style="padding: 0">
                            <table class="table table-striped" cellspacing="0">
                                <thead>
                                <tr class="table-heads">
                                    <th class="head-item mbr-fonts-style display-8" style="font-weight: 300">序號</th>
                                    <th class="head-item mbr-fonts-style display-8" style="font-weight: 300">購買商品</th>
                                    <th class="head-item mbr-fonts-style display-8" style="font-weight: 300">移除</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $cnt=1;
                                    $max_can_use_rpoint_total=0;
                                ?>
                                @forelse ($carts as $item)
                                    <?php
                                        $prod_name=$item->options->prod_name;
                                        $productstock_id=$item->options->productstock_id;
                                        $productstock=\App\Model\ProductStock::whereId($productstock_id)->first();
                                        if($productstock) {
                                            $productstock_rpoint = $productstock->r_point;
                                            $max_can_use_rpoint_total += $productstock_rpoint * $item->qty;
                                        }
                                        $max_qty=getCanBuyQty($productstock_id);
                                    ?>
                                    <tr>
                                        <td class="body-item mbr-fonts-style display-7">{{$cnt++}}</td>
                                        <td class="body-item mbr-fonts-style display-7" style="width: 100%;line-height: 30px;font-size: 15px">
                                            <a href="/product/{{$item->model->id}}">
                                                <img src="{{$item->model->image}}" alt="{{$prod_name}}" style="width:100%">
                                            </a>
                                            <div style="padding-top: 8px;"><a href="/product/{{$item->model->id}}">{{ $prod_name }}</a></div>
                                            <form>
                                                ${{number_format($item->price)}} x
                                                <select class="quantity_xs" data-id="{{ $item->rowId }}" style="display: inline-block;">
                                                    @for($i = 1; $i <= $max_qty ; $i++)
                                                        <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                = ${{ number_format($item->subtotal) }}
                                            </form>
                                        </td>
                                        {!! Form::open(['url' => route('cart.destroy', $item->rowId),'id'=>'remove_form'])  !!}
                                            {{ method_field('DELETE') }}
                                            {!! Form::hidden('prod_name',$item->name) !!}
                                            <td class="body-item mbr-fonts-style display-7">
                                                <button type="submit" class="remove-btn" style="border-radius: 7px;outline: none;cursor:pointer" onclick="return confirm('是否確認要移除本商品？');">
                                                    <span class="fa fa-remove mbr-iconfont mbr-iconfont-btn"></span>
                                                </button>
                                            </td>
                                        {!! Form::close() !!}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" style="text-align: center">
                                            <div>&nbsp;</div>
                                            <div>&nbsp;</div>
                                            <div class="mbr-section-btn align-center">
                                                <h4 class="display-7" style="color: darkred">購物車內目前沒有任何商品 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-primary display-8" href="/product_list">繼續購物</a></h4>
                                            </div>
                                            <div>&nbsp;</div>
                                        </td>
                                    </tr>
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
                                        <td style="">&nbsp;</td>
                                    </tr>
                                    {{--<tr class="footer-area">--}}
                                        {{--<td>&nbsp;</td>--}}
                                        {{--<td style="color: red;text-align: right">折扣/優惠券：-200</td>--}}
                                        {{--<td style="">&nbsp;</td>--}}
                                    {{--</tr>--}}
{{--                                    <tr class="footer-area">--}}
{{--                                        <td>&nbsp;</td>--}}
{{--                                        <td style="text-align: right">運費：${{ $shipping }}</td>--}}
{{--                                        <td style="">&nbsp;</td>--}}
{{--                                    </tr>--}}
                                    @if(isUserLogin() && getPoints('white')>0)
                                        <?php
                                        $whitepoint=getPoints('white');
                                        ?>
                                        <tr class="footer-area">
                                            <td colspan="2" style="text-align: right;font-weight: 400;font-size: 16px;">
                                                @if(getNumbers()->get('white_point'))
                                                    <span style="color:red">R點點數已折抵：<span class="display-7" style="color: red">- {{getNumbers()->get('white_point')}}</span></span>
                                                @else
                                                    <div style="font-size: 15px;">( 目前R點點數: <span style="color: green">{{number_format($max_can_use_rpoint_total)}} 點</span> )
                                                        @if($max_can_use_rpoint_total>0)
                                                            {!! Form::open(['url' => route('whitepoint.store'),'id'=>'form_point_store_xs'])  !!}
                                                            折抵點數：
                                                            {!! Form::number('white_point', 0,['class'=>'field display-7 white_point_number','min'=>'0','max'=>number_format($max_can_use_rpoint_total),'id'=>'white_point_xs','placeholder'=>'','required'=>'required']); !!} 點
                                                            <button type="submit" class="btn btn-primary-outline display-4" style="padding: 8px 12px;font-weight: 400;font-size: 15px;border-radius: 30px" onclick="var white_point=document.getElementById('white_point_xs').value;if(white_point>0 && white_point<={{$max_can_use_rpoint_total}}) return confirm('您是否確認要折抵R點點數');else{alert('點數要大於0 或小於 {{$max_can_use_rpoint_total}}');return false;}">我要折抵點數</button>
                                                            {!! Form::close() !!}
                                                        @else
                                                            <div style="color: red">( 您的R點 點數為0無法折抵 )</div>
                                                        @endif
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="{!! getNumbers()->get('white_point')?'width: 250px':'' !!}">
                                                @if(getNumbers()->get('white_point'))
                                                    {!! Form::open(['url' => route('whitepoint.destroy'),'id'=>'form_point_delete_xs'])  !!}
                                                    {{method_field('delete')}}
                                                    <button type="submit" class="remove-btn" style="border-radius: 7px;outline: none;cursor:pointer" onclick="return confirm('您是否確認要取消點數折抵？');">
                                                        <span class="fa fa-remove mbr-iconfont mbr-iconfont-btn"></span>
                                                    </button>
                                                    {!! Form::close() !!}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
{{--                                    <tr class="footer-area">--}}
{{--                                        <td style="background-color: #eee">&nbsp;</td>--}}
{{--                                        <td style="text-align: right;background-color: #eee">總計：${{ number_format($newTotal) }}</td>--}}
{{--                                        <td style="background-color: #eee">&nbsp;</td>--}}
{{--                                    </tr>--}}
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="container-fluid table-info-container">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($carts->count()>0)
        <section class="mbr-section content11 cid-rk9cXHfYix" id="content11-1x">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-10">
                        <div class="mbr-section-btn align-center">
                            <a class="btn btn-primary-outline display-4" href="/product_list">繼續購物</a>
                            <a class="btn btn-primary display-4" href="/checkout">前往結帳</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@section('extra-js')
    <script src="/assets/popper/popper.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <!--<script src="/assets/smoothscroll/smooth-scroll.js"></script>-->
    <script src="/assets/touchswipe/jquery.touch-swipe.min.js"></script>
    <script src="/assets/viewportchecker/jquery.viewportchecker.js"></script>
    <script src="/assets/datatables/jquery.data-tables.min.js"></script>
    <script src="/assets/datatables/data-tables.bootstrap4.min.js"></script>
    <script src="/assets/dropdown/js/script.min.js"></script>
    <script src="/assets/theme/js/script.js"></script>

    <script src="{{ asset('/js/app.js') }}"></script>
    <script>
        (function(){
            const classname = document.querySelectorAll('.quantity')

            Array.from(classname).forEach(function(element) {
                element.addEventListener('change', function() {
                    const id=element.getAttribute('data-id')
                    axios.patch(`/cart/${id}`, {
                        quantity: this.value
                    })
                        .then(function (response) {
                            console.log(response);
                            window.location.href='/cart';
                        })
                        .catch(function (error) {
                            console.log(error);
                            window.location.href='/cart';
                        });
                })
            })

            const classname2 = document.querySelectorAll('.quantity_xs')

            Array.from(classname2).forEach(function(element) {
                element.addEventListener('change', function() {
                    const id=element.getAttribute('data-id')
                    axios.patch(`/cart/${id}`, {
                        quantity: this.value
                    })
                        .then(function (response) {
                            console.log(response);
                            window.location.href='/cart';
                        })
                        .catch(function (error) {
                            console.log(error);
                            window.location.href='/cart';
                        });
                })
            })
        })();
    </script>
@endsection