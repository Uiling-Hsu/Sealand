@extends('frontend.layouts.app')

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
            width: 50%;border-right: solid 2px white;padding: 6px 20px;
        }
        .temp_content_td{
            width: 50%;border-right: solid 2px white;padding: 6px 15px;
        }
        .temp_button_td{
            text-align: center;font-size: 40px;font-weight: bold;padding: 5px;border-top: solid 2px white;
        }
        .partner{
            padding: 5px; border: solid 1px #ddd;
            border-radius: 5px;
            color: #777;
            background-color: #eee;
            font-weight: 400;
            width: 100%;
        }

        .mbr-figure table{
            width: 100%;
            padding: 40px 0;
            border-style: dashed;
            border-width: 1px;
            font-size: 16px;
        }
        .mbr-figure td{
            padding: 40px 0;
        }

        .btn-success, .btn-success:active, .btn-success.active {
            background-color: #00b900 !important;
            border-color: #00b900 !important;
            color: #ffffff !important;
        }
        .btn-success:hover, .btn-success:focus, .btn-success.focus {
            color: #ffffff !important;
            background-color: #009400 !important;
            border-color: #009400 !important;
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
                                        <img src="{{$cate->image_temp?$cate->image_temp:$cate->image}}" title="" alt="" style="width: 100%;border: solid 1px #eee;max-width: 400px">
                                    </div>
                                    <a name="list"></a>
                                    <div>&nbsp;</div>
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content">
                                            <h4 class=" text-3 text-uppercase mb-3 text-right" style="color: red;font-weight: 400;">( * 必填欄位 )</h4>
                                            {!! Form::open(['url' => '/temp','class'=>'form-horizontal','name'=>'submit_form'])  !!}
                                            {!! Form::hidden('cate_id',$cate->id) !!}
                                            {!! Form::hidden('product_id',null,['id'=>'product_id']) !!}
                                            {!! Form::hidden('partner_id',null,['id'=>'partner_id']) !!}
                                            <div class="form-row">
                                                <div class="form-group col">
                                                    <label for="proarea_id" class="font-weight-bold text-dark text-3">交車區域 <span style="color: red;"> *</span></label>
                                                    <!-- aaa Form select Input -->
                                                    {!! Form::select('proarea_id', $list_proareas , $search_proarea_id,['id'=>'proarea_id','class'=>'form-control','style'=>'','required','onchange'=>'document.location.href="?search_proarea_id="+this.value+"#list";']) !!}
                                                </div>
                                            </div>

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
                                            <div class="form-row" id="show_product">
                                                @if(count($product_arr))
                                                    <div style="color: green;text-align: center;width: 100%;padding-bottom: 10px;font-weight: 300;">( 符合您條件搜尋共 {{count($product_arr)}} 台車型 )</div>
                                                @endif
                                            <!--桌機版-->
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
                                                                        <td class="temp_title_td">原始牌價</td>
                                                                        <td class="temp_content_td">{{$product->new_car_price>0? '$ '.number_format($product->new_car_price):'(更新中...)'}}</td>
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
                                                                    @php
                                                                        $partner_name='';
                                                                        $list_partners=null;
                                                                        $partner=$product->partner;
                                                                        $partners_count=0;
                                                                        if($partner){
                                                                            $partner_name=$partner->title;
                                                                            if(mb_substr( $partner_name,0,2,"utf-8")=='格上')
                                                                                $list_partners=\App\Model\Partner::whereStatus(1)->where('title','like','%格上%')->where('proarea_id',$search_proarea_id)->pluck('title','id')->prepend('請選擇','');
                                                                            else
                                                                                $list_partners=\App\Model\Partner::whereStatus(1)->whereid($partner->id)->pluck('title','id')->prepend('請選擇','');
                                                                        }

                                                                        //$list_partners=$product->partner;
                                                                        //dd($list_partners);
                                                                    @endphp
                                                                    <tr>
                                                                        {{--<td class="temp_title_td"></td>--}}
                                                                        <td colspan="2" class="temp_button_td" style="font-size: 16px;font-weight: 400;text-align: left;padding: 10px">
                                                                            <div style="padding-bottom: 5px">請選擇交車地點</div>
                                                                            {!! Form::select('select_partner', $list_partners?$list_partners:[] , null ,['class'=>'partner','id'=>'partner'.$key]) !!}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="temp_button_td">
                                                                            <button type="submit" onclick="return chk_subscriber{{$key}}();" class="btn btn-primary" style="padding: 5px 10px;font-size: 14px;margin: 0 5px">我要訂閱</button>
                                                                            <script>
                                                                                function chk_subscriber{{$key}}() {
                                                                                    $('#product_id').val('{{$product->id}}');
                                                                                    $('#partner_id').val($('#partner{{$key}} :selected').val());
                                                                                    if($('#partner_id').val()==='') {
                                                                                        alert('請選擇交車地點');
                                                                                        $('#partner{{$key}}').css('border-color','red').css('border-width','2px').delay(5000).queue(function (next) {
                                                                                            $(this).css('border-color','#ddd').css('border-width','1px');
                                                                                            next();
                                                                                        });
                                                                                        return false;
                                                                                    }
                                                                                    else {
                                                                                        @if($user && $user->is_check != 1)
                                                                                        alert('尚未開通訂閱功能，請至會員中心>修改基本資料，填寫完整的會員資料。SeaLand會在確認後，開通您的訂閱功能。');
                                                                                        return false;
                                                                                        @else
                                                                                            return chk_form();
                                                                                        @endif
                                                                                    }
                                                                                }
                                                                            </script>
                                                                            <a href="https://lin.ee/5hY23RH"
                                                                               class="btn btn-success" target="_blank" style="padding: 5px 10px;font-size: 14px;margin: 0 5px">線上諮詢</a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div style="color: red">( 此區域暫無車輛可供訂閱 )</div>
                                                    @endif
                                                </section>
                                                <hr>
                                                <!--手機版-->
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
                                                                        <td class="temp_title_td">原始牌價</td>
                                                                        <td class="temp_content_td">{{$product->new_car_price>0? '$ '.number_format($product->new_car_price):'(更新中...)'}}</td>
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
                                                                    @php
                                                                        $partner_name='';
                                                                        $list_partners=null;
                                                                        $partner=$product->partner;
                                                                        $partners_count=0;
                                                                        if($partner){
                                                                            $partner_name=$partner->title;
                                                                            if(mb_substr( $partner_name,0,2,"utf-8")=='格上')
                                                                                $list_partners=\App\Model\Partner::whereStatus(1)->where('title','like','%格上%')->where('proarea_id',$search_proarea_id)->pluck('title','id')->prepend('請選擇','');
                                                                            else
                                                                                $list_partners=\App\Model\Partner::whereStatus(1)->whereid($partner->id)->where('proarea_id',$search_proarea_id)->pluck('title','id')->prepend('請選擇','');
                                                                        }

                                                                        //$list_partners=$product->partner;
                                                                        //dd($list_partners);
                                                                    @endphp
                                                                    <tr>
                                                                        {{--<td class="temp_title_td"></td>--}}
                                                                        <td colspan="2" class="temp_button_td" style="font-size: 16px;font-weight: 400;text-align: left;padding: 10px">
                                                                            <div style="padding-bottom: 5px">請選擇交車地點</div>
                                                                            {!! Form::select('select_partner', $list_partners?$list_partners:[] , null ,['class'=>'partner','id'=>'partner_xs'.$key]) !!}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="temp_button_td">
                                                                            <button type="submit" onclick="return chk_subscriber_xs{{$key}}();" class="btn btn-primary" style="padding: 5px 10px;font-size: 14px;margin: 0 5px">我要訂閱</button>
                                                                            <script>
                                                                                function chk_subscriber_xs{{$key}}() {
                                                                                    $('#product_id').val('{{$product->id}}');
                                                                                    $('#partner_id').val($('#partner_xs{{$key}} :selected').val());
                                                                                    if($('#partner_id').val()==='') {
                                                                                        alert('請選擇交車地點');
                                                                                        //$('#partner{{$key}}').focus()
                                                                                        return false;
                                                                                    }
                                                                                    @if($user && $user->is_check != 1)
                                                                                    alert('尚未開通訂閱功能，請至會員中心>修改基本資料，填寫完整的會員資料。SeaLand會在確認後，開通您的訂閱功能。');
                                                                                    return false;
                                                                                    @else
                                                                                        return chk_form();
                                                                                    @endif
                                                                                }
                                                                            </script>
                                                                            <a href="https://lin.ee/5hY23RH"
                                                                               class="btn btn-success" target="_blank" style="padding: 5px 10px;font-size: 14px;margin: 0 5px">線上諮詢</a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div style="color: red">( 此區域暫無車輛可供訂閱 )</div>
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
    <div class="modal cid-sdF2KbblXf fade" tabindex="-1" role="dialog" data-overlay-color="#000000" data-overlay-opacity="0.8" data-on-timer-delay="0" id="mbr-popup-25" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div style="display: block" id="spec">
                    <div class="modal-header pb-0">
                        <h5 class="modal-title mbr-fonts-style display-5" style="color: orange">訂閱費用說明</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" fill="currentColor">
                                <path d="M31.797 0.191c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.598 0.581 0.342 1.543 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM14.472 17.515c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.613 0.595 0.34 1.562 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM1.144 0.205c-0.584-0.587-1.544 0.336-0.942 0.942l30.654 30.651c0.613 0.625 1.563-0.325 0.942-0.942z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div>
                            <div class="card-img mbr-figure">
                                <table>
                                    <tr style="border-bottom: dashed 1px black;">
                                        <td style="width: 40%;">訂閱</td>
                                        <td style="width: 60%;text-align: left;">{{number_format($cate->deposit)}} <span style="color: grey"> (保證金)</span></td>
                                    </tr>
                                    <tr style="border-bottom: dashed 1px black;">
                                        <td style="width: 40%;">取車</td>
                                        <td style="width: 60%;text-align: left;">
                                            {{number_format($cate->basic_fee)}} x 3<br>
                                            +<br>
                                            {{$cate->mile_fee}} x 3,000公里 = {{number_format( ($cate->basic_fee*3) + ($cate->mile_fee * 3000) )}}<span style="color: grey">(預收)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 40%;">還車</td>
                                        <td style="width: 60%;text-align: left;">
                                            里程費率*(實際里程-3,000公里)<br>
                                            +<br>
                                            其它費用 <span style="color: grey">(ETC等)</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
                        <table style="text-align: center;width: 90%;margin-left: 30px">
                            <tr>
                                <td style="position: relative;top: -3px"><input type="checkbox" id="terms"></td>
                                <td style="text-align: left;">&nbsp;&nbsp;<label for="terms">我同意 Sealand <a href="/pdf/rent_rule01.pdf" onclick="t1=1;" target="_blank">會員合約訂閱車輛規定</a></label></td>
                            </tr>
                            <tr>
                                <td style="position: relative;top: -3px"><input type="checkbox" id="terms2"></td>
                                <td style="text-align: left;">&nbsp;&nbsp;<label for="terms2">我同意 Sealand <a href="/pdf/rent_rule02.pdf" onclick="t2=1;" target="_blank">車輛租賃契約_訂閱式租賃</a></label></td>
                            </tr>
                        </table>
                        <div>&nbsp;</div>
                    </div>
                    <!---->
                    <!--document.submit_form.submit();-->
                    <div class="modal-footer">
                        <div class="mbr-section-btn">
                            <a class="btn btn-md btn-primary display-3" href="#" style=" padding: 15px 30px" onclick="return chk_form2();">
                                送出訂閱
                            </a>
                        </div>
                    </div>
                </div>
                <div style="display: none" id="sending">
                    <div class="modal-header pb-0">
                        <h5 class="modal-title mbr-fonts-style display-5">資料送出審核中...</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" fill="currentColor">
                                <path d="M31.797 0.191c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.598 0.581 0.342 1.543 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM14.472 17.515c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.613 0.595 0.34 1.562 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM1.144 0.205c-0.584-0.587-1.544 0.336-0.942 0.942l30.654 30.651c0.613 0.625 1.563-0.325 0.942-0.942z"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p class="mbr-text mbr-fonts-style display-7">
                            請等待大約30秒左右。(有可能時間會超過1~2分鐘左右，敬請等待審核結果。)
                        </p>
                        <div style="text-align: center;">
                            <img src="/assets/images/loading2.gif" alt="" style="width: 100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="modal cid-sdF2KbblXf fade" tabindex="-1" role="dialog" data-overlay-color="#000000" data-overlay-opacity="0.8" data-on-timer-delay="0" id="mbr-popup-26" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    <h5 class="modal-title mbr-fonts-style display-5">資料送出審核中...</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" fill="currentColor">
                            <path d="M31.797 0.191c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.598 0.581 0.342 1.543 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM14.472 17.515c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.613 0.595 0.34 1.562 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM1.144 0.205c-0.584-0.587-1.544 0.336-0.942 0.942l30.654 30.651c0.613 0.625 1.563-0.325 0.942-0.942z"></path>
                        </svg>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="mbr-text mbr-fonts-style display-7">
                        請等待大約30秒左右。(有可能時間會超過1~2分鐘左右，敬請等待審核結果。)
                    </p>
                    <div style="text-align: center;">
                            <img src="/assets/images/loading2.gif" alt="" style="width: 100%">
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
@endsection

@section('extra-js')
    <script src="/js/jquery-ui.min.js" type="text/javascript"></script>
    <script>
        var availableDates =  {!! getShowDateString() !!} ;
        //var availableDates = ["2020-11-27","2020-11-28","2020-11-29","2020-11-30","2020-12-1","2020-12-2","2020-12-3","2020-12-4","2020-12-5","2020-12-6","2020-12-7","2020-12-8"];
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

        function chk_form() {
            var sub_date=document.getElementById('sub_date');
            /*if($('#proarea_id :selected').val()==''){
                alert('請選擇交車區域')
                $('#proarea_id').focus();
                return false;
            }
            else*/
            if(sub_date.value===''){
                alert('請選擇交車日期')
                $('#sub_date').css('border-color','red').css('border-width','2px').delay(5000).queue(function (next) {
                    $(this).css('border-color','#ddd').css('border-width','1px');
                    next();
                });
                return false;
            }
            else if($('#pick_up_time :selected').val()==='') {
                alert('請選擇前往取車時間')
                $('#pick_up_time').css('border-color','red').css('border-width','2px').delay(5000).queue(function (next) {
                    $(this).css('border-color','#ddd').css('border-width','1px');
                    next();
                });
                return false;
            }
            else {
                $('#mbr-popup-25').modal();
                return false;
                //document.submit_form.submit();
            }

        }

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
            /*$('#mbr-popup-25').modal();*/
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


        var t1=0;
        var t2=0;

        function chk_form2() {
            if(t1==0) {
                alert("您必須閱讀: 會員合約訂閱車輛規定 才能繼續。");
                return false;
            }else if(t2==0) {
                alert("您必須閱讀: 車輛租賃契約_訂閱式租賃 才能繼續。");
                return false;
            }else if(terms.checked!=true) {
                alert("您必須勾選同意: 會員合約訂閱車輛規定 才能繼續。");
                return false;
            }else if(terms2.checked!=true) {
                alert("您必須勾選同意: 車輛租賃契約_訂閱式租賃 才能繼續。");
                return false;
            }else {
                $('#spec').hide();$('#sending').show();
                document.submit_form.submit();
            }

        }
    </script>
@endsection