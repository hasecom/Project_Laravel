<?php
/*
仮登録用のモデル

仮登録クラス

*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers;

/*
protected-そのクラス自身と継承クラスからアクセス可能
*/

class Temp_User extends Model
{
    protected $fillable = ['id'];
    //laravelはidというカラム名が主キーと判定。規約をオーバーライドする場合はprimaryKeyプロパティ

    protected $table = 'temporary_registration';
    protected $temp_id = 'temp_id';
    protected $temp_pw = 'temp_pw';
    protected $temp_email = 'temp_email';
    protected $temp_name = 'temp_name';
    protected $token = 'token';

//デフォルト値
    protected $attributes = [
        'temp_id' => "",
        'temp_pw' => "",
        'temp_email' => "",
        'temp_name' => "",
        'token'=>""
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
    private function de($json){
        $array = json_decode($json,true);
        return $array;
    }
}
