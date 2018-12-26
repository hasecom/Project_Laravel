<?php
/*
User用のモデル

*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['id'];
    //laravelはidというカラム名が主キーと判定。規約をオーバーライドする場合はprimaryKeyプロパティ

    protected $table = 'users';
    protected $user_id = 'user_id';
    protected $user_pw = 'user_pw';
    protected $user_name = 'user_name';
    protected $tel_num = 'tel_num';
    protected $mail = 'mail';
    protected $si_text = 'si_text';
    protected $icon_path = 'icon_path';
    protected $flg = 'flg';
    protected $point = 'point';

    public $timestamps = false;
//デフォルト値
    protected $attributes = [
        'user_id' => "",
        'user_pw' => "",
        'user_name' => "",
        'tel_num' => "",
        'si_text'=>"",
        'icon_path'=>"undefined",
        'flg'=>1,
        'point'=>0,
    ];

    
  /*
(array)XXX or エンコード後にデコード
  (array)XXXの方がスピードは速いが
  ネスト構造になっているものは結果が変わるかも。
  */

    //エンコード
    protected function en($array){
        $json = json_encode($array,JSON_PRETTY_PRINT);
        return $json;
    }
    //デコード
    protected function de($json){
        $array = json_decode($json,true);
        return $array;
    }

}
