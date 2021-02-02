@extends('admin.layouts.adminapp')

@section('extra-css')
    <link rel="stylesheet" href="/back_assets/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="/back_assets/plugins/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/summernote/dist/summernote-bs4.css">
    <link rel="stylesheet" href="/back_assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link rel="stylesheet" href="/back_assets/plugins/mohithg-switchery/dist/switchery.min.css">
    <link rel="stylesheet" href="/back_assets/dist/css/theme.css">
    <link rel="stylesheet" href="/back_assets/css/custom.css">

    <script src="/back_assets/src/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="/css/jquery-ui-1.9.2.css" type="text/css" charset="utf-8" />

    <style>
        .search_select{
            height: auto;min-height: 35px;
            width: 100%;
            border: 1px solid #eaeaea;
            padding: 0 10px;
            background-color: #fff;
            font-size: 15px;
            border-radius: 4px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
        }
    </style>
@stop

@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="page-header-title">
                            <i class="ik ik-settings bg-blue"></i>
                            <div class="d-inline">
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">月結報表對帳單</h5>
                                {{--                                <span>各項參數月結報表對帳單</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">月結報表對帳單</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="">
                            <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                <span style="display: inline-block;padding-left: 10px">車輛 查詢及列表</span>
                            </div>
                        </div>
                        <div class="card-body" style="padding-bottom: 5px">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['url' => '/admin/reporter','method'=>'GET','name'=>'form_search'])  !!}
                                    {!! Form::hidden('download',null,['id'=>'download']) !!}
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="search_partner_id_arr">總經銷商</label>
                                            {!! Form::select('search_dealer_id', $list_dealers ,$search_dealer_id ,['id'=>'partner','class'=>'form-control','onclick'=>'document.getElementById("download").value=0;']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_cate_id">開始日期</label>
                                            {!! Form::text('search_start_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly','required']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_brandcat_id">結束日期</label>
                                            {!! Form::text('search_end_date',null,['class'=>'form-control datePicker','autocomplete'=>'off','readonly','required']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <div style="height: 28px;">&nbsp;</div>
                                            <button type="submit" class="btn btn-primary" onclick="document.getElementById('download').value=0">查詢</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <hr>
                        @if($search_dealer_id)
                            <table>
                                <tr>
                                    <th style="padding-top: 10px;padding-left: 20px;padding-right: 10px;font-size: 20px;color: purple">
                                        月報表<br>
                                        開始日期：{{$search_start_date}}<br>
                                        結束日期：{{$search_end_date}}
                                    </th>
                                </tr>
                                <tr>
                                    <th style="padding-top: 10px;padding-left: 22px;padding-right: 10px;font-size: 16px;">
                                        @php
                                            $dealer_name='';
                                            $dealer=\App\Model\Dealer::whereId($search_dealer_id)->first();
                                            if($dealer)
                                                $dealer_name=$dealer->title;
                                        @endphp
                                        總經銷商：{{$dealer_name}}
                                    </th>
                                </tr>
                            </table>
                            <hr>
                            <table>
                                <tr>
                                    <th style="padding: 10px 20px;font-size: 20px;font-weight: bold;">1. 起租繳付 報表</th>
                                </tr>
                                <tr>
                                    <th style="padding-left: 30px;padding-right: 10px;font-size: 16px;">
                                        <span style="display: inline-block;padding-left: 10px">總資料筆數：{{$start_ords?$start_ords->count():0}} 筆</span>
                                        @if($start_ords && $start_ords->count()>0)
                                            <a href="#" onclick="document.getElementById('download').value=1;document.form_search.submit();" class="btn btn-primary float-md-right">匯出月結報表</a>
                                        @endif
                                    </th>
                                </tr>
                            </table>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="background-color: #e3f5fd;">No.</th>
                                            <th style="background-color: #e3f5fd;">對帳區間</th>
                                            <th style="background-color: #e3f5fd;">網站來源</th>
                                            <th style="background-color: #e3f5fd;">經銷商</th>
                                            <th style="background-color: #e3f5fd;">訂單編號</th>
                                            <th style="background-color: #e3f5fd;">付款日期</th>
                                            <th style="background-color: #e3f5fd;">品牌</th>
                                            <th style="background-color: #e3f5fd;">車型</th>
                                            <th style="background-color: #e3f5fd;">車號</th>
                                            <th style="background-color: #e3f5fd;">起租/迄租</th>
                                            <th style="background-color: #e3f5fd;">起租日</th>
                                            <th style="background-color: #e3f5fd;">迄租日</th>
                                            <th style="background-color: #e3f5fd;">實際取車日</th>
                                            <th style="background-color: #e3f5fd;">實際還車日</th>
                                            <th style="background-color: #e3f5fd;">月租金</th>
                                            <th style="background-color: #e3f5fd;">里程費率元/KM</th>
                                            <th style="background-color: #e3f5fd;">預收里程KM/月</th>
                                            <th style="background-color: #e3f5fd;">預收月數</th>
                                            <th style="background-color: #e3f5fd;">實際使用里程(km)</th>
                                            <th style="background-color: #e3f5fd;">超額里程(km)</th>
                                            <th style="background-color: #e3f5fd;">預收月租金總額</th>
                                            <th style="background-color: #e3f5fd;">預收里程租金</th>
                                            <th style="background-color: #e3f5fd;">逾期租金</th>
                                            <th style="background-color: #e3f5fd;">車損</th>
                                            {{--<th style="background-color: #e3f5fd;">營業損失</th>--}}
                                            <th style="background-color: #e3f5fd;">油費</th>
                                            <th style="background-color: #e3f5fd;">服務費</th>
                                            <th style="background-color: #e3f5fd;">ETAG</th>
                                            <th style="background-color: #e3f5fd;">其他項目</th>
                                            <th style="background-color: #e3f5fd;">%</th>
                                            <th style="background-color: #e3f5fd;">車源商應收租金(J)</th>
                                            <th style="background-color: #e3f5fd;">車源商應收代墊款(K)</th>
                                            <th style="background-color: #fde9e9;">合計</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $start_total=0;
                                        @endphp
                                        @if($start_ords)
                                            @foreach($start_ords as $key=>$ord)
                                                @php
                                                    $rate=0;
                                                    $partner=$ord->partner;
                                                    if($partner){
                                                        $partner_name=$partner->title;
                                                        $dealer=$partner->dealer;
                                                        if($dealer){
                                                            if($ord->order_from==1)
                                                                $rate=$dealer->rate_carplus;
                                                            else
                                                                $rate=$dealer->rate_sealand;
                                                        }
                                                    }

                                                    $basic_fees=$ord->basic_fee * $ord->rent_month; //預收月租金總額

                                                    $mile_months=$ord->mile_pre_month * $ord->rent_month;
                                                    $mile_fee=$ord->mile_fee; //里程費率Km/元
                                                    $mile_fee_total=$mile_months*$mile_fee; //預收里程租金
                                                    //預收月租金總額=(預收月租金總額+里程租金)*0.84
                                                    $partner_rent_total=($basic_fees+$mile_fee_total) * $rate;
                                                    $start_total+=$partner_rent_total;
                                                @endphp
                                                @if($partner)
                                                    <tr>
                                                        <td>{{$key+1}}</td> {{--No.--}}
                                                        <td>{{$search_start_date}}<br>~{{$search_end_date}}</td> {{--對帳區間--}}
                                                        <td>{{$ord->order_from==1?'格上':'Sealand'}}</td> {{--經銷商--}}
                                                        <td>{{$partner_name}}</td> {{--經銷商--}}
                                                        <td>{{$ord->ord_no}}</td> {{--訂單編號--}}
                                                        <td>{{substr($ord->paid2_date,0,10)}}</td> {{--付款日期--}}
                                                        <td>{{$ord->brandcat_name}}</td> {{--品牌--}}
                                                        <td>{{$ord->brandin_name}}</td> {{--車型--}}
                                                        <td>{{$ord->plate_no}}</td> {{--車號--}}
                                                        <td>起租</td> {{--起租/迄租--}}
                                                        <td>{{ $ord->sub_date }}</td> {{--起租日--}}
                                                        <td>{{$ord->expiry_date}}</td> {{--迄租日--}}
                                                        <td>{{$ord->real_sub_date}}</td> {{--實際取車日--}}
                                                        <td></td> {{--實際還車日--}}
                                                        <td>{{ number_format($ord->basic_fee) }}</td> {{--月租金--}}
                                                        <td>{{ $ord->mile_fee }}</td> {{--里程費率元/KM--}}
                                                        <td>{{ number_format($ord->mile_pre_month) }}</td> {{--預收里程KM/月--}}
                                                        <td>{{$ord->rent_month}}</td> {{--預收月數--}}
                                                        <td></td> {{--實際使用里程(km)--}}
                                                        <td></td> {{--超額里程(km)--}}
                                                        <td>{{ number_format($basic_fees) }}</td> {{--預收月租金總額--}}
                                                        <td>{{ number_format($mile_fee_total) }}</td> {{--里程租金--}}
                                                        <td></td> {{--逾期租金--}}
                                                        <td></td> {{--車損--}}
                                                        {{--<td></td> --}}{{--營業損失--}}
                                                        <td></td> {{--油費--}}
                                                        <td></td> {{--服務費--}}
                                                        <td></td> {{--E-tag--}}
                                                        <td></td> {{--其他項目--}}
                                                        <td>{{$rate*100}} %</td>
                                                        <td>{{number_format($partner_rent_total)}}</td> {{--車源商應收租金(J)--}}
                                                        <td></td> {{--車源商應收代墊款(K)--}}
                                                        <td style="background-color: #ecfde9;">{{number_format($partner_rent_total)}}</td> {{--合計--}}
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="29">&nbsp;</td>
                                            <td style="text-align: right;" colspan="2">總計：</td>
                                            <td style="color: purple;font-weight: bold;font-size: 20px;background-color: #ecfde9;">{{number_format($start_total)}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    @if($search_dealer_id!=1 && $start_carplus_commission_ords->count()>0)
                                        <h5>格上網站非格上車輛傭金</h5>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="background-color: #e3f5fd;">No.</th>
                                                <th style="background-color: #e3f5fd;">對帳區間</th>
                                                <th style="background-color: #e3f5fd;">網站來源</th>
                                                <th style="background-color: #e3f5fd;">經銷商</th>
                                                <th style="background-color: #e3f5fd;">訂單編號</th>
                                                <th style="background-color: #e3f5fd;">付款日期</th>
                                                <th style="background-color: #e3f5fd;">品牌</th>
                                                <th style="background-color: #e3f5fd;">車型</th>
                                                <th style="background-color: #e3f5fd;">車號</th>
                                                <th style="background-color: #e3f5fd;">起租/迄租</th>
                                                <th style="background-color: #e3f5fd;">起租日</th>
                                                <th style="background-color: #e3f5fd;">迄租日</th>
                                                <th style="background-color: #e3f5fd;">實際取車日</th>
                                                <th style="background-color: #e3f5fd;">實際還車日</th>
                                                <th style="background-color: #e3f5fd;">月租金</th>
                                                <th style="background-color: #e3f5fd;">里程費率元/KM</th>
                                                <th style="background-color: #e3f5fd;">預收里程KM/月</th>
                                                <th style="background-color: #e3f5fd;">預收月數</th>
                                                <th style="background-color: #e3f5fd;">實際使用里程(km)</th>
                                                <th style="background-color: #e3f5fd;">超額里程(km)</th>
                                                <th style="background-color: #e3f5fd;">預收月租金總額</th>
                                                <th style="background-color: #e3f5fd;">預收里程租金</th>
                                                <th style="background-color: #e3f5fd;">逾期租金</th>
                                                <th style="background-color: #e3f5fd;">車損</th>
                                                {{--<th style="background-color: #e3f5fd;">營業損失</th>--}}
                                                <th style="background-color: #e3f5fd;">油費</th>
                                                <th style="background-color: #e3f5fd;">服務費</th>
                                                <th style="background-color: #e3f5fd;">ETAG</th>
                                                <th style="background-color: #e3f5fd;">其他項目</th>
                                                <th style="background-color: #e3f5fd;">%</th>
                                                <th style="background-color: #e3f5fd;">車源商應收租金(J)</th>
                                                <th style="background-color: #e3f5fd;">車源商應收代墊款(K)</th>
                                                <th style="background-color: #fde9e9;">合計</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $start_total=0;
                                            @endphp
                                            @if($start_carplus_commission_ords)
                                                @foreach($start_carplus_commission_ords as $key=>$ord)
                                                    @php
                                                        $rate=0;
                                                        $partner=$ord->partner;
                                                        if($partner){
                                                            $partner_name=$partner->title;
                                                            $dealer=$partner->dealer;
                                                            if($dealer)
                                                                $rate=$dealer->rate_carplus_commission;
                                                        }

                                                        $basic_fees=$ord->basic_fee * $ord->rent_month; //預收月租金總額

                                                        $mile_months=$ord->mile_pre_month * $ord->rent_month;
                                                        $mile_fee=$ord->mile_fee; //里程費率Km/元
                                                        $mile_fee_total=$mile_months*$mile_fee; //預收里程租金
                                                        //預收月租金總額=(預收月租金總額+里程租金)*0.84
                                                        $partner_rent_total=($basic_fees+$mile_fee_total) * $rate;
                                                        $start_total+=$partner_rent_total;
                                                    @endphp
                                                    @if($partner)
                                                        <tr>
                                                            <td>{{$key+1}}</td> {{--No.--}}
                                                            <td>{{$search_start_date}}<br>~{{$search_end_date}}</td> {{--對帳區間--}}
                                                            <td>{{$ord->order_from==1?'格上':'Sealand'}}</td> {{--經銷商--}}
                                                            <td>{{$partner_name}}</td> {{--經銷商--}}
                                                            <td>{{$ord->ord_no}}</td> {{--訂單編號--}}
                                                            <td>{{substr($ord->paid2_date,0,10)}}</td> {{--付款日期--}}
                                                            <td>{{$ord->brandcat_name}}</td> {{--品牌--}}
                                                            <td>{{$ord->brandin_name}}</td> {{--車型--}}
                                                            <td>{{$ord->plate_no}}</td> {{--車號--}}
                                                            <td>起租</td> {{--起租/迄租--}}
                                                            <td>{{ $ord->sub_date }}</td> {{--起租日--}}
                                                            <td>{{$ord->expiry_date}}</td> {{--迄租日--}}
                                                            <td>{{$ord->real_sub_date}}</td> {{--實際取車日--}}
                                                            <td></td> {{--實際還車日--}}
                                                            <td>{{ number_format($ord->basic_fee) }}</td> {{--月租金--}}
                                                            <td>{{ $ord->mile_fee }}</td> {{--里程費率元/KM--}}
                                                            <td>{{ number_format($ord->mile_pre_month) }}</td> {{--預收里程KM/月--}}
                                                            <td>{{$ord->rent_month}}</td> {{--預收月數--}}
                                                            <td></td> {{--實際使用里程(km)--}}
                                                            <td></td> {{--超額里程(km)--}}
                                                            <td>{{ number_format($basic_fees) }}</td> {{--預收月租金總額--}}
                                                            <td>{{ number_format($mile_fee_total) }}</td> {{--里程租金--}}
                                                            <td></td> {{--逾期租金--}}
                                                            <td></td> {{--車損--}}
                                                            {{--<td></td> --}}{{--營業損失--}}
                                                            <td></td> {{--油費--}}
                                                            <td></td> {{--服務費--}}
                                                            <td></td> {{--E-tag--}}
                                                            <td></td> {{--其他項目--}}
                                                            <td>{{$rate*100}} %</td>
                                                            <td>{{number_format($partner_rent_total)}}</td> {{--車源商應收租金(J)--}}
                                                            <td></td> {{--車源商應收代墊款(K)--}}
                                                            <td style="background-color: #ecfde9;">{{number_format($partner_rent_total)}}</td> {{--合計--}}
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="29">&nbsp;</td>
                                                <td style="text-align: right;" colspan="2">總計：</td>
                                                <td style="color: purple;font-weight: bold;font-size: 20px;background-color: #ecfde9;">{{number_format($start_total)}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                    <div>&nbsp;</div>
                                </div>

                            </div>
                            <hr>
                            <table>
                                <tr>
                                    <th style="padding: 10px 20px;font-size: 20px;font-weight: bold;">2. 迄租繳付 報表</th>
                                </tr>
                                <tr>
                                    <th style="padding-left: 30px;padding-right: 10px;font-size: 16px;">
                                        <span style="display: inline-block;padding-left: 10px">總資料筆數：{{$end_ords?$end_ords->count():0}} 筆</span>
                                    </th>
                                </tr>
                            </table>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="background-color: #fde3e3;">No.</th>
                                            <th style="background-color: #fde3e3;">對帳區間</th>
                                            <th style="background-color: #fde3e3;">網站來源</th>
                                            <th style="background-color: #fde3e3;">經銷商</th>
                                            <th style="background-color: #fde3e3;">訂單編號</th>
                                            <th style="background-color: #fde3e3;">付款日期</th>
                                            <th style="background-color: #fde3e3;">品牌</th>
                                            <th style="background-color: #fde3e3;">車型</th>
                                            <th style="background-color: #fde3e3;">車號</th>
                                            <th style="background-color: #fde3e3;">起租/迄租</th>
                                            <th style="background-color: #fde3e3;">起租日</th>
                                            <th style="background-color: #fde3e3;">迄租日</th>
                                            <th style="background-color: #fde3e3;">實際取車日</th>
                                            <th style="background-color: #fde3e3;">實際還車日</th>
                                            <th style="background-color: #fde3e3;">月租金</th>
                                            <th style="background-color: #fde3e3;">里程費率元/KM</th>
                                            <th style="background-color: #fde3e3;">預收里程KM/月</th>
                                            <th style="background-color: #fde3e3;">預收月數</th>
                                            <th style="background-color: #fde3e3;">實際使用里程(km)</th>
                                            <th style="background-color: #fde3e3;">超額里程(km)</th>
                                            <th style="background-color: #fde3e3;">預收月租金總額</th>
                                            <th style="background-color: #fde3e3;">預收里程租金</th>
                                            <th style="background-color: #fde3e3;">超額里程租金</th>
                                            <th style="background-color: #fde3e3;">逾期租金</th>
                                            <th style="background-color: #fde3e3;">%</th>
                                            <th style="background-color: #fde3e3;">車源商應收租金(J)</th>
                                            <th style="background-color: #fde3e3;">車損</th>
                                            <th style="background-color: #fde3e3;">油費</th>
                                            <th style="background-color: #fde3e3;">服務費</th>
                                            <th style="background-color: #fde3e3;">ETAG</th>
                                            <th style="background-color: #fde3e3;">其他項目</th>
                                            <th style="background-color: #fde3e3;">%</th>
                                            <th style="background-color: #fde3e3;">車源商應收代墊款(K)</th>
                                            <th style="background-color: #fde9e9;">合計</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $end_total=0;
                                        @endphp
                                        @if($end_ords)
                                            @foreach($end_ords as $key=>$ord)
                                                @php
                                                    $rate=0;
                                                    $partner=$ord->partner;
                                                    if($partner){
                                                        $partner_name=$partner->title;
                                                        $dealer=$partner->dealer;
                                                        if($dealer){
                                                            if($ord->order_from==1)
                                                                $rate=$dealer->rate_carplus;
                                                            else
                                                                $rate=$dealer->rate_sealand;
                                                        }
                                                    }

                                                    $basic_fees=$ord->basic_fee * $ord->rent_month; //預收月租金總額

                                                    $mile_months=$ord->mile_pre_month * $ord->rent_month;
                                                    $mile_fee=$ord->mile_fee; //里程費率Km/元
                                                    //實際使用里程(km)
                                                    $use_mile=$ord->back_milage-$ord->milage;
                                                    //超額里程(km)
                                                    $rent_month= $ord->rent_month;
                                                    if(!$rent_month)
                                                        $rent_month=3;
                                                    $over_user_mile=$use_mile - ($rent_month * 1000);

                                                    //預收里程租金
                                                    $mile_fee_total=$mile_months*$mile_fee; //預收里程租金
                                                    //里程租金
                                                    $mile_rent_fee=$over_user_mile * $ord->mile_fee;

                                                    //車源商應收租金
                                                    //$partner_rent_total=round(($mile_fee_total+$mile_rent_fee)*0.84);
                                                    $partner_rent_total=round( $mile_rent_fee * $rate );

                                                    //預收月租金總額=(預收月租金總額+里程租金)*0.84
                                                    $delay_fee=$ord->delay_fee; //逾時租金
                                                    $damage_fee=$ord->damage_fee; //車損費用
                                                    $business_loss=$ord->business_loss; //營業損失
                                                    $fuel_cost=$ord->fuel_cost; //油費
                                                    $service_charge=$ord->service_charge; //牽送車服務費
                                                    $e_tag=$ord->e_tag; //e-tag 金額
                                                    $other_fee_total=$e_tag + $damage_fee + $business_loss + $delay_fee + $fuel_cost + $service_charge;

                                                    //車源商應收代墊款
                                                    $collection_subtotal=round($other_fee_total) * 0.97; //代收費用總計(G)
                                                    $end_subtotal=$partner_rent_total+$collection_subtotal;
                                                    $end_total+=$end_subtotal;

                                                @endphp
                                                @if($partner)
                                                    <tr>
                                                        <td>{{$key+1}}</td> {{--No.--}}
                                                        <td>{{$search_start_date}}<br>~{{$search_end_date}}</td> {{--對帳區間--}}
                                                        <td>{{$ord->order_from==1?'格上':'Sealand'}}</td> {{--經銷商--}}
                                                        <td>{{$partner_name}}</td> {{--經銷商--}}
                                                        <td>{{$ord->ord_no}}</td> {{--訂單編號--}}
                                                        <td>{{substr($ord->paid2_date,0,10)}}</td> {{--付款日期--}}
                                                        <td>{{$ord->brandcat_name}}</td> {{--品牌--}}
                                                        <td>{{$ord->brandin_name}}</td> {{--車型--}}
                                                        <td>{{$ord->plate_no}}</td> {{--車號--}}
                                                        <td>迄租</td> {{--起租/迄租--}}
                                                        <td>{{ $ord->sub_date }}</td> {{--起租日--}}
                                                        <td>{{$ord->expiry_date}}</td> {{--迄租日--}}
                                                        <td>{{$ord->real_sub_date}}</td> {{--實際取車日--}}
                                                        <td>{{$ord->real_back_date}}</td> {{--實際還車日--}}
                                                        <td>{{ number_format($ord->basic_fee) }}</td> {{--月租金--}}
                                                        <td>{{ $ord->mile_fee }}</td> {{--里程費率元/KM--}}
                                                        <td>{{ number_format($ord->mile_pre_month) }}</td> {{--預收里程KM/月--}}
                                                        <td>{{$ord->rent_month}}</td> {{--預收月數--}}
                                                        <td>{{number_format($use_mile)}}</td> {{--實際使用里程(km)--}}
                                                        <td>{{number_format($over_user_mile)}}</td> {{--超額里程(km)--}}
                                                        <td></td> {{--預收月租金總額--}}
                                                        <td>{{ number_format($mile_fee_total) }}</td> {{--預收里程租金--}}
                                                        <td>{{ number_format($mile_rent_fee) }}</td> {{--超額里程租金--}}
                                                        <td>{{ number_format($ord->delay_fee) }}</td> {{--逾期租金--}}
                                                        <td>{{$rate*100}} %</td> {{--%--}}
                                                        <td>{{number_format($partner_rent_total)}}</td> {{--車源商應收租金(J)--}}
                                                        <td>{{ number_format($ord->damage_fee) }}</td> {{--車損--}}
                                                        {{--<td></td> --}}{{--營業損失--}}
                                                        <td>{{ number_format($ord->fuel_cost) }}</td> {{--油費--}}
                                                        <td>{{ number_format($ord->service_charge) }}</td> {{--服務費--}}
                                                        <td>{{ number_format($ord->e_tag) }}</td> {{--E-tag--}}
                                                        <td>{{ number_format($ord->business_loss) }}</td> {{--其他項目--}}
                                                        <td>97 %</td>
                                                        <td>{{number_format($collection_subtotal)}}</td> {{--車源商應收代墊款(K)--}}
                                                        <td style="background-color: #ecfde9;">{{number_format($end_subtotal)}}</td> {{--合計--}}
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                        <tr>
                                            <td colspan="31">&nbsp;</td>
                                            <td style="text-align: right;" colspan="2">總計：</td>
                                            <td style="color: purple;font-weight: bold;font-size: 20px;background-color: #ecfde9;">{{number_format($end_total)}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    @if($search_dealer_id!=1 && $end_carplus_commission_ords->count()>0)
                                        <h5>格上網站非格上車輛傭金</h5>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th style="background-color: #fde3e3;">No.</th>
                                                <th style="background-color: #fde3e3;">對帳區間</th>
                                                <th style="background-color: #fde3e3;">網站來源</th>
                                                <th style="background-color: #fde3e3;">經銷商</th>
                                                <th style="background-color: #fde3e3;">訂單編號</th>
                                                <th style="background-color: #fde3e3;">付款日期</th>
                                                <th style="background-color: #fde3e3;">品牌</th>
                                                <th style="background-color: #fde3e3;">車型</th>
                                                <th style="background-color: #fde3e3;">車號</th>
                                                <th style="background-color: #fde3e3;">起租/迄租</th>
                                                <th style="background-color: #fde3e3;">起租日</th>
                                                <th style="background-color: #fde3e3;">迄租日</th>
                                                <th style="background-color: #fde3e3;">實際取車日</th>
                                                <th style="background-color: #fde3e3;">實際還車日</th>
                                                <th style="background-color: #fde3e3;">月租金</th>
                                                <th style="background-color: #fde3e3;">里程費率元/KM</th>
                                                <th style="background-color: #fde3e3;">預收里程KM/月</th>
                                                <th style="background-color: #fde3e3;">預收月數</th>
                                                <th style="background-color: #fde3e3;">實際使用里程(km)</th>
                                                <th style="background-color: #fde3e3;">超額里程(km)</th>
                                                <th style="background-color: #fde3e3;">預收月租金總額</th>
                                                <th style="background-color: #fde3e3;">預收里程租金</th>
                                                <th style="background-color: #fde3e3;">里程租金</th>
                                                <th style="background-color: #fde3e3;">逾期租金</th>
                                                <th style="background-color: #fde3e3;">車損</th>
                                                {{--<th style="background-color: #fde3e3;">營業損失</th>--}}
                                                <th style="background-color: #fde3e3;">油費</th>
                                                <th style="background-color: #fde3e3;">服務費</th>
                                                <th style="background-color: #fde3e3;">ETAG</th>
                                                <th style="background-color: #fde3e3;">其他項目</th>
                                                <th style="background-color: #fde3e3;">%</th>
                                                <th style="background-color: #fde3e3;">車源商應收租金(J)</th>
                                                <th style="background-color: #fde3e3;">車源商應收代墊款(K)</th>
                                                <th style="background-color: #fde9e9;">合計</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $end_total=0;
                                            @endphp
                                            @if($end_ords)
                                                @foreach($end_carplus_commission_ords as $key=>$ord)
                                                    @php
                                                        $rate=0;
                                                        $partner=$ord->partner;
                                                        if($partner){
                                                            $partner_name=$partner->title;
                                                            $dealer=$partner->dealer;
                                                            if($dealer)
                                                                $rate=$dealer->rate_carplus_commission;
                                                        }

                                                        $basic_fees=$ord->basic_fee * $ord->rent_month; //預收月租金總額

                                                        $mile_months=$ord->mile_pre_month * $ord->rent_month;
                                                        $mile_fee=$ord->mile_fee; //里程費率Km/元
                                                        //實際使用里程(km)
                                                        $use_mile=$ord->back_milage-$ord->milage;
                                                        //超額里程(km)
                                                        $rent_month= $ord->rent_month;
                                                        if(!$rent_month)
                                                            $rent_month=3;
                                                        $over_user_mile=$use_mile - ($rent_month * 1000);

                                                        //預收里程租金
                                                        $mile_fee_total=$mile_months*$mile_fee; //預收里程租金
                                                        //里程租金
                                                        $mile_rent_fee=$over_user_mile * $ord->mile_fee;

                                                        //車源商應收租金
                                                        //$partner_rent_total=round(($mile_fee_total+$mile_rent_fee)*0.84);
                                                        $partner_rent_total=round( $mile_rent_fee * $rate );

                                                        //預收月租金總額=(預收月租金總額+里程租金)*0.84
                                                        $delay_fee=$ord->delay_fee; //逾時租金
                                                        $damage_fee=$ord->damage_fee; //車損費用
                                                        $business_loss=$ord->business_loss; //營業損失
                                                        $fuel_cost=$ord->fuel_cost; //油費
                                                        $service_charge=$ord->service_charge; //牽送車服務費
                                                        $e_tag=$ord->e_tag; //e-tag 金額
                                                        $other_fee_total=$e_tag + $damage_fee + $business_loss + $delay_fee + $fuel_cost + $service_charge;

                                                        //車源商應收代墊款
                                                        $collection_subtotal=round($other_fee_total); //代收費用總計(G)
                                                        $end_subtotal=$partner_rent_total+$collection_subtotal;
                                                        $end_total+=$end_subtotal;

                                                    @endphp
                                                    @if($partner)
                                                        <tr>
                                                            <td>{{$key+1}}</td> {{--No.--}}
                                                            <td>{{$search_start_date}}<br>~{{$search_end_date}}</td> {{--對帳區間--}}
                                                            <td>{{$ord->order_from==1?'格上':'Sealand'}}</td> {{--經銷商--}}
                                                            <td>{{$partner_name}}</td> {{--經銷商--}}
                                                            <td>{{$ord->ord_no}}</td> {{--訂單編號--}}
                                                            <td>{{substr($ord->paid2_date,0,10)}}</td> {{--付款日期--}}
                                                            <td>{{$ord->brandcat_name}}</td> {{--品牌--}}
                                                            <td>{{$ord->brandin_name}}</td> {{--車型--}}
                                                            <td>{{$ord->plate_no}}</td> {{--車號--}}
                                                            <td>迄租</td> {{--起租/迄租--}}
                                                            <td>{{ $ord->sub_date }}</td> {{--起租日--}}
                                                            <td>{{$ord->expiry_date}}</td> {{--迄租日--}}
                                                            <td>{{$ord->real_sub_date}}</td> {{--實際取車日--}}
                                                            <td>{{$ord->real_back_date}}</td> {{--實際還車日--}}
                                                            <td>{{ number_format($ord->basic_fee) }}</td> {{--月租金--}}
                                                            <td>{{ $ord->mile_fee }}</td> {{--里程費率元/KM--}}
                                                            <td>{{ number_format($ord->mile_pre_month) }}</td> {{--預收里程KM/月--}}
                                                            <td>{{$ord->rent_month}}</td> {{--預收月數--}}
                                                            <td>{{number_format($use_mile)}}</td> {{--實際使用里程(km)--}}
                                                            <td>{{number_format($over_user_mile)}}</td> {{--超額里程(km)--}}
                                                            <td></td> {{--預收月租金總額--}}
                                                            <td>{{ number_format($mile_fee_total) }}</td> {{--預收里程租金--}}
                                                            <td>{{ number_format($mile_rent_fee) }}</td> {{--里程租金--}}
                                                            <td>{{ number_format($ord->delay_fee) }}</td> {{--逾期租金--}}
                                                            <td>{{ number_format($ord->damage_fee) }}</td> {{--車損--}}
                                                            {{--<td></td> --}}{{--營業損失--}}
                                                            <td>{{ number_format($ord->fuel_cost) }}</td> {{--油費--}}
                                                            <td>{{ number_format($ord->service_charge) }}</td> {{--服務費--}}
                                                            <td>{{ number_format($ord->e_tag) }}</td> {{--E-tag--}}
                                                            <td>{{ number_format($ord->business_loss) }}</td> {{--其他項目--}}
                                                            <td>{{$rate*100}} %</td>
                                                            <td>{{number_format($partner_rent_total)}}</td> {{--車源商應收租金(J)--}}
                                                            <td>{{number_format($collection_subtotal)}}</td> {{--車源商應收代墊款(K)--}}
                                                            <td style="background-color: #ecfde9;">{{number_format($end_subtotal)}}</td> {{--合計--}}
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <tr>
                                                <td colspan="30">&nbsp;</td>
                                                <td style="text-align: right;" colspan="2">總計：</td>
                                                <td style="color: purple;font-weight: bold;font-size: 20px;background-color: #ecfde9;">{{number_format($end_total)}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @endif
                                    <div>&nbsp;</div>
                                </div>

                            </div>
                        @endif
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                        <div>&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section('extra-js')
    <script>window.jQuery || document.write('<script src="/back_assets/src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
    <script src="/back_assets/plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="/back_assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="/back_assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="/back_assets/plugins/select2/dist/js/select2.min.js"></script>
    <script src="/back_assets/plugins/summernote/dist/summernote-bs4.min.js"></script>
    <script src="/back_assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="/back_assets/plugins/jquery.repeater/jquery.repeater.min.js"></script>
    <script src="/back_assets/plugins/mohithg-switchery/dist/switchery.min.js"></script>
    <script src="/back_assets/dist/js/theme.min.js"></script>
    {{--    <script src="/back_assets/js/form-advanced.js"></script>--}}

    <script src="/js/jquery-ui.min.js" type="text/javascript"></script>
    <script>
        var availableDates = {!! getShowDateString() !!};
        $(function()
        {
            $('.datePicker').datepicker({
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
                changeMonth: true, changeYear: false});
        });


    </script>

@stop