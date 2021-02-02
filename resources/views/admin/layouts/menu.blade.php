@php
    //檢查後台目前選單是否 highlight
    function getactivestr($keyword1='', $keyword2='', $keyword3='', $keyword4='', $keyword5='', $keyword6='', $keyword7='', $keyword8='', $keyword9='', $keyword10='', $keyword11='', $keyword12='', $keyword13='', $keyword14='', $keyword15='', $keyword16='', $keyword17='', $keyword18='', $keyword19='', $keyword20=''){
        if(!$keyword1)
            return false;
        if( request()->is($keyword1) || request()->is($keyword2) ||
            request()->is($keyword3) || request()->is($keyword4) ||
            request()->is($keyword5) || request()->is($keyword6) ||
            request()->is($keyword7) || request()->is($keyword8) ||
            request()->is($keyword9) || request()->is($keyword10) ||
            request()->is($keyword11) || request()->is($keyword12) ||
            request()->is($keyword13) || request()->is($keyword14) ||
            request()->is($keyword15) || request()->is($keyword16) ||
            request()->is($keyword17) || request()->is($keyword18) ||
            request()->is($keyword19) || request()->is($keyword20)){
            return ' active open';
        }
        return '';
    }
    $admin=getAdminUser();
    //會員資料總筆數
    $user_count=\App\Model\frontend\User::count();
    $user_not_check_count=\App\Model\frontend\User::where('idcard_image01', '!=','')->where('idcard_image02', '!=','')->where('driver_image01', '!=','')->where('driver_image02', '!=','')->where('is_check', -1)->count();
    $user_subscriber_count=\App\Model\frontend\User::has('subscribers')->count();
    $user_reject_count=\App\Model\frontend\User::whereHas('subscribers', function($q) {
        $q->where('memo','!=','');
    })->count();

    //訂閱未選車筆數
    /*if(role('carplus_varify'))
        $subscriber_count=\App\Model\Subscriber::whereNull('product_id')->where('is_cancel',0)->where('is_history',0)->where('is_babysitter_send_email',1)->count();
    else
        $subscriber_count=\App\Model\Subscriber::whereNull('product_id')->where('is_cancel',0)->where('can_order_car',1)->where('is_history',0)->count();*/

    $ord_count=\App\Model\Ord::where('is_cancel',0)->where('state_id','>=',2)->where('state_id','<=',13)->count();


    //自動取消訂閱單，車輛自動上架
    chk_subscriber_auto_cancel();

    //自動取消訂單，車輛自動上架
    chk_ord_auto_cancel();

    //每日自動檢視切換訂單狀態至 7:續約招攬
    chk_change_ord_state_7();

    //每日自動寄發 user 車輛是否續約Email
    chk_user_renewal_notify_email();

    //訂單剩餘10天時，寄Email通知 保姆設定續約月份
    chk_renew_autosend_email_to_babysitter();

    //訂單剩餘7天時，每日自動檢視切換訂單狀態至 8:準備還車事宜
    chk_change_ord_state_8();

    /*//每日自動寄發提醒會員及經銷商交車Email
    auto_send_remind_eamil_to_user_and_partner();*/

    //每日檢查自動上架車輛
    check_auto_online_product();


@endphp
<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="/admin">
            {{--<div class="logo-img">
                <img src="/back_assets/src/img/brand-white.svg" class="header-brand-img" alt="lavalite">
            </div>--}}
            <span class="text">後台管理系統</span>
        </a>
        <button type="button" class="nav-toggle"><i data-toggle="expanded" class="ik ik-toggle-right toggle-icon"></i></button>
        {{--<button id="sidebarclose" class="nav-close"><i class="ik ik-x"></i></button>--}}
    </div>

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-lavel">menu</div>
                {{--<div class="nav-item {{request()->is('*/main')?'active':''}}">
                    <a href="/admin"><i class="ik ik-grid"></i><span>回主選單</span></a>
                </div>--}}
                {{--<div class="nav-item {{request()->is('*/dashboard')?'active':''}}">
                    <a href="/admin"><i class="ik ik-bar-chart-2"></i><span>儀表板</span></a>
                </div>--}}
                {{--<div class="nav-item {{request()->is('*/setting')?'active':''}}">
                    <a href="/admin/setting"><i class="ik ik-settings"></i><span>設定</span></a>
                </div>--}}
                @if(role('admin') || has_permission('setting'))
                    <div class="nav-item has-sub {{getactivestr('*slider*','*holiday*','*dealer*','*partner*','*state*','*renewtate*','*samecartate*','*ptate*','*brand*','*flow*','*proarea*','*procolor*','*profuel*','*progeartype*','*ssite*','*setting*')}}">
                        <a href="#"><i class="ik ik-settings"></i><span>設定</span></a>
                        <div class="submenu-content">
                            <a href="/admin/slider" class="menu-item {{request()->is('*/slider*')?'active':''}}">首頁輪播</a>
                            <div class="nav-item has-sub {{getactivestr('*flowcat*','*flowin*')}}">
                                <a href="javascript:void(0)" class="menu-item">訂閱說明</a>
                                <div class="submenu-content">
                                    <a href="/admin/flowcat" class="menu-item {{request()->is('*/flowcat*')?'active':''}}">分類</a>
                                    <a href="/admin/flowin" class="menu-item {{request()->is('*/flowin*')?'active':''}}">內容</a>
                                </div>
                            </div>
                            <a href="/admin/holiday" class="menu-item {{request()->is('*/holiday*')?'active':''}}">假日管理</a>
                            <a href="/admin/dealer" class="menu-item {{request()->is('*/dealer*')?'active':''}}">總經銷商</a>
                            <a href="/admin/partner" class="menu-item {{request()->is('*/partner*')?'active':''}}">經銷商</a>
                            @if(role('admin') || role('babysitter'))
                                <a href="/admin/state" class="menu-item {{request()->is('*/state*')?'active':''}}">訂單狀態</a>
                                <a href="/admin/renewtate" class="menu-item {{request()->is('*/renewtate*')?'active':''}}">訂單續約狀態</a>
                                <a href="/admin/samecartate" class="menu-item {{request()->is('*/samecartate*')?'active':''}}">原車續租狀態</a>
                                <a href="/admin/ptate" class="menu-item {{request()->is('*/ptate*')?'active':''}}">車輛狀態</a>
                            @endif
                            <div class="nav-item has-sub {{getactivestr('*brandcat*','*brandin*')}}">
                                <a href="javascript:void(0)" class="menu-item">品牌管理</a>
                                <div class="submenu-content">
                                    <a href="/admin/brandcat" class="menu-item {{request()->is('*/brandcat*')?'active':''}}">品牌</a>
                                    <a href="/admin/brandin" class="menu-item {{request()->is('*/brandin*')?'active':''}}">車型</a>
                                </div>
                            </div>
                            <div class="nav-item has-sub {{getactivestr('*proarea*','*procolor*','*profuel*','*progeartype*')}}">
                                <a href="javascript:void(0)" class="menu-item">規格管理</a>
                                <div class="submenu-content">
                                    <a href="/admin/proarea" class="menu-item {{request()->is('*/proarea*')?'active':''}}"> 交車區域</a>
                                    <a href="/admin/procolor" class="menu-item {{request()->is('*/procolor*')?'active':''}}">顏色</a>
                                    <a href="/admin/profuel" class="menu-item {{request()->is('*/profuel*')?'active':''}}">燃料</a>
                                    <a href="/admin/progeartype" class="menu-item {{request()->is('*/progeartype*')?'active':''}}">排檔</a>
                                </div>
                            </div>
                            <a href="/admin/ssite" class="menu-item {{request()->is('*/ssite*')?'active':''}}">發證地點代碼</a>
                            @if($admin->id==1 || $admin->id==18)
                                <a href="/admin/setting" class="menu-item {{request()->is('*/setting')?'active':''}}">資料參數設定</a>
                            @endif
                        </div>
                    </div>
                @endif
                @if(role('admin') || role('babysitter'))
                    <div class="nav-item has-sub {{getactivestr('*faqcat*','*faqin*')}}">
                        <a href="#"><i class="fa fa-question-circle"></i><span>常見問題 FAQ</span></a>
                        <div class="submenu-content">
                            <a href="/admin/faqcat" class="menu-item {{request()->is('*faqcat*')?'active':''}}">常見問題 FAQ 分類</a>
                            <a href="/admin/faqin" class="menu-item {{request()->is('*faqin*')?'active':''}}">常見問題 FAQ 列表</a>
                        </div>
                    </div>
                @endif
                {{--@if ($user->hasRole('admin'))
                    <div class="nav-item {{request()->is('*/cate*')?'active':''}}">
                        <a href="/admin/state" class="menu-item {{request()->is('*/state*')?'active':''}}"><i class="fa fa-tasks"></i>訂單狀態</a>
                    </div>
                @endif--}}
                @if(role('admin') || has_permission('cate'))
                    <div class="nav-item {{request()->is('*/cate*')?'active':''}}">
                        <a href="/admin/cate"><i class="fa fa-sitemap"></i><span>方案管理</span></a>
                    </div>
                @endif
                @if(role('admin') || has_permission('product'))
                    <div class="nav-item {{request()->is('*/product*')?'active':''}}">
                        <a href="/admin/product"><i class="fa fa-car"></i><span>車輛管理</span></a>
                    </div>
                @endif
                @if(role('admin') || has_permission('subscriber'))
                    <div class="nav-item {{request()->is('*/subscriber*') || request()->is('*/selectcar*')?'active':''}}">
                        <a href="/admin/subscriber">
                            <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                            <span>
                                訂閱
                                {{--
                                @if($subscriber_count>0 && (role('admin') || role('babysitter')))
                                    <span class="badge badge-danger">{{$subscriber_count}}</span>
                                @endif--}}
                            </span>
                        </a>
                    </div>
                @endif
                @if(role('admin') || has_permission('ord'))
                    <div class="nav-item {{request()->is('*/ord*')?'active':''}}">
                        <a href="/admin/ord">
                            <i class="fa fa-bus" aria-hidden="true"></i>
                            <span>
                                訂單管理
                                @if($ord_count>0 && (role('admin') || role('babysitter')))
                                    <span class="badge badge-danger">{{$ord_count}}</span>
                                @endif
                            </span>
                        </a>
                    </div>
                @endif
                @if(role('admin') || role('babysitter'))
                    <div class="nav-item {{request()->is('*/reporter*')?'active':''}}">
                        <a href="/admin/reporter"><i class="fa fa-list-alt" aria-hidden="true"></i><span>月結報表</span></a>
                    </div>
                @endif
                {{--@if(role('admin') || has_permission('member'))
                    <div class="nav-item {{request()->is('*/user*')?'active':''}}">
                        <a href="/admin/user">
                            <i class="ik ik-user"></i>
                            <span>
                                會員管理
                                ({{number_format($user_count)}})
                                @if($user_not_check_count>0)
                                    <span class="badge badge-danger">{{$user_not_check_count}}</span>
                                @endif
                            </span>
                        </a>
                    </div>
                @endif--}}
                @if(role('admin') || has_permission('member'))
                    <div class="nav-item has-sub {{getactivestr('*user*','*u_is_check*','*u_subscriber*','*u_reject*')}}">
                        <a href="#">
                            <i class="ik ik-user"></i>
                            <span>
                                會員管理
                                ({{number_format($user_count)}})
                                @if($user_not_check_count>0)
                                    <span class="badge badge-danger">{{$user_not_check_count}}</span>
                                @endif
                            </span>
                        </a>
                        <div class="submenu-content">
                            <a href="/admin/user" class="menu-item {{request()->is('*user*')?'active':''}}">
                                會員列表 ({{number_format($user_count)}})
                            </a>
                            <a href="/admin/u_is_check?search_is_check=-1&search_is_picok=1" class="menu-item {{request()->is('*u_is_check*')?'active':''}}">
                                會員審查
                                @if($user_not_check_count>0)
                                    <span class="badge badge-danger">{{$user_not_check_count}}</span>
                                @endif
                            </a>
                            <a href="/admin/u_subscriber?search_has_subscriber=1" class="menu-item {{request()->is('*u_subscriber*')?'active':''}}">
                                訂閱記錄
                                @if($user_subscriber_count>0)
                                    <span class="badge badge-danger">{{$user_subscriber_count}}</span>
                                @endif
                            </a>
                            <a href="/admin/u_reject?search_has_reject=1" class="menu-item {{request()->is('*u_reject*')?'active':''}}">
                                黑名單
                                @if($user_reject_count>0)
                                    <span class="badge badge-danger">{{$user_reject_count}}</span>
                                @endif
                            </a>
                        </div>
                    </div>
                @endif
                {{--@if($admin->id==1)--}}
                    @if(role('admin') || role('babysitter'))
                        <div class="nav-item {{request()->is('*/wlog*')?'active':''}}">
                            <a href="/admin/wlog"><i class="fa fa-list-alt" aria-hidden="true"></i><span>Log 記錄查詢</span></a>
                        </div>
                    @endif
                {{--@endif--}}

                {{--<div class="nav-item {{request()->is('*/contact*')?'active':''}}">
                    <a href="/admin/contact"><i class="ik ik-message-square"></i><span>聯絡我們</span></a>
                </div>--}}
                @if($admin->id==1 || $admin->id==18)
                    <div class="nav-item has-sub {{getactivestr('*permission*','*role*','*admin/admin*')}}">
                        <a href="#"><i class="ik ik-lock"></i><span>帳號、權限管理</span></a>
                        <div class="submenu-content">
                            @if($admin->id==1)
                                <a href="/admin/permission" class="menu-item {{request()->is('*permission*')?'active':''}}">權限項目管理</a>
                                <a href="/admin/role" class="menu-item {{request()->is('*role*')?'active':''}}">角色名稱管理</a>
                            @endif
                            <a href="/admin/admin" class="menu-item {{request()->is('*admin/admin*')?'active':''}}">帳號管理</a>
                        </div>
                    </div>
                @endif
            </nav>
        </div>
    </div>
</div>