@extends('frontend_carplus.layouts.app')

@section('extra-css')
    <style>
        .renew_select{
            border: solid 1px #ddd;
            padding: 5px;
            border-radius: 5px;
            color: #777;
            background-color: #eee;
            font-weight: 400;
        }
    </style>
@stop

@section('extra-top-js')

@stop

@section('content')

    <div role="main" class="main" style="padding-top: 120px;padding-bottom: 120px;background-image: url(/assets/images/flow_bg.jpg);">
        {{--@include('frontend.layouts.partials.message')--}}
        <div class="shop" style="padding-top: 20px">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="featured-boxes">
                            <div class="row">
                                <div class="col-md-12" style="max-width: 500px;margin: 0 auto;background-color: #fff;border-radius: 20px;padding: 25px">
                                    <div>&nbsp;</div>
                                    <div>&nbsp;</div>
                                    <h3 class="text-center">訂單明細</h3>
                                    <div>&nbsp;</div>
                                    <hr>
                                    <div>&nbsp;</div>
                                    <div style="text-align: left;padding-left:20px;">
                                        訂單編號：{{$ord->ord_no}}
                                    </div>
                                    <div style="text-align: left;padding-left:20px;">
                                        訂單新增時間：{{$ord->created_at}}
                                    </div>
                                    @if($ord->is_cancel==1)
                                        <div style="text-align: left;padding-left:20px;color: red;padding-top: 10px">
                                            <div style="font-size: 24px;">此訂單已取消</div>
                                            ( 取消時間：{{ $ord->cancel_date }} )
                                        </div>
                                    @else
                                        @if($ord->is_cancel==0 && $ord->is_paid==0)
                                            <div style="text-align: left;padding-left:20px;color: red;padding-top: 10px">
                                                @php
                                                    if($ord->is_pass_by_api==1)
                                                        $limit_minutes=60 * setting('ord_limit_minutes');
                                                    else
                                                        $limit_minutes=28800;
                                                    $time2=date('Y-m-d H:i:s');
                                                    $time1=$ord->created_at;
                                                    $diff=$limit_minutes - ((strtotime($time2) - strtotime($time1)));
                                                @endphp
                                                <span style="display:none;" id="unixtime_coming_0">{{$diff}}</span>
                                                <div onload='timer()' id="timer_coming_0" style="color: green;padding-bottom: 10px;"></div>
                                                <script type="text/javascript">
                                                    var counter = setInterval(timer, 1000);

                                                    function timer() {
                                                        var unixtime = document.getElementById("unixtime_coming_0");
                                                        var count = parseInt(unixtime.innerHTML, 10);
                                                        unixtime.innerHTML = count - 1;

                                                        if (count < 1) {
                                                            $('#timer_coming_0').css('color','red');
                                                            document.getElementById("timer_coming_0").innerHTML= '( 訂單已過期 )';
                                                            clearInterval(counter);
                                                            return;
                                                        }

                                                        var days = Math.floor(count/86400);
                                                        var hours = Math.floor(count/3600) % 24;
                                                        var minutes = Math.floor(count/60) % 60;
                                                        var seconds = count % 60;

                                                        document.getElementById("timer_coming_0").innerHTML= '訂單有效剩餘時間：' + hours + "時 "+ minutes + "分 " + seconds + "秒"; // watch for spelling
                                                    }
                                                </script>
                                                請注意！請於時效內完成付款，否則訂單將自動取消。
                                            </div>
                                        @endif
                                        <div style="text-align: left;padding-left:20px;color:purple;padding-top: 10px">
                                            {{$ord->state_id>=8?'原':''}}訂單狀態：{{$ord->state?$ord->state->ftitle:''}}
                                        </div>
                                        @if($ord->state_id>=8 && $ord->renewtate)
                                            <div style="text-align: left;padding-left:20px;color:darkorange;padding-top: 10px">
                                                訂單續約狀態：{{$ord->renewtate->ftitle}}
                                            </div>
                                        @endif
                                        @php
                                            $left_days=getOrdLeftDays($ord->id);
                                        @endphp
                                        @if($ord->state_id>=6)
                                            <div style="text-align: left;padding-left:20px;padding-top: 5px">
                                                剩餘到期日：
                                                @if($left_days <= setting('user_renewal_start_days'))
                                                    <span style="color: red;font-weight: bold;font-size: 20px;">{{$left_days}} 天</span>
                                                @else
                                                    <span>{{$left_days}} 天</span>
                                                @endif
                                                @if($ord->state_id==7 && $left_days <= setting('user_renewal_start_days') && $left_days >= setting('user_renewal_end_days'))
                                                    <hr>
                                                    <span style="color: green">
                                                        請選擇以下續約選項：

                                                        {!! Form::select('renewtate_id', $list_renewtates , $ord->renewtate_id ,['class'=>'renew_select','onclick'=>'curr=this.selectedIndex','onchange'=>'if(confirm("是否確認要改變設定？")){document.location.href="?renewtate_id="+this.value;}else{this.selectedIndex=curr;}']) !!}
                                                        <div style="color: red;font-weight: 400;padding-top: 5px;font-size: 15px;">(您可以在到期日前{{setting('user_renewal_end_days')}}~{{setting('user_renewal_start_days')}}天內決定是否要續約)</div>
                                                    </span>
                                                    <hr>
                                                @endif
                                            </div>
                                            @if($ord->state_id>=10)
                                                <div style="text-align: left;padding-left:20px;color:purple;padding-top: 10px">
                                                    車輛續約：
                                                    @if($ord->is_car_renewal==0)
                                                        <span style="color: red">( 車源商已不提供續約 )</span>
                                                    @else
                                                        {{$ord->renewtate?$ord->renewtate->ftitle:''}}
                                                    @endif
                                                </div>
                                            @endif
                                        @endif
                                    @endif
                                    <div>&nbsp;</div>
                                    <div class="featured-box featured-box-primary text-left mt-2">
                                        <div class="box-content" style="padding: 0 20px">
                                            <div class="form-row">
                                                <div class="form-group col">

                                                    @if($cate)
                                                        <h5>方案資訊：</h5>
                                                        <span style="font-size: 20px;color: purple">{{$cate->title}}</span><br>
                                                        <span style="color: purple">{{number_format($cate->basic_fee) }} 元/月</span><br>
                                                        <span style="color: purple">{{number_format($cate->mile_fee,2) }} 元/每公里</span><br>
                                                    @endif
                                                        <div style="color: green;font-size: 18px;">
                                                            保證金：{{number_format($ord->deposit)}}
                                                        </div>
                                                        <div>
                                                            是否付款：{!! $ord->is_paid==1?'<span style="color:green">保證金已付</span>':'<span style="color:red">未付款</span>' !!}
                                                        </div>
                                                </div>
                                            </div>
                                            <hr>
                                            @if($ord->is_cancel==0)
                                                <h5>車輛資訊：</h5>
                                                {{--車輛 ID：<span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->id }}</span><br>--}}
                                                @if($ord->plate_no && $ord->state_id>=3)
                                                    車號：{{$ord->plate_no}}<br>
                                                @endif
                                                @if($product)
                                                    <span style="color: black;font-weight: 300;">品牌:</span><span style="font-weight: bold;"> {{$product->brandcat?$product->brandcat->title:'' }}</span><br>
                                                    <span style="color: black;font-weight: 300;">車型:</span><span style="font-weight: bold;"> {{$product->brandin?$product->brandin->title:''}}</span><br>
                                                    <span style="color: black;font-weight: 300;">排氣量:</span><span style="font-weight: bold;"> {{ number_format($product->displacement) }}</span><br>
                                                    <span style="color: black;font-weight: 300;">年份:</span><span style="font-weight: bold;"> {{ $product->year }}</span><br>
                                                    <span style="color: black;font-weight: 300;">排檔:</span><span style="font-weight: bold;"> {{$product->progeartype?$product->progeartype->title:''}}</span><br>
                                                    <span style="color: black;font-weight: 300;">座位數:</span><span style="font-weight: bold;"> {{$product->seatnum}}</span><br>
                                                    <span style="color: black;font-weight: 300;">顏色:</span><span style="font-weight: bold;"> {{$product->procolor?$product->procolor->title:''}}</span><br>
                                                    <span style="color: black;font-weight: 300;">里程數:</span><span style="font-weight: bold;"> {{ number_format($product->milage) }}</span><br><br>
                                                @endif
                                                @if($ord->state_id>=4)
                                                    <hr>
                                                    <div>交車里程數：{{number_format($ord->milage)}}</div>
                                                    <div>預計交車日期：{{$ord->sub_date}}</div>
                                                    <div>實際交車日期：{{$ord->real_sub_date}}</div>
                                                    @if($ord->state_id>=5)
                                                        <div>實際交車時間：{{$ord->real_sub_time}}</div>
                                                        <div>到期日：{{$ord->expiry_date}} {{$ord->expiry_time}}</div>
                                                    @endif
                                                    <div>
                                                        @php
                                                            $basic_fee=$ord->basic_fee;
                                                            $mile_fee=$ord->mile_fee;
                                                            $mile_pre_month=$ord->mile_pre_month;
                                                            $payment_total=($basic_fee+($mile_fee*$mile_pre_month)) * $ord->rent_month;
                                                        @endphp
                                                        起租款：
                                                        ( {{number_format($basic_fee)}} + ( {{$mile_fee}} x {{number_format($mile_pre_month)}} ) )  *
                                                        {{$ord->rent_month}} = {{number_format($payment_total)}} 元
                                                    </div>
                                                    <div style="color: green;font-size: 20px;padding-top: 10px">
                                                        {!! $ord->is_paid2==1?'<span style="color: green">已付':'<span style="color: red">未付' !!} 起租款：{{number_format($ord->payment_total)}} 元
                                                    </div>
                                                @endif
                                                @if($ord->state_id>=9)
                                                    @php
                                                        $use_mile=$ord->back_milage-$ord->milage;
                                                        $mile_3month=$ord->mile_pre_month * $ord->rent_month;
                                                        $sub_use_mile=$use_mile-$mile_3month;
                                                        $mile_fee=$ord->mile_fee;
                                                        $delay_fee=$ord->delay_fee;
                                                        $mile_fee_total=$sub_use_mile*$mile_fee+$delay_fee;
                                                    @endphp
                                                    <hr>
                                                    <h5>里程費用計算(G)</h5>
                                                    <hr>
                                                    <div>
                                                        取車日期：{{$ord->real_sub_date}} {{$ord->real_sub_time}}
                                                    </div>
                                                    <!-- 交車日期 Form text Input -->
                                                    <div>
                                                        還車日期：{{$ord->real_back_date}}
                                                    </div>
                                                    <div>
                                                        取車里程：{{number_format($ord->milage)}}
                                                    </div>
                                                    <!-- 還車里程 Form text Input -->
                                                    <div>
                                                        還車里程：{{number_format($ord->back_milage)}}
                                                    </div>
                                                    <div>
                                                        合計使用里程(A)：{{number_format($use_mile)}}
                                                    </div>
                                                    <div>
                                                        預付里程數(B)：{{number_format($mile_3month)}}
                                                    </div>
                                                    <div>
                                                        差額里程數(A-B)：{{number_format($sub_use_mile)}}
                                                    </div>
                                                    <div>
                                                        里程費率Km/元：{{$mile_fee}}
                                                    </div>
                                                    <div>
                                                        逾時租金：{{$ord->delay_fee?$ord->delay_fee:0}}
                                                    </div>
                                                    <div style="color: green;font-weight: bold;font-size: 16px;border-top: solid 1px #eee;padding-top: 5px">
                                                        補(退)金額(G)：{{number_format($ord->mile_fee_total)}}</span>
                                                    </div>
                                                    <hr>
                                                    <h5>其他費用(N)</h5>
                                                    <hr>
                                                    <div>
                                                        E-Tag金額：{{number_format($ord->e_tag)}}
                                                    </div>

                                                    <div>
                                                        車損費用：{{number_format($ord->damage_fee)}}
                                                    </div>

                                                    <div>
                                                        營業損失：{{number_format($ord->business_loss)}}
                                                    </div>

                                                    <div>
                                                        油費：{{number_format($ord->fuel_cost)}}
                                                    </div>

                                                    <div>
                                                        牽送車服務費：{{number_format($ord->service_charge)}}
                                                    </div>
                                                    <div style="color: green;font-weight: bold;font-size: 16px;border-top: solid 1px #eee;padding-top: 5px">
                                                        應收金額合計：{{number_format($ord->other_fee_total)}}
                                                    </div>
                                                    <hr>
                                                    <div style="color: purple;font-weight: bold;font-size: 16px;">
                                                        補收費用總計(G)+(N)：{{number_format($ord->payment_backcar_total)}}
                                                    </div>
                                                    <div style="color: green;font-size: 20px;padding-top: 10px">
                                                        @if($ord->payment_backcar_total>0)
                                                            {!! $ord->is_paid3==1?'<span style="color: green">已付':'<span style="color: red">未付' !!} 迄租款項：{{number_format($ord->payment_backcar_total)}} 元
                                                        @else
                                                            <div style="color: green">Sealand 應退還：{{ (number_format($ord->payment_backcar_total*-1))}} 元</div>
                                                        @endif
                                                    </div>
                                                    <div>&nbsp;</div>
                                                @endif
                                                <div>&nbsp;</div>
                                                <div class="form-row">
                                                    <div class="form-group col-lg-12">
                                                        <div style="text-align: center;">
                                                            @if($ord->is_cancel==0)
                                                                @if($ord->is_paid==0)
                                                                    <!-- Begin Form -->
                                                                    {!! Form::open(['url' => '/checkout/creditPaid'])  !!}
                                                                        {!! Form::hidden('ord_id',$ord->id) !!}
                                                                        <a href="/ord_list" class="btn btn-primary text-3">回訂單列表</a>
                                                                        <button type="submit" class="btn btn-success text-3">前往付：保證金</button>
                                                                    {!! Form::close() !!}
                                                                    <!-- End of Form -->
                                                                @elseif($ord->state_id==4 && $ord->is_paid==1 && $ord->is_paid2==0)
                                                                    <!-- Begin Form -->
                                                                    {!! Form::open(['url' => '/checkout/creditPaid2'])  !!}
                                                                        {!! Form::hidden('ord_id',$ord->id) !!}
                                                                        <a href="/ord_list" class="btn btn-primary text-3">回訂單列表</a>
                                                                        <button type="submit" class="btn btn-success text-3" onclick="">前往付：起租款</button>
                                                                    {!! Form::close() !!}
                                                                    <!-- End of Form -->
                                                                @elseif($ord->state_id==9 && $ord->is_paid==1 && $ord->is_paid2==1 && $ord->payment_backcar_total>0)
                                                                    <!-- Begin Form -->
                                                                    {!! Form::open(['url' => '/checkout/creditPaid3'])  !!}
                                                                        {!! Form::hidden('ord_id',$ord->id) !!}
                                                                        <a href="/ord_list" class="btn btn-primary text-3">回訂單列表</a>
                                                                        <button type="submit" class="btn btn-success text-3" onclick="">前往付：迄租款</button>
                                                                    {!! Form::close() !!}
                                                                    <!-- End of Form -->
                                                                @else
                                                                    <a href="/ord_list" class="btn btn-primary text-3">回訂單列表</a>
                                                                @endif
                                                            @else
                                                                <a href="/ord_list" class="btn btn-primary text-3">回訂單列表</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div style="text-align: center;">
                                                    <a href="/ord_list" class="btn btn-primary text-3">回訂單列表</a>
                                                </div>
                                            @endif

                                        </div>
                                    </div>

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
    <script>
        var t1=0;
        var t2=0;

        function chk_form() {
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
            }else
                document.form1.submit();

        }
    </script>
@endsection