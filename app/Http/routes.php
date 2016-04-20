<?php
 
//initialize("routes");
// Frontsite Routes...
Route::get('/',                                                     'HomeController@index');
Route::get('/ajax',                                                 'HomeController@ajax');
Route::post('/ajax',                                                'HomeController@ajax');
Route::get('/contactus',                                            'HomeController@contactus');
Route::get('/restaurants',                                          'HomeController@allRestaurants');
Route::get('/home/debugmode',                                       'HomeController@debugmode');

Route::resource('/restaurants/signup',                              'HomeController@signupRestaurants');
Route::get('/restaurants/{searchTerm}',                             'HomeController@searchRestaurants');
Route::post('/search/restaurants/ajax',                             'HomeController@searchRestaurantsAjax');
Route::resource('/restaurants/loadmenus/{catid}/{resid}/',          'HomeController@loadmenus');
Route::get('/restaurants/menu/stats/{id}',                          'HomeController@countStatus');
Route::get('/restaurants/{slug}/menu',                              'HomeController@menusRestaurants');
Route::get('/search/menu/{term}',                                   'HomeController@searchMenus');
Route::post('/search/menu/ajax',                                    'HomeController@searchMenusAjax');
Route::post('/uploadimg/{type}',                                    'HomeController@uploadimg')->where('type', '[a-z]+');
Route::post('/newsletter/subscribe',                                'HomeController@newsletterSubscribe');
Route::post('/rating/save',                                         'HomeController@ratingSave');
Route::get('/test',                                                 'HomeController@test');
Route::get('home/simplemodal/{page}',                               'HomeController@simplemodal');
Route::post('home/simplemodal/{page}',                              'HomeController@simplemodal');

//Authentication routes...
Route::post('auth/login/ajax',                                      'Auth\AuthController@authenticateAjax');
//Route::get('auth/login',                                          'Auth\AuthController@getLogin');
Route::post('auth/login',                                           'Auth\AuthController@authenticate');
Route::get('auth/logout',                                           'Auth\AuthController@getLogout');

Route::get('home/faq',                                              'HomeController@home2');
Route::get('home/{type}',                                           'HomeController@home');
Route::post('home/{type}',                                          'HomeController@home');

Route::get('orders/alertstore',                                     'OrdersController@alertstore');
Route::get('orders/list/{action}/email/{email}/{guid}',             'OrdersController@orderstatus');
Route::post('orders/list/{action}/email/{email}/{guid}',            'OrdersController@orderstatus');

// Registration routes...
Route::get('auth/register',                                         'Auth\AuthController@getRegister');
Route::post('auth/register',                                        'Auth\AuthController@postRegister');
Route::post('auth/register/ajax',                                   'Auth\AuthController@postAjaxRegister');
Route::get('auth/resend_email/{email}',                             'Auth\AuthController@resendEmail');
Route::get('auth/resend_email/ajax/{email}',                        'Auth\AuthController@resendPostEmail');
Route::get('auth/verify_email/{email}',                             'Auth\AuthController@verifyEmail');
Route::get('auth/forgot-password',                                  'Auth\AuthController@forgotPassword');
Route::post('auth/forgot-password',                                 'Auth\AuthController@postForgotPassword');
Route::post('auth/forgot-password/ajax',                            'Auth\AuthController@postAjaxForgotPassword');
Route::post('auth/validate/email/ajax',                             'Auth\AuthController@postAjaxValidateEmail');
Route::post('auth/validate/email/ajax/{CurrentUser}',               'Auth\AuthController@postAjaxValidateEmail');
Route::resource('restaurant/view',                                  'RestaurantController@restaurantInfo');
Route::resource('home/faq',                                         'HomeController@home2');

// Routes After Logged in Check
Route::group(['middleware' => ['logged']], function() {
    Route::resource('dashboard',                                    'AdministratorController@dashboard');

    //Orders Routes
    Route::get('orders/list/{type}',                                'OrdersController@index')->where('slug', '[a-z]+');
    Route::get('orders/list/{type}/{id}',                           'OrdersController@index')->where('slug', '[a-z]+');
    Route::post('orders/list/ajax/{type}',                          'OrdersController@listingAjax')->where('slug', '[a-z]+');
    Route::post('orders/list/ajax/{type}/{id}',                     'OrdersController@listingAjax')->where('slug', '[a-z]+');
    Route::get('orders/order_detail/{id}/{type}',                   'OrdersController@order_detail')->where('id', '[0-9]+');
    Route::post('orders/order_detail/{id}/{type}',                  'OrdersController@order_detail')->where('id', '[0-9]+');
    Route::get('orders/view/{id}',                                  'OrdersController@viewOrder')->where('id', '[0-9]+');
    Route::post('orders/list/cancel/{type}',                        'OrdersController@changeOrderCancel');
    Route::post('orders/list/approve/{type}',                       'OrdersController@changeOrderApprove');
    Route::post('orders/list/disapprove/{type}',                    'OrdersController@changeOrderDisapprove');
    Route::get('orders/list/delete/{type}/{id}',                    'OrdersController@deleteOrder')->where('id', '[0-9]+');
    Route::post('orders/list/delete/{type}/{id}',                   'OrdersController@deleteOrder')->where('id', '[0-9]+');
    Route::get('orders/report',                                     'OrdersController@report');
    
    //Profiles Addresses Routes
    Route::get('user/addresses',                                    'ProfileAddressesController@index');
    Route::post('user/addresses',                                   'ProfileAddressesController@index');
    Route::post('user/addresses/ajax/list',                         'ProfileAddressesController@listingAjax');
    Route::post('user/addresses/sequence',                          'ProfileAddressesController@addressesSequence');
    Route::post('user/addresses/save/{id}',                         'ProfileAddressesController@addressEdit');
    Route::post('user/addresses/{id}',                              'ProfileAddressesController@index');
    Route::get('user/addresses/edit/{id}',                          'ProfileAddressesController@addressesFind');
    Route::get('user/addresses/delete/{id}',                        'ProfileAddressesController@addressesDelete')->where('id', '[0-9]+');
    Route::post('user/addresses/delete/{id}',                       'ProfileAddressesController@addressesDelete')->where('id', '[0-9]+');
    Route::get('restaurant/users/action/{type}/{id}',               'UsersController@usersAction');
    Route::post('restaurant/users/action/{type}/{id}',              'UsersController@usersAction');
    Route::get('user/info',                                         'AdministratorController@dashboard');
    Route::resource('user/images',                                  'UsersController@images');
    Route::resource('restaurant/info',                              'RestaurantController@restaurantInfo');
    
    //Credit Cards
    Route::get('credit-cards/list/{type}',                          'CreditCardsController@index');
    Route::post('credit-cards/list/{type}',                         'CreditCardsController@index');
    Route::post('credit-cards/list/ajax/{type}',                    'CreditCardsController@listingAjax');
    Route::get('credit-cards/list/ajax/{type}',                     'CreditCardsController@listingAjax');
    Route::post('credit-cards/sequence',                            'CreditCardsController@creditCardsSequence');
    Route::get('credit-cards/edit/{id}/{type}',                     'CreditCardsController@creditCardFind');
    Route::get('credit-cards/delete/{id}/{type}',                   'CreditCardsController@creditCardsAction');
});

// Routes After Logged in and Role Restaurant Check
Route::group(['middleware' => ['logged', 'role:restaurant']], function() {
    Route::get('notification/addresses',                            'NotificationAddressesController@index');
    Route::post('notification/addresses',                           'NotificationAddressesController@index');
    Route::post('notification/addresses/ajax/list',                 'NotificationAddressesController@listingAjax');
    Route::post('notification/addresses/sequence',                  'NotificationAddressesController@addressesSequence');
    Route::get('notification/addresses/edit/{id}',                  'NotificationAddressesController@ajaxEditAddressForm');
    Route::get('notification/addresses/delete/{id}',                'NotificationAddressesController@deleteAddresses')->where('id', '[0-9]+');
    Route::get('notification/addresses/default/{id}',               'NotificationAddressesController@defaultAddresses')->where('id', '[0-9]+');

    Route::post("restaurant/enable",                                'RestaurantController@enable');
    Route::resource('restaurant/menu-manager',                      'RestaurantController@menuManager');
    Route::get('restaurant/deletemenuimage/{id}',                   'RestaurantController@deletemenuimage');
    Route::get('restaurant/bringonline',                            'RestaurantController@bringonline');
});

// Routes After Logged in and Role Admin Check
Route::group(['middleware' => ['logged', 'role:super']], function() {
    Route::get('users/list',                                        'UsersController@index');
    Route::post('users/list/ajax',                                  'UsersController@listingAjax');
    Route::get('users/edit/{id}',                                   'UsersController@ajaxEditUserForm');
    Route::post('users/update',                                     'UsersController@userUpdate');
    Route::get('users/action/{type}/{id}',                          'UsersController@usersAction');
    Route::post('users/action/{type}/{id}',                         'UsersController@usersAction');

    Route::get('restaurant/list',                                   'RestaurantController@index');
    Route::post('restaurant/list/ajax',                             'RestaurantController@listingAjax');
    Route::get('restaurant/list/delete/{id}',                       'RestaurantController@restaurantDelete')->where('id', '[0-9]+');
    Route::post('restaurant/list/delete/{id}',                      'RestaurantController@restaurantDelete')->where('id', '[0-9]+');
    Route::get('restaurant/list/status/{id}',                       'RestaurantController@restaurantStatus')->where('id', '[0-9]+');
    Route::get('restaurant/orders/history/{id}',                    'OrdersController@history')->where('id', '[0-9]+');
    Route::resource('restaurant/add/new',                           'RestaurantController@addRestaurants');
    
    //Event Logs
    Route::get('eventlogs/list',                                    'EventLogsController@index');
    Route::post('eventlogs/list/ajax',                              'EventLogsController@listingAjax');
    
    //Subscribers List
    Route::get('subscribers/list',                                  'SubscribersController@index');
    Route::post('subscribers/list/ajax',                            'SubscribersController@listingAjax');
    Route::post('subscribers/send',                                 'SubscribersController@send');
    
    Route::resource('restaurant/newsletter',                        'AdministratorController@newsletter');
});

Route::resource('user/reviews',                                     'UserReviewsController@index');
Route::post('user/reviews/list/ajax',                               'UserReviewsController@listingAjax');
Route::get('user/reviews/action/{id}',                              'UserReviewsController@reviewAction');
Route::post('user/reviews/action/{id}',                             'UserReviewsController@reviewAction');
Route::get('user/reviews/edit/{id}',                                'UserReviewsController@ajaxEditUserReviewForm');

Route::get('restaurant/list',                                       'RestaurantController@index');
Route::post('restaurant/list/ajax',                                 'RestaurantController@listingAjax');

Route::get('user/uploads',                                          'UsersController@uploads');
Route::get('user/uploads/{UserID}',                                 'UsersController@uploads');
Route::post('user/uploads/ajax/{UserID}',                           'UsersController@uploadsajax');

Route::get('restaurant/menu_form/{id}',                             'RestaurantController@menu_form');
Route::get('restaurant/menu_form/{id}/{rid}',                       'RestaurantController@menu_form');
Route::get('restaurant/additional',                                 'RestaurantController@additional');
Route::get('restaurant/alladdons/{resid}',                          'RestaurantController@alladdons');
Route::get('restaurant/loadPrevious/{addonid}',                     'RestaurantController@loadPrevious');
Route::get('restaurant/uploadimg',                                  'RestaurantController@uploadimg');
Route::post('restaurant/uploadimg',                                 'RestaurantController@uploadimg');
Route::post('restaurant/uploadimg/{type}',                          'RestaurantController@uploadimg')->where('type', '[a-z]+');
Route::post('restaurant/menuadd',                                   'RestaurantController@menuadd');
Route::get('restaurant/menuadd',                                    'RestaurantController@menuadd');

Route::post('restaurant/menuCatSort',                               'RestaurantController@menuCatSort');
Route::get('restaurant/menuCatSort',                                'RestaurantController@menuCatSort');

Route::post('restaurant/menuOrderSort',                             'RestaurantController@menuOrderSort');
Route::get('restaurant/menuOrderSort',                              'RestaurantController@menuOrderSort');

Route::post('restaurant/check_enable/{id}/{cat}/{limit}/{status}',  'RestaurantController@check_enable');
Route::get('restaurant/check_enable/{id}/{cat}/{limit}/{status}',   'RestaurantController@check_enable');
Route::get('restaurant/orderCat/{id}/{sort}',                       'RestaurantController@orderCat');
Route::post('restaurant/orderCat/{id}/{sort}',                      'RestaurantController@orderCat');

Route::get('restaurant/orderCat2/{id}/{sort}',                       'RestaurantController@orderCat2');
Route::post('restaurant/orderCat2/{id}/{sort}',                      'RestaurantController@orderCat2');

Route::get('restaurant/deleteMenu',                                 'RestaurantController@deleteMenu');
Route::post('restaurant/deleteMenu',                                'RestaurantController@deleteMenu');

Route::get('restaurant/red/{path}',                                 'RestaurantController@red');

Route::get('restaurant/redfront/{path}/{slug}/{path2}',             'RestaurantController@redfront');
Route::get('restaurant/redfront/{path}/{slug}/{path2}/{query}',     'RestaurantController@redfront');
Route::get('restaurant/loadChild/{id}/{flag}',                      'RestaurantController@loadChild');
Route::get('restaurant/saveCat',                                    'RestaurantController@saveCat');
Route::post('restaurant/saveCat',                                   'RestaurantController@saveCat');

Route::post('restaurant/cities',                                    'RestaurantController@cities');

Route::post('reviews/users/get',                                    'UserReviewsController@ajaxGetReviewUsersList');

Route::post('user/ajax_register',                                   'UsersController@ajax_register');
Route::resource('user/json_data',                                   'UsersController@json_data');

Route::any('admin/(:any)/add/(:any?)', function($controller, $params = null) {
    return Controller::call('admin.' . $controller . '@edit', (array) $params);
});