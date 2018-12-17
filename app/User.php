<?php
/*
User用のモデル

*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    


    //エンコード
    protected function en($obj){
        $json = json_encode($obj,JSON_PRETTY_PRINT);
        return $json;
    }
    //デコード
    protected function de($json){
        $array = json_decode($json,true);
        return $array;
    }
}
