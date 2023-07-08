<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Report extends Controller
{
    public function report(Request $req, $usersl, $tokenz, $postno){
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    if(DB::table('posts')->where('slno',$postno)->count()>0){
                        if(DB::table('report')->where('post_slno',$postno)->count()>30){
                            if(DB::table('posts')->where('slno',$postno)->delete()){
                                DB::table('comments')->where('post_slno',$postno)->delete();
                                return response()->json([
                                    'message'=>'Post Successfully Deleted.'
                                ],200);
                            }else{
                                return response()->json([
                                    'message'=>'Post Might Have Been Already Deleted.'
                                ],200);
                            }

                        }else{
                            if(DB::table('report')->where('post_slno',$postno)->where('email',$tok_email->user_email)->count()>0){
                                return response()->json([
                                    'message'=>'Reported Successfully A Long Ago.'
                                ],200);
                            }else{
                                DB::table('report')->insert([
                                    'post_slno'=>$postno,
                                    'email'=> $tok_email->user_email
                                ]);
                                return response()->json([
                                    'message'=>'Report Successful.'
                                ],200);
                            }
                        }
                    }else{
                        return response()->json([
                            'message'=>'Post Do Not Exist Anymore.'
                        ],200);
                    }
                }else{
                    return response()->json([
                        'message'=>'Invalid Token According To Serial.'
                    ],200);
                }
            }  
        }else{
            return response()->json([
                'message'=>'Invalid Serial Number.'
            ],200);
        }
    }
}
