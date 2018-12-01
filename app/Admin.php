<?php
/*
h-テストで作成中

*/
namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
 

class Admin extends Authenticatable
{
  
    protected $table = 'admins';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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