<?php
/*
管理者用のコントローラー
*/


namespace App\Http\Controllers;

use Illuminate\Http\Request;

//モデルAdminに問い合わせ
use App\Admin;
use App\User;

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
        $items2 = User::get(); 
        $sample2 = Admin::sample();
        $sample3 ="HELLo";
        $sample_arrary =  compact('sample2','sample3','items','items2');
        return view('admin/admin_top',$sample_arrary);
    }
    // 管理者一覧のビュー
    public function index() 
    {
        return view('admindb'); 
    }
    
 
}
