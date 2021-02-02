@extends('frontend_carplus.layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="/assets/css/jquery-ui.css">
    <style>
        #loading
        {
            text-align:center;
            background: url('/images/loader.gif') no-repeat center;
            height: 150px;
        }
    </style>
@stop

@section('content')
    <div role="main" class="main shop py-4">
        <div style="padding-top: 20px">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3">
                        <h4 class="text-primary">選擇規格:</h4>
                        <div class="toggle toggle-tertiary toggle-simple" data-plugin-toggle="">
                            {{--<section class="toggle active">
                                <a class="toggle-title" style="font-size: 16px;font-weight: 300;">價格</a>
                                <div class="toggle-content">
                                    <div class="list-group">
                                        <input type="hidden" id="hidden_minimum_price" value="5000" />
                                        <input type="hidden" id="hidden_maximum_price" value="10000" />
                                        <p id="price_show" style="margin: 0 0 10px 30px">5000 - 10000</p>
                                        <div id="price_range" style="width: 80%;margin-left: 30px"></div>
                                    </div>
                                </div>
                            </section>--}}
                            <section class="toggle active">
                                <a class="toggle-title" style="font-size: 16px;font-weight: 300;">價格</a>
                                <div class="toggle-content" style="display: block;padding-top: 10px;padding-left: 30px">
                                    {!! Form::select('price', ['6800'=>'6,800元','8800'=>'8,800元'] , Request('price')?Request('price'):6800 ,['id'=>'price','class'=>'form-control','style'=>'font-size:15px','onchange'=>'document.location.href="?price="+this.value']) !!}
                                </div>
                            </section>
                            <section class="toggle active">
                                <a class="toggle-title" style="font-size: 16px;font-weight: 300;">品牌/車型</a>
                                <div class="toggle-content" style="display: block;padding-top: 10px;padding-left: 30px">
                                    <div class="text-3">品牌</div>
                                    {!! Form::select('brandcat_id', $list_brandcats , null ,['id'=>'brandcat_id','class'=>'form-control','style'=>'font-size:15px']) !!}
                                    <div class="text-3" style="padding-top: 10px">車型</div>
                                    <div class="toggle-content">
                                        {!! Form::select('brandin_id', $list_brandins , null ,['id'=>'brandin_id','class'=>'form-control','style'=>'font-size:15px','required']) !!}
                                        {{--<ul style="list-style-type:none">
                                            <li>
                                                <input type="checkbox" id="checkbox-1-1" class="regular-checkbox common_selector brand" value="BENZ" /><label for="checkbox-1-1"></label> <span>BENZ</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="checkbox-1-2" class="regular-checkbox common_selector brand" value="BMW" /><label for="checkbox-1-2"></label> <span>BMW</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="checkbox-1-3" class="regular-checkbox common_selector brand" value="TOYOTA" /><label for="checkbox-1-3"></label> <span>TOYOTA</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="checkbox-1-4" class="regular-checkbox common_selector brand" value="NISSAN" /><label for="checkbox-1-4"></label> <span>NISSAN</span>
                                            </li>
                                            <li>
                                                <input type="checkbox" id="checkbox-1-4" class="regular-checkbox common_selector brand" value="HONDA" /><label for="checkbox-1-4"></label> <span>HONDA</span>
                                            </li>
                                        </ul>--}}
                                    </div>
                                    {{--<ul style="list-style-type:none">
                                        <li>
                                            <input type="checkbox" id="checkbox-1-1" class="regular-checkbox common_selector brand" value="BENZ" /><label for="checkbox-1-1"></label> <span>BENZ</span>
                                        </li>
                                        <li>
                                            <input type="checkbox" id="checkbox-1-2" class="regular-checkbox common_selector brand" value="BMW" /><label for="checkbox-1-2"></label> <span>BMW</span>
                                        </li>
                                        <li>
                                            <input type="checkbox" id="checkbox-1-3" class="regular-checkbox common_selector brand" value="TOYOTA" /><label for="checkbox-1-3"></label> <span>TOYOTA</span>
                                        </li>
                                        <li>
                                            <input type="checkbox" id="checkbox-1-4" class="regular-checkbox common_selector brand" value="NISSAN" /><label for="checkbox-1-4"></label> <span>NISSAN</span>
                                        </li>
                                        <li>
                                            <input type="checkbox" id="checkbox-1-4" class="regular-checkbox common_selector brand" value="HONDA" /><label for="checkbox-1-4"></label> <span>HONDA</span>
                                        </li>
                                    </ul>--}}
                                </div>
                            </section>
                            <section class="toggle active">
                                <a class="toggle-title" style="font-size: 16px;font-weight: 300;">交車區域</a>
                                <div class="toggle-content" style="display: block;padding-top: 10px;padding-left: 30px">
                                    {!! Form::select('proarea_id', $list_proareas , null ,['id'=>'proarea_id','class'=>'form-control','style'=>'font-size:15px']) !!}
                                </div>
                            </section>
                            {{--<section class="toggle active">
                                <a class="toggle-title" style="font-size: 16px;font-weight: 300;">排氣量</a>
                                <div class="toggle-content">
                                    <div class="list-group">
                                        <input type="hidden" id="hidden_minimum_displacement" value="1200" />
                                        <input type="hidden" id="hidden_maximum_displacement" value="3500" />
                                        <p id="displacement_show" style="margin: 0 0 10px 30px">1200 - 3500</p>
                                        <div id="displacement_range" style="width: 80%;margin-left: 30px"></div>
                                    </div>
                                </div>
                            </section>
                            <section class="toggle active">
                                <a class="toggle-title" style="font-size: 16px;font-weight: 300;">車型</a>
                                <div class="toggle-content" style="display: block;padding-top: 10px">
                                    <ul style="list-style-type:none">
                                        <li>
                                            <input type="checkbox" id="checkbox-2-1" class="regular-checkbox" /><label for="checkbox-2-1"></label> <span>房車</span>
                                        </li>
                                        <li>
                                            <input type="checkbox" id="checkbox-2-2" class="regular-checkbox" /><label for="checkbox-2-2"></label> <span>休旅車</span>
                                        </li>
                                        <li>
                                            <input type="checkbox" id="checkbox-2-3" class="regular-checkbox" /><label for="checkbox-2-3"></label> <span>貨卡車</span>
                                        </li>
                                    </ul>
                                </div>
                            </section>--}}
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row products product-thumb-info-list filter_data"></div>
                        <div class="row">
                            <div class="col-9">
                                {{ $products->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4-frontend') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script>
        $(document).ready(function(){

            filter_data();

            function filter_data()
            {
                $('.filter_data').html('<div id="loading" style="" ></div>');
                var action = 'fetch_data';
                // var minimum_price = $('#hidden_minimum_price').val();
                // var maximum_price = $('#hidden_maximum_price').val();
                // var brand = get_filter('brand');
                var price=$('#price :selected').val()
                var brandcat_id=$('#brandcat_id :selected').val()
                var brandin_id=$('#brandin_id :selected').val()
                var proarea_id=$('#proarea_id :selected').val()
                // var ram = get_filter('ram');
                // var storage = get_filter('storage');
                // minimum_price:minimum_price, maximum_price:maximum_price,
                $.ajax({
                    url:"/fetch_data",
                    method:"GET",
                    data:{action:action, price:price, brandcat_id:brandcat_id, brandin_id:brandin_id, proarea_id:proarea_id},
                    success:function(data){
                        $('.filter_data').html(data);
                    }
                });
            }

            function get_filter(class_name)
            {
                var filter = [];
                $('.'+class_name+':checked').each(function(){
                    filter.push($(this).val());
                });
                return filter;
            }

            $('.common_selector').click(function(){
                filter_data();
            });

            $(document).on('change', '#brandcat_id', function(){
                var brandcat_id = $('#brandcat_id :selected').val();//注意:selected前面有個空格！
                $.ajax({
                    url:"/ajax_brand",
                    method:"GET",
                    data:{
                        brandcat_id:brandcat_id
                    },
                    success:function(res){
                        $('#brandin_id').html(res);
                    }
                });//end ajax
                filter_data();
            });

            $(document).on('change', '#brandin_id', function(){
                filter_data();
            });

            $(document).on('change', '#proarea_id', function(){
                filter_data();
            });

            /*$('#price_range').slider({
                range:true,
                min:5000,
                max:10000,
                values:[5000, 10000],
                step:500,
                stop:function(event, ui)
                {
                    $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
                    $('#hidden_minimum_price').val(ui.values[0]);
                    $('#hidden_maximum_price').val(ui.values[1]);
                    filter_data();
                }
            });*/

        });
    </script>
@endsection