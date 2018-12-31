<?php
/*
* 画像投稿のコントローラー
*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Posted_photos;
use App\User;




class ImagesController extends Controller
{
    /*=UserフロントPOST=*/
    public function image_post(){
        
    $sample_data = $_POST['files'];
    $img = $_POST['files'];
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    //saving
    // $fileName = 'photo.jpg';
   // Storage::put('public/photo.jpg', $fileData);
    $path = Storage::disk('s3')->put('public/ddd.jpg', $fileData);


    $contents = Storage::disk('s3')->get('face2.jpg'); 
    return  base64_encode($contents);


    }
    public function post_data_get($id){//投稿のデータ
        $img_post_data = [];
        $input_exists = User::where('user_id', $id)->exists();
        if($input_exists != true) exit;//idがなければ処理停止

        $get_my_user_id = session()->get('user_id');
        $get_my_id = User::where('user_id',$get_my_user_id)->value('id');//My内部ID
        $get_input_id = User::where('user_id',$id)->value('id');//内部ID
       if($get_my_id == $get_input_id){//ログインユーザのみ見せたいデータがあれば。
           
       }
       $img_post_data = $this->mediation_post_data($get_input_id);
       return $img_post_data;
    }
    public function post_data_post($id){
        //post_image_page.vueからaxiosで取得したID
        $input_exists = User::where('user_id', $id)->exists();
        if($input_exists != true) exit;//idがなければ処理停止
        $get_input_id = User::where('user_id',$id)->value('id');//内部ID


        //*新規投稿画像をDBに保存
        $new_posted_photos = new Posted_photos;
        $new_posted_photos->user_id = $get_input_id;
        $new_posted_photos->photo_description = $_POST['description'];
        $new_posted_photos->file_name = str_random(16);
        $new_posted_photos->photo_path =str_random(16);
        $new_posted_photos->save();
        return $get_input_id;
    }
    //画像データ送受信のjsonの整形
    private function mediation_post_data($get_input_id){
        $send_img_info = [];
        $data = Posted_photos::where('user_id',$get_input_id)->get();
        //sortとかここでできまするね
        foreach($data as $val => $key){
            $send_img_info[$val] = [$val => $key];
        }
        return $send_img_info;
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
