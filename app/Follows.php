<?php
/*
Follows
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers;

/*
protected-そのクラス自身と継承クラスからアクセス可能
*/

class Follows extends Model
{
    protected $fillable = ['id'];
    //laravelはidというカラム名が主キーと判定。規約をオーバーライドする場合はprimaryKeyプロパティ

    protected $table = 'follows';

//デフォルト値
    protected $attributes = [
    
    ];


}
