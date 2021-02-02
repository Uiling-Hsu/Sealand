@if (session()->has('success_message') || session()->has('status') ||
     session()->has('failure_message') || session()->has('email') || session()->has('error_message') || count($errors) > 0)
    <style>
        .msg .alert-success, .msg .alert-danger{
            -webkit-border-radius: 30px;
            -moz-border-radius: 30px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 18px;
        }
        .msg .alert-success{
            border: solid 1px #186702;
            background-color: #fff;
            -webkit-border-radius: 30px;
            -moz-border-radius: 30px;
            border-radius: 30px;
            color:#186702;
            font-weight: 400;
        }
        .msg .alert-danger{
            background-color: white;
            border: solid 1px #bb0000;
            color: #bb0000;
            font-weight: 400;
        }
    </style>
    <div class="msg">
        <div class="container">
            @if (session()->has('success_message') || session()->has('status') )
                <div class="alert alert-success" role="alert">
                    {{ session()->get('success_message') }} {{session()->get('status')}}
                </div>
            @elseif(session()->has('failure_message') || session()->has('email') || session()->has('error_message'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('failure_message') }} {{ session()->get('email') }} {{ session()->get('error_message') }}
                </div>
            @endif
        </div>

        {{--@if(count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif--}}
    </div>

    <script>
        (function(){
            //$('div.msg').delay(20000).slideUp(300);
        })();
    </script>
    @php
        session()->forget('success_message');
        session()->forget('status');
        session()->forget('failure_message');
        session()->forget('email');
    @endphp
@endif
