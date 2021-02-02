@extends('frontend_carplus.layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="/css/jquery-ui-1.9.2.css" type="text/css" charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="/assets/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="/assets/slick/slick-theme.css">
@stop

@section('extra-top-js')

@stop

@section('content')
    <style type="text/css">

        .slider {
            width: 100%;
            margin: 0 auto;
        }

        .slick-slide {
            margin: 0 5px;
        }

        .slick-slide img {
            width: 100%;
        }

        .slick-prev:before,
        .slick-next:before {
            color: black;
        }


        .slick-slide {
            /*transition: all ease-in-out .3s;*/
            /*opacity: .2;*/
        }

        .slick-active {
            /*opacity: .5;*/
        }

        .slick-current {
            opacity: 1;
        }

        .temp_table{
            width: 100%;background-color: #f5f5f5;border-radius: 10px;
        }
        .temp_top_td{
            color: #e77100;text-align: center;font-size: 26px;font-weight: bold;padding: 15px 5px 10px 5px;border-bottom: solid 2px white;
        }
        .temp_title_td{
            width: 40%;border-right: solid 2px white;padding: 6px 20px;
        }
        .temp_content_td{
            width: 60%;border-right: solid 2px white;padding: 6px 15px;
        }
        .temp_button_td{
            text-align: center;font-size: 40px;font-weight: bold;padding: 5px;border-top: solid 2px white;
        }
    </style>
    <div role="main" class="main" style="padding-top: 120px;padding-bottom: 120px;background-image: url(/assets/images/flow_bg.jpg);">
        {{--@include('frontend.layouts.partials.message')--}}
        <div class="shop" style="padding-top: 20px">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="featured-boxes">
                            <div class="row">
                                <div class="col-md-12" style="max-width: 600px;margin: 0 auto;background-color: #fff;border-radius: 20px;padding: 25px">
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <h3 class="text-center">我要訂閱</h3>
                                    <div>&nbsp;</div>
                                    <div style="text-align: center;">
                                        <img src="{{$cate->image}}" title="" alt="" style="width: 100%;border: solid 1px #eee;max-width: 400px">
                                    </div>
                                    <a name="list"></a>
                                    <div>&nbsp;</div>
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content">
                                            <h4 class=" text-3 text-uppercase mb-3 text-right" style="color: red;font-weight: 400;">( * 必填欄位 )</h4>
                                            {!! Form::open(['url' => '/temp','class'=>'form-horizontal','name'=>'submit_form'])  !!}
                                            {!! Form::hidden('cate_id',$cate->id) !!}
                                            {!! Form::hidden('product_id',null,['id'=>'product_id']) !!}
                                            {{--<div class="form-row">
                                                <div class="form-group col">
                                                    <label class="font-weight-bold text-dark text-3">帳號 (Email) <span style="color: red;"> *</span></label>
                                                    <input type="text" name="idno" value="" class="form-control form-control-lg">
                                                </div>
                                            </div>--}}
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="proarea_id" class="font-weight-bold text-dark text-3">交車區域 <span style="color: red;"> *</span></label>
                                                    <!-- aaa Form select Input -->
                                                    {!! Form::select('search_proarea_id', $list_proareas , null,['id'=>'proarea_id','class'=>'form-control','style'=>'','required','onchange'=>'document.location.href="?search_proarea_id="+this.value+"#list";']) !!}
                                                </div>
                                            </div>
                                            {{--<script>
                                                $(document).on('change', '#proarea_id', function(){
                                                    var proarea_id = $('#proarea_id :selected').val();
                                                    $.ajax({
                                                        url:"/ajax_temp_brandin",
                                                        method:"GET",
                                                        data:{
                                                            cate_id: {{$cate->id}},
                                                            proarea_id:proarea_id,
                                                        },
                                                        success:function(data){
                                                            $('#regular1').html(data.html);
                                                            $('#regular2').html(data.html);
                                                            $('#msg').html(data.show_msg).show();

                                                            $("regular1").slick({
                                                                dots: true,
                                                                infinite: false,
                                                                slidesToShow: 2,
                                                                slidesToScroll: 2,
                                                                arrows: false
                                                            });

                                                            $(".regular2").slick({
                                                                dots: true,
                                                                infinite: false,
                                                                slidesToShow: 1,
                                                                slidesToScroll: 1,
                                                                arrows: false
                                                            });
                                                        }
                                                    });
                                                });
                                            </script>--}}
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="sub_date" class="font-weight-bold text-dark text-3">交車日期 <span style="color: red;"> *</span></label>
                                                    {!! Form::text('sub_date', null,['id'=>'sub_date','class'=>'form-control datePicker','autocomplete'=>'off','readonly']); !!}
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="pick_up_time" class="font-weight-bold text-dark text-3">前往取車時間 <span style="color: red;"> *</span></label>
                                                    {!! Form::select('pick_up_time', $list_pick_up_times, null,['id'=>'pick_up_time','class'=>'form-control','required']); !!}
                                                </div>
                                            </div>
                                            <hr>
                                            <div style="padding-bottom: 10px;text-align: center;">
                                                <div id="msg" style="display: none"></div>
                                            </div>
                                            {{--<div class="form-row" id="show_product"><span style="color: green">(請選擇  交車區域 顯示可訂閱的車輛)</span></div>--}}
                                            <div class="form-row" id="show_product">
                                                @if(count($product_arr))
                                                    <div style="color: green;text-align: center;width: 100%;padding-bottom: 10px;font-weight: 300;">( 符合您條件搜尋共 {{count($product_arr)}} 台車型 )</div>
                                                @endif

                                                <section class="regular1 slider d-none d-sm-block" style="padding: 0 10px;background-color: #fff;" id="regular1">
                                                    @if($product_arr)
                                                        @foreach($product_arr as $key=>$product)
                                                            @php
                                                                $brandcat_name = '';
                                                                $brandcat = $product->brandcat;
                                                                if($brandcat)
                                                                    $brandcat_name = $brandcat->title;

                                                                $brandin_name = '';
                                                                $brandin = $product->brandin;
                                                                if($brandin)
                                                                    $brandin_name = $brandin->title;

                                                                $procolor_name = '';
                                                                $procolor = $product->procolor;
                                                                if($procolor)
                                                                    $procolor_name = $procolor->title;

                                                                $milage = $product->milage;
                                                                if(! $milage)
                                                                    $milage = 0;
                                                                $milage = (int) number_format(floor($milage / 1000)) * 1000;
                                                            @endphp
                                                            <div>
                                                                <table class="temp_table">
                                                                    <tbody><tr>
                                                                        <td colspan="2" class="temp_top_td">{{$brandin_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="temp_title_td">廠牌</td>
                                                                        <td class="temp_content_td">{{$brandcat_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="temp_title_td">顏色</td>
                                                                        <td class="temp_content_td">{{$procolor_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="temp_title_td">排氣量</td>
                                                                        <td class="temp_content_td">{{number_format($product->displacement)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="temp_title_td">年份</td>
                                                                        <td class="temp_content_td">{{$product->year}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="temp_title_td">里程</td>
                                                                        <td class="temp_content_td">{{number_format($milage)}}</td>
                                                                    </tr>
                                                                    @if($product->equipment)
                                                                        <tr>
                                                                            <td class="temp_title_td">配備</td>
                                                                            <td class="temp_content_td">{{$product->equipment}}</td>
                                                                        </tr>
                                                                    @endif
                                                                    <tr>
                                                                        <td colspan="2" class="temp_button_td">
                                                                            <button type="submit" onclick="$('#product_id').val('{{$product->id}}');{{($user && $user->is_check != 1 ? 'alert(\'尚未開通訂閱功能，請至會員中心>修改基本資料，填寫完整的會員資料。SeaLand會在確認後，開通您的訂閱功能。\');return false;' : 'return chk_form();')}}" class="btn btn-primary">我要訂閱</button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </section>
                                                <hr>
                                                <section class="regular2 slider d-sm-none" style="padding: 0 10px;background-color: #fff;" id="regular2">
                                                    @if($product_arr)
                                                        @foreach($product_arr as $key=>$product)
                                                            @php
                                                                $brandcat_name = '';
                                                                $brandcat = $product->brandcat;
                                                                if($brandcat)
                                                                    $brandcat_name = $brandcat->title;

                                                                $brandin_name = '';
                                                                $brandin = $product->brandin;
                                                                if($brandin)
                                                                    $brandin_name = $brandin->title;

                                                                $procolor_name = '';
                                                                $procolor = $product->procolor;
                                                                if($procolor)
                                                                    $procolor_name = $procolor->title;

                                                                $milage = $product->milage;
                                                                if(! $milage)
                                                                    $milage = 0;
                                                                $milage = (int) number_format(floor($milage / 1000)) * 1000;
                                                            @endphp
                                                            <div>
                                                                <table class="temp_table">
                                                                    <tbody><tr>
                                                                        <td colspan="2" class="temp_top_td">{{$brandin_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="temp_title_td">廠牌</td>
                                                                        <td class="temp_content_td">{{$brandcat_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="temp_title_td">顏色</td>
                                                                        <td class="temp_content_td">{{$procolor_name}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="temp_title_td">排氣量</td>
                                                                        <td class="temp_content_td">{{number_format($product->displacement)}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="temp_title_td">年份</td>
                                                                        <td class="temp_content_td">{{$product->year}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="temp_title_td">里程</td>
                                                                        <td class="temp_content_td">{{number_format($milage)}}</td>
                                                                    </tr>
                                                                    @if($product->equipment)
                                                                        <tr>
                                                                            <td class="temp_title_td">配備</td>
                                                                            <td class="temp_content_td">{{$product->equipment}}</td>
                                                                        </tr>
                                                                    @endif
                                                                    <tr>
                                                                        <td colspan="2" class="temp_button_td">
                                                                            <button type="submit" onclick="$('#product_id').val('{{$product->id}}');{{($user && $user->is_check != 1 ? 'alert(\'尚未開通訂閱功能，請至會員中心>修改基本資料，填寫完整的會員資料。SeaLand會在確認後，開通您的訂閱功能。\');return false;' : 'return chk_form();')}}" class="btn btn-primary">我要訂閱</button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </section>
                                                @if(count($product_arr)>2)
                                                    <div style="text-align: center;width: 100%;padding-bottom: 10px;padding-top: 40px;font-weight: 300;">( 請左右滑動查看訂閱車輛 )</div>
                                                @endif
                                            </div>

                                            {{--<div class="form-row">
                                                <div>&nbsp;</div>
                                                <hr>
                                                <div class="form-group col-lg-12">
                                                    <div style="text-align: center;">
                                                        <input type="submit" value="確認訂閱資料及送出" class="btn btn-success text-3" onclick="return chk_form();">
                                                        <a href="/#list" class="btn btn-primary text-3" onclick="alert('您的訂閱需求單資料已儲存，可下次再進入此表單繼續編輯。');">我再想想</a>
                                                    </div>
                                                </div>
                                            </div>--}}
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                    <script>
                                        function chk_form() {
                                            var sub_date=document.getElementById('sub_date');
                                            /*if($('#proarea_id :selected').val()==''){
                                                alert('請選擇交車區域')
                                                $('#proarea_id').focus();
                                                return false;
                                            }
                                            else*/
                                            if(sub_date.value===''){
                                                alert('請輸入交車日期')
                                                sub_date.focus();
                                                return false;
                                            }
                                            else if($('#pick_up_time :selected').val()==='') {
                                                alert('請選擇前往取車時間')
                                                return false;
                                            }
                                            else if(confirm("是否確定要訂閱此車輛？")) {
                                                document.submit_form.submit();
                                            }
                                            else
                                                return false;

                                        }
                                    </script>
                                    {{--<div class="text-center">
                                        <span class="text-4">快速登入：</span>
                                        <a href="#" type="button" class="btn btn-modern btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Facebook 登入" style="padding: 0.533rem 0.933rem;">
                                            <i class="fa fa-facebook text-8 text-primary" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" type="button" class="btn btn-modern btn-default" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Google 登入" style="padding: 0.533rem 0.933rem;">
                                            <i class="fa fa-google text-8 text-primary" aria-hidden="true"></i>
                                        </a>
                                        <a href="#" type="button" class="btn btn-modern btn-default text-6 text-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Line 登入" style="height: 45px;padding: 0.25rem 0.933rem;">
                                            Line
                                        </a>
                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extra-js')
    <script src="/js/jquery-ui.min.js" type="text/javascript"></script>
    <script>
        var availableDates = {!! getShowDateString() !!};
        $(function()
        {
            $('.datePicker').datepicker({
                defaultDate : "{{getFirstCanSelectDate()}}",
                dateFormat: "yy-mm-dd",
                clearText: '清除',
                clearStatus: '清除已選日期',
                closeText: '關閉',
                closeStatus: '不改變當前選擇',
                prevText: '<上月',
                prevStatus: '顯示上月',
                prevBigText: '<<',
                prevBigStatus: '顯示上一年',
                nextText: '下月>',
                nextStatus: '顯示下月',
                nextBigText: '>>',
                nextBigStatus: '顯示下一年',
                currentText: '今天',
                currentStatus: '顯示本月',
                monthNames: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
                monthNamesShort: ['一月','二月','三月','四月','五月','六月', '七月','八月','九月','十月','十一月','十二月'],
                monthStatus: '選擇月份',
                yearStatus: '選擇年份',
                weekHeader: '週',
                weekStatus: '年內週次',
                dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
                dayNamesShort: ['週日','週一','週二','週三','週四','週五','週六'],
                dayNamesMin: ['日','一','二','三','四','五','六'],
                dayStatus: '設置 DD 為一周起始',
                dateStatus: '選擇 m月 d日, DD',
                firstDay: 1,
                initStatus: '請選擇日期',
                isRTL: false,
                onClose: function() {
                    $(this).trigger('blur');
                },
                beforeShowDay:
                    function(date)
                    {
                        return [available(date), "" ];
                    }
                , changeMonth: true, changeYear: false});
        });

        function available(date) {
            dmy = date.getFullYear() + "-" + (date.getMonth()+1) + "-" + date.getDate();
            if ($.inArray(dmy, availableDates) != -1) {
                return true;
            } else {
                return false;
            }
        }

        (function(){
            $('.alert-danger').delay(10000).slideUp(300);

            // $(document).on('change', '#proarea_id', function(){
            /*var proarea_id = $('#proarea_id :selected').val();
            if(proarea_id) {
                $.ajax({
                    url: "/ajax_temp_brandin",
                    method: "GET",
                    data: {
                        cate_id: {{$cate->id}},
                            proarea_id: proarea_id,
                        },
                        success: function (data) {
                            $('#show_product').html(data.html);
                            $('#msg').html(data.show_msg).show();
                        }
                    });
                }*/
            // });

        })();

    </script>
    <script src="/assets/slick/slick.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        $(document).on('ready', function() {

            $(".regular1").slick({
                dots: true,
                infinite: false,
                slidesToShow: 2,
                slidesToScroll: 2,
                arrows: true
            });

            $(".regular2").slick({
                dots: true,
                infinite: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true
            });

        });
    </script>
@endsection