<?php
/*
管理者用のコントローラー

TODO:チャレンジレスポンス認証に変更させる
TODO:パスワードのハッシュ化
TODO:admin_login_data()内のPOSTされる値をhidden要素に変更させるvalueはcsrf_token
*/


namespace App\Http\Controllers;

use Illuminate\Http\Request;

//モデルAdminに問い合わせ
use App\Admin;
use App\User;




class AdminsController extends Controller
{
        protected $status = false;//sessionでユーザ情報があるかないか:false=ない


    //admin_attempt-Adminログイン画面
    public function admin_attempt()
    {
        return view('admin/admin_login');
    }
    /* 
    admin_login_dataはadminログインフォームからPOSTされたデータの処理
    データベースと比較する。
    POSTデータはadmin_login.vueより取得。
    エンコードしてデコードする。
    DBと比較して一致すればセッションに登録をする。
    */
    public function admin_login_data()
    {  
        if(isset($_POST['username'])){
        $user_name_en = json_encode(['username'=>$_POST['username']]);
        $user_pass_en = json_encode(['userpassword'=>$_POST['userpassword']]);
        $user_name = json_decode($user_name_en,true);
        $user_pass = json_decode($user_pass_en,true);
     
        if(isset($user_name_en)){
        //サンプルです。
        // Admin::where('id', 2)
        // ->update(['admin_id' => $user_name['username']]);
         session()->put(['admin_id' => $user_name['username']]);
         session()->put(['admin_pw' => $user_pass['userpassword']]);
       
    }
    } 
}
    /*admin_top-Adminトップページ
    session()->get()でセッションデータを取得。
    admin_topに転送
    */
    public function admin_top()
    {
        //viewへの受け渡し
        $admin_info = Admin::get(); 
        $user_info = User::get(); 

        $admin_username =session()->get('admin_id');//入力idをsessionに登録
        $admin_userpw = session()->get('admin_pw');//入力pwをsessionに登録
       
        $db_admin_id = Admin::pluck("admin_id"); 
        foreach ($db_admin_id as $val) {//db内のadmin_idを回す
            if($val === $admin_username){//idがdb内のidと一致するか
                $admin_pass = Admin::where('admin_id',$admin_username)->value('admin_pw');
               if($admin_userpw === $admin_pass){//dbのpwと入力されたpwが一致するか
                    $this->status = true;//true=1(認証されたらtrue)
      
        $sample2 = Admin::sample();
        $sample_array = ['sample2'=>$sample2,
                        'admin_info'=>$admin_info,
                        'user_info'=>$user_info,
                        'login_user_id'=>$admin_username,
                        'admin_status'=>$this->status//0は未ログイン
                    ];
        //認証が成功したらトップページに移動
        return view('admin/admin_top',$sample_array);
    }
} 
}
//認証が失敗したらログインページにリダイレクト
      return redirect()->route('admin_login');
    }
    // 管理者一覧のビュー
    public function index() 
    {
        return view('admindb'); 
    }
   
    
 
}
