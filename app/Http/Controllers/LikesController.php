<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Follows;
use App\Likes;
use App\Posted_photos;


class LikesController extends Controller
{
   public function likes_get($id){
       $likes_user_data = $this->likes_data($id);
     

    return $likes_user_data;
   }
   public function likes_post(){

   }
   private function likes_data($input_id){//photo_idからいいねした各ユーザ(引数:photo_id)
    $likes_user_data = [];
    $id_exists = Posted_photos::where('photo_id',$input_id)->exists($likes_user_data);
    if($id_exists != 1)exit;
    $likes_id_exists = Likes::where('photo_id',$input_id)->exists($likes_user_data);
    if($likes_id_exists != 1)exit;
    $input_id_arr= Likes::where('photo_id',$input_id)->where('flg',1)->pluck('user_id');
    
    foreach($input_id_arr as $key => $val){
        $likes_user_exists = User::where('id',$val)->value('flg');//userのflgが0or1
        if($likes_user_exists != 1)break;
        $likes_user_data[$key] = User::find($val,
        array(
            'id',
            'user_id',
            'user_name',
            'si_text',
            'icon_path',
        ));       
    }
    return $likes_user_data;
   }
   public static function likes_allocation($data){
    $likes_cnt = 0;
    $likes_cnt = LikesController::likes_count($data);
    $user_inner_id = User::where('user_id',session()->get('user_id'))->value('id');
    $input_exists = Likes::where('photo_id', $data)->exists();
    if($input_exists == 1){
        $like_id = Likes::where('photo_id',$data)->value('id');
        $principal_like = Likes::where('photo_id',$data)->where('user_id',$user_inner_id)->exists();
     if($principal_like == 1){//本人が一度でもいいねしていたら
        $likes_flg_chk = Likes::where('photo_id',$data)->where('user_id',$user_inner_id)->value('flg');
        if($likes_flg_chk == 1){
        $like_stauts = 1;
        }else{
        $like_stauts = 0;
        }
     }else{
        $like_stauts = 0;
     }
    }else{
        $like_stauts =0;
        $like_id = null;
    }
        return array("like_stauts"=>$like_stauts,"like_id"=>$like_id,'likes_cnt'=>$likes_cnt);
   }
   public static function likes_registration($photo_id,$like_stauts){//いいね押したら
    $likes_cnt = 0;
    $likes_cnt = LikesController::likes_count($photo_id);
    $user_inner_id = User::where('user_id',session()->get('user_id'))->value('id');
    $input_exists = Likes::where('photo_id', $photo_id)->exists();
    $principal_like = Likes::where('photo_id',$photo_id)->where('user_id',$user_inner_id)->exists();//LikeDBにあるか
       if($like_stauts == 0){
           if($input_exists ==1 && $principal_like == 1){//LikeDBにあれば
            $likes_id = Likes::where('photo_id',$photo_id)->where('user_id',$user_inner_id)->value('id');
            $new_likes =Likes::findOrFail($likes_id);
            $new_likes->flg = 1;
            $new_likes->save();
           }else{
        //*新規いいねをDBに保存
        $new_likes = new Likes;
        $new_likes->user_id = $user_inner_id;
        $new_likes->photo_id = $photo_id;
        $new_likes->flg = 1;
        $new_likes->save();
           }
        $like_stauts = 1;
       }else{
           //*like_stauts = 1(いいねがされていたら)必然的にDBにデータが存在する
            $likes_id = Likes::where('photo_id',$photo_id)->where('user_id',$user_inner_id)->value('id');
            $change_likes_flg = Likes::where('id',$likes_id)->first();
            $change_likes_flg->flg =0;
            $change_likes_flg->save();
            $like_stauts = 0;
           
       }
       //*like_stauts:DB,Likesのflgと同じ意味(自分からしていいねしているかどうか)
    return array('photo_id'=>$photo_id,'like_stauts'=>$like_stauts,'likes_cnt'=>$likes_cnt);
   }

   private static function likes_count($photo_id){
            $likes_cnt = Likes::where('photo_id',$photo_id)->where('flg',1)->count();
            return $likes_cnt;
   }
   

    
}
