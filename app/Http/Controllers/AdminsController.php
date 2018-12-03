<?php
/*
管理者用のコントローラー

TODO: Web.phpからルートの移行
TODO: DB設定

h-ゆうたの作成したAdminControllerを
AdminsControllerに統合
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
        //viewへの受け渡し
        $sample2 ="sampleです";
        return view('admin/admin_top', compact('sample2'));
    }
    // 管理者一覧のビュー
    public function index() 
    {
        return view('admindb'); 
    }
    
 
}
