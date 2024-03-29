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

/*====================================================================
Adminログイン画面
======================================================================*/
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
     
        if(isset($user_name_en)){//session記憶
         session()->put(['admin_id' => $user_name['username']]);
         session()->put(['admin_pw' => $user_pass['userpassword']]);
    }
    }else if(isset($_POST['status'])){//session削除
        session()->forget('admin_id');
        session()->forget('admin_pw');

    }
}
/*====================================================================
Adminトップページ
======================================================================*/
    /*
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
    //?内部IDの削除枠がとぶ？正常？どっちがいい？

        public function admin_top_post(Request $request){
            //admin_topからのpostデータ(新規登録&ユーザ変更処理)
            if(isset($_POST['sign_up_id'])){//TODO:あとでhiddenに変更とーくん
                
                $signup_id_en = json_encode(['admin_id'=>$_POST['sign_up_id']]);
                $signup_pw_en = json_encode(['sign_up_pw'=>$_POST['sign_up_pw']]);
                $signup_authority_en = json_encode(['sign_up_authority'=>$_POST['sign_up_authority']]);
               
                $signup_id = json_decode($signup_id_en,true);
                $signup_pw = json_decode($signup_pw_en,true);
                $signup_authority = json_decode($signup_authority_en,true);
          //新規登録save       
        $sign_up_admin = new Admin;
        $sign_up_admin->admin_id = $signup_id['admin_id'];
        $sign_up_admin->admin_pw = $signup_pw['sign_up_pw'];
        $sign_up_admin->admin_authority = $signup_authority['sign_up_authority'];
        $sign_up_admin->save();
    
            }else if(isset($_POST['update_admin_id'])){
            //編集機能edit
            $inner_id = $_POST['admin_inner_id']; 
                    $edit_id = $_POST['update_admin_id'];
                    $edit_pw = $_POST['update_admin_pw'];
                    $edit_authority = $_POST['update_admin_authority'];
                  
                     $edit_admin = Admin::findOrFail($inner_id);
                     $edit_admin->admin_id =$edit_id;
                     $edit_admin->admin_pw =$edit_pw;
                     $edit_admin->admin_authority = $edit_authority;                     
                    $edit_admin->save();
    
            }else{
                //削除機能delete TODO:エラー時の分岐処理など
                    $delete_id = $_POST['admin_inner_id'];
                    $delete_admin = Admin::findOrFail($delete_id);
                    $delete_admin->delete();
                }
}
/*====================================================================
管理者一覧のビュー
======================================================================*/
public function index() 
    {
        return view('admindb'); 
    }
   
    
 
}
