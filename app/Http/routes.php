<?php

// Frontsite Routes...
Route::get('/', 'HomeController@index');
Route::get('/restaurants', 'HomeController@allRestaurants');
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