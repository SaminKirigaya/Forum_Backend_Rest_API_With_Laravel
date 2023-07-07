<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Posttypes extends Controller
{
    public function posttypes(){
        $post_type = DB::table('problem_types')->select('*')->get();
        return response()->json([
            'postType' => $post_type
        ],200);
    }
}
