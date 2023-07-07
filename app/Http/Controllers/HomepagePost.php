<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class HomepagePost extends Controller
{
    public function homepagepost(){
        $homePost = DB::table('posts')->inRandomOrder()->get();
        return response()->json([
            'randomposts' => $homePost
        ],200);
    }
}
