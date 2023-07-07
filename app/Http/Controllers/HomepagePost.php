<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HomepagePost extends Controller
{
    public function homepagepost(){
        $homePost = DB::table('posts')->inRandomOrder()->get();
        foreach ($homePost as $post) {
            $user = DB::table('users')->select('email')->where('slno', $post->user_slno)->first();
            $post->author_email = $user->email;
        }

        return response()->json([
            'randomposts' => $homePost
        ],200);
    }
}
