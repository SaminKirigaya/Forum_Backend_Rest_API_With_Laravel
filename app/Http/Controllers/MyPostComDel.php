<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyPostComDel extends Controller
{
    public function mypostcomdel(Request $req, $usersl, $comntno){
        $tokenz = $req->bearerToken();
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    if(DB::table('comments')->where('slno',$comntno)->count()>0){
                        $usersl = intval($usersl);
                        $comnt = DB::table('comments')->select('*')->where('slno',$comntno)->first();
                        $userno = DB::table('posts')->select('user_slno')->where('slno',$comnt->post_slno)->first();
                        if($usersl == $userno->user_slno){
                            if(DB::table('comments')->where('slno',$comntno)->delete()){
                                return response()->json([
                                    'message'=>'Successful'
                                ],200);
                            }else{
                                return response()->json([
                                    'message'=>'Some Error Occured. Please Try Later.'
                                ],200);
                            }
                        }else{
                            return response()->json([
                                'message'=>'You Do Not Have Authority To Delete Others Post Comment.'
                            ],200);
                        }
                    }else{
                        return response()->json([
                            'message'=>'Comment May Have Been Removed.'
                        ],200);
                    }
                }else{
                    return response()->json([
                        'message'=>'Token Is Not Valid According To Serial.'
                    ],200);
                }
            }else{
                return response()->json([
                    'message'=>'You Are Not Logged In.'
                ],200);
            }    
        }else{
            return response()->json([
                'message'=>'Serial Invalid.'
            ],200);
        }
    }
}
