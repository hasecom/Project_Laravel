<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PublicUserController extends Controller
{
    public function public_user($id){

        //TODO:入力値が実行されないような処理を通す
        $user_exist = User::where('user_id',$id)->exists();
        if($user_exist == 1){//ユーザが存在するか
            $user_flag = User::where('user_id',$id)->value('flg');
          if($user_flag == 1){//ユーザフラグが1か
            $user_inner = User::where('user_id',$id)->value('id');//内部ID取得
            //*主キーからfindでデータ取得->クラス内のメソッド参照(obj->arr)
            $user_info = $this->utf_chg(User::find($user_inner,
            array(
                'id',
                'user_id',
                'user_name',
                'si_text',
                'icon_path'
            )));
            return $user_info;
          }
        }
    
    }
/* ====================================================================
使い回しメソッド
======================================================================*/
    //*Userモデルでオブジェクトを配列に変換させる
    public function utf_chg($uni_arr){
        $utf8_arr = array();
        $utf8_arr = User::de($uni_arr);
        return $utf8_arr;
    }
}
