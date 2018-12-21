<?php

use App\admin;
use App\User;
use App\Temp_Uer;

/*TODO:ユーザートップページが各ユーザのIDになるように設置*/


/*====================================================================
管理者用トップページ
======================================================================*/

Route::get('/admin_top', 'AdminsController@admin_top');
Route::post('/admin_top', 'AdminsController@admin_top_post');

/*====================================================================
管理者用ログインページ
======================================================================*/

Route::get('/admin', 'AdminsController@admin_attempt')->name('admin_login');
Route::post('/admin', 'AdminsController@admin_login_data');



Route::get('/admindb', 'AdminsController@index');
Route::get('/ajax/admindb', 'Ajax\AdminController@index');


/*====================================================================
ユーザフロントページ
======================================================================*/

Route::get('/', 'UsersController@user_front');
// Route::post('/', 'UsersController@user_front_post');


/*====================================================================
ユーザログインページ
======================================================================*/

Route::get('/login', 'UsersController@user_login')->name('login');
Route::post('/login', 'UsersController@user_login_post');


/*====================================================================
ユーザー新規作成ページ
======================================================================*/

Route::get('/sign_up', 'UsersController@sign_up');
Route::post('/sign_up', 'UsersController@sign_up_post');


/*====================================================================
ユーザートップページ
======================================================================*/

Route::get('/user', 'UsersController@user_top');


/*====================================================================
ユーザー仮登録->本登録ページ
======================================================================*/

Route::get('/login_first', 'UsersController@main_registration');


/*====================================================================
ユーザー画面->画像投稿
======================================================================*/

Route::post('/user', 'ImagesController@image_post');



