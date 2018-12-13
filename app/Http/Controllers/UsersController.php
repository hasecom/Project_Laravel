<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    protected $status = false;//sessionでユーザ情報があるかないか:false=ない

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
    public function user_login_post(Request $requsest){
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
        return view('user/top');
    }
    
    
}
