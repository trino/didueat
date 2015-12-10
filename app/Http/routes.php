<?php
//initialize("routes");

// Frontsite Routes...
Route::get('/',                                     'HomeController@index');
Route::get('/ajax',                                 'HomeController@ajax');
Route::post('/ajax',                                'HomeController@ajax');
Route::get('/contactus',                            'HomeController@contactus');
Route::get('/restaurants',                          'HomeController@allRestaurants');

Route::get('/search/restaurants/{term}',            'HomeController@searchRestaurants');
Route::post('/search/restaurants/ajax',             'HomeController@searchRestaurantsAjax');
Route::resource('/restaurants/signup',              'HomeController@signupRestaurants');
Route::resource('/restaurants/loadmenus/{catid}/{resid}/', 'HomeController@loadmenus');
Route::get('/restaurants/menu/stats/{id}',          'HomeController@countStatus');
Route::get('/restaurants/{slug}/menus',             'HomeController@menusRestaurants');
Route::get('/search/menus/{term}',                  'HomeController@searchMenus');
Route::post('/search/menus/ajax',                   'HomeController@searchMenusAjax');
Route::post('/uploadimg/{type}',                    'HomeController@uploadimg')->where('type','[a-z]+');
Route::post('/newsletter/subscribe',                'HomeController@newsletterSubscribe');
Route::post('/rating/save',                         'HomeController@ratingSave');

//Authentication routes...
Route::post('auth/login/ajax',                      'Auth\AuthController@authenticateAjax');
//Route::get('auth/login',                            'Auth\AuthController@getLogin');
//Route::post('auth/login',                           'Auth\AuthController@authenticate');
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
Route::post('auth/validate/email/ajax',             'Auth\AuthController@postAjaxValidateEmail');

// Routes After Logged in Check
Route::group(['middleware' => ['logged']], function(){
	Route::resource('dashboard',                        'AdministratorController@dashboard');
	Route::get('restaurant/orders/{type}',              'RestaurantController@orderslist')->where('slug', '[a-z]+');
	Route::get('restaurant/orders/order_detail/{id}',   'RestaurantController@order_detail')->where('id', '[0-9]+');
	Route::get('restaurant/report',                     'RestaurantController@report');
	Route::resource('user/addresses',                   'UsersController@addresses');
    Route::get('user/addresses/edit/{id}',              'UsersController@addressesUpdate');
	Route::get('user/addresses/delete/{id}',            'UsersController@addressesDelete')->where('id', '[0-9]+');
	Route::get('user/info',                             'AdministratorController@dashboard');
	Route::resource('user/images',                      'UsersController@images');
	Route::resource('restaurant/info',                  'RestaurantController@restaurantInfo');
});

// Routes After Logged in and Role Restaurant Check
Route::group(['middleware' => ['logged', 'role:restaurant']], function()
{
	Route::get('restaurant/orders/list',                'RestaurantController@pendingOrders');
	Route::get('restaurant/orders/view/{id}',           'RestaurantController@viewOrder')->where('id', '[0-9]+');
	Route::post('restaurant/orders/list/cancel',        'RestaurantController@changeOrderCancel');
	Route::post('restaurant/orders/list/approve',       'RestaurantController@changeOrderApprove');
	Route::post('restaurant/orders/list/disapprove',    'RestaurantController@changeOrderDisapprove');
	Route::get('restaurant/orders/list/delete/{id}',    'RestaurantController@deleteOrder')->where('id', '[0-9]+');

	Route::resource('restaurant/addresses',             'RestaurantController@addresses');
	Route::get('restaurant/addresses/edit/{id}',        'RestaurantController@ajaxEditAddressForm');
	Route::get('restaurant/addresses/delete/{id}',      'RestaurantController@deleteAddresses')->where('id', '[0-9]+');
	Route::get('restaurant/addresses/default/{id}',     'RestaurantController@defaultAddresses')->where('id', '[0-9]+');

	Route::resource('restaurant/menus-manager',         'RestaurantController@menuManager');
});

// Routes After Logged in and Role Admin Check
Route::group(['middleware' => ['logged', 'role:super']], function(){
	Route::resource('restaurant/users',                 'AdministratorController@users');
	Route::get('restaurant/users/edit/{id}',            'AdministratorController@ajaxEditUserForm');
	Route::post('restaurant/users/update',              'AdministratorController@userUpdate');
	Route::get('restaurant/users/action/{type}/{id}',   'AdministratorController@usersAction');

	Route::get('restaurant/list',                       'RestaurantController@restaurants');
	Route::get('restaurant/list/delete/{id}',           'RestaurantController@restaurantDelete')->where('id', '[0-9]+');
	Route::get('restaurant/list/status/{id}',           'RestaurantController@restaurantStatus')->where('id', '[0-9]+');
	Route::resource('restaurant/add/new',               'RestaurantController@addRestaurants');
	Route::get('restaurant/orders/history/{id}',        'RestaurantController@history')->where('id', '[0-9]+');

	Route::get('restaurant/eventlog',                   'RestaurantController@eventsLog');
	Route::resource('restaurant/newsletter',            'AdministratorController@newsletter');
	Route::resource('restaurant/subscribers',           'AdministratorController@subscribers');

	Route::resource('user/reviews',                   	'UsersController@reviews');
	Route::get('user/reviews/action',             		'UsersController@reviewAction');
	Route::get('user/reviews/edit/{id}',            	'UsersController@ajaxEditUserReviewForm');
	//Credit Cards
    Route::resource('users/credit-cards',                 'AdministratorController@creditCardsList');
	Route::get('users/credit-cards/action/{id}',   		  'AdministratorController@creditCardsAction');
	Route::get('users/credit-cards/edit/{id}',            'AdministratorController@ajaxEditCreditCardFrom');
});

Route::get('restaurant/menu_form/{id}',             'RestaurantController@menu_form');
Route::get('restaurant/menu_form/{id}/{rid}',       'RestaurantController@menu_form');
Route::get('restaurant/additional',                 'RestaurantController@additional');
Route::get('restaurant/uploadimg',                  'RestaurantController@uploadimg');
Route::post('restaurant/uploadimg',                 'RestaurantController@uploadimg');
Route::post('restaurant/uploadimg/{type}',          'RestaurantController@uploadimg')->where('type','[a-z]+');
Route::post('restaurant/menuadd',                   'RestaurantController@menuadd');
Route::get('restaurant/menuadd',                    'RestaurantController@menuadd');
Route::get('restaurant/orderCat',                   'RestaurantController@orderCat');
Route::post('restaurant/orderCat/{id}/{sort}',      'RestaurantController@orderCat');
Route::get('restaurant/deleteMenu/{id}',            'RestaurantController@deleteMenu');
Route::get('restaurant/deleteMenu/{id}/{slug}',     'RestaurantController@deleteMenu');
Route::get('restaurant/red/{path}',                 'RestaurantController@red');

Route::get('restaurant/redfront/{path}/{slug}/{path2}', 'RestaurantController@redfront');
Route::get('restaurant/loadChild/{id}/{flag}',      'RestaurantController@loadChild');
Route::get('restaurant/saveCat',                    'RestaurantController@saveCat');
Route::post('restaurant/saveCat',                   'RestaurantController@saveCat');
Route::get('restaurant/getToken',                   'HomeController@getToken');

Route::post('user/ajax_register',                   'UsersController@ajax_register');
Route::resource('user/json_data',                   'UsersController@json_data');

Route::any('admin/(:any)/add/(:any?)', function($controller,$params=null) {
    return Controller::call('admin.'.$controller.'@edit', (array) $params);
});