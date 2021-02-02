<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{setting('store_name')}} 後台管理系統--重設密碼</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="/back_assets/favicon.ico" type="image/x-icon" />

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="/back_assets/plugins/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/ionicons/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/icon-kit/dist/css/iconkit.min.css">
    <link rel="stylesheet" href="/back_assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="/back_assets/dist/css/theme.min.css">
    <link rel="stylesheet" href="/back_assets/css/custom.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/back_assets/src/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div class="auth-wrapper">
    <div class="container-fluid h-100">
        @include('admin.layouts.partials.message')
        <div class="row flex-row h-100 bg-white">
            <div class="col-xl-8 col-lg-6 col-md-5 p-0 d-md-block d-lg-block d-sm-none d-none">
                <div class="lavalite-bg" style="background-image: url('/back_assets/img/auth/login-bg.jpg')">
                    <div class="lavalite-overlay"></div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                <div class="authentication-form mx-auto">
                    <div class="logo-centered">
                        <a href="/"><img src="/back_assets/src/img/brand.svg" alt=""></a>
                    </div>
                    <h3>密碼重設</h3>
                    <p>請輸入帳號及新密碼： </p>
                    <form action="{{ route('admin.password.request') }}" id="form" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email 帳號" required autofocus>
                            <i class="ik ik-user"></i>
                            @if ($errors->has('email'))
                                <div>
                                    <span class="help-block" style="color: white">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" id="password" class="form-control" name="password" placeholder="密碼顯示強度狀態必需為綠色字的 強 或 非常強" data-indicator="pwindicator" minlength="8" required>
                            <i class="ik ik-eye" onclick="myFunction()"></i>
                            <div id="pwindicator" style="padding: 0 10px 0 20px">
                                <div class="bar" style=""></div>
                                <div class="label" id="pw_label"></div>
                            </div>
                            @if ($errors->has('password'))
                                <strong>{{ $errors->first('password') }}</strong>
                            @endif
                        </div>
                        <div class="form-group">
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="新確試密碼" required autofocus>
                            <i class="ik ik-lock"></i>
                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col text-left">
                                <button class="btn btn-success float-right" type="submit">重設</button>
                                {{--<label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="item_checkbox" name="item_checkbox" value="option1">
                                    <span class="custom-control-label">&nbsp;記住我</span>
                                </label>--}}
                            </div>
                        </div>
                    </form>
                    <div class="register">
                        <p><a href="/admin/register">我要註冊新帳號</a></p>
                        <p><a href="/admin/login">我要登入</a></p>
                        <p><a href="/admin/resent">重寄帳號啟用信</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script>window.jQuery || document.write('<script src="/back_assets/src/js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
<script src="/back_assets/plugins/popper.js/dist/umd/popper.min.js"></script>
<script src="/back_assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/back_assets/plugins/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
<script src="/back_assets/plugins/screenfull/dist/screenfull.js"></script>
{{--<script src="/back_assets/dist/js/theme.js"></script>--}}
<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
{{--<script>--}}
{{--    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=--}}
{{--        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;--}}
{{--        e=o.createElement(i);r=o.getElementsByTagName(i)[0];--}}
{{--        e.src='https://www.google-analytics.com/analytics.js';--}}
{{--        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));--}}
{{--    ga('create','UA-XXXXX-X','auto');ga('send','pageview');--}}
{{--</script>--}}
<script src="/js/jquery.pwstrength.js"></script>
<script type="text/javascript">
    $(function () {
        //啟用密碼強度指示器，並變更說明文字
        $("input[name='password']").pwstrength({ texts: ['很弱', '弱', '中等', '強', '非常強'] });
    });
</script>
<script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
@include('admin.layouts.partials.modal')
</body>
</html>
