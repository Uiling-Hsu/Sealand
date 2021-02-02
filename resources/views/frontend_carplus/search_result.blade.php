@extends('frontend_carplus.layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="/assets/web//assets/mobirise-icons/mobirise-icons.css">
    <link rel="stylesheet" href="/assets/soundcloud-plugin/style.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="/assets/socicon/css/styles.css">
    <link rel="stylesheet" href="/assets/dropdown/css/style.css">
    <link rel="stylesheet" href="/assets/animatecss/animate.min.css">
    <link rel="stylesheet" href="/assets/theme/css/style.css">
    <link rel="stylesheet" href="/assets/gallery/style.css">
    <link rel="stylesheet" href="/assets/mobirise/css/mbr-additional.css" type="text/css">
    <link rel="stylesheet" href="/assets/custom/css/style.css">
    <link rel="stylesheet" href="/assets/custom/css/hr.css">
    <script src="/assets/web/assets/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="/css/pagination.css">
@stop

@section('content')
    <section class="header6 cid-rk37IKwQTv" id="header6-k" style="background-image: url(/assets/images/mbr-1920x1170.jpg);">
        <div class="mbr-overlay" style="opacity: 0.6; background-color: rgb(0, 0, 0);">
        </div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-6 col-md-8 align-center">
                    <h2 class="mbr-section-title align-center mbr-fonts-style mbr-white display-2">商品搜尋</h2>
                </div>
            </div>
        </div>
        <a name="list"></a>
    </section>
    {{--@include('frontend.layouts.partials.message')--}}
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    <section class="cid-rk37T39pkf" id="form3-l" style="padding-top: 20px;padding-bottom: 0px;">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="form-1 col-md-4 col-lg-4">
                    {!! Form::open(['url' => '/search#list','method'=>'GET'])  !!}
                    <div class="row input-main">
                        <div class="col-md-8 input-wrap">
                            {!! Form::text('query', null,['class'=>'field display-7','id'=>'query','placeholder'=>'請輸入2個字以上的關鍵字','pattern'=>'.{2,}','required title'=>'至少需2個字以上', 'required'=>'required']); !!}
                        </div>
                        <div class="col-md-4 input-wrap">
                                <span class="input-group-btn">
                                    <button href="#" type="submit" class="btn btn-form btn-primary display-4 align">查詢</button>
                                </span>
                        </div>
                    </div>
                    {!! Form::close() !!}
                    @if($query)
                        <div style="color:darkred;text-align:center">搜尋結果共：{{$search_products->total()}} 個商品</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <hr>
    <section class="mbr-gallery cid-rk3xcwlebh" id="shop1-11">
        <div>
            <div class="mbr-shop">
                <div class="row col-md-12">
                    <div class="wrapper-shop-items col-xl-12">
                        <div class="mbr-gallery-row">
                            <div>
                                <div class="shop-items">
                                    @if($query)
                                        @forelse($search_products as $product)
                                            <div class="mbr-gallery-item">
                                                <div class="galleryItem">
                                                    <div class="style_overlay"></div>
                                                    <div class="img_wraper">
                                                        <img src="{{$product->image}}">
                                                    </div>
                                                    <span class="onsale mbr-fonts-style display-7" data-onsale="false" style="display: none;">-50%</span>
                                                    <div class="sidebar_wraper">
                                                        <h4 class="item-title mbr-fonts-style mbr-text display-7 mbr-regular" style="color: #366428">{{$product->title_tw}}</h4>
                                                        <div class="price-block">
                                                            <span class="shop-item-price mbr-fonts-style display-6" style="color:darkred">$ {{number_format($product->price)}}</span>
                                                            <span class="oldprice mbr-fonts-style display-7" style="display: none;">$28</span>
                                                        </div>
                                                        <div class="mbr-section-btn" buttons="0">
                                                            <a href="/product/{{$product->id}}#list" class="btn btn-primary-outline display-7">我要購買</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                        @endforelse
                                    @endif
                                </div>
                            </div>
                            <div class="clearfix">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Lightbox -->
                <div class="shopItemsModal_wraper" style="z-index: 100;">
                    <div class="shopItemsModalBg">
                    </div>
                    <div class="shopItemsModal row">
                        <div class="col-md-6 image-modal">
                        </div>
                        <div class="col-md-6 text-modal">
                        </div>
                        <div class="closeModal">
                            <div class="close-modal-wrapper">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <nav class="pagination-wrapper">
        {{ $search_products->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4-frontend') }}
    </nav>
    <div>&nbsp;</div>
@endsection

@section('extra-js')
    <script src="/assets/web//assets/jquery/jquery.min.js"></script>
    <script src="/assets/popper/popper.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="/assets/dropdown/js/script.min.js"></script>
    <!--<script src="/assets/smoothscroll/smooth-scroll.js"></script>-->
    <script src="/assets/viewportchecker/jquery.viewportchecker.js"></script>
    <script src="/assets/mobirise-shop/script.js"></script>
    <script src="/assets/touchswipe/jquery.touch-swipe.min.js"></script>
    <script src="/assets/theme/js/script.js"></script>
    <script src="/assets/gallery/player.min.js"></script>
    <script src="/assets/gallery/script.js"></script>
@endsection