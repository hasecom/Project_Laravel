<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Follows;
use App\Http\Controllers\UsersController;

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
            $mylogin_data = new UsersController;
            $mylogin_data->account_data();
            $user_data['my_data'] = $mylogin_data->account_data();

            $user_data["user_info"] = $user_info;//user_data配列に加える
            $user_follow = $this->utf_chg(Follows::where('user_id',$user_inner)->select('followed_id')->get());
            for($i = 0; $i < count($user_follow); $i++){//フォロワーのデータ取得、送信
                foreach($user_follow[$i] as $key =>$val){
                    $add_user_id = $this->utf_chg(User::find($val,
                    array(
                        'user_id',
                        'user_name',
                        'si_text',
                        'icon_path'
                    )));
                    $user_data["follows"][$i] = $add_user_id;
                }
            }  
          
          
            return $user_data;
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
