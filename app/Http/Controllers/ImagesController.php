<?php
/*
* 画像投稿のコントローラー
*/


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;





class ImagesController extends Controller
{
    /*=UserフロントGET=*/
    public function user_front() {
        return view('user/front');
    }
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
 
}
