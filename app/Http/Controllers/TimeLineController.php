<?php
/*
* タイムラインのコントローラー
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Posted_photos;
use App\Follows;
use App\User;




class TimeLineController extends Controller{
    public function timeline_post_data_get(){
       
        $timeline_data = [];
        $post_count = 0;
         $user_id = session()->get('user_id');
         $input_exists = User::where('user_id', $user_id)->exists();
         if($input_exists != true) exit;//idがなければ処理停止
        $id = User::where('user_id',$user_id)->value('id');
        $follows_exists = Follows::where('user_id',$id)->exists();
        if($follows_exists != true){
            //フォロー〇人
        }else{
            $follows_id = Follows::where('user_id',$id)->pluck('followed_id');
            foreach ($follows_id as $key => $val){
                $post_data = Posted_photos::where('user_id',$val)->get();
                foreach($post_data as $id_key => $data){
                  //$timeline_data[$data['user_id']][$id_key] = [$id_key => $data];//個別の配列  
                  $timeline_data[$post_count] = $data;
                  $post_count++;
                }
            }
        }
        
        return $timeline_data;
    }
    public function timeline_post_data_post(){

    }
}