@extends('frontend.layouts.app')

@section('extra-css')

@stop

@section('content')
    <div role="main" class="main">

        <div class="shop" style="padding-top: 20px">
            <div class="container">

                <div class="row">
                    <div class="col-lg-8">

                        <div class="owl-carousel owl-theme" data-plugin-options="{'items': 1, 'autoplay': true, 'autoplayTimeout': 4000, 'margin': 10, 'animateIn': 'slideInRight', 'animateOut': 'slideOutLeft'}">
                            <div>
                                <img alt="" class="img-fluid" src="{{$product->image}}">
                            </div>
                            @if($product->productimages)
                                @foreach($product->productimages as $key=>$productimage)
                                    <div>
                                        <img alt="" class="img-fluid" src="{{$productimage->image}}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-2 featured-box-full featured-box-full-light text-center" style="border: solid 1px #efefef;padding-top: 20px">
                                    <i class="far fa-life-ring" style="font-size: 40px;color: #ddd"></i>
                                    <h4 class="font-weight-normal text-3">66千瓦/ 90 PS</h4>
                                </div>
                                <div class="col-lg-2 featured-box-full featured-box-full-light text-center" style="border: solid 1px #efefef;padding-top: 20px">
                                    <i class="fas fa-film" style="font-size: 40px;color: #ddd"></i>
                                    <h4 class="font-weight-normal text-3">汽油</h4>
                                </div>
                                <div class="col-lg-2 featured-box-full featured-box-full-light text-center" style="border: solid 1px #efefef;padding-top: 20px">
                                    <i class="far fa-star" style="font-size: 40px;color: #ddd"></i>
                                    <h4 class="font-weight-normal text-3">前輪驅動</h4>
                                </div>
                                <div class="col-lg-2 featured-box-full featured-box-full-light text-center" style="border: solid 1px #efefef;padding-top: 20px">
                                    <i class="far fa-edit" style="font-size: 40px;color: #ddd"></i>
                                    <h4 class="font-weight-normal text-3">5門</h4>
                                </div>
                                <div class="col-lg-2 featured-box-full featured-box-full-light text-center" style="border: solid 1px #efefef;padding-top: 20px">
                                    <i class="far fa-star" style="font-size: 40px;color: #ddd"></i>
                                    <h4 class="font-weight-normal text-3">手動變速箱</h4>
                                </div>
                                <div class="col-lg-2 featured-box-full featured-box-full-light text-center" style="border: solid 1px #efefef;padding-top: 20px">
                                    <i class="far fa-edit" style="font-size: 40px;color: #ddd"></i>
                                    <h4 class="font-weight-normal text-3">歐洲6</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <style>
                        .list-title{
                            font-weight: bold;font-size: 18px;
                        }
                        .list-content{
                            font-weight: 400;line-height: 20px;
                        }
                    </style>
                    <div class="col-lg-4">

                        <div class="summary entry-summary">

                            <h1 class="mb-0 font-weight-bold text-7">{{$product->name}}</h1>

                            <div style="padding: 30px 5px 0 5px">
                                <ul class="list list-icons list-icons-style-3 list-icons-sm">
                                    <li>
                                        <i class="fas fa-check"></i> <span class="list-title">全包式</span>
                                        <p class="list-content">始終與您同在：責任險，部分和全面保險，以及擔保，維護，磨損，輪胎，稅收和批准。</p>
                                    </li>
                                    <li>
                                        <i class="fas fa-check"></i> <span class="list-title">靈活</span>
                                        <p class="list-content">每6個月更換一次汽車，或根據需要駕駛。您可以隨時暫停或取消訂閱。</p>
                                    </li>
                                    <li>
                                        <i class="fas fa-check"></i> <span class="list-title">免費公里</span>
                                        <p class="list-content">訂閱包括每年15,000公里。超出的路程為0.20歐元。</p>
                                    </li>
                                </ul>
                            </div>

                            <div class="pb-0 clearfix">
                                <div title="Rated 3 out of 5" class="float-left">
                                    <input type="text" class="d-none" value="3" title="" data-plugin-star-rating data-plugin-options="{'displayOnly': true, 'color': 'primary', 'size':'xs'}">
                                </div>

                                <!--<div class="review-num">
                                    <span class="count" itemprop="ratingCount">2</span> reviews
                                </div>-->
                            </div>

                            <!-- Begin Form -->
                            {!! Form::open(['url' => '/checkout_post'])  !!}
                                {{--{!! Form::hidden('checkout',1) !!}--}}
                                {!! Form::hidden('price',$product->price,['id'=>'price']) !!}
                                {!! Form::hidden('product_id',$product->id,['id'=>'product_id']) !!}
                                {!! Form::hidden('total',null,['id'=>'total']) !!}
                                <div class="text-4" style="padding-bottom: 10px">
                                    租期：{!! Form::select('period_id', $list_periods , null ,['id'=>'period_id','class'=>'','style'=>'font-size:15px;width: 160px','required']) !!}
                                </div>
                                <div class="text-4" style="color: #0088cc;padding-bottom: 10px;">訂閱價：{{ number_format($product->price) }} 元/月</div>
                                <div class="text-4" style="padding-bottom: 10px">使用費：{{ $product->fee }} 元/1公里</div>
                                <div class="text-5 span_total" style="color: purple;padding-bottom: 10px"></div>
                                <div>&nbsp;</div>
                                <button type="submit" class="btn btn-primary btn-modern text-uppercase text-4" onclick="return confirm('您是否確定要訂閱此車？')">我要訂閱</button>
                            {!! Form::close() !!}
                            <!-- End of Form -->
                            <!--<div class="product-meta">
                                <span class="posted-in">Categories: <a rel="tag" href="#">Accessories</a>, <a rel="tag" href="#">Bags</a>.</span>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">

                        <div class="tabs tabs-product mb-2">
                            <ul class="nav nav-tabs">
                                <li class="nav-item active"><a class="nav-link py-3 px-4" href="#productDescription0" data-toggle="tab">規格列表</a></li>
                                <li class="nav-item"><a class="nav-link py-3 px-4" href="#productDescription" data-toggle="tab">配套設備</a></li>
                                <li class="nav-item"><a class="nav-link py-3 px-4" href="#productInfo" data-toggle="tab">選件</a></li>
                            </ul>
                            <div class="tab-content p-0">
                                <div class="tab-pane p-4 active" id="productDescription0">
                                    <ul>
                                        <li>編　號：BZEC2200001</li>
                                        <li>廠　牌：BENZ</li>
                                        <li>款　式：E-CLASS</li>
                                        <li>排氣量：2,143 cc.</li>
                                        <li>年　份：2014 年</li>
                                        <li>排　檔：自排</li>
                                        <li>燃　料：油電混合</li>
                                        <li>座位數：5</li>
                                        <li>顏　色：銀</li>
                                        <li>交車區域：大台北</li>
                                    </ul>
                                </div>
                                <div class="tab-pane p-4" id="productDescription">
                                    <ul>
                                        <li>藍牙功能</li>
                                        <li>冷氣</li>
                                        <li>方向盤加熱</li>
                                        <li>通過應用程序導航</li>
                                        <li>加熱座椅</li>
                                        <li>音響系統</li>
                                    </ul>
                                </div>
                                <div class="tab-pane p-4" id="productInfo">
                                    <table class="table m-0">
                                        <tbody>
                                        <tr>
                                            <th class="border-top-0">
                                                Size:
                                            </th>
                                            <td class="border-top-0">
                                                Unique
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Colors
                                            </th>
                                            <td>
                                                Red, Blue
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Material
                                            </th>
                                            <td>
                                                100% Leather
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div style="padding-top: 40px;padding-bottom: 0;font-weight: bold;font-size: 20px;">常見問題</div>
                        <div class="toggle toggle-minimal toggle-primary" data-plugin-toggle data-plugin-options="{ 'isAccordion': true }">
                            <section class="toggle active" style="margin: 0">
                                <a class="toggle-title"><span style="font-size: 18px;font-weight: bold;">誰適合預訂此車？</span></a>
                                <div class="toggle-content">
                                    <p>預訂此汽車訂閱時，以下條件適用於駕駛員：</p>
                                    <ul>
                                        <li>最低年齡18歲</li>
                                        <li>最高年齡70歲</li>
                                        <li>居住在台灣</li>
                                        <li>有效汽車駕駛執照</li>
                                    </ul>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title"><span style="font-size: 18px;font-weight: bold;">您如何交還並返回？</span></a>
                                <div class="toggle-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Nullam tortor nunc, bibendum vitae semper a, volutpat eget massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title"><span style="font-size: 18px;font-weight: bold;">每期是指多長的期間？</span></a>
                                <div class="toggle-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Nullam tortor nunc, bibendum vitae semper a, volutpat eget massa. </p>
                                </div>
                            </section>
                            <section class="toggle">
                                <a class="toggle-title"><span style="font-size: 18px;font-weight: bold;">訂閱費用是多少？</span></a>
                                <div class="toggle-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Nullam tortor nunc, bibendum vitae semper a, volutpat eget massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. </p>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <hr class="solid my-5">
                        <h4 class="mb-3" style="font-weight: 300;">相關 <strong>其它車種</strong></h4>
                        <div class="masonry-loader masonry-loader-showing">
                            <div class="row products product-thumb-info-list mt-3" data-plugin-masonry data-plugin-options="{'layoutMode': 'fitRows'}">
                                <div class="col-12 col-sm-6 col-lg-3 product">
                                    <span class="product-thumb-info border-0">
                                        <a href="/product/1" class="add-to-cart-product bg-color-primary">
                                            <span class="text-uppercase text-4">前往預定</span>
                                        </a>
                                        <a href="/product/1">
                                            <span class="product-thumb-info-image">
                                                <img alt="" class="img-fluid" src="/assets/images/project-1.jpg">
                                            </span>
                                        </a>
                                        <span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
                                            <a href="/product/1">
                                                <h4 class="text-4 text-primary">Photo Camera</h4>
                                                <span class="price">
                                                    <del><span class="amount">$325</span></del>
                                                    <ins><span class="amount text-dark font-weight-semibold">$299</span></ins>
                                                </span>
                                            </a>
                                        </span>
                                    </span>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3 product">
                                    <span class="product-thumb-info border-0">
                                        <a href="/product/1" class="add-to-cart-product bg-color-primary">
                                            <span class="text-uppercase text-4">前往預定</span>
                                        </a>
                                        <a href="/product/1">
                                            <span class="product-thumb-info-image">
                                                <img alt="" class="img-fluid" src="/assets/images/project-2.jpg">
                                            </span>
                                        </a>
                                        <span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
                                            <a href="/product/1">
                                                <h4 class="text-4 text-primary">Golf Bag</h4>
                                                <span class="price">
                                                    <span class="amount text-dark font-weight-semibold">$72</span>
                                                </span>
                                            </a>
                                        </span>
                                    </span>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3 product">
                                    <span class="product-thumb-info border-0">
                                        <a href="/product/1" class="add-to-cart-product bg-color-primary">
                                            <span class="text-uppercase text-4">前往預定</span>
                                        </a>
                                        <a href="/product/1">
                                            <span class="product-thumb-info-image">
                                                <img alt="" class="img-fluid" src="/assets/images/project-3.jpg">
                                            </span>
                                        </a>
                                        <span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
                                            <a href="/product/1">
                                                <h4 class="text-4 text-primary">Workout</h4>
                                                <span class="price">
                                                    <span class="amount text-dark font-weight-semibold">$60</span>
                                                </span>
                                            </a>
                                        </span>
                                    </span>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-3 product">
                                    <span class="product-thumb-info border-0">
                                        <a href="/product/1" class="add-to-cart-product bg-color-primary">
                                            <span class="text-uppercase text-4">前往預定</span>
                                        </a>
                                        <a href="/product/1">
                                            <span class="product-thumb-info-image">
                                                <img alt="" class="img-fluid" src="/assets/images/project-4.jpg">
                                            </span>
                                        </a>
                                        <span class="product-thumb-info-content product-thumb-info-content pl-0 bg-color-light">
                                            <a href="/product/1">
                                                <h4 class="text-4 text-primary">Luxury bag</h4>
                                                <span class="price">
                                                    <span class="amount text-dark font-weight-semibold">$199</span>
                                                </span>
                                            </a>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--本月特價車款 Title-->
    <section class="page-header page-header-modern bg-color-white page-header-md" style="margin:0">
        <div class="container">
            <div class="row">
                <div class="col-md-12 align-self-center p-static order-2 text-center">
                    <div class="get-started text-center">
                        <a href="#" onclick="window.history.go(-1);return false;" class="btn btn-primary btn-lg text-3 font-weight-semibold btn-py-2 px-4">回車輛列表</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('extra-js')
    <script>
        ajax_price();
        $(document).on('change', '#period_id', function(){
            ajax_price();
        });

        function ajax_price() {
            var period_id = $('#period_id :selected').val();//注意:selected前面有個空格！
            var price = $('#price').val();
            var product_id = $('#product_id').val();
            $.ajax({
                url:"/ajax_price",
                method:"GET",
                data:{
                    product_id: product_id, period_id:period_id, price:price
                },
                success:function(res){
                    if(res>0) {
                        $('.span_total').html('總費用為：' + formatNumber(res) + '元');
                        $('#total').html(res);
                    }
                    else{
                        $('.span_total').html('');
                        $('#total').html(null);
                    }
                }
            });//end ajax
        }

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }

    </script>
@endsection