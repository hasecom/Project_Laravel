<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers;

/*
protected-そのクラス自身と継承クラスからアクセス可能
*/

class Tags extends Model
{
    protected $fillable = ['id'];
    protected $table = 'tags';
    protected $id = 'id';
    protected $tag_name = 'tag_name';
    
    public $timestamps = false;

//デフォルト値
    protected $attributes = [
       'tag_name'=>'',
    ];
 
}
