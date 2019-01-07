<?php
/*
Likes
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers;

/*
protected-そのクラス自身と継承クラスからアクセス可能
*/

class Likes extends Model
{
    protected $fillable = ['id'];
    
    protected $table = 'likes';
    protected $id = 'id';
    protected $user_id = '';
    protected $photo_id = 'photo_id';
    protected $flg = 'flg';
    protected $likes_date = 'likes_date';

    public $timestamps = false;

//デフォルト値
    protected $attributes = [
      'flg'=>0,
    ];
 
}
