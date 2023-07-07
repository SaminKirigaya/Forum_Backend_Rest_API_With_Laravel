<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LatestPost extends Controller
{
    public function latestpost(){
        $top_posts = DB::table('posts')->orderBy('slno', 'desc')->get();
        return response()->json([
            'toppost' => $top_posts
        ],200);
    
    }
}
