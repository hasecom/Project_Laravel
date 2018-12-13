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
         var_dump($user_id);
      }
      if(isset($user_id_en)){//session記憶
        session()->put(['user_id' => $user_id['userid']]);
        session()->put(['user_pw' => $user_pass['userpassword']]);
   }
   //TODO:DBにアクセスして認証チェック
    }
/*====================================================================
Userの新規登録画面
======================================================================*/
    /*=User新規登録登録GET=*/
    public function sign_up() {
        return view('user/sign_up');
    }
/*====================================================================
Userのトップ画面
======================================================================*/
    /*=Userトップ画面=*/
    public function user_top() { 
        $user_data = 
        [
            'user_status'=>$this->status//0は未ログイン
        ];
        return view('user/top');
    }
    
    
}
