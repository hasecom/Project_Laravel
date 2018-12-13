<?php

use App\admin;

/*
TODO: AdminとUser用のコントローラー作成
TODO: return viewを各コントローラーで行うように変更


Admin用のコントローラー作成完了
(app/http/Controllers/AdminsController.php)

*/

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


//管理者用トップページ
Route::get('/admin_top', 'AdminsController@admin_top');
Route::post('/admin_top', 'AdminsController@admin_top_post');

//管理者用ログインページ
Route::get('/admin', 'AdminsController@admin_attempt')->name('admin_login');
Route::post('/admin', 'AdminsController@admin_login_data');



Route::get('/admindb', 'AdminsController@index');
Route::get('/ajax/admindb', 'Ajax\AdminController@index');


//フロントページ
Route::get('/', 'UsersController@user_front');

//ユーザログインページ
Route::get('/login', 'UsersController@user_login');
Route::post('/login', 'AdminsController@user_login_post');

//ユーザー新規作成ページ
Route::get('/sign_up', 'UsersController@sign_up');

//ユーザートップページ
Route::get('/user', 'UsersController@user_top');







