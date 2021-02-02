@extends('frontend_carplus.layouts.app')

@section('extra-css')
    <style>
        .btn-secondary, .btn-secondary:active, .btn-secondary.active {
            background-color: #f1901c !important;
            border-color: #f1901c !important;
            color: #ffffff !important;
        }
        .btn-secondary:hover, .btn-secondary:focus, .btn-secondary.focus {
            color: #ffffff !important;
            background-color: #f1901c !important;
            border-color: #f1901c !important;
        }
        .mbr-section-btn a.btn:not(.btn-form):hover, .mbr-section-btn a.btn:not(.btn-form):focus {
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
        }
        .btn-secondary-outline:hover, .btn-secondary-outline:focus, .btn-secondary-outline.focus {
            color: #ffffff;
            background-color: #f1901c;
            border-color: #f1901c;
        }
    </style>
@stop

@section('content')
    <section class="extFeatures cid-s12THEJrXk" id="extFeatures21-4" style="background-image: url(/assets/images/flow_bg.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <h2 class="mbr-section-title pb-2 mbr-bold mbr-fonts-style align-left display-1">訂閱流程<br><br></h2>
                </div>
            </div>
            <section class="extAccordion cid-s93fxRVX62" id="extAccordion2-1z" style="padding-top: 0">
                <div class="container" style="padding-right: 0;padding-left: 0">
                    <div class="row justify-content-center mbr-section-btn align-center pt-3" style="text-align: center;">
                        <a href="/about_1" class="btn btn-md btn-secondary disp-9">訂閱流程</a>
                        <a href="/about_2" class="btn btn-md btn-secondary-outline disp-9">訂閱須知</a>
                    </div>
                    <div>&nbsp;</div>
                    <div>&nbsp;</div>
                    @for($i=1;$i<=7;$i++)
                        <div class="row justify-content-center pt-4">
                            <div class="col-md-10 col-lg-8 content-block">
                                <img src="/assets/images/訂閱流程/訂閱流程_0{{$i}}.jpg" alt="" style="width: 100%">
                            </div>
                        </div>
                    @endfor
                </div>
            </section>
        </div>
    </section>

@endsection

@section('extra-js')

@endsection