<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AdminDeleteComs extends Controller
{
    public function admindeletecoms(Request $req, $usersl, $postno, $comno){
        $tokenz = $req->bearerToken();
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $user_mail = DB::table('users')->select('email')->where('slno',$usersl)->first();
                $token_mail = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                if($user_mail->email == $token_mail->user_email){

                    if(DB::table('posts')->where('slno',$postno)->count()>0){
                        if(DB::table('posts')->where('slno',$postno)->where('user_slno',$usersl)->count()>0){

                            if(DB::table('comments')->where('slno',$comno)->count()>0){

                                if(DB::table('comments')->where('slno',$comno)->where('post_slno',$postno)->count()>0){

                                    DB::table('comments')->where('slno',$comno)->where('post_slno',$postno)->delete();

                                    return response()->json([
                                        'message' =>'Comment Deleted.'
                                    ],200);

                                }else{
                                    return response()->json([
                                        'message' =>'Not your comment.'
                                    ],200);
                                }

                            }else{
                                return response()->json([
                                    'message' =>'Not existing comment.'
                                ],200);
                            }

                        }else{
                            return response()->json([
                                'message' =>'Not your post.'
                            ],200);
                        }
                    }else{
                        return response()->json([
                            'message' =>'post not exist.'
                        ],200);
                    }

                }else{
                    return response()->json([
                        'message' =>'Token Invalid With Serial.'
                    ],200);
                 }

            }else{
                return response()->json([
                    'message' =>'Invalid token'
                ],200);
            }

        }else{
            return response()->json([
                'message' =>'Invalid serial.'
            ],200);
        }


    }
}
