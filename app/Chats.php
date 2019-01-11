<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
    protected $fillable = ['id'];

    protected $table = 'chats';
    protected $user_id = 'user_id';
    protected $photo_id = 'photo_id';
    protected $comment_text = 'comment_text';
    
    public $timestamps = false;

//デフォルト値
    protected $attributes = [
        'comment_text' => "",
        'photo_id' => "",
        'user_id' => "",
    ];

}
