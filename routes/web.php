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

Route::get('/', function () {
    return redirect()->route('login');
//    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::resource('users', 'UsersController');
Route::get('roles/{role}/auth', 'RolesController@getRoleAuth')->name('roles.getRoleAuth'); // 查看角色拥有的权限
Route::post('roles/{role}/auth', 'RolesController@roleAuth')->name('roles.roleAuth'); // 为角色授权
Route::resource('roles', 'RolesController');
Route::resource('permissions', 'PermissionsController');

// Menu
Route::resource('menus', 'MenusController', ['only' => ['index', 'update']]);

// laravel logs
Route::get('logs', 'LogController@index');

// 操作日志
Route::resource('operations', 'OperationController');

// 上传图片
Route::post('upload_image', 'UploadFileController@uploadImage')->name('uploadFile.upload_image');
Route::post('delete_image', 'UploadFileController@deleteImage')->name('uploadFile.delete_image');
