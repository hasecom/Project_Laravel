<?php
/*
管理者用のコントローラー

TODO: Web.phpからルートの移行
TODO: DB設定
*/


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminsController extends Controller
{
    //admin_attempt-Adminログイン画面
    public function admin_attempt()
    {
        return view('admin/admin_login');
    }
    //admin_top-Adminトップページ
    public function admin_top()
    {
        return view('admin/admin_top');
    }
    
 
}
