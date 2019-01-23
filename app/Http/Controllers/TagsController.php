<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tags;
use App\User;
class TagsController extends Controller
{
    public function tags_list_get($word){
       $user_data = $this->tags_user($word);
      $tags_words_data = $this->tags_word($word);
     
      return array($tags_words_data,$user_data);
    }
    public function tags_list_post(){

    }
    private function tags_word($val){
        $users = Tags::where('tag_name', 'like', $val.'%')->get();
            return $users;
    }
    private function tags_user($val){
        $user_id =[];
        $user_name = [];
        $id_box = [];
        $user_info = [];
        $user_id_ex = User::where('user_id',  $val)->exists();
        $user_name_ex = User::where('user_name',  $val)->exists();
        if($user_id_ex == true){
        $is_exist_id = User::where('user_id',$val)->exists();
        if($is_exist_id != true)exit;
        $user_id = $this->utf_chg(User::where('user_id',  $val)->pluck('id'));
        }
        if($user_name_ex == true){
        $is_exist_name = User::where('user_id',$val)->exists();
        if($is_exist_name != true)exit;
        $user_name = $this->utf_chg(User::where('user_name',$val)->pluck('id'));
        }
        $id_box= array_unique(array_merge($user_id, $user_name));//idとnameの検索かつ重複削除
        foreach($id_box as $key => $id){
        $user_info[$key] = $this->utf_chg(User::find($id,
        array(
            'id',
            'user_id',
            'user_name',
            'si_text',
            'icon_path'
        )));
      
        }
        return $user_info;
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
