<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chats;
use App\User;
use App\Posted_photos;
class ChatsController extends Controller
{
    //
    public function chat_get($id){
       $photo_id_exist =Posted_photos::where('photo_id',$id)->exists();
        if($photo_id_exist != true)exit();
        $chat_data = [];
       $chat_id = Chats::where('photo_id',$id)->pluck('id');
       foreach($chat_id as $key => $val){
           
           $chat_data[$key] = Chats::where('id',$val)->get([
                                                        'id',
                                                        'user_id',
                                                        'comment_text',
                                                        'comment_date',
                                                        ]);                                           
           $chat_data[$key][0]['user_data'] = User::where('id',$chat_data[$key][0]['user_id'])->get([
                                                                                                    'id',
                                                                                                    'user_id',
                                                                                                    'user_name',
                                                                                                    'icon_path',
                                                                                                    'flg'
                                                                                                    ]);
       }
       return $chat_data;
    }
    //!commnent_text => comment_text に 変更
    //!chatsのidをオートインクリメント
    public function chat_post(){
        $chat_text = $_POST['chat_text'];
        $photo_id = $_POST['photo_data'];
        $my_id = $_POST['my_data'];

        $new_chats = new Chats;
        $new_chats->user_id = $my_id;
        $new_chats->photo_id =$photo_id;
        $new_chats->comment_text = $chat_text;
        $new_chats->save();


    }
}
