<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HomepagePost extends Controller
{
    public function homepagepost(Request $req){
        $homePost = DB::table('posts')->inRandomOrder()->get();
        foreach ($homePost as $post) {
            $user = DB::table('users')->select('email','imglink')->where('slno', $post->user_slno)->first();
            
            $post->author_email = $user ? $user->email : "Unknown";
            $post->author_image = $user ? $user->imglink : "Unknown";
        }

        $top_posts = DB::table('posts')->orderBy('slno', 'desc')->get();
        foreach ($top_posts as $post) {
            $user = DB::table('users')->select('email','imglink')->where('slno', $post->user_slno)->first();
            $post->author_email = $user->email;
            $post->image = $user->imglink;
        }

        return response()->json([
            'randomposts' => $homePost,
            'toppost' => $top_posts
        ],200);
    
    }
}
