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
       

        //サンプルです。ゆうたの権限を1にする
        Admin::where('id', 1)
        ->update(['admin_authority' => 1]);
        return view('admin/admin_login',$sample_array);
    }

    public function admin_login_data(){
       
        $data = json_decode(file_get_contents("php://input"), true); 
        $task_= $data['params']; 

        //サンプルです。ゆうたの権限を3にする
        Admin::where('id', 1)
        ->update(['admin_authority' => 3]);
        
       
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
