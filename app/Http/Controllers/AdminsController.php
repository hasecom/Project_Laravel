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

//モデルAdminに問い合わせ
use App\Admin;

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
        $items = Admin::get(); 
        $sample2 ="sampleですよおおおおおおおおお!!!!!!!!!!!!!!!!";
        $sample3 ="HELLo";
        $sample_arrary =  compact('sample2','sample3','items');
        return view('admin/admin_top',$sample_arrary);
    }
    // 管理者一覧のビュー
    public function index() 
    {
        return view('admindb'); 
    }
    
 
}
