<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{setting('store_name')}} 後台管理系統--註冊</title>
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
                        <div class="lavalite-bg" style="background-image: url('/back_assets/img/auth/register-bg.jpg')">
                            <div class="lavalite-overlay"></div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-7 my-auto p-0">
                        <div class="authentication-form mx-auto">
                            <div class="logo-centered">
                                <a href="/"><img src="/back_assets/src/img/brand.svg" alt=""></a>
                            </div>
                            <h3>歡迎加入我們!</h3>
                            <p>請輸入以下資訊，只要幾個步驟即可建立測試帳號。</p>
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('admin/saveregister') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="姓名" required autofocus>
                                    <i class="ik ik-user"></i>
                                    @if ($errors->has('email'))
                                        <strong>{{ $errors->first('name') }}</strong>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="帳號(Email)" required>
                                    <i class="ik ik-mail"></i>
                                    @if ($errors->has('email'))
                                        <strong>{{ $errors->first('email') }}</strong>
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
                                    <input id="password-confirm" type="password" class="form-control" placeholder="密碼確認" name="password_confirmation" required>
                                    <i class="ik ik-lock" id="myInput"></i>
                                    @if ($errors->has('password_confirmation'))
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-12 text-left">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="item_checkbox" name="item_checkbox" value="option1" required>
                                            <span class="custom-control-label">&nbsp;我同意 <a href="#">會員隱私權條款</a></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <button class="btn btn-theme" type="submit" onclick="var pw_label=document.getElementById('pw_label').innerHTML;if(pw_label!='強' && pw_label!='非常強'){alert('密碼長度不可少於8碼，且至少包含大、小寫、特殊符號及數字，密碼顯示強度狀態必需符合 強 或 非常強。');return false;}else return true;">註冊帳號</button>
                                </div>
                            </form>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <a href="/admin/login">我要登入</a>&nbsp;&nbsp;&nbsp;
                            <a href="{{ url('admin/password/reset') }}">忘記密碼</a>&nbsp;&nbsp;&nbsp;
                            <a href="/admin/resent">重寄帳號啟用信</a>
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
{{--        <script src="/back_assets/dist/js/theme.js"></script>--}}
        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        {{--<script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>--}}

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
