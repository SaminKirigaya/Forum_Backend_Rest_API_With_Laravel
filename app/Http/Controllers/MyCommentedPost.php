<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyCommentedPost extends Controller
{
    public function mycommentedpost(Request $req, $usersl, $tokenz){
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    $all_my_comments = DB::table('comments')->select('*')->where('comment_user_slno',$usersl)->get();
                    foreach($all_my_comments as $all_com){
                        $all_mother_post = DB::table('posts')->select('*')->where('slno',$all_com->post_slno)->orderBy('slno','desc')->get();
                    }
                    foreach($all_mother_post as $mother_post){
                        $author = DB::table('users')->select('email')->where('slno',$mother_post->user_slno)->first();
                        $mother_post->author = $author->email;
                    }
                    return response()->json([
                        'message'=>'Successful.',
                        '$mother_post'=> $all_mother_post
                    ],200);



                }else{
                    return response()->json([
                        'message'=>'Token Is Invalid According To Serial.'
                    ],200);
                }
            }else{
                return response()->json([
                    'message'=>'You Are Not Logged In.'
                ],200);
            }
        }else{
            return response()->json([
                'message'=>'Invalid User Serial.'
            ],200);
        }
    }
}
