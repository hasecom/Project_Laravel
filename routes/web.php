<?php
////<<<<<<< HEAD
use App\admin;
////=======
/*
TODO: AdminとUser用のコントローラー作成
TODO: return viewを各コントローラーで行うように変更


Admin用のコントローラー作成完了
(app/http/Controllers/AdminsController.php)

*/
////>>>>>>> 88e86441e505b10194e03e663a6071fa5e39aba8
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
Route::get('/admin', 'AdminsController@admin_top');

//管理者用ログインページ
Route::get('/admin', 'AdminsController@admin_attempt');


Route::get('admindb', 'AdminsController@index');
Route::get('ajax/admindb', 'Ajax\AdminController@index');


//フロントページ
Route::get('/', function () {
    return view('
    user/front');
});

//ユーザログインページ
Route::get('/login', function () {
    return view('user/login');
});

//ユーザー新規作成ページ
Route::get('/sign_up', function () {
    return view('user/sign_up');
});

//ユーザートップページ
Route::get('/user', function () {
    return view('user/top');
});




