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
各ユーザのマイページ
======================================================================*/
/*
TODO:{id}のマイページは_each_user_pageからaxiosで取得する為だけの箱のためいずれかはもっと複雑にするべき
TODO:個人情報は含まれないから大丈夫だけど
*/
Route::get('/api/user/{id}', 'PublicUserController@public_user');
Route::post('/api/user/{id}', 'PublicUserController@public_user_post');


/*====================================================================
ユーザー画面->画像投稿
======================================================================*/

Route::post('/user', 'ImagesController@image_post');

/*====================================================================
ユーザログインしてるか
======================================================================*/

Route::get('/api/users/chk', 'UsersController@account_chk_data');


/*====================================================================
投稿用のデータ送信用
======================================================================*/
/*

*/
Route::get('/api/user/post_data/{id}', 'ImagesController@post_data_get');
Route::post('/api/user/post_data/{id}', 'ImagesController@post_data_post');

/*====================================================================
タイムライン用データ送信用
======================================================================*/
/*

*/
Route::get('/api/user/post_data/timeline/data', 'TimeLineController@timeline_post_data_get');
Route::post('/api/user/post_data/timeline/data', 'TimeLineController@timeline_post_data_post');

/*====================================================================
いいねユーザ用データ送信用
======================================================================*/
/*

*/
Route::get('/api/user/post_data/timeline/likes_data/{id}', 'LikesController@likes_get');
Route::post('/api/user/post_data/timeline/likes_data/{id}', 'LikesController@likes_post');
