<?php

namespace App\Http\Controllers;

use App\User;
use App\Posted_photos;
use App\Point;
use Illuminate\Http\Request;

class Point_Controller extends Controller
{
    //
    public function point_get(){

    }
    public function point_post(){
        $user_id = $_POST['user_id'];//買うユーザのid(ログインユーザ)
        $photo_id = $_POST['photo_id'];//買われる画像のid
        $covered_user_id = $_POST['covered_id'];//買われる画像のユーザのid
        $exists_user = User::where('id',$user_id)->exists();
        if($exists_user != 1)exit('error');
        $session_exists_user = User::where('user_id',session()->get('user_id'))->exists();
        if($session_exists_user != 1)exit('0');
        $session_user_id = User::where('user_id',session()->get('user_id'))->value('id');
        if($user_id != $session_user_id)exit('0');
        $exists_photo = Posted_photos::where('photo_id',$photo_id)->exists();
        if($exists_photo != 1)exit('0');
        if(Posted_photos::where('photo_id',$photo_id)->value('user_id') != $covered_user_id)exit('0');
      
        $photo_price = Posted_photos::where('photo_id',$photo_id)->value('photo_price');
        //ユーザのポイントが購入する写真より多いか？
        $user_now_point = User::where('id',$user_id)->value('point');
        if($user_now_point < $photo_price)exit('1');

          //*購入保存
          $new_point = new Point;
          $new_point->user_id = $user_id;
          $new_point->photo_id = $photo_id;
          $new_point->price = $photo_price;
          $new_point->charge_point = -($photo_price);
          $new_point->save();
        //*購入された方
          $covered_new_point = new Point;
          $covered_new_point->user_id = $covered_user_id;
          $covered_new_point->photo_id = $photo_id;
          $covered_new_point->price = $photo_price;
          $covered_new_point->charge_point = $photo_price;
          $covered_new_point->save();

       //よくわからんからユーザのPOINTはここで操作
       //購入する方
       $user_point = User::where('id', $user_id)->first();
       $user_point->point = $user_now_point - $photo_price;
       $user_point->save();

       //売る方
       $cover_now_point = User::where('id',$covered_user_id)->value('point');
       $covered_user_point = User::where('id', $covered_user_id)->first();
       $covered_user_point->point = $cover_now_point + $photo_price;
       $covered_user_point->save();
       
        //*戻り値0=>不正なエラー、1=>お金が足りない、

        return 2;
    }
}
