<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tags;
class TagsController extends Controller
{
    public function tags_list_get($word){
        $users = Tags::where('tag_name', 'like', $word.'%')->get();
            return $users;
    }
    public function tags_list_post(){

    }
}
