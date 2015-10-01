<?php

// Frontsite Routes...
Route::get('/', 'HomeController@index');
Route::get('/restaurants', 'HomeController@allRestaurants');
Route::resource('/home/test', 'HomeController@test');
Route::resource('/restaurants/signup', 'HomeController@signupRestaurants');
Route::get('/restaurants/{slug}/menus', 'HomeController@menusRestaurants');

// Authentication routes...
Route::post('auth/login/ajax', 'Auth\AuthController@authenticateAjax');
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@authenticate');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/resend_email/{email}', 'Auth\AuthController@resendEmail');
Route::get('auth/verify_email/{email}', 'Auth\AuthController@verifyEmail');
Route::get('auth/forgot-passoword', 'Auth\AuthController@forgotPassword');
Route::post('auth/forgot-passoword', 'Auth\AuthController@postForgotPassword');

// Dashboard After Authentication routes...
Route::resource('dashboard', 'AdministratorController@dashboard');
Route::get('user/info', 'AdministratorController@dashboard');
Route::get('restaurant/users', 'AdministratorController@users');
Route::get('restaurant/restaurants', 'AdministratorController@restaurants');
Route::resource('restaurant/newsletter', 'AdministratorController@newsletter');

Route::resource('restaurant/info', 'RestaurantController@restaurantInfo');
Route::get('restaurant/addresses', 'RestaurantController@addresses');
Route::resource('restaurant/menus-manager', 'RestaurantController@menuManager');
Route::get('restaurant/orders/pending', 'RestaurantController@pendingOrders');
Route::get('restaurant/orders/history', 'RestaurantController@historyOrders');
Route::get('restaurant/eventlog', 'RestaurantController@eventsLog');
Route::get('restaurant/report', 'RestaurantController@report');
Route::get('restaurant/menu_form/{id}', 'RestaurantController@menu_form');
Route::get('restaurant/additional', 'RestaurantController@additional');

Route::resource('user/addresses', 'UsersController@addresses');
Route::get('user/uploadmeal', 'UsersController@uploadMeal');
Route::resource('user/images', 'UsersController@images');
Route::get('user/orders', 'UsersController@viewOrders');

Route::resource('restaurant/info', 'Dashboard\Restaurant\RestaurantController@restaurantInfo');
Route::get('restaurant/addresses', 'Dashboard\Restaurant\RestaurantController@addresses');
Route::resource('restaurant/menus-manager', 'Dashboard\Restaurant\RestaurantController@menuManager');
Route::get('restaurant/orders/pending', 'Dashboard\Restaurant\RestaurantController@pendingOrders');
Route::get('restaurant/orders/history', 'Dashboard\Restaurant\RestaurantController@historyOrders');
Route::get('restaurant/eventlog', 'Dashboard\Restaurant\RestaurantController@eventsLog');
Route::get('restaurant/report', 'Dashboard\Restaurant\RestaurantController@report');
Route::get('restaurant/menu_form/{id}', 'Dashboard\Restaurant\RestaurantController@menu_form');
Route::get('restaurant/additional', 'Dashboard\Restaurant\RestaurantController@additional');
Route::get('restaurant/uploadimg', 'Dashboard\Restaurant\RestaurantController@uploadimg');
Route::post('restaurant/uploadimg', 'Dashboard\Restaurant\RestaurantController@uploadimg');
Route::get('restaurant/getToken', 'Dashboard\Restaurant\RestaurantController@getToken');
Route::post('restaurant/menuadd', 'Dashboard\Restaurant\RestaurantController@menuadd');
Route::get('restaurant/menuadd', 'Dashboard\Restaurant\RestaurantController@menuadd');
Route::get('restaurant/orderCat', 'Dashboard\Restaurant\RestaurantController@orderCat');
Route::post('restaurant/orderCat', 'Dashboard\Restaurant\RestaurantController@orderCat');
Route::get('restaurant/deleteMenu/{id}', 'Dashboard\Restaurant\RestaurantController@deleteMenu');

Route::resource('user/addresses', 'Dashboard\User\UsersController@addresses');
Route::get('user/uploadmeal', 'Dashboard\User\UsersController@uploadMeal');
Route::resource('user/images', 'Dashboard\User\UsersController@images');
Route::get('user/orders', 'Dashboard\User\UsersController@viewOrders');
Route::post('user/ajax_register', 'Dashboard\User\UsersController@ajax_register');