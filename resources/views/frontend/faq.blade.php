@extends('frontend.layouts.app')

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
                    <h2 class="mbr-section-title pb-2 mbr-bold mbr-fonts-style align-left display-1">Q&A<br><br></h2>
                </div>
            </div>
            <section class="extAccordion cid-s93fxRVX62" id="extAccordion2-1z" style="padding-top: 0">
                <div class="container">
                    @if($list_faqcats->count()>1)
                        <div class="row justify-content-center mbr-section-btn align-center pt-3" style="text-align: center;">
                            @foreach($list_faqcats as $key=>$list_faqcat)
                                <a href="/faq/{{$list_faqcat->id}}#list" class="btn btn-md btn-secondary{{$list_faqcat->id==$faqcat_id?'':'-outline'}} disp-9">{{$list_faqcat->title_tw}}</a>
                            @endforeach
                        </div>
                        <div>&nbsp;</div>
                    @endif
                    <div class="row justify-content-center pt-4">
                        <div class="col-md-10 col-lg-8 content-block">
                            <div class="accordion-content">
                                <div id="bootstrap-accordion_28" class="panel-group accordionStyles accordion " role="tablist" aria-multiselectable="true">

                                    @if($faqins->count()>0)
                                        @foreach($faqins as $key=>$faqin)
                                            <div class="card">
                                                <div class="card-header" role="tab" id="heading{{$key}}" style="border-top-right-radius: 10px;border-top-left-radius: 10px;border-bottom-right-radius: 10px;border-bottom-left-radius: 10px;">
                                                    <a role="button" class="collapsed panel-title" data-toggle="collapse" data-core="" href="#collapse1_{{$key}}" aria-expanded="false" aria-controls="collapse1">
                                                        <h4 class="mbr-fonts-style header-text disp-9" style="line-height: 25px;">
                                                            {{$faqin->title_tw}}
                                                        </h4>
                                                        <span class="sign mbr-iconfont mbri-arrow-down inactive"></span>

                                                    </a>
                                                </div>
                                                <div id="collapse1_{{$key}}" class="panel-collapse noScroll collapse" role="tabpanel" aria-labelledby="heading{{$key}}" data-parent="#bootstrap-accordion_28">
                                                    <div class="panel-body p-4">
                                                        <p class="mbr-fonts-style panel-text mbr-text disp-10">
                                                            {!! nl2br($faqin->descript_tw) !!}
                                                        </p>
                                                        @if($faqin->image)
                                                            <p class="mbr-fonts-style panel-text mbr-text disp-10">
                                                                <img src="{{$faqin->image}}" alt="" style="width: 100%">
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </section>

@endsection

@section('extra-js')

@endsection