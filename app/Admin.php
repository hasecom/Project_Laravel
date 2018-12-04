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
    
    protected  function sample(){
        $cold = Admin::get();
    return $cold;
    }

  
    protected function en($array){
        $json = json_encode($array,JSON_PRETTY_PRINT);
        return $json;
    }
    private function de($json){
        $array = json_decode($json,true);
        return $array;
    }
}
