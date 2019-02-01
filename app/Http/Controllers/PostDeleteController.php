<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tags;
use App\Likes;
use App\Chats;
use App\Posted_photos;

class PostDeleteController extends Controller
{
    public function post_delete_get($post_id){//post_id

    }
    public function post_delete_post($post_id){//post_id
        $photo_id =$_POST['photo_id'];
        $photo_tag = $_POST['photo_tag'];
        $likes_id = $_POST['likes_id'];
        $user_id = $_POST['user_id'];
        //TODO:タグのカウント、タグ削除
       
        
        //phot　o_id削除、likes_id削除、、いいねした人、カウントリセット削除
      
        if($photo_tag !=""){
       $this->tags_processing($photo_tag);
        }
        
       $this->chat_processing($photo_id);
       
       $this->likes_processing($photo_id);
       
       $this->photo_del($photo_id);
    
    }
    private function tags_processing($photo_tag){//タグ削除orカウント減らし
        
        $tag_arr = explode('#', $photo_tag);
               for ($i=1; $i < count($tag_arr); $i++) { //配列一つ目はnullなのでとばす
            $tag_chk = Tags::where('tag_name',$tag_arr[$i])->value('tag_cnt');
            if($tag_chk == ""){//nullだったら何もしないよ
            }else if($tag_chk == 1){//tag_chkが1だったらtag削除するよ
                Tags::where('tag_name',$tag_arr[$i])->delete();
            }else{
            $tag_id = Tags::where('tag_name',$tag_arr[$i])->value('id');
            $Tag_pull = Tags::where('id',$tag_id)->first();
            $Tag_pull->tag_cnt =$tag_chk - 1;
            $Tag_pull->save();
            }
        }
    }
    private function likes_processing($photo_id){
        $likes_exists = Likes::where('photo_id',$photo_id)->exists();
        if($likes_exists != 1)return;
        $likes_arr = Likes::where('photo_id',$photo_id)->pluck('id');
        for ($j=0; $j < count($likes_arr); $j++){ 
            Likes::where('id',$likes_arr[$j])->delete();
        }
    }
    private function chat_processing($photo_id){
        $chats_exists = Chats::where('photo_id',$photo_id)->exists();
        if($chats_exists != 1)return;
       $chats_arr = Chats::where('photo_id',$photo_id)->pluck('id');
       for ($k=0; $k < count($chats_arr); $k++){ 
        Chats::where('id',$chats_arr[$k])->delete();
        }
    }
    private function photo_del($photo_id){
        $photo_exists = Posted_photos::where('photo_id',$photo_id)->exists();
        if($photo_exists != 1)return;
        Posted_photos::where('photo_id',$photo_id)->delete();
    }
}
