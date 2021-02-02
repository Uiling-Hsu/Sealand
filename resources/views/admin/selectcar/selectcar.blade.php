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
                                <h5 style="margin-bottom: 5px;position:relative;top:10px">選擇車輛</h5>
                                {{--                                <span>各項參數選擇車輛</span>--}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <nav class="breadcrumb-container" aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/admin"><i class="ik ik-home"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">選擇車輛</a></li>
                                {{--                                <li class="breadcrumb-item active" aria-current="page">Components</li>--}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div style="max-width: 600px;padding: 30px">
                            <h5>
                                方案類別：
                                @if($subscriber->cate)
                                    @php
                                      $cate=$subscriber->cate;
                                    @endphp
                                    <span style="font-size: 20px;color: purple">{{$cate->title}}</span>&nbsp;&nbsp;&nbsp;
                                    <span style="color: purple">{{number_format($cate->basic_fee) }} 元</span>&nbsp;&nbsp;&nbsp;
                                    <span style="color: purple">{{number_format($cate->mile_fee,2) }} 元/每公里</span>
                                @endif
                            </h5>
                            <div>&nbsp;</div>
                            <h5>交車區域：{{$subscriber->proarea?$subscriber->proarea->title:''}}</h5>
                            <div>&nbsp;</div>
                            <h5>預計交車日期：{{$subscriber->sub_date}}</h5>
                            <hr>
                            <h5>品牌、車型</h5>
                            <div>&nbsp;</div>
                            <table class="table table-striped table-bordered">
                                <thead style="background-color: #d6d6d6;">
                                <tr>
                                    <td>品牌</td>
                                    <td>車型</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($subcars as $subcar)
                                    @php
                                        $brandcat=$subcar->brandcat;
                                        $brandin=$subcar->brandin;
                                    @endphp
                                    @if($brandcat && $brandin)
                                        <tr>
                                            <td>{{$brandcat->title}}</td>
                                            <td>{{$brandin->title}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                            {{--<div>&nbsp;</div>
                            <div style="max-width: 100px">
                                <a href="/admin/subscriber/{{$subscriber->id}}/edit" class="btn btn-primary">取消選取，返回車輛訂閱頁面</a>
                            </div>--}}
                        </div>
                        <hr>
                        <a name="list"></a>
                        <div class="">
                            <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                <span style="display: inline-block;padding-left: 10px">車輛 查詢及列表</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    {!! Form::open(['url' => '/admin/selectcar/'.$subscriber->id.'#list','name'=>'form_search','method'=>'GET'])  !!}
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="search_partner_id">經銷商</label>
                                            {!! Form::select('search_partner_id', $list_partners , $search_partner_id ,['id'=>'partner','class'=>'form-control','style'=>'font-size:15px','onchange'=>'document.location.href="?search_partner_id="+this.value+"#list";']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_brandcat_id">品牌 (請先選擇方案類別)</label>
                                            {!! Form::select('search_brandcat_id', $list_brandcats , $search_brandcat_id ,['id'=>'brandcat','class'=>'form-control','style'=>'font-size:15px','onchange'=>'document.location.href="?search_partner_id="+document.getElementById("partner").value+"&search_brandcat_id="+this.value+"#list";']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_brandin_id">車型</label>
                                            {!! Form::select('search_brandin_id', $list_brandins , $search_brandin_id ,['id'=>'brandin','class'=>'form-control','style'=>'font-size:15px','onchange'=>'document.form_search.submit();']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_brandin_id">交車區域</label>
                                            {!! Form::select('search_proarea_id', $list_proareas , $search_proarea_id ,['id'=>'brandin','class'=>'form-control','style'=>'font-size:15px','onchange'=>'document.form_search.submit();']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_model">編號</label>
                                            {!! Form::text('search_model', $search_model ,['id'=>'model','class'=>'form-control']) !!}
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="search_plate_no">車號</label>
                                            {!! Form::text('search_plate_no', $search_plate_no ,['id'=>'model','class'=>'form-control']) !!}
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div style="height: 28px;">&nbsp;</div>
                                            <button type="submit" class="btn btn-primary">查詢</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <a href="?clear=1" class="btn btn-success">顯示全部資料</a>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div style="padding-top: 20px;padding-left: 10px;padding-right: 10px;font-size: 16px;">
                                <span style="display: inline-block;padding-left: 10px">車輛 列表: <span style="color: #AA0805">( 總資料筆數：{{$products->total()}} )</span></span>&nbsp;&nbsp;&nbsp;
                                <a href="/admin/subscriber/{{$subscriber->id}}/edit" class="btn btn-info">返回訂閱車輛管理頁面</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        {{--<th style="text-align:center;width:80px"><span style="display: inline-block">首頁顯示<br>(最多選4輛車)</span> </th>--}}
                                        <th style="text-align: center;">確定選取</th>
                                        <th style="text-align: center;">ID</th>
                                        <th>經銷商</th>
                                        <th>方案類別</th>
                                        <th>品牌、車型</th>
                                        <th>車牌、編號</th>
                                        <th>其它規格1</th>
                                        <th>其它規格2</th>
                                        {{--<th>圖片</th>--}}
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $key=>$product)
                                            @php
                                                $ord=\App\Model\Ord::where('product_id',$product->id)->where('is_cancel',0)->where('state_id','<=',10)->first();
                                            @endphp
                                            @if(!$ord)
                                                {!! Form::hidden('product_id[]',$product->id) !!}
                                                <tr @if(Request('bid')==($product->id)) {!! tableBgColor() !!} @endif>
                                                    {{--<td style="text-align:center;width: 10%">
                                                        <a name="list{{$key}}"></a>
                                                        {!! Form::checkbox('is_home_show[]', $product->id, $product->home_show==1?'checked':'' ) !!}
                                                    </td>--}}
                                                    <td style="width: 15%;text-align: center;">
                                                        @if($subscriber->product_id && $subscriber->product_id==$product->id)
                                                            (您目前已選取此車輛)
                                                        @else
                                                            <!-- Begin Form -->
                                                            {!! Form::open(['url' => '/admin/selectcar'])  !!}
                                                                {!! Form::hidden('subscriber_id',$subscriber->id) !!}
                                                                {!! Form::hidden('product_id',$product->id) !!}
                                                                <button type="submit" class="btn btn-success" onclick="return confirm('您是否確定會員要選取此車')">確定選取此車</button>
                                                            {!! Form::close() !!}
                                                            <!-- End of Form -->
                                                        @endif
                                                    </td>
                                                    <td class="id" style="width: 5%;text-align: center;">{{$product->id}}</td>
                                                    <td style="width:15%;color: purple">
                                                        {{--@if($product->partner)
                                                            <span style="color: purple;font-size: 20px;font-weight: bold;">{{$product->partner->title }}</span><br>
                                                        @endif--}}
                                                        {!! Form::select('partner_id', $list_partners , $product->partner_id ,['class'=>'form-control','style'=>'font-size:15px','id'=>'product'.$key,'required','onchange'=>'updateField'.$key.'();']) !!}
                                                        @if($product->partner2)
                                                            <br>( 原經銷據點：{{$product->partner2->title}} )
                                                        @endif
                                                        <script>
                                                            function updateField{{$key}}() {
                                                                var partner_id = $('#product{{$key}} :selected').val();
                                                                if(confirm('是否確認要變更車輛經銷商？')) {
                                                                    $.get('/admin/update_product_table_field', {
                                                                        "db": 'products',
                                                                        "id": '{{$product->id}}',
                                                                        "field": 'partner_id',
                                                                        "value": partner_id
                                                                    });
                                                                }
                                                                else{
                                                                    $('#product{{$key}}').val({{$product->partner_id}});
                                                                }
                                                            }
                                                        </script>

                                                    </td>
                                                    <td style="width:15%">
                                                        @if($product->cate)
                                                            <span style="font-size: 20px;color: purple">{{$product->cate->title}}</span><br>
                                                            <span style="color: purple">{{number_format($product->cate->basic_fee) }} 元</span><br>
                                                            <span style="color: purple">{{number_format($product->cate->mile_fee,2) }} 元/每公里</span><br>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span style="color: black;font-weight: 300;">品牌:</span><span style="font-weight: bold;"> {{$product->brandcat?$product->brandcat->title:'' }}</span><br>
                                                        <span style="color: black;font-weight: 300;">車型:</span><span style="font-weight: bold;"> {{$product->brandin?$product->brandin->title:''}}</span>
                                                    </td>
                                                    <td style="width:15%;color: purple">
                                                        <div>車輛ID：{{$product->id}}</div>
                                                        <span style="font-size: 20px;">車號：{{$product->plate_no}}</span>
                                                        <hr>
                                                        編號：{{$product->model}}
                                                    </td>
                                                    <td style="width:15%;color: purple;text-align: left;">
                                                        <span style="color: black;font-weight: 300;">排氣量:</span><span style="font-weight: bold;"> {{ number_format($product->displacement) }}</span><br>
                                                        <span style="color: black;font-weight: 300;">年份:</span><span style="font-weight: bold;"> {{ $product->year }}</span><br>
                                                        <span style="color: black;font-weight: 300;">排檔:</span><span style="font-weight: bold;"> {{$product->progeartype?$product->progeartype->title:''}}</span><br>
                                                    </td>
                                                    <td style="width:15%;color: purple;text-align: left;">
                                                        <span style="color: black;font-weight: 300;">座位數:</span><span style="font-weight: bold;"> {{$product->seatnum}}</span><br>
                                                        <span style="color: black;font-weight: 300;">顏色:</span><span style="font-weight: bold;"> {{$product->procolor?$product->procolor->title:''}}</span><br>
                                                        <span style="color: black;font-weight: 300;">里程數:</span><span style="font-weight: bold;"> {{ number_format($product->milage) }}</span><br>
                                                        <span style="color: black;font-weight: 300;">交車區域:</span><span style="font-weight: bold;"> {{$product->proarea?$product->proarea->title:''}}</span><br>
                                                    </td>

                                                </tr>
                                            @endif
                                        @endforeach
                                        {{--@if($products && $products->count())
                                            <tr>
                                                <td class="text-center">{!! Form::submit('首頁顯示設定',['class'=>'btn btn-primary','onclick'=>'return confirm("是否確定要首頁顯示設定?")']) !!}</td>
                                            </tr>
                                            --}}{{--return confirm("是否確定要批次刪除？");--}}{{--
                                        @endif--}}
                                    </tbody>
                                </table>
                                <div>&nbsp;</div>
                                <div class="col-md-12">
                                    {{ $products->appends(Request::except('page'))->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            </div>

                        </div>
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
    <script src="/back_assets/js/drable.js"></script>
    <script>
        document.addEventListener('drop', function(event) {
            var id = document.querySelectorAll('.id');
            var data = [];

            for (var i = 0, len = id.length; i < len; i++) {
                data.push(id[i].innerHTML);
                id[i].parentNode.querySelector('.sort').innerHTML = paddingLeft( i+1, 2 );
            }
            $.get('/admin/ajax_sort', {"data": data,"db":'products'});
        }, false);

        var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elem.forEach(function(html) {
            var switchery = new Switchery(html, {
                color: 'green',
                jackColor: '#fff'
            });
        });

        $('#chkdelall').click(function(){
            if($("#chkdelall").prop("checked")) {
                $("input[name='is_home_show[]']").each(function() {
                    $(this).prop("checked", true);
                });
            } else {
                $("input[name='is_home_show[]']").each(function() {
                    $(this).prop("checked", false);
                });
            }
        });

        $('#chkall').click(function(){
            if($("#chkall").prop("checked")) {
                $("input[name='isread[]']").each(function() {
                    $(this).prop("checked", true);
                });
            } else {
                $("input[name='isread[]']").each(function() {
                    $(this).prop("checked", false);
                });
            }
        });

        /*$(document).on('change', '#brandcat', function(){
            var brandcat = $('#brandcat :selected').val();//注意:selected前面有個空格！
            $.ajax({
                url:"/admin/ajax_brand",
                method:"GET",
                data:{
                    brandcat:brandcat
                },
                success:function(res){
                    $('#brandin').html(res);
                }
            })//end ajax
        });*/
    </script>
@stop