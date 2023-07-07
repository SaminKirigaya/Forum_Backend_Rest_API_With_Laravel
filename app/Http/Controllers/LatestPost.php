<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LatestPost extends Controller
{
    public function latestpost(){
        $top_posts = DB::table('posts')->orderBy('slno', 'desc')->get();
        foreach ($top_posts as $post) {
            $user = DB::table('users')->select('email')->where('slno', $post->user_slno)->first();
            $post->author_email = $user->email;
        }

        return response()->json([
            'toppost' => $top_posts
        ],200);
    
    }
}
