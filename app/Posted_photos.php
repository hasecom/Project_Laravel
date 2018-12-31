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

class Posted_photos extends Model
{
    protected $fillable = ['id'];
    
    protected $table = 'posted_photos';
    protected $photo_id = 'photo_id';
    protected $photo_name = 'photo_name';
    protected $user_id = 'user_id';
    protected $photo_description = 'photo_description';
    protected $photo_price = 'photo_price';
    protected $file_name = 'file_name';
    protected $photo_path = 'photo_path';
    protected $photo_px = 'photo_px';
    protected $photo_size = 'photo_size';
    protected $upload_date = 'update_date';

    
    public $timestamps = false;

//デフォルト値
    protected $attributes = [
       'photo_name' =>'No Name',
       'photo_description'=>'',
       'photo_price'=>0,
       'file_name'=>"",
       'photo_path'=>'',
       'photo_px'=>0,
       'photo_size'=>0,
    ];
 
}
