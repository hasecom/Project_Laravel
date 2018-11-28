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
    return view('welcome');
});

//管理者用トップページ
Route::get('/admin_top', function () {
    return view('admin/admin_top');
});
//管理者用ログインページ
Route::get('/admin', function () {
    return view('admin/admin_login');
});

//ユーザログインページ
Route::get('/login', function () {
    return view('user/login');
});

//ユーザー新規作成ページ
Route::get('/sign_up', function () {
    return view('user/sign_up');
});




