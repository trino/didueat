<?php
//initialize("routes");

// Frontsite Routes...
Route::get('/',                                     'HomeController@index');
Route::get('/contactus',                            'HomeController@contactus');
Route::get('/restaurants',                          'HomeController@allRestaurants');
Route::get('/restaurants/{slug}/menus',             'HomeController@menusRestaurants');
Route::resource('/restaurants/signup',              'HomeController@signupRestaurants');
Route::resource('/home/test',                       'HomeController@test');

//Authentication routes...
Route::post('auth/login/ajax',                      'Auth\AuthController@authenticateAjax');
Route::get('auth/login',                         'Auth\AuthController@getLogin');
Route::post('auth/login',                           'Auth\AuthController@authenticate');
Route::get('auth/logout',                           'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register',                         'Auth\AuthController@getRegister');
Route::post('auth/register',                        'Auth\AuthController@postRegister');
Route::post('auth/register/ajax',                   'Auth\AuthController@postAjaxRegister');
Route::get('auth/resend_email/{email}',             'Auth\AuthController@resendEmail');
Route::get('auth/resend_email/ajax/{email}',        'Auth\AuthController@resendPostEmail');
Route::get('auth/verify_email/{email}',             'Auth\AuthController@verifyEmail');
Route::get('auth/forgot-passoword',                 'Auth\AuthController@forgotPassword');
Route::post('auth/forgot-passoword',                'Auth\AuthController@postForgotPassword');
Route::post('auth/forgot-passoword/ajax',           'Auth\AuthController@postAjaxForgotPassword');

// Dashboard After Authentication routes...
Route::resource('dashboard',                        'AdministratorController@dashboard');
Route::get('user/info',                             'AdministratorController@dashboard');
Route::resource('restaurant/users',                 'AdministratorController@users');
Route::get('restaurant/users/action/{type}/{id}',   'AdministratorController@usersAction');
Route::resource('restaurant/newsletter',            'AdministratorController@newsletter');

//Restaurants Routes
Route::get('restaurant/restaurants',                'RestaurantController@restaurants');
Route::get('restaurant/restaurants/delete/{id}',    'RestaurantController@restaurantDelete'     )->where('id', '[0-9]+');
Route::get('restaurant/restaurants/status/{id}',    'RestaurantController@restaurantStatus'     )->where('id', '[0-9]+');
Route::resource('restaurant/info',                  'RestaurantController@restaurantInfo');
Route::resource('restaurant/menus-manager',         'RestaurantController@menuManager');
Route::resource('restaurant/addresses',             'RestaurantController@addresses');
Route::get('restaurant/addresses/delete/{id}',      'RestaurantController@deleteAddresses'      )->where('id', '[0-9]+');
Route::get('restaurant/orders/pending',             'RestaurantController@pendingOrders');
Route::get('restaurant/orders/view/{id}',           'RestaurantController@viewOrder'            )->where('id', '[0-9]+');
Route::get('restaurant/orders/pending/cancel/{id}', 'RestaurantController@changeOrderCancel'    )->where('id', '[0-9]+');
Route::get('restaurant/orders/pending/approve/{id}','RestaurantController@changeOrderApprove'   )->where('id', '[0-9]+');
Route::get('restaurant/orders/pending/delete/{id}', 'RestaurantController@deleteOrder'          )->where('id', '[0-9]+');
Route::get('restaurant/orders/order_detail/{id}',   'RestaurantController@order_detail'         )->where('id', '[0-9]+');
Route::get('restaurant/orders/history/{id}',        'RestaurantController@history'              )->where('id', '[0-9]+');
Route::get('restaurant/orders/{type}',              'RestaurantController@orderslist'           )->where('slug', '[a-z]+');
Route::get('restaurant/eventlog',                   'RestaurantController@eventsLog');
Route::get('restaurant/report',                     'RestaurantController@report');
Route::get('restaurant/menu_form/{id}',             'RestaurantController@menu_form');
Route::get('restaurant/additional',                 'RestaurantController@additional');
Route::get('restaurant/uploadimg',                  'RestaurantController@uploadimg');
Route::post('restaurant/uploadimg',                 'RestaurantController@uploadimg');
Route::get('restaurant/getToken',                   'RestaurantController@getToken');
Route::post('restaurant/menuadd',                   'RestaurantController@menuadd');
Route::get('restaurant/menuadd',                    'RestaurantController@menuadd');
Route::get('restaurant/orderCat',                   'RestaurantController@orderCat');
Route::post('restaurant/orderCat',                  'RestaurantController@orderCat');
Route::get('restaurant/deleteMenu/{id}',            'RestaurantController@deleteMenu');
Route::get('restaurant/red/{path}',            'RestaurantController@red');

Route::resource('user/addresses',                   'UsersController@addresses');
Route::resource('user/addresses/edit/{id}',            'UsersController@addressesUpdate');
Route::get('user/addresses/delete/{id}',            'UsersController@addressesDelete')->where('id', '[0-9]+');
Route::get('user/uploadmeal',                       'UsersController@uploadMeal');
Route::resource('user/images',                      'UsersController@images');
Route::get('user/orders',                           'UsersController@viewOrders');
Route::post('user/ajax_register',                   'UsersController@ajax_register');
Route::resource('user/json_data',                   'UsersController@json_data');

Route::get('auth/test',                             'Auth\AuthController@test');

Route::any('admin/(:any)/add/(:any?)', function($controller,$params=null) {
    return Controller::call('admin.'.$controller.'@edit', (array) $params);
});