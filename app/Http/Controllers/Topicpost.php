<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Topicpost extends Controller
{
    public function topicpost($codename){
        $topics = DB::table('posts')->select('*')->where('problem_type',$codename)->inRandomOrder()->get();
        
        return response()->json([
            'topic_post' => $topics
        ],200);
    }
}
