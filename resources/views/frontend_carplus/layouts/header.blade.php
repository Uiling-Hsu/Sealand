@php
    //自動取消訂閱單，車輛自動上架
    chk_subscriber_auto_cancel();

    //自動取消訂單，車輛自動上架
    chk_ord_auto_cancel();
@endphp
<style>
    .cid-s134of9sFs .navbar .dropdown-item:hover {
        padding-left: 2rem;
        background: #f39f3b !important;
    }
    .cid-s134of9sFs .nav-link:hover {
        color: #c1c1c1 !important;
    }
    .cid-s134of9sFs .dropdown-item:hover {
        color: white !important;
    }
</style>
<section class="extMenu3 menu cid-s134of9sFs" once="menu" id="extMenu10-r">
    <nav class="navbar navbar-dropdown navbar-fixed-top navbar-expand-lg" style="padding:0;margin:0">
        <div class="d-none d-lg-block" style="width: 100%;">
            <div class="mbr-section-title pb-2 mbr-bold mbr-fonts-style align-center disp-5" style="padding:0;margin:0">
                <img src="/assets/images/top_header_banner.jpg" alt="" style="width: 100%;padding:0;margin:0">
            </div>
        </div>
        <div class="d-lg-none" style="width: 100%;">
            <div class="mbr-section-title pb-2 mbr-bold mbr-fonts-style align-center disp-5" style="padding:0;margin:0">
                <img src="/assets/images/top_header_banner_xs.jpg" alt="" style="width: 100%;padding:0;margin:0">
            </div>
        </div>
        <div class="navbar-brand" style="padding-left: 10px">
            <span class="navbar-logo" style="padding: 5px 0">
                <a href="/">
                    {{--<img src="/assets/images/mbr-122x61.png" alt="" title="" style="height: 3.8rem;">--}}
                    <img src="{{setting('header_logo')}}" alt="" title="" style="width: 150px;height: 40px !important">
                </a>
            </span>
            {{--<span class="navbar-caption-wrap"><a class="navbar-caption text-secondary display-2" href="/">
                SeaLand</a></span>--}}
        </div>
        <div class="navbar-toggler">
            <span style="padding-right: 10px;position:relative;top:5px">
                <a href="/flow" class="text-secondary">訂閱流程</a>
            </span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav nav-dropdown nav-right" data-app-modern-menu="true">
                <li class="nav-item">
                    <a class="nav-link link text-secondary display-7" href="/">首頁</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link text-secondary display-7" href="/#list">訂閱方案</a>
                </li>
                @php
                    $user=getLoginUser();
                    $temps_count=$subscriber=$ords_count=$is_no_paid_count=$is_no_paid2_count=0;
                    if($user){
                        $temps_count=\App\Model\Temp::where('user_id',$user->id)->orderBy('cate_id')->count();
                        $subscriber_count=\App\Model\Subscriber::where('user_id',$user->id)->where('is_history',0)->orderBy('cate_id')->count();
                        $ords_count = \App\Model\Ord::where('user_id', $user->id)->where('is_cancel',0)->orderBy('created_at','DESC')->count();
                        $is_no_paid_count= \App\Model\Ord::where('user_id', $user->id)->where('is_cancel',0)->where('is_paid',0)->count();
                        $is_no_paid2_count= \App\Model\Ord::where('user_id', $user->id)->where('is_cancel',0)->where('is_paid',1)->where('is_paid2',0)->count();
                        $is_no_paid3_count= \App\Model\Ord::where('user_id', $user->id)->where('is_cancel',0)->where('is_paid',1)->where('is_paid2',1)->where('is_paid3',0)->count();
                    }
                @endphp

                <li class="nav-item dropdown">
                    <a class="nav-link link dropdown-toggle text-secondary display-7" href="#" data-toggle="dropdown-submenu" aria-expanded="false">會員中心</a>
                    <div class="dropdown-menu">
                        @if(!$user)
                            <a class="dropdown-item text-secondary display-7" href="/user/login">會員登入</a>
                            <a class="dropdown-item text-secondary display-7" href="/user/register">會員註冊</a>
                            <a class="dropdown-item text-secondary display-7" href="/user/password/reset">忘記密碼</a>
                            <a class="dropdown-item text-secondary display-7" href="/user/resent">重寄帳號啟用信</a>
                        @else
                            <a class="dropdown-item text-secondary display-7" href="/user/changePassword">修改密碼</a>
                            <a class="dropdown-item text-secondary display-7" href="/user/user_update">修改基本資料</a>
                            <a class="dropdown-item text-secondary display-7" href="/ord_list">我的訂閱</a>
                            <a class="dropdown-item text-secondary display-7" href="/user/user_fee">自行繳費明細</a>
                            <a class="dropdown-item text-secondary display-7" href="#" onclick="event.preventDefault(); if(confirm('您是否確認要登出系統?')){ document.getElementById('logout-form').submit();}">登出系統</a>
                            <form id="logout-form" action="/user/logout" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        @endif
                    </div>
                </li>
                {{--<li class="nav-item">
                    <a class="nav-link link text-secondary display-7" href="/about_1">訂閱流程</a>
                </li>--}}
                <li class="nav-item dropdown">
                    <a class="nav-link link dropdown-toggle text-secondary display-7" href="#" data-toggle="dropdown-submenu" aria-expanded="false">訂閱流程</a>
                    <div class="dropdown-menu">
                        @php
                            $list_flowcats=\App\Model\Flowcat::whereStatus(1)->orderBy('sort')->get();
                        @endphp
                        @if($list_flowcats)
                            @foreach($list_flowcats as $list_flowcat)
                                <a class="dropdown-item text-secondary display-7" href="/flow/{{$list_flowcat->id}}">{{$list_flowcat->title}}</a>
                            @endforeach
                        @endif
                    </div>
                </li>
                @if(setting('is_qa_display')==1)
                    <li class="nav-item dropdown">
                        <a class="nav-link link dropdown-toggle text-secondary display-7" href="#" data-toggle="dropdown-submenu" aria-expanded="false">Q&A</a>
                        <div class="dropdown-menu">
                            @php
                                $list_faqcats=\App\Model\Faqcat::whereStatus(1)->orderBy('sort')->get();
                            @endphp
                            @if($list_faqcats)
                                @foreach($list_faqcats as $list_faqcat)
                                    <a class="dropdown-item text-secondary display-7" href="/faq/{{$list_faqcat->id}}">{{$list_faqcat->title_tw}}</a>
                                @endforeach
                            @endif
                        </div>
                    </li>
                @endif
            </ul>

        </div>
    </nav>
</section>