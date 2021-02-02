<?php

	/*
	|--------------------------------------------------------------------------
	| Web Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register web routes for your application. These
	| routes are loaded by the RouteServiceProvider within a group which
	| contains the "web" middleware group. Now create something great!
	|
	*/

    Route::domain('sealand.tw')->group(function () {
        Route::group(['middleware' => ['guest']], function () {

            Route::get('/', 'frontend\InfoController@index');

            //Route::get('/about', 'frontend\InfoController@about');
            Route::get('/about_1', function() {
                return redirect('/flow');
            });
            Route::get('/about_2', function() {
                return redirect('/flow');
            });
            Route::get('/about', function() {
                return redirect('/flow');
            });

            Route::get('/users/export/', 'frontend\UsersController@export');

            Route::get('/news', 'frontend\InfoController@news');
            Route::get('/news/{hotin}', 'frontend\InfoController@news_in');
            Route::get('/service/{service}', 'frontend\InfoController@service');

            Route::get('/faq', 'frontend\InfoController@faq');
            Route::get('/faq/{faqcat_id}', 'frontend\InfoController@faq');

            Route::get('/flow', 'frontend\InfoController@flow');
            Route::get('/flow/{flowcat_id}', 'frontend\InfoController@flow');

            Route::get('/contact', 'frontend\InfoController@contact');
            Route::post('/contact', 'frontend\InfoController@contact_post');
            Route::get('/privacy', 'frontend\InfoController@privacy');
            Route::get('/member_policy', 'frontend\InfoController@member_policy');

            Route::get('/product_list', 'frontend\ProductController@list')->name('product.list');
            Route::get('/product_list/{id}', 'frontend\ProductController@list');
            Route::post('/product_list', 'frontend\ProductController@list')->name('product.list_post');
            Route::get('/product/{product}', 'frontend\ProductController@show');
            Route::get('/fetch_data', 'frontend\ProductController@fetch_data');

            Route::get('/chkIsUseEmailPost', 'frontend\AjaxController@chkIsUseEmailPost');

            //Admin
            $this->get('admin/password/reset/{token}', 'admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
            // USER
            Route::get('user/login', 'frontend\Auth\LoginController@getLoginForm')->name('user.login');
            Route::post('user/authenticate', 'frontend\Auth\LoginController@authenticate')->name('user.authenticate');
            Route::view('to_register', 'frontend.auth.to_register');
            Route::get('user/register', 'frontend\Auth\RegisterController@getRegisterForm')->name('user.register');
            Route::post('user/saveregister', 'frontend\Auth\RegisterController@saveRegisterForm')->name('user.saveregister');
            Route::get('/verify-user/{code}', 'frontend\Auth\RegisterController@activateUser')->name('activate.user');
            Route::get('user/resent', 'frontend\AccountController@resent');
            Route::post('user/resent', 'frontend\AccountController@resent_post');

            Route::get('login/{provider}', 'frontend\Auth\LoginController@redirectToProvider');
            Route::get('login/{provider}/callback', 'frontend\Auth\LoginController@handleProviderCallback');
 
            //Route::get('/line', 'frontend\LineController@pageLine');
            Route::get('callback/login', 'frontend\Auth\LoginController@lineLoginCallBack');

            // USER Password Reset Routes...
            $this->post('user/password/email', 'frontend\Auth\ForgotPasswordController@sendResetLinkEmail')->name('user.password.email');
            $this->get('user/password/reset', 'frontend\Auth\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');
            $this->post('user/password/reset', 'frontend\Auth\ResetPasswordController@reset')->name('user.password.reset');
            $this->get('user/password/reset/{token}', 'frontend\Auth\ResetPasswordController@showResetForm')->name('user.password.reset');

            Route::get('/search', 'frontend\ProductController@search')->name('search');

            Route::get('/cart', 'frontend\CartController@index')->name('cart.index');
            Route::post('/cart', 'frontend\CartController@store')->name('cart.store');
            Route::patch('/cart/{product}', 'frontend\CartController@update')->name('cart.update');
            Route::delete('/cart/{id}', 'frontend\CartController@destroy')->name('cart.destroy');
            Route::patch('/cart/{product}', 'frontend\CartController@update')->name('cart.update');
            Route::get('/checkout', 'frontend\CheckoutController@index')->name('checkout.index');

            Route::get('/checkout_direct_pay/{ord}', 'frontend\CheckoutController@checkout_direct_pay');
            Route::post('/checkout/creditPaid', 'frontend\CheckoutController@creditPaid')->name('checkout.creditPaid');
            Route::post('/checkout/creditPaid2', 'frontend\CheckoutController@creditPaid2')->name('checkout.creditPaid2');
            Route::post('/checkout/creditPaid3', 'frontend\CheckoutController@creditPaid3')->name('checkout.creditPaid3');
            Route::get('/thankyou/{ord_no}', 'frontend\CheckoutController@thankyou')->name('checkout.thankyou');
            Route::get('/failure/{retcode}', 'frontend\CheckoutController@failure')->name('checkout.failure');
            Route::post('/checkout_retry', 'frontend\CheckoutController@checkoutRetry')->name('checkout.checkoutRetry');

            Route::get('empty', function() {
                Cart::instance('default')->destroy();
                redirect()->back();
                //Cart::instance('saveForLater')->destroy();
            });

            Route::get('upload5code', 'frontend\InfoController@upload5code');
            Route::get('upload5code/{ord_no}', 'frontend\InfoController@upload5code');
            Route::post('upload5code', 'frontend\InfoController@upload5code_post');

            Route::get('ajax_temp_proarea','frontend\AjaxController@ajax_temp_proarea');
            Route::get('ajax_temp_brandin','frontend\AjaxController@ajax_temp_brandin');
            //Route::get('ajax_partner','frontend\AjaxController@ajax_partner');
            Route::get('ajax_sub_date','frontend\AjaxController@ajax_sub_date');

            Route::get('ajax_brandcat','frontend\AjaxController@ajax_brandcat');
            Route::get('ajax_brandcat2','frontend\AjaxController@ajax_brandcat2');
            Route::get('ajax_brandin','frontend\AjaxController@ajax_brandin');

            Route::get('ajax_price','frontend\AjaxController@ajax_price');

            Route::get('/user_send_email/{field}/{filename}', 'frontend\InfoController@licenceMailFileShow');

            Route::get('cookieset', function()
            {
                $foreverCookie = Cookie::forever('forever', 'Success');
                $tempCookie = Cookie::make('temporary', 'Victory', 5);//引數格式：$name, $value, $minutes
                return Response::make()->withCookie($foreverCookie)->withCookie($tempCookie);
            });
            Route::get('cookietest', function()
            {
                $forever = Cookie::get('forever');
                $temporary = Cookie::get('temporary');
                return View::make('cookietest', array('forever' => $forever, 'temporary' => $temporary, 'variableTest' => 'works'));
            });
            //先上一個demo寫入cookie
            $cookie = \Cookie('cookie_name', 'value', 5);
            $data = ['title'=>'hello world'];
            return \response()
                ->view('frontend.test', $data)
                ->cookie($cookie);

        });

        Route::group(['middleware' => ['user']], function () {

            Route::post('user/logout', 'frontend\Auth\LoginController@getLogout')->name('user.logout');

            Route::get('user/changePassword','frontend\AccountController@showChangePasswordForm')->name('changePassword');
            Route::post('user/changePassword','frontend\AccountController@changePassword')->name('changePassword');

            Route::get('user/point/{item}','frontend\AccountController@point')->name('point');

            Route::get('user/user_update', 'frontend\AccountController@edit')->name('user.edit');
            Route::post('user/user_update','frontend\AccountController@update')->name('user.update');

            Route::get('user/user_fee', 'frontend\OrdController@user_fee');
            Route::post('user/user_fee','frontend\OrdController@user_fee_post');

            Route::get('user/orders', 'frontend\OrdController@index')->name('orders.index');
            Route::get('user/orders/{is_history}', 'frontend\OrdController@index')->name('orders.index_history');
            Route::get('user/order_cancel/{order_cancel}', 'frontend\OrdController@order_cancel')->name('orders.order_cancel');

            /*Route::post('/whitepoint', 'frontend\WhitepointController@store')->name('whitepoint.store');
            Route::delete('/whitepoint', 'frontend\WhitepointController@destroy')->name('whitepoint.destroy');*/

            Route::get('/temp/{cate_id}', 'frontend\TempController@temp');
            Route::post('/temp', 'frontend\TempController@temp_post');

            Route::get('/subscriber_list', 'frontend\SubscriberController@subscriber_list');
            Route::get('/subscriber/{subscriber}', 'frontend\SubscriberController@subscriber');

            Route::get('/ord_list', 'frontend\OrdController@index');
            Route::get('/subscriber/{subscriber}', 'frontend\OrdController@subscriber');
            Route::get('/ord/{ord}', 'frontend\OrdController@ord');

            Route::get('/ord_no_paid_list', 'frontend\OrdController@ord_no_paid_list');

            Route::get('/ord_no_paid2_list', 'frontend\OrdController@ord_no_paid2_list');

            Route::get('/ord_no_paid3_list', 'frontend\OrdController@ord_no_paid3_list');

            Route::post('/checkout_post', 'frontend\CheckoutController@checkout_post')->name('checkout.post');

            Route::get('/activate_success', 'frontend\InfoController@activate_success');

            Route::get('/user/{field}/{filename}', 'frontend\InfoController@licenceFileShow');
        });
    });

    Route::domain('car-plus.sealand.tw')->group(function () {
        Route::group(['middleware' => ['guest']], function () {

            Route::get('/', 'frontend_carplus\InfoController@index');

            //Route::get('/about', 'frontend_carplus\InfoController@about');
            Route::get('/about_1', function() {
                return redirect('/flow');
            });
            Route::get('/about_2', function() {
                return redirect('/flow');
            });
            Route::get('/about', function() {
                return redirect('/flow');
            });

            Route::get('/users/export/', 'frontend_carplus\UsersController@export');

            Route::get('/news', 'frontend_carplus\InfoController@news');
            Route::get('/news/{hotin}', 'frontend_carplus\InfoController@news_in');
            Route::get('/service/{service}', 'frontend_carplus\InfoController@service');

            Route::get('/faq', 'frontend_carplus\InfoController@faq');
            Route::get('/faq/{faqcat_id}', 'frontend_carplus\InfoController@faq');

            Route::get('/flow', 'frontend_carplus\InfoController@flow');
            Route::get('/flow/{flowcat_id}', 'frontend_carplus\InfoController@flow');

            Route::get('/contact', 'frontend_carplus\InfoController@contact');
            Route::post('/contact', 'frontend_carplus\InfoController@contact_post');
            Route::get('/privacy', 'frontend_carplus\InfoController@privacy');
            Route::get('/member_policy', 'frontend_carplus\InfoController@member_policy');

            Route::get('/product_list', 'frontend_carplus\ProductController@list')->name('product.list');
            Route::get('/product_list/{id}', 'frontend_carplus\ProductController@list');
            Route::post('/product_list', 'frontend_carplus\ProductController@list')->name('product.list_post');
            Route::get('/product/{product}', 'frontend_carplus\ProductController@show');
            Route::get('/fetch_data', 'frontend_carplus\ProductController@fetch_data');

            Route::get('/chkIsUseEmailPost', 'frontend_carplus\AjaxController@chkIsUseEmailPost');

            //Admin
            $this->get('admin/password/reset/{token}', 'admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
            // USER
            Route::get('user/login', 'frontend_carplus\Auth\LoginController@getLoginForm')->name('carplus.user.login');
            Route::post('user/authenticate', 'frontend_carplus\Auth\LoginController@authenticate')->name('user.authenticate');
            Route::view('to_register', 'frontend.auth.to_register');
            Route::get('user/register', 'frontend_carplus\Auth\RegisterController@getRegisterForm')->name('carplus.user.register');
            Route::post('user/saveregister', 'frontend_carplus\Auth\RegisterController@saveRegisterForm')->name('user.saveregister');
            Route::get('/verify-user/{code}', 'frontend_carplus\Auth\RegisterController@activateUser')->name('activate.user');
            Route::get('user/resent', 'frontend_carplus\AccountController@resent');
            Route::post('user/resent', 'frontend_carplus\AccountController@resent_post');

            Route::get('login/{provider}', 'frontend_carplus\Auth\LoginController@redirectToProvider');
            Route::get('login/{provider}/callback', 'frontend_carplus\Auth\LoginController@handleProviderCallback');

            //Route::get('/line', 'frontend_carplus\LineController@pageLine');
            Route::get('callback/login', 'frontend_carplus\Auth\LoginController@lineLoginCallBack');

            // USER Password Reset Routes...
            $this->post('user/password/email', 'frontend_carplus\Auth\ForgotPasswordController@sendResetLinkEmail')->name('carplus.user.password.email');
            $this->get('user/password/reset', 'frontend_carplus\Auth\ForgotPasswordController@showLinkRequestForm')->name('carplus.user.password.request');
            $this->post('user/password/reset', 'frontend_carplus\Auth\ResetPasswordController@reset')->name('carplus.user.password.reset');
            $this->get('user/password/reset/{token}', 'frontend_carplus\Auth\ResetPasswordController@showResetForm')->name('carplus.user.password.reset');

            Route::get('/search', 'frontend_carplus\ProductController@search')->name('search');

            Route::get('/cart', 'frontend_carplus\CartController@index')->name('cart.index');
            Route::post('/cart', 'frontend_carplus\CartController@store')->name('cart.store');
            Route::patch('/cart/{product}', 'frontend_carplus\CartController@update')->name('cart.update');
            Route::delete('/cart/{id}', 'frontend_carplus\CartController@destroy')->name('cart.destroy');
            Route::patch('/cart/{product}', 'frontend_carplus\CartController@update')->name('cart.update');
            Route::get('/checkout', 'frontend_carplus\CheckoutController@index')->name('checkout.index');

            Route::get('/checkout_direct_pay/{ord}', 'frontend_carplus\CheckoutController@checkout_direct_pay');
            Route::post('/checkout/creditPaid', 'frontend_carplus\CheckoutController@creditPaid')->name('checkout.creditPaid');
            Route::post('/checkout/creditPaid2', 'frontend_carplus\CheckoutController@creditPaid2')->name('checkout.creditPaid2');
            Route::post('/checkout/creditPaid3', 'frontend_carplus\CheckoutController@creditPaid3')->name('checkout.creditPaid3');
            Route::get('/thankyou/{ord_no}', 'frontend_carplus\CheckoutController@thankyou')->name('checkout.thankyou');
            Route::get('/failure/{retcode}', 'frontend_carplus\CheckoutController@failure')->name('checkout.failure');
            Route::post('/checkout_retry', 'frontend_carplus\CheckoutController@checkoutRetry')->name('checkout.checkoutRetry');

            Route::get('empty', function() {
                Cart::instance('default')->destroy();
                redirect()->back();
                //Cart::instance('saveForLater')->destroy();
            });

            Route::get('upload5code', 'frontend_carplus\InfoController@upload5code');
            Route::get('upload5code/{ord_no}', 'frontend_carplus\InfoController@upload5code');
            Route::post('upload5code', 'frontend_carplus\InfoController@upload5code_post');

            Route::get('ajax_temp_proarea','frontend_carplus\AjaxController@ajax_temp_proarea');
            Route::get('ajax_temp_brandin','frontend_carplus\AjaxController@ajax_temp_brandin');
            //Route::get('ajax_partner','frontend_carplus\AjaxController@ajax_partner');
            Route::get('ajax_sub_date','frontend_carplus\AjaxController@ajax_sub_date');

            Route::get('ajax_brandcat','frontend_carplus\AjaxController@ajax_brandcat');
            Route::get('ajax_brandcat2','frontend_carplus\AjaxController@ajax_brandcat2');
            Route::get('ajax_brandin','frontend_carplus\AjaxController@ajax_brandin');

            Route::get('ajax_price','frontend_carplus\AjaxController@ajax_price');

            Route::get('/user_send_email/{field}/{filename}', 'frontend_carplus\InfoController@licenceMailFileShow');

            Route::get('cookieset', function()
            {
                $foreverCookie = Cookie::forever('forever', 'Success');
                $tempCookie = Cookie::make('temporary', 'Victory', 5);//引數格式：$name, $value, $minutes
                return Response::make()->withCookie($foreverCookie)->withCookie($tempCookie);
            });
            Route::get('cookietest', function()
            {
                $forever = Cookie::get('forever');
                $temporary = Cookie::get('temporary');
                return View::make('cookietest', array('forever' => $forever, 'temporary' => $temporary, 'variableTest' => 'works'));
            });
            //先上一個demo寫入cookie
            $cookie = \Cookie('cookie_name', 'value', 5);
            $data = ['title'=>'hello world'];
            return \response()
                ->view('frontend.test', $data)
                ->cookie($cookie);

        });

        Route::group(['middleware' => ['user']], function () {

            Route::post('user/logout', 'frontend_carplus\Auth\LoginController@getLogout')->name('user.logout');

            Route::get('user/changePassword','frontend_carplus\AccountController@showChangePasswordForm')->name('changePassword');
            Route::post('user/changePassword','frontend_carplus\AccountController@changePassword')->name('changePassword');

            Route::get('user/point/{item}','frontend_carplus\AccountController@point')->name('point');

            Route::get('user/user_update', 'frontend_carplus\AccountController@edit')->name('user.edit');
            Route::post('user/user_update','frontend_carplus\AccountController@update')->name('user.update');

            Route::get('user/user_fee', 'frontend_carplus\OrdController@user_fee');
            Route::post('user/user_fee','frontend_carplus\OrdController@user_fee_post');

            Route::get('user/orders', 'frontend_carplus\OrdController@index')->name('orders.index');
            Route::get('user/orders/{is_history}', 'frontend_carplus\OrdController@index')->name('orders.index_history');
            Route::get('user/order_cancel/{order_cancel}', 'frontend_carplus\OrdController@order_cancel')->name('orders.order_cancel');

            /*Route::post('/whitepoint', 'frontend_carplus\WhitepointController@store')->name('whitepoint.store');
            Route::delete('/whitepoint', 'frontend_carplus\WhitepointController@destroy')->name('whitepoint.destroy');*/

            Route::get('/temp/{cate_id}', 'frontend_carplus\TempController@temp');
            Route::post('/temp', 'frontend_carplus\TempController@temp_post');

            Route::get('/subscriber_list', 'frontend_carplus\SubscriberController@subscriber_list');
            Route::get('/subscriber/{subscriber}', 'frontend_carplus\SubscriberController@subscriber');

            Route::get('/ord_list', 'frontend_carplus\OrdController@index');
            Route::get('/subscriber/{subscriber}', 'frontend_carplus\OrdController@subscriber');
            Route::get('/ord/{ord}', 'frontend_carplus\OrdController@ord');

            Route::get('/ord_no_paid_list', 'frontend_carplus\OrdController@ord_no_paid_list');

            Route::get('/ord_no_paid2_list', 'frontend_carplus\OrdController@ord_no_paid2_list');

            Route::get('/ord_no_paid3_list', 'frontend_carplus\OrdController@ord_no_paid3_list');

            Route::post('/checkout_post', 'frontend_carplus\CheckoutController@checkout_post')->name('checkout.post');

            Route::get('/activate_success', 'frontend_carplus\InfoController@activate_success');

            Route::get('/user/{field}/{filename}', 'frontend_carplus\InfoController@licenceFileShow');
        });
    });

    Route::group(['middleware' => ['guest']], function () {

        Route::get('/', 'frontend_carplus\InfoController@index');

        //Route::get('/about', 'frontend_carplus\InfoController@about');
        Route::get('/about_1', function() {
            return redirect('/flow');
        });
        Route::get('/about_2', function() {
            return redirect('/flow');
        });
        Route::get('/about', function() {
            return redirect('/flow');
        });

        Route::get('/users/export/', 'frontend_carplus\UsersController@export');

        Route::get('/news', 'frontend_carplus\InfoController@news');
        Route::get('/news/{hotin}', 'frontend_carplus\InfoController@news_in');
        Route::get('/service/{service}', 'frontend_carplus\InfoController@service');

        Route::get('/faq', 'frontend_carplus\InfoController@faq');
        Route::get('/faq/{faqcat_id}', 'frontend_carplus\InfoController@faq');

        Route::get('/flow', 'frontend_carplus\InfoController@flow');
        Route::get('/flow/{flowcat_id}', 'frontend_carplus\InfoController@flow');

        Route::get('/contact', 'frontend_carplus\InfoController@contact');
        Route::post('/contact', 'frontend_carplus\InfoController@contact_post');
        Route::get('/privacy', 'frontend_carplus\InfoController@privacy');
        Route::get('/member_policy', 'frontend_carplus\InfoController@member_policy');

        Route::get('/product_list', 'frontend_carplus\ProductController@list')->name('product.list');
        Route::get('/product_list/{id}', 'frontend_carplus\ProductController@list');
        Route::post('/product_list', 'frontend_carplus\ProductController@list')->name('product.list_post');
        Route::get('/product/{product}', 'frontend_carplus\ProductController@show');
        Route::get('/fetch_data', 'frontend_carplus\ProductController@fetch_data');

        Route::get('/chkIsUseEmailPost', 'frontend_carplus\AjaxController@chkIsUseEmailPost');

        //Admin
        $this->get('admin/password/reset/{token}', 'admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
        // USER
        Route::get('user/login', 'frontend_carplus\Auth\LoginController@getLoginForm')->name('carplus.user.login');
        Route::post('user/authenticate', 'frontend_carplus\Auth\LoginController@authenticate')->name('user.authenticate');
        Route::view('to_register', 'frontend.auth.to_register');
        Route::get('user/register', 'frontend_carplus\Auth\RegisterController@getRegisterForm')->name('carplus.user.register');
        Route::post('user/saveregister', 'frontend_carplus\Auth\RegisterController@saveRegisterForm')->name('user.saveregister');
        Route::get('/verify-user/{code}', 'frontend_carplus\Auth\RegisterController@activateUser')->name('activate.user');
        Route::get('user/resent', 'frontend_carplus\AccountController@resent');
        Route::post('user/resent', 'frontend_carplus\AccountController@resent_post');

        Route::get('login/{provider}', 'frontend_carplus\Auth\LoginController@redirectToProvider');
        Route::get('login/{provider}/callback', 'frontend_carplus\Auth\LoginController@handleProviderCallback');

        //Route::get('/line', 'frontend_carplus\LineController@pageLine');
        Route::get('callback/login', 'frontend_carplus\Auth\LoginController@lineLoginCallBack');

        // USER Password Reset Routes...
        $this->post('user/password/email', 'frontend_carplus\Auth\ForgotPasswordController@sendResetLinkEmail')->name('carplus.user.password.email');
        $this->get('user/password/reset', 'frontend_carplus\Auth\ForgotPasswordController@showLinkRequestForm')->name('carplus.user.password.request');
        $this->post('user/password/reset', 'frontend_carplus\Auth\ResetPasswordController@reset')->name('carplus.user.password.reset');
        $this->get('user/password/reset/{token}', 'frontend_carplus\Auth\ResetPasswordController@showResetForm')->name('carplus.user.password.reset');

        Route::get('/search', 'frontend_carplus\ProductController@search')->name('search');

        Route::get('/cart', 'frontend_carplus\CartController@index')->name('cart.index');
        Route::post('/cart', 'frontend_carplus\CartController@store')->name('cart.store');
        Route::patch('/cart/{product}', 'frontend_carplus\CartController@update')->name('cart.update');
        Route::delete('/cart/{id}', 'frontend_carplus\CartController@destroy')->name('cart.destroy');
        Route::patch('/cart/{product}', 'frontend_carplus\CartController@update')->name('cart.update');
        Route::get('/checkout', 'frontend_carplus\CheckoutController@index')->name('checkout.index');

        Route::get('/checkout_direct_pay/{ord}', 'frontend_carplus\CheckoutController@checkout_direct_pay');
        Route::post('/checkout/creditPaid', 'frontend_carplus\CheckoutController@creditPaid')->name('checkout.creditPaid');
        Route::post('/checkout/creditPaid2', 'frontend_carplus\CheckoutController@creditPaid2')->name('checkout.creditPaid2');
        Route::post('/checkout/creditPaid3', 'frontend_carplus\CheckoutController@creditPaid3')->name('checkout.creditPaid3');
        Route::get('/thankyou/{ord_no}', 'frontend_carplus\CheckoutController@thankyou')->name('checkout.thankyou');
        Route::get('/failure/{retcode}', 'frontend_carplus\CheckoutController@failure')->name('checkout.failure');
        Route::post('/checkout_retry', 'frontend_carplus\CheckoutController@checkoutRetry')->name('checkout.checkoutRetry');

        Route::get('empty', function() {
            Cart::instance('default')->destroy();
            redirect()->back();
            //Cart::instance('saveForLater')->destroy();
        });

        Route::get('upload5code', 'frontend_carplus\InfoController@upload5code');
        Route::get('upload5code/{ord_no}', 'frontend_carplus\InfoController@upload5code');
        Route::post('upload5code', 'frontend_carplus\InfoController@upload5code_post');

        Route::get('ajax_temp_proarea','frontend_carplus\AjaxController@ajax_temp_proarea');
        Route::get('ajax_temp_brandin','frontend_carplus\AjaxController@ajax_temp_brandin');
        //Route::get('ajax_partner','frontend_carplus\AjaxController@ajax_partner');
        Route::get('ajax_sub_date','frontend_carplus\AjaxController@ajax_sub_date');

        Route::get('ajax_brandcat','frontend_carplus\AjaxController@ajax_brandcat');
        Route::get('ajax_brandcat2','frontend_carplus\AjaxController@ajax_brandcat2');
        Route::get('ajax_brandin','frontend_carplus\AjaxController@ajax_brandin');

        Route::get('ajax_price','frontend_carplus\AjaxController@ajax_price');

        Route::get('/user_send_email/{field}/{filename}', 'frontend_carplus\InfoController@licenceMailFileShow');

        Route::get('cookieset', function()
        {
            $foreverCookie = Cookie::forever('forever', 'Success');
            $tempCookie = Cookie::make('temporary', 'Victory', 5);//引數格式：$name, $value, $minutes
            return Response::make()->withCookie($foreverCookie)->withCookie($tempCookie);
        });
        Route::get('cookietest', function()
        {
            $forever = Cookie::get('forever');
            $temporary = Cookie::get('temporary');
            return View::make('cookietest', array('forever' => $forever, 'temporary' => $temporary, 'variableTest' => 'works'));
        });
        //先上一個demo寫入cookie
        $cookie = \Cookie('cookie_name', 'value', 5);
        $data = ['title'=>'hello world'];
        return \response()
            ->view('frontend.test', $data)
            ->cookie($cookie);

    });

    Route::group(['middleware' => ['user']], function () {

        Route::post('user/logout', 'frontend_carplus\Auth\LoginController@getLogout')->name('user.logout');

        Route::get('user/changePassword','frontend_carplus\AccountController@showChangePasswordForm')->name('changePassword');
        Route::post('user/changePassword','frontend_carplus\AccountController@changePassword')->name('changePassword');

        Route::get('user/point/{item}','frontend_carplus\AccountController@point')->name('point');

        Route::get('user/user_update', 'frontend_carplus\AccountController@edit')->name('user.edit');
        Route::post('user/user_update','frontend_carplus\AccountController@update')->name('user.update');

        Route::get('user/user_fee', 'frontend_carplus\OrdController@user_fee');
        Route::post('user/user_fee','frontend_carplus\OrdController@user_fee_post');

        Route::get('user/orders', 'frontend_carplus\OrdController@index')->name('orders.index');
        Route::get('user/orders/{is_history}', 'frontend_carplus\OrdController@index')->name('orders.index_history');
        Route::get('user/order_cancel/{order_cancel}', 'frontend_carplus\OrdController@order_cancel')->name('orders.order_cancel');

        /*Route::post('/whitepoint', 'frontend_carplus\WhitepointController@store')->name('whitepoint.store');
        Route::delete('/whitepoint', 'frontend_carplus\WhitepointController@destroy')->name('whitepoint.destroy');*/

        Route::get('/temp/{cate_id}', 'frontend_carplus\TempController@temp');
        Route::post('/temp', 'frontend_carplus\TempController@temp_post');

        Route::get('/subscriber_list', 'frontend_carplus\SubscriberController@subscriber_list');
        Route::get('/subscriber/{subscriber}', 'frontend_carplus\SubscriberController@subscriber');

        Route::get('/ord_list', 'frontend_carplus\OrdController@index');
        Route::get('/subscriber/{subscriber}', 'frontend_carplus\OrdController@subscriber');
        Route::get('/ord/{ord}', 'frontend_carplus\OrdController@ord');

        Route::get('/ord_no_paid_list', 'frontend_carplus\OrdController@ord_no_paid_list');

        Route::get('/ord_no_paid2_list', 'frontend_carplus\OrdController@ord_no_paid2_list');

        Route::get('/ord_no_paid3_list', 'frontend_carplus\OrdController@ord_no_paid3_list');

        Route::post('/checkout_post', 'frontend_carplus\CheckoutController@checkout_post')->name('checkout.post');

        Route::get('/activate_success', 'frontend_carplus\InfoController@activate_success');

        Route::get('/user/{field}/{filename}', 'frontend_carplus\InfoController@licenceFileShow');
    });

	// ADMIN
	Route::group(['prefix'=>'admin'], function () {

		// Admin Password Reset Routes...
		//登入
		Route::get('login', 'admin\Auth\LoginController@getLoginForm')->name('admin.login');
		Route::post('authenticate', 'admin\Auth\LoginController@authenticate')->name('admin.authenticate');
		//註冊會員
		Route::get('register', 'admin\Auth\RegisterController@getRegisterForm')->name('admin.register');
		Route::post('saveregister', 'admin\Auth\RegisterController@saveRegisterForm')->name('admin.saveregister');
		//郵件連回網站，啟用帳號及登入
		Route::get('/verify-admin/{code}', 'admin\Auth\RegisterController@activateAdmin')->name('activate.admin');
		//寄出密碼重設信函頁面
		$this->post('password/email', 'admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
		//密碼重設信函連回網站
		Route::get('password/reset/{token}', 'admin\Auth\ResetPasswordController@showResetForm')->name('admin.password.reset');
		//顯示密碼重設頁面及送出, 重設成功及登入
		$this->get('password/reset', 'admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
		$this->post('password/reset', 'admin\Auth\ResetPasswordController@reset');
		//重寄帳號啟用連結信函
		Route::get('resent', 'admin\Admin\AccountController@resent');
		Route::post('resent', 'admin\Admin\AccountController@resent_post');
		//多元登入
		Route::get('login/{provider}', 'frontend\Auth\LoginController@redirectToProvider');
		Route::get('login/{provider}/callback', 'frontend\Auth\LoginController@handleProviderCallback');

		/*$this->get('user/password/reset', 'frontend\Auth\ForgotPasswordController@showLinkRequestForm')->name('user.password.request');
		$this->post('user/password/reset', 'frontend\Auth\ResetPasswordController@reset')->name('user.password.reset');*/

		Route::group(['middleware' => 'admin'], function () {

			Route::get('/', function() {
				return redirect('/admin/dashboard');
			});
			//Route::view('/','admin.dashboard');
			Route::view('dashboard','admin.dashboard');
			Route::post('logout', 'admin\Auth\LoginController@getLogout')->name('admin.logout');
			//Route::view('table','admin.table');
			//Route::view('slider','admin.slider');

			//slider
			Route::resource('slider', 'admin\Slider\AdminSliderController');
			Route::get('slider/{id}/status/{status}','admin\Slider\AdminSliderController@status');
			Route::get('slider/del_img/{slider}', 'admin\Slider\AdminSliderController@del_img');
			Route::get('slider/{slider}/delete','admin\Slider\AdminSliderController@destroy');
			Route::post('slider/batch_update/', 'admin\Slider\AdminSliderController@batch_update');

			//about
			Route::post('aboutin/list/{aboutin}','admin\Aboutin\AdminAboutinController@show_list');
			Route::get('aboutin/list/{aboutin}','admin\Aboutin\AdminAboutinController@show_list');
			Route::get('aboutin/create','admin\Aboutin\AdminAboutinController@create');
			Route::get('aboutin/delete/{aboutin}','admin\Aboutin\AdminAboutinController@destroy');
			Route::resource('aboutin', 'admin\Aboutin\AdminAboutinController',['except' => ['create']]);
			Route::post('aboutin/batch_update/', 'admin\Aboutin\AdminAboutinController@batch_update');
			Route::get('aboutin/{id}/status/{status}','admin\Aboutin\AdminAboutinController@status');
			Route::get('aboutin/del_img/{aboutin}', 'admin\Aboutin\AdminAboutinController@del_img');

            Route::resource('holiday', 'admin\Holiday\AdminHolidayController');
            Route::post('holiday/checkupdate/', 'admin\Holiday\AdminHolidayController@checkupdate');

			//banner
			Route::resource('banner', 'admin\Banner\AdminBannerController');
			Route::get('banner/{id}/status/{status}','admin\Banner\AdminBannerController@status');
			Route::get('banner/del_img/{banner}', 'admin\Banner\AdminBannerController@del_img');
			Route::get('banner/{banner}/delete','admin\Banner\AdminBannerController@destroy');
			Route::post('banner/batch_update/', 'admin\Banner\AdminBannerController@batch_update');

			//hot
			Route::post('hotin/list/{hotin}','admin\Hotin\AdminHotinController@show_list');
			Route::get('hotin/list/{hotin}','admin\Hotin\AdminHotinController@show_list');
			Route::get('hotin/create','admin\Hotin\AdminHotinController@create');
			Route::get('hotin/delete/{hotin}','admin\Hotin\AdminHotinController@destroy');
			Route::resource('hotin', 'admin\Hotin\AdminHotinController',['except' => ['create']]);
			Route::post('hotin/batch_update/', 'admin\Hotin\AdminHotinController@batch_update');
			Route::get('hotin/{id}/status/{status}','admin\Hotin\AdminHotinController@status');
			Route::get('hotin/del_img/{hotin}', 'admin\Hotin\AdminHotinController@del_img');

			Route::get('hotin2/create/{hotin2}','admin\Hotin\AdminHotin2Controller@create');
			Route::get('hotin2/delete/{hotin2}','admin\Hotin\AdminHotin2Controller@destroy');
			Route::resource('hotin2', 'admin\Hotin\AdminHotin2Controller',['except' => ['create']]);
			Route::get('hotin2/del_img/{hotin2}/{image}', 'admin\Hotin\AdminHotin2Controller@del_img');
			Route::post('hotin2/sort', 'admin\Hotin\AdminHotin2Controller@sort');

			//service
			Route::get('service/','admin\Service\AdminServiceController@index');
			Route::get('service/create','admin\Service\AdminServiceController@create');
			Route::get('service/delete/{service}','admin\Service\AdminServiceController@destroy');
			Route::post('service/sort', 'admin\Service\AdminServiceController@sort');
			Route::resource('service', 'admin\Service\AdminServiceController',['except' => ['create']]);
			Route::get('service/del_img/{service}/{image}', 'admin\Service\AdminServiceController@del_img');

			//faq
			Route::resource('faqcat', 'admin\Faqcat\AdminFaqcatController');
			Route::get('faqcat/{id}/status/{status}','admin\Faqcat\AdminFaqcatController@status');
			Route::get('faqcat/del_img/{faqcat}', 'admin\Faqcat\AdminFaqcatController@del_img');
			Route::get('faqcat/{faqcat}/delete','admin\Faqcat\AdminFaqcatController@destroy');
			Route::post('faqcat/batch_update/', 'admin\Faqcat\AdminFaqcatController@batch_update');

			Route::post('faqin/list/{faqin}','admin\Faqin\AdminFaqinController@show_list');
			Route::get('faqin/list/{faqin}','admin\Faqin\AdminFaqinController@show_list');
			Route::get('faqin/create/{faqin}','admin\Faqin\AdminFaqinController@create');
			Route::get('faqin/delete/{faqin}','admin\Faqin\AdminFaqinController@destroy');
			Route::resource('faqin', 'admin\Faqin\AdminFaqinController',['except' => ['create']]);
			Route::post('faqin/batch_update/', 'admin\Faqin\AdminFaqinController@batch_update');
			Route::get('faqin/{id}/status/{status}','admin\Faqin\AdminFaqinController@status');
			Route::get('faqin/del_img/{faqin}', 'admin\Faqin\AdminFaqinController@del_img');

			//flow
			Route::resource('flowcat', 'admin\Flowcat\AdminFlowcatController');
			Route::get('flowcat/{id}/status/{status}','admin\Flowcat\AdminFlowcatController@status');
			Route::get('flowcat/del_img/{flowcat}', 'admin\Flowcat\AdminFlowcatController@del_img');
			Route::get('flowcat/{flowcat}/delete','admin\Flowcat\AdminFlowcatController@destroy');
			Route::post('flowcat/batch_update/', 'admin\Flowcat\AdminFlowcatController@batch_update');

			Route::post('flowin/list/{flowin}','admin\Flowin\AdminFlowinController@show_list');
			Route::get('flowin/list/{flowin}','admin\Flowin\AdminFlowinController@show_list');
			Route::get('flowin/create/{flowin}','admin\Flowin\AdminFlowinController@create');
			Route::get('flowin/delete/{flowin}','admin\Flowin\AdminFlowinController@destroy');
			Route::resource('flowin', 'admin\Flowin\AdminFlowinController',['except' => ['create']]);
			Route::post('flowin/batch_update/', 'admin\Flowin\AdminFlowinController@batch_update');
			Route::get('flowin/{id}/status/{status}','admin\Flowin\AdminFlowinController@status');
			Route::get('flowin/del_img/{flowin}', 'admin\Flowin\AdminFlowinController@del_img');

			//paymenttype
			Route::get('paymenttype/','admin\Paymenttype\AdminPaymenttypeController@index');
			Route::get('paymenttype/create','admin\Paymenttype\AdminPaymenttypeController@create');
			Route::get('paymenttype/delete/{paymenttype}','admin\Paymenttype\AdminPaymenttypeController@destroy');
			Route::resource('paymenttype', 'admin\Paymenttype\AdminPaymenttypeController',['except' => ['create']]);
			Route::get('paymenttype/del_img/{paymenttype}/{image}', 'admin\Paymenttype\AdminPaymenttypeController@del_img');

			//state
			Route::get('state/','admin\State\AdminStateController@index');
			Route::get('state/create','admin\State\AdminStateController@create');
			Route::get('state/{state}/delete','admin\State\AdminStateController@destroy');
			Route::resource('state', 'admin\State\AdminStateController',['except' => ['create']]);
			Route::get('state/del_img/{state}/{image}', 'admin\State\AdminStateController@del_img');

            //dealer
            Route::get('dealer/','admin\Dealer\AdminDealerController@index');
            Route::get('dealer/create','admin\Dealer\AdminDealerController@create');
            Route::get('dealer/{dealer}/delete','admin\Dealer\AdminDealerController@destroy');
            Route::resource('dealer', 'admin\Dealer\AdminDealerController',['except' => ['create']]);
            Route::get('dealer/del_img/{dealer}/{image}', 'admin\Dealer\AdminDealerController@del_img');

            //ssite
            Route::get('ssite/','admin\Ssite\AdminSsiteController@index');
            Route::get('ssite/create','admin\Ssite\AdminSsiteController@create');
            Route::get('ssite/{ssite}/delete','admin\Ssite\AdminSsiteController@destroy');
            Route::resource('ssite', 'admin\Ssite\AdminSsiteController',['except' => ['create']]);
            Route::get('ssite/del_img/{ssite}/{image}', 'admin\Ssite\AdminSsiteController@del_img');

			//renewtate
			Route::get('renewtate/','admin\Renewtate\AdminRenewtateController@index');
			Route::get('renewtate/create','admin\Renewtate\AdminRenewtateController@create');
			Route::get('renewtate/{renewtate}/delete','admin\Renewtate\AdminRenewtateController@destroy');
			Route::resource('renewtate', 'admin\Renewtate\AdminRenewtateController',['except' => ['create']]);
			Route::get('renewtate/del_img/{renewtate}/{image}', 'admin\Renewtate\AdminRenewtateController@del_img');

			//samecartate
			Route::get('samecartate/','admin\Samecartate\AdminSamecartateController@index');
			Route::get('samecartate/create','admin\Samecartate\AdminSamecartateController@create');
			Route::get('samecartate/{samecartate}/delete','admin\Samecartate\AdminSamecartateController@destroy');
			Route::resource('samecartate', 'admin\Samecartate\AdminSamecartateController',['except' => ['create']]);
			Route::get('samecartate/del_img/{samecartate}/{image}', 'admin\Samecartate\AdminSamecartateController@del_img');

			//ptate
			Route::get('ptate/','admin\Ptate\AdminPtateController@index');
			Route::get('ptate/create','admin\Ptate\AdminPtateController@create');
			Route::get('ptate/{ptate}/delete','admin\Ptate\AdminPtateController@destroy');
			Route::resource('ptate', 'admin\Ptate\AdminPtateController',['except' => ['create']]);
			Route::get('ptate/del_img/{ptate}/{image}', 'admin\Ptate\AdminPtateController@del_img');

			//store
			Route::post('shippingtype/list/{shippingtype}','admin\Shippingtype\AdminShippingtypeController@show_list');
			Route::get('shippingtype/list/{shippingtype}','admin\Shippingtype\AdminShippingtypeController@show_list');
			Route::get('shippingtype/create','admin\Shippingtype\AdminShippingtypeController@create');
			Route::get('shippingtype/delete/{shippingtype}','admin\Shippingtype\AdminShippingtypeController@destroy');
			Route::resource('shippingtype', 'admin\Shippingtype\AdminShippingtypeController',['except' => ['create']]);
			Route::post('shippingtype/batch_update/', 'admin\Shippingtype\AdminShippingtypeController@batch_update');
			Route::get('shippingtype/{id}/status/{status}','admin\Shippingtype\AdminShippingtypeController@status');
			Route::get('shippingtype/del_img/{shippingtype}', 'admin\Shippingtype\AdminShippingtypeController@del_img');

			Route::get('shippingtype2/create/{shippingtype2}','admin\Shippingtype\AdminShippingtype2Controller@create');
			Route::get('shippingtype2/delete/{shippingtype2}','admin\Shippingtype\AdminShippingtype2Controller@destroy');
			Route::resource('shippingtype2', 'admin\Shippingtype\AdminShippingtype2Controller',['except' => ['create']]);
			Route::get('shippingtype2/del_img/{shippingtype2}/{image}', 'admin\Shippingtype\AdminShippingtype2Controller@del_img');

            //cate
            Route::get('cate/create','admin\Cate\AdminCateController@create');
            Route::resource('cate', 'admin\Cate\AdminCateController');
            Route::get('cate/{cate}/delete','admin\Cate\AdminCateController@destroy');
            Route::post('cate/batch_update/', 'admin\Cate\AdminCateController@batch_update');

			//product
			Route::resource('product', 'admin\Product\AdminProductController');
			Route::post('product','admin\Product\AdminProductController@index');
			//Route::get('product/create','admin\Product\AdminProductController@create');
			Route::post('product/store','admin\Product\AdminProductController@store');
			Route::get('product/{id}/status/{status}','admin\Product\AdminProductController@status');
			Route::get('product/del_img/{product}', 'admin\Product\AdminProductController@del_img');
			Route::get('product/{product}/delete','admin\Product\AdminProductController@destroy');
			Route::post('product/batch_update/', 'admin\Product\AdminProductController@batch_update');
			//productimage
			Route::get('product/productimage/del_img/{productimage}','admin\Product\AdminProductController@productimage_del_img');
			//addition
			/*Route::get('prodaddition/{product}','admin\Product\AdminProductController@prodaddition');
			Route::post('prodaddition','admin\Product\AdminProductController@prodaddition_update')->name('prodaddition.update');*/
			Route::post('product_import','admin\Product\AdminProductController@product_import');

            //subscriber
			Route::resource('subscriber', 'admin\Subscriber\AdminSubscriberController');
			Route::post('subscriber','admin\Subscriber\AdminSubscriberController@index');
			//Route::get('subscriber/create','admin\Subscriber\AdminSubscriberController@create');
			Route::post('subscriber/store','admin\Subscriber\AdminSubscriberController@store');
			Route::get('subscriber/{id}/status/{status}','admin\Subscriber\AdminSubscriberController@status');
			Route::get('subscriber/del_img/{subscriber}', 'admin\Subscriber\AdminSubscriberController@del_img');
			Route::get('subscriber/{subscriber}/delete','admin\Subscriber\AdminSubscriberController@destroy');
			Route::post('subscriber/batch_update/', 'admin\Subscriber\AdminSubscriberController@batch_update');
			//subscriberimage
			Route::get('subscriber/subscriberimage/del_img/{subscriberimage}','admin\Subscriber\AdminSubscriberController@subscriberimage_del_img');

            Route::get('subscriber_user/{user}/edit', 'admin\Subscriber\AdminSubscriberController@subscriber_user');

            Route::get('subscriber/{field}/{filename}', 'admin\Subscriber\AdminSubscriberController@licenceFileShow');

            Route::post('sub_trandfer_ord', 'admin\Subscriber\AdminSubscriberController@sub_trandfer_ord');

            //selectcar
            Route::get('selectcar/{subscriber}', 'admin\Selectcar\AdminProductController@index');
            Route::post('selectcar', 'admin\Selectcar\AdminProductController@selectcar_post');

            //cate
            Route::get('partner/create','admin\Partner\AdminPartnerController@create');
            Route::resource('partner', 'admin\Partner\AdminPartnerController');
            Route::get('partner/{partner}/delete','admin\Partner\AdminPartnerController@destroy');
            Route::post('partner/batch_update/', 'admin\Partner\AdminPartnerController@batch_update');

			//brand
			Route::resource('brandcat', 'admin\Brandcat\AdminBrandcatController');
			Route::get('brandcat/create/{cate}','admin\Brandcat\AdminBrandcatController@create');
			Route::get('brandcat/{id}/status/{status}','admin\Brandcat\AdminBrandcatController@status');
			Route::get('brandcat/del_img/{brandcat}', 'admin\Brandcat\AdminBrandcatController@del_img');
			Route::get('brandcat/{brandcat}/delete','admin\Brandcat\AdminBrandcatController@destroy');
			Route::post('brandcat/batch_update/', 'admin\Brandcat\AdminBrandcatController@batch_update');

			Route::post('brandin/list/{brandin}','admin\Brandin\AdminBrandinController@show_list');
			Route::get('brandin/list/{brandin}','admin\Brandin\AdminBrandinController@show_list');
			Route::get('brandin/create/{cate}/{brandcat}','admin\Brandin\AdminBrandinController@create');
			Route::get('brandin/delete/{brandin}','admin\Brandin\AdminBrandinController@destroy');
			Route::resource('brandin', 'admin\Brandin\AdminBrandinController',['except' => ['create']]);
			Route::post('brandin/batch_update/', 'admin\Brandin\AdminBrandinController@batch_update');
			Route::get('brandin/{id}/status/{status}','admin\Brandin\AdminBrandinController@status');
			Route::get('brandin/del_img/{brandin}', 'admin\Brandin\AdminBrandinController@del_img');

			//proarea
			Route::resource('proarea', 'admin\Proarea\AdminProareaController');
			Route::get('proarea/{id}/status/{status}','admin\Proarea\AdminProareaController@status');
			Route::get('proarea/del_img/{proarea}', 'admin\Proarea\AdminProareaController@del_img');
			Route::get('proarea/{proarea}/delete','admin\Proarea\AdminProareaController@destroy');
			Route::post('proarea/batch_update/', 'admin\Proarea\AdminProareaController@batch_update');

			//procolor
			Route::resource('procolor', 'admin\Procolor\AdminProcolorController');
			Route::get('procolor/{id}/status/{status}','admin\Procolor\AdminProcolorController@status');
			Route::get('procolor/del_img/{procolor}', 'admin\Procolor\AdminProcolorController@del_img');
			Route::get('procolor/{procolor}/delete','admin\Procolor\AdminProcolorController@destroy');
			Route::post('procolor/batch_update/', 'admin\Procolor\AdminProcolorController@batch_update');

			//profuel
			Route::resource('profuel', 'admin\Profuel\AdminProfuelController');
			Route::get('profuel/{id}/status/{status}','admin\Profuel\AdminProfuelController@status');
			Route::get('profuel/del_img/{profuel}', 'admin\Profuel\AdminProfuelController@del_img');
			Route::get('profuel/{profuel}/delete','admin\Profuel\AdminProfuelController@destroy');
			Route::post('profuel/batch_update/', 'admin\Profuel\AdminProfuelController@batch_update');

			//progeartype
			Route::resource('progeartype', 'admin\Progeartype\AdminProgeartypeController');
			Route::get('progeartype/{id}/status/{status}','admin\Progeartype\AdminProgeartypeController@status');
			Route::get('progeartype/del_img/{progeartype}', 'admin\Progeartype\AdminProgeartypeController@del_img');
			Route::get('progeartype/{progeartype}/delete','admin\Progeartype\AdminProgeartypeController@destroy');
			Route::post('progeartype/batch_update/', 'admin\Progeartype\AdminProgeartypeController@batch_update');

			//period
			Route::resource('period', 'admin\Period\AdminPeriodController');
			Route::get('period/{id}/status/{status}','admin\Period\AdminPeriodController@status');
			Route::get('period/del_img/{period}', 'admin\Period\AdminPeriodController@del_img');
			Route::get('period/{period}/delete','admin\Period\AdminPeriodController@destroy');
			Route::post('period/batch_update/', 'admin\Period\AdminPeriodController@batch_update');

			//ord
			Route::resource('ord', 'admin\Ord\AdminOrdController');
            //Route::get('ord/create','admin\Ord\AdminOrdController@create');
			Route::get('ord/{id}/status/{status}','admin\Ord\AdminOrdController@status');
			Route::get('ord/del_img/{ord}', 'admin\Ord\AdminOrdController@del_img');
			Route::get('ord/{ord}/delete','admin\Ord\AdminOrdController@destroy');
			Route::post('ord/batch_update/', 'admin\Ord\AdminOrdController@batch_update');
			Route::get('ord/pdf/{id}', 'admin\Ord\AdminOrdController@pdf');
			Route::get('ord_email/{ord}', 'admin\Ord\AdminOrdController@ord_email');
			Route::get('backend_change_subdate_notify/{ord}', 'admin\Ord\AdminOrdController@backend_change_subdate_notify');

			Route::get('reporter', 'admin\Ord\AdminOrdController@reporter');

            //ordselectcar
            Route::get('ordselcar/{ord}', 'admin\OrdSelectcar\AdminProductController@ordselcar');
            Route::post('ordselcar', 'admin\OrdSelectcar\AdminProductController@ordselcar_post');

			//user
			Route::get('user','admin\User\AdminUserController@index');
			Route::get('user/create','admin\User\AdminUserController@create');
			Route::get('user/delete/{user}','admin\User\AdminUserController@destroy');
			Route::resource('user', 'admin\User\AdminUserController',['except' => ['create']]);
			Route::get('user/del_img/{user}/{image}', 'admin\User\AdminUserController@del_img');
			Route::get('user/{id}/status/{status}','admin\User\AdminUserController@status');
			Route::get('user/{id}/is_activate/{is_activate}','admin\User\AdminUserController@is_activate');
			Route::get('user/{id}/grade/{grade}','admin\User\AdminUserController@grade');
			Route::get('user_temp_notify_email/{user}','admin\User\AdminUserController@user_temp_notify_email');
			Route::get('user_temp_reject_notify_email/{user}','admin\User\AdminUserController@user_temp_reject_notify_email');
			Route::get('user_subscriber_ok_email/{subscriber}','admin\User\AdminUserController@user_subscriber_ok_email');
			Route::get('user_subscriber_reject_email/{subscriber}','admin\User\AdminUserController@user_subscriber_reject_email');
			Route::get('only_user_subscriber_reject_email/{subscriber}','admin\User\AdminUserController@only_user_subscriber_reject_email');
			Route::get('send_user_data_and_cate/{user}/{subscriber}','admin\User\AdminUserController@send_user_data_and_cate');

            Route::get('user/{field}/{filename}', 'admin\User\AdminUserController@licenceFileShow');
            Route::get('user_idcard/{user}', 'admin\User\AdminUserController@user_idcard');
            Route::get('u_is_check', 'admin\User\AdminUserController@index');
            Route::get('u_subscriber', 'admin\User\AdminUserController@u_subscriber');
            Route::get('u_reject', 'admin\User\AdminUserController@u_reject');

			//contact
			Route::get('contact','admin\Contact\AdminContactController@index');
			Route::get('contact/create','admin\Contact\AdminContactController@create');
			Route::get('contact/delete/{contact}','admin\Contact\AdminContactController@destroy');
			Route::resource('contact', 'admin\Contact\AdminContactController',['except' => ['create']]);
			Route::get('contact/del_img/{contact}/{image}', 'admin\Contact\AdminContactController@del_img');
			Route::post('contact/batch_update/', 'admin\Contact\AdminContactController@batch_update');

			//permission
			Route::resource('permission', 'admin\Permission\AdminPermissionController');
			Route::get('permission/delete/{permission}','admin\Permission\AdminPermissionController@destroy');
			Route::get('permission/{id}/status/{status}','admin\Permission\AdminPermissionController@status');
			Route::post('permission/sort', 'admin\Permission\AdminPermissionController@sort');
			Route::get('permission/del_img/{permission}', 'admin\Permission\AdminPermissionController@del_img');
			Route::get('permission/{permission}/delete','admin\Permission\AdminPermissionController@destroy');

			//role
			Route::resource('role', 'admin\Role\AdminRoleController');
			Route::get('role/{id}/status/{status}','admin\Role\AdminRoleController@status');
			Route::post('role/sort', 'admin\Role\AdminRoleController@sort');
			Route::get('role/del_img/{role}', 'admin\Role\AdminRoleController@del_img');
			Route::get('role/{role}/delete','admin\Role\AdminRoleController@destroy');

			//admin
			Route::get('admin','admin\Admin\AdminController@index');
			Route::get('admin/create','admin\Admin\AdminController@create');
			Route::get('admin/{admin}/delete','admin\Admin\AdminController@destroy');
			Route::resource('admin', 'admin\Admin\AdminController',['except' => ['create']]);
			Route::get('admin/{id}/status/{status}','admin\Admin\AdminController@status');
			Route::get('admin/{admin}/password','admin\Admin\AdminController@password');
			Route::patch('admin/password/{admin}','admin\Admin\AdminController@password_update');

			Route::get('setting','admin\Setting\AdminSettingController@index');
			Route::post('setting','admin\Setting\AdminSettingController@update');

			Route::get('profile','admin\Admin\AdminController@profile');
			Route::post('profile','admin\Admin\AdminController@profile_post');

			Route::get('changePassword','admin\Admin\AccountController@showChangePasswordForm')->name('admin.changePassword');
			Route::post('changePassword','admin\Admin\AccountController@changePassword')->name('admin.changePassword');

			Route::get('ajax_sort','admin\Ajax\AjaxController@ajax_sort');
			Route::get('ajax_switch','admin\Ajax\AjaxController@ajax_switch');
			Route::get('ajax_subscriber_switch','admin\Ajax\AjaxController@ajax_subscriber_switch');
			Route::get('ajax_product_select','admin\Ajax\AjaxController@ajax_product_select');
			Route::get('ajax_remove_item','admin\Ajax\AjaxController@ajax_remove_item');
			Route::get('ajax_delete_record','admin\Ajax\AjaxController@ajax_delete_record');
			Route::get('ajax_remove_file','admin\Ajax\AjaxController@ajax_remove_file');
			Route::get('ajax_clear_field','admin\Ajax\AjaxController@ajax_clear_field');
			Route::get('ajax_remove_image','admin\Ajax\AjaxController@ajax_remove_image');
			Route::get('ajax_remove_image_and_delete','admin\Ajax\AjaxController@ajax_remove_image_and_delete');

			Route::get('ajax_master_sort','admin\Ajax\AjaxController@ajax_master_sort');
			Route::get('ajax_master_switch','admin\Ajax\AjaxController@ajax_master_switch');
			Route::get('ajax_master_remove_image','admin\Ajax\AjaxController@ajax_remove_image');

			Route::get('ajax_brandcat','admin\Ajax\AjaxController@ajax_brandcat');
			Route::get('ajax_brandin','admin\Ajax\AjaxController@ajax_brandin');

			Route::get('update_table_field','admin\Ajax\AjaxController@update_table_field');
			Route::get('update_user_table_field','admin\Ajax\AjaxController@update_user_table_field');
			Route::get('update_subscriber_table_field','admin\Ajax\AjaxController@update_subscriber_table_field');
			Route::get('update_product_table_field','admin\Ajax\AjaxController@update_product_table_field');

            //wlog
            Route::resource('wlog', 'admin\Wlog\AdminWlogController');

            //Send Email
            Route::get('send_email/mn1_1/{user}', 'admin\Email\AdminEmailController@mn1_1');
            Route::get('send_email/my1_1/{user}', 'admin\Email\AdminEmailController@my1_1');
            Route::get('send_email/my2/{subscriber}', 'admin\Email\AdminEmailController@my2');
            Route::get('send_email/mn2/{subscriber}', 'admin\Email\AdminEmailController@mn2');
            Route::get('send_email/my3/{ord}', 'admin\Email\AdminEmailController@my3');
            Route::get('send_email/cy3/{ord}', 'admin\Email\AdminEmailController@cy3');
            Route::get('send_email/ry3/{ord}', 'admin\Email\AdminEmailController@ry3');
            Route::get('send_email/ry3_1/{ord}', 'admin\Email\AdminEmailController@ry3_1');
            Route::get('send_email/ry10/{ord}', 'admin\Email\AdminEmailController@ry10');
            Route::get('send_email/ry10_1/{ord}', 'admin\Email\AdminEmailController@ry10_1');
            Route::get('send_email/my8ry8/{ord}', 'admin\Email\AdminEmailController@my8ry8');
            Route::get('send_email/my12/{user}', 'admin\Email\AdminEmailController@my12');


		});
	});

	Route::get('/newebpay_return', 'frontend\CheckoutController@newebpay_return');
	Route::post('/newebpay_return', 'frontend\CheckoutController@newebpay_return');
	Route::get('/newebpay_notify', 'frontend\CheckoutController@newebpay_notify');
	Route::post('/newebpay_notify', 'frontend\CheckoutController@newebpay_notify');

	Route::get('/newebpay_return2', 'frontend\CheckoutController@newebpay_return2');
	Route::post('/newebpay_return2', 'frontend\CheckoutController@newebpay_return2');
	Route::get('/newebpay_notify2', 'frontend\CheckoutController@newebpay_notify2');
	Route::post('/newebpay_notify2', 'frontend\CheckoutController@newebpay_notify2');

	Route::get('/newebpay_return3', 'frontend\CheckoutController@newebpay_return3');
	Route::post('/newebpay_return3', 'frontend\CheckoutController@newebpay_return3');
	Route::get('/newebpay_notify3', 'frontend\CheckoutController@newebpay_notify3');
	Route::post('/newebpay_notify3', 'frontend\CheckoutController@newebpay_notify3');

	//Auth::routes();

	//Route::get('/home', 'HomeController@index')->name('home');


