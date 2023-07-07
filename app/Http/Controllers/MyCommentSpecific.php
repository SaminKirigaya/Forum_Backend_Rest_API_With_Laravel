<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyCommentSpecific extends Controller
{
    public function mycommentspecific(Request $req, $usersl, $tokenz, $postno){
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    if(DB::table('posts')->where('slno',$postno)->count()>0){

                        if(DB::table('comments')->where('post_slno',$postno)->where('comment_user_slno',$usersl)->count()>0){
                            $postdata = DB::table('posts')->select('*')->where('slno',$postno)->get();
                            foreach($postdata as $post){
                                $author = DB::table('users')->select('email')->where('slno',$post->user_slno)->first();
                                $post->author = $author->email;
                            }
                            $all_my_comments = DB::table('comments')->select('*')->where('post_slno',$postno)->where('comment_user_slno',$usersl)->get();
                            $other_comments = DB::table('comments')->select('*')->where('post_slno',$postno)->get();
                            foreach($other_comments as $other){
                                $comenter = DB::table('users')->select('email')->where('slno',$other->comment_user_slno)->first();
                                $other->author = $comenter->email;
                            }

                            return response()->json([
                                'message'=> 'Successful',
                                'postmaindata' => $postdata,
                                'mycomments'=> $all_my_comments,
                                'other_comment' => $other_comments
                            ],200);


                        }else{
                            return response()->json([
                                'message'=>'You Do Not Have Any Comments In This Field.'
                            ],200);
                        }    

                    }else{
                        return response()->json([
                            'message'=>'The Post May have Been Removed.'
                        ],200);
                    }
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
                'message'=>'Serial No Error.'
            ],200);
        }
    }
}
