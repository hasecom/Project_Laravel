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
        $sample2 = "aa";
        $sample3 =10;
        $sample_array = ['sample2'=>$sample2,'sample3'=>$sample3];
        return view('admin/admin_login',$sample_array);
    }

    public function admin_login_data(){
       
        $data = json_decode(file_get_contents("php://input"), true); 
        $task= $data['params']; 
        $sample2 = "aa";
        $sample3 =10;
        $task_ = ['sample2'=>$sample2,'sample3'=>$sample3];
        return $task;
    }


    //admin_top-Adminトップページ
    public function admin_top()
    {
        //viewへの受け渡し
        $items = Admin::get(); 
        $items2 = User::get(); 
        $sample2 = Admin::sample();
        $sample3 =10;
        $sample_array = ['sample2'=>$sample2,'sample3'=>$sample3,'items'=>$items,'items2'=>$items2];
        return view('admin/admin_top',$sample_array);
    }
    // 管理者一覧のビュー
    public function index() 
    {
        return view('admindb'); 
    }
   
    
 
}
