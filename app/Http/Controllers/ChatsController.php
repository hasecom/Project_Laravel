<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chats;
class ChatsController extends Controller
{
    //
    public function chat_get(){

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
