<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ComDisLike extends Controller
{
    public function comdislike(Request $req, $usersl, $comntno){
        $tokenz = $req->bearerToken();
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                if(DB::table('comments')->where('slno',$comntno)->count()>0){
                    $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                    $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                    if($tok_email->user_email == $usrsl_email->email){
                        if(DB::table('comment_like')->where('comment_slno',$comntno)->where('user_email',$usrsl_email->email)->count()>0){
                            DB::table('comment_like')->where('comment_slno',$comntno)->where('user_email',$usrsl_email->email)->delete();
                            DB::table('comment_dislike')->insert([
                                'comment_slno'=> $comntno,
                                'user_email'=> $usrsl_email->email
                            ]);

                            $like = DB::table('comments')->select('dislike_amount')->where('slno',$comntno)->first();
                            $like->dislike_amount = $like->dislike_amount+1;
                            DB::table('comments')->where('slno',$comntno)->update([
                                'dislike_amount'=>$like->dislike_amount
                            ]);

                            $like = DB::table('comments')->select('like_amount')->where('slno',$comntno)->first();
                            $like->like_amount = $like->like_amount-1;
                            DB::table('comments')->where('slno',$comntno)->update([
                                'like_amount'=>$like->like_amount
                            ]);

                            return response()->json([
                                'message'=>'Success'
                            ],200);

                        }else if(DB::table('comment_dislike')->where('comment_slno',$comntno)->where('user_email',$usrsl_email->email)->count()>0){
                            return response()->json([
                                'message'=>'Failed'
                            ],200);
                        }else{
                            DB::table('comment_dislike')->insert([
                                'comment_slno'=> $comntno,
                                'user_email'=> $usrsl_email->email
                            ]);
                            $like = DB::table('comments')->select('dislike_amount')->where('slno',$comntno)->first();
                            $like->dislike_amount = $like->dislike_amount+1;
                            DB::table('comments')->where('slno',$comntno)->update([
                                'dislike_amount'=>$like->dislike_amount
                            ]);

                            return response()->json([
                                'message'=>'Success'
                            ],200);
                        }
                    }else{
                        return response()->json([
                            'message'=>'Invalid Token According To Serial.'
                        ],200);
                    }
                }else{
                    return response()->json([
                        'message'=>'The Post Might Have Been Removed.'
                    ],200);
                }
            }else{
                return response()->json([
                    'message'=>'You Are Not Logged In.'
                ],200);
            }
        }else{
            return response()->json([
                'message'=>'Invalid Serial Number.'
            ],200);
        }
    }
}
