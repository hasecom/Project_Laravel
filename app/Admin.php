<?php
/*
h-テストで作成中
admin用のmodel
主に認証用?

*/
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\Admin as Authenticatable;
 

class Admin extends Authenticatable
{
  
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //$fillableは更新系の処理で予期せぬ値が登録されることを防ぐための仕組み
    protected $fillable = [
        'admin_id', 'admin_pw',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'admin_pw', 'remember_token',
    ];
}