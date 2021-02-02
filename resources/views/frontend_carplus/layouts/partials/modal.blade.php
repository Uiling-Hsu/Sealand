@if (session()->has('modal_qrcode_success_message') || session()->has('modal_success_message') || session()->has('modal_status') ||
     session()->has('modal_failure_message') || session()->has('modal_email'))
    <div class="modal mbr-popup cid-s1RxdRZtfh fade" tabindex="-1" role="dialog" data-on-timer-delay="0" data-overlay-color="#000000" data-overlay-opacity="0.8" id="mbr-popup-1q" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0">
                    @php
                        $color='orange';
                        if(session()->has('modal_success_title_color'))
                            $color=session()->get('modal_success_title_color');
                        $title='系統訊息';
                        if(session()->has('modal_success_title'))
                            $title=session()->get('modal_success_title');
                    @endphp
                    <h5 class="modal-title mbr-fonts-style disp-7" style="color: {{$color}}">{{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32" fill="currentColor">
                            <path d="M31.797 0.191c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.598 0.581 0.342 1.543 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM14.472 17.515c-0.264-0.256-0.686-0.25-0.942 0.015l-13.328 13.326c-0.613 0.595 0.34 1.562 0.942 0.942l13.328-13.326c0.27-0.262 0.27-0.695 0-0.957zM1.144 0.205c-0.584-0.587-1.544 0.336-0.942 0.942l30.654 30.651c0.613 0.625 1.563-0.325 0.942-0.942z"></path>
                        </svg>
                    </button>
                </div>

                <div class="modal-body">
                    @if(session()->has('modal_qrcode_success_message'))
                        <p class="mbr-text mbr-fonts-style display-7" style="text-align: left;">
                            {!! session()->get('modal_qrcode_success_message') !!}
                        </p>
                        <p class="mbr-text mbr-fonts-style display-7" style="text-align: center;">
                            <br><img src="{{env('APP_URL')}}/assets/images/qr_code.png" style="width: 130px;border: solid 1px #eee;">
                        </p>
                    @else
                        <p class="mbr-text mbr-fonts-style display-7" style="text-align: left;">
                            {!! session()->get('modal_success_message') !!}{!! session()->get('modal_status') !!}{!! session()->get('modal_failure_message') !!}{!! session()->get('modal_email') !!}
                        </p>
                    @endif

                    <div></div>
                </div>

                <div class="modal-footer pt-0">
                    <div class="mbr-section-btn">
                        <a class="btn btn-md btn-secondary display-4" href="#" class="close" data-dismiss="modal">
                            關閉
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        session()->forget('modal_success_title_color');
        session()->forget('modal_success_title');
        session()->forget('modal_success_message');
        session()->forget('modal_status');
        session()->forget('modal_failure_message');
        session()->forget('modal_email');
    @endphp
@endif