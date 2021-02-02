@if (session()->has('success_message') || session()->has('status') || session()->has('failure_message') || session()->has('email') || session()->has('error_message') || session()->has('flash_message') || count($errors) > 0)
    <div class="msg">
        <style>
            .alert-success, .alert-danger{
                -webkit-border-radius: 30px;
                -moz-border-radius: 30px;
                border-radius: 30px;
                font-weight: bold;
                font-size: 18px;
            }
            .alert-success{
                border: solid 1px #186702;
                background-color: #fff;
                -webkit-border-radius: 30px;
                -moz-border-radius: 30px;
                border-radius: 30px;
                color:#186702;
                font-weight: 400;
            }
            .alert-danger{
                background-color: red;
                color: white;
                font-weight: bold;
            }
        </style>
        <div>&nbsp;</div>
        <div class="container">
            @if (session()->has('success_message') || session()->has('status') || session()->has('flash_message') )
                <div class="alert alert-success" role="alert">
                    {{ session()->get('success_message') }} {{session()->get('status')}} {{session()->get('flash_message')}}
                </div>
            @elseif(session()->has('failure_message') || session()->has('email'))
                <div class="alert alert-danger" role="alert">
                    {{ session()->get('failure_message') }} {{ session()->get('email') }}
                </div>
            @endif
        </div>

        {{--@if(count($errors) > 0)--}}
            {{--<div class="alert alert-danger">--}}
                {{--<ul>--}}
                    {{--@foreach ($errors->all() as $error)--}}
                        {{--<li>{{ $error }}</li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--@endif--}}
    </div>

    <script>
        (function(){
            $('div.msg').delay(10000).slideUp(300);
        })();
    </script>
@endif
