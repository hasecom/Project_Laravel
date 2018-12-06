<?php
/*
Admin用のモデル

AdminクラスをAdminsControllerから使用可能

*/

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
protected-そのクラス自身と継承クラスからアクセス可能
*/

class Admin extends Model
{
    protected $guarded = ['id'];

    protected $table = 'admins';

    public $timestamps = false;
    
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
