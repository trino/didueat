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
Route::resource('dashboard', 'Dashboard\AdministratorController@dashboard');
Route::get('user/info', 'Dashboard\AdministratorController@dashboard');
Route::get('restaurant/users', 'Dashboard\AdministratorController@users');
Route::get('restaurant/restaurants', 'Dashboard\AdministratorController@restaurants');
Route::get('restaurant/newsletter', 'Dashboard\AdministratorController@newsletter');

Route::resource('restaurant/info', 'Dashboard\RestaurantController@restaurantInfo');
Route::get('restaurant/addresses', 'Dashboard\RestaurantController@addresses');
Route::resource('restaurant/menus-manager', 'Dashboard\RestaurantController@menuManager');
Route::get('restaurant/orders/pending', 'Dashboard\RestaurantController@pendingOrders');
Route::get('restaurant/orders/history', 'Dashboard\RestaurantController@historyOrders');
Route::get('restaurant/eventlog', 'Dashboard\RestaurantController@eventsLog');
Route::get('restaurant/report', 'Dashboard\RestaurantController@report');

Route::resource('user/addresses', 'Dashboard\UsersController@addresses');
Route::get('user/uploadmeal', 'Dashboard\UsersController@uploadMeal');
Route::resource('user/images', 'Dashboard\UsersController@images');
Route::get('user/orders', 'Dashboard\UsersController@viewOrders');