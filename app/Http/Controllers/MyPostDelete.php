<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyPostDelete extends Controller
{
    public function mypostdelete(Request $req, $usersl, $tokenz, $postno){
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    if(DB::table('posts')->where('slno',$postno)->count()>0){
                        $usersl = intval($usersl);
                        $postUserSl = DB::table('posts')->select('user_slno')->where('slno',$postno)->first();
                        if($usersl == $postUserSl->user_slno){
                            $delpost = DB::table('posts')->where('slno',$postno)->delete();
                            if($delpost){
                                DB::table('comments')->where('post_slno',$postno)->delete();
                                return response()->json([
                                    'message'=>'Post Deleted Successfully.'
                                ],200);
                            }else{
                                return response()->json([
                                    'message'=>'Sorry Some Error Occured.Try Later.'
                                ],200);
                            }
                        }else{
                            return response()->json([
                                'message'=>'You Are Not The Auther Of This Post.'
                            ],200);
                        }
                    }else{
                        return response()->json([
                            'message'=>'Post May Have Been Deleted Already.'
                        ],200);
                    }
                }else{
                    return response()->json([
                        'message'=>'Token Invalid According To Serial.'
                    ],200);
                }
            }else{
                return response()->json([
                    'message'=>'You Are Not Logged In.'
                ],200);
            }
        }else{
            return response()->json([
                'message'=>'Invalid Serial No.'
            ],200);
        }
    }
}
