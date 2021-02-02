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
                <div class="container">
                    @if($list_flowcats->count()>1)
                        <div class="row justify-content-center mbr-section-btn align-center pt-3" style="text-align: center;">
                            @foreach($list_flowcats as $key=>$list_flowcat)
                                <a href="/flow/{{$list_flowcat->id}}#list" class="btn btn-md btn-secondary{{$list_flowcat->id==$flowcat_id?'':'-outline'}} disp-9">{{$list_flowcat->title}}</a>
                            @endforeach
                        </div>
                        <div>&nbsp;</div>
                    @endif
                    @if($flowins->count()>0)
                        @foreach($flowins as $key=>$flowin)
                            <div class="row justify-content-center pt-4">
                                <div class="col-md-10 col-lg-8 content-block" style="background-color: #fff;">
                                    <div style="padding: 20px;border-bottom: solid 1px #57c2df;text-align: center;font-size: 28px;color: #57c2df">
                                        {{$flowin->title}}
                                    </div>
                                    <div style="padding: 20px;font-size: 16px;color: black;line-height: 25px;">
                                        {!! nl2br($flowin->descript) !!}
                                    </div>
                                    @if($flowin->image)
                                        <img src="{{$flowin->image}}" alt="" style="width: 100%">
                                    @endif
                                    <div>&nbsp;</div>
                                </div>
                            </div>
                            <div>&nbsp;</div>
                        @endforeach
                    @endif
                </div>
            </section>

        </div>
    </section>

@endsection

@section('extra-js')

@endsection