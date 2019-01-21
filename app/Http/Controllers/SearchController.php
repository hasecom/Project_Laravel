<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tags;
use App\Posted_photos;

class SearchController extends Controller
{
     public function search_list_get($word){
    $input_word =Tags::where('tag_name',$word)->exists();
    if($input_word != 1)exit();
    $word_cnt = Tags::where('tag_name',$word)->value('tag_cnt');

    $search_photo_ob = Posted_photos::where('tag', 'like', '%'.$word.'%')->get();
            return $search_photo_ob;
    }
    public function search_list_post($word){

    }
}
