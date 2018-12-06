<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;    
use App\Http\Controllers\Controller;
use App\Admin;

class AdminController extends Controller
{
    public function index() {// idの降順で管理者ID表示

        return \App\Admin::orderBy('id', 'desc')->get();

    }

}
