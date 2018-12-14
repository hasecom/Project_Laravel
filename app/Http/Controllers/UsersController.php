<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    protected $status = false;//sessionでユーザ情報があるかないか、false=ない

/*====================================================================
Userのフロント画面
======================================================================*/
    /*=UserフロントGET=*/
    public function user_front() {
        return view('user/front');
    }
/*====================================================================
Userのログイン画面
======================================================================*/
    /*=UserログインGET=*/
    public function user_login() {
        return view('user/login');
    }
    /*=UserログインPOST=*/
    public function user_login_post(){
   
      if(isset($_POST['userid'])){
        $user_id_en = json_encode(['userid'=>$_POST['userid']]);
        $user_pass_en = json_encode(['userpassword'=>$_POST['userpassword']]);
        $user_id = json_decode($user_id_en,true);
        $user_pass = json_decode($user_pass_en,true);
      }
      if(isset($user_id_en)){//session記憶
        session()->put(['user_id' => $user_id['userid']]);
        session()->put(['user_pw' => $user_pass['userpassword']]);
   }

    }
/*====================================================================
Userの新規登録画面
======================================================================*/
    /*=User新規登録登録GET=*/
    public function sign_up() {
        return view('user/sign_up');
    }
/* ====================================================================
Userのトップ画面
======================================================================*/
    /*=Userトップ画面=*/
    public function user_top() { 
        $user_userid =session()->get('user_id');//入力idをsessionに登録
        $user_userpw = session()->get('user_pw');//入力pwをsessionに登録
/*
TODO:DBにアクセスして認証チェック
*/
   $db_user_id = User::pluck("user_id");

   foreach ($db_user_id as $val) {//db内のuser_idを回す
        if($val === $user_userid){//idがdb内のidと一致するか
         $user_pass = User::where('user_id',$user_userid)->value('user_pw');
          if($user_userpw === $user_pass){//dbのpwと入力されたpwが一致するか
            $user_inner = User::where('user_id',$user_userid)->value('id');//内部ID取得
            $user_info = User::find($user_inner);//主キーからfindでデータ取得
            echo $user_info;
        
            $this->status = true;//true=1(認証されたらtrue)
            $user_data = 
            [
            'user_info'=>$user_info,//ユーザ情報
            'user_status'=>$this->status//0は未ログイン
            ];
         return view('user/top',$user_data);
         }
     }
    }
    //認証が失敗したらログインページにリダイレクト
    return redirect()->route('login');
    }
}
