<?php
/*
Admin用のモデル

AdminクラスをAdminsControllerから使用可能

*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers;

/*
protected-そのクラス自身と継承クラスからアクセス可能
*/

class Admin extends Model
{
    protected $fillable = ['id'];
    //laravelはidというカラム名が主キーと判定。規約をオーバーライドする場合はprimaryKeyプロパティ

    protected $table = 'admins';
    protected $admin_id = 'admin_id';
    protected $admin_pw = 'admin_pw';
    protected $admin_authority = 'admin_authority';
   

    public $timestamps = false;

//デフォルト値
    protected $attributes = [
        'admin_id' => "",
        'admin_pw' => "",
        'admin_authority' => 1,
    ];
    
    protected  function sample(){
        $cold = Admin::get();
    return $this->en($cold);
    }
    
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
