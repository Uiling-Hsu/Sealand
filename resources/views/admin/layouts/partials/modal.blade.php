@if (session()->has('modal_success_message') || session()->has('modal_failure_message'))
    <div class="modal fade" id="demoModal" tabindex="-1" role="dialog" aria-labelledby="demoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demoModalLabel">系統訊息：</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body" style="font-size: 16px">
                    @if(session()->has('modal_success_message'))
                        <span style="color: green">{{ session()->get('modal_success_message') }}</span>
                    @else
                        <span style="color: red">{{ session()->get('modal_failure_message') }}</span>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function(){
            $('.modal').modal();
        })();
    </script>
@endif