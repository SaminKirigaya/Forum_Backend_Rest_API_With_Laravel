<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Topicpost extends Controller
{
    public function topicpost($codename){
        $topics = DB::table('posts')->select('*')->where('problem_type',$codename)->orderBy('slno','desc')->get();
        if($topics->count()==1){
            $topics = DB::table('posts')->select('*')->where('problem_type',$codename)->orderBy('slno','desc')->first();
            $user = DB::table('users')->select('email','imglink')->where('slno', $topics->user_slno)->first();
            $topics->author_email = $user->email;
            $topics->image = $user->imglink;

            return response()->json([
                'message' => 'Successful',
                'topic_post' => $topics
            ],200);
        
        }else if($topics->count()>1){
            foreach ($topics as $post) {
                $user = DB::table('users')->select('email','imglink')->where('slno', $post->user_slno)->first();
                $post->author_email = $user->email;
                $post->image = $user->imglink;

            }
            return response()->json([
                'message' => 'Successful',
                'topic_post' => $topics
            ],200);
        }else{
            return response()->json([
                'message' => 'No post in this topic.',
                
            ],200);
        }
        
        
        
    }
}
