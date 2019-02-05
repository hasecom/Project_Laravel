<?php


namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers;


class Point extends Model
{
    protected $fillable = ['id'];
    
    protected $table = 'points';
    protected $id = 'id';
    protected $user_id = 'user_id';
    protected $photo_id = 'photo_id';
    protected $charge_point = 'charge_point';
    protected $price = 'price';
    protected $charge_date = 'charge_date';

    public $timestamps = false;

//デフォルト値
    protected $attributes = [
        'photo_id'=>NULL,
        'charge_point'=>0,
        'price'=>0,
    ];
 
}
