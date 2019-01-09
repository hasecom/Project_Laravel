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
/*
*ゆたたが作るよー!
*↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
*/
    $img_post = $_POST['img_post'];
    if(session()->has('img_token')){
        $session_img = session()->get('img_token');
        if($img_post!=$session_img){
            $this->img_upload();
            session()->put(['img_token'=>$img_post]);
            }
        }else{
        $this->img_upload();
        session()->put(['img_token'=>$img_post]);
        }
    }

    //画像取り出し
    // $contents = Storage::disk('s3')->get('face2.jpg');  


// session()->forget('img_token');
// }

    // return  base64_encode($contents);
    // return $dir;
/*
*↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
*ゆたたが作ったよー!
*/
    private function img_upload(){
        $sample_data = $_POST['files'];
        $img = $_POST['files'];
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $fileData = base64_decode($img);

        $date = date('Y-m-d H:i:s');
        $folder_name=$date;
        $file_name=$date.'_'.str_random(16);
        $result=Storage::disk('s3')->directories();

        $dir_flg=0;
        foreach($result as $val){
            $cnt_img = count(Storage::disk('s3')->allFiles($val));
            if($cnt_img<5){
                $dir=$val;
                $dir_flg=1;
            }
        }
        if($dir_flg==1){
                Storage::disk('s3')->put($dir.'/'.$file_name.'.png', $fileData);
            }else{
                Storage::disk('s3')->makeDirectory($folder_name);
                Storage::disk('s3')->put($folder_name.'/'.$file_name.'.png', $fileData);
            }
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
