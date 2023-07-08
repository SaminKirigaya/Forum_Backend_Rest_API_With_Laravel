<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DelPersonalCom extends Controller
{
    public function delpersonalcom(Request $req, $usersl, $tokenz, $comntno){
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    if(DB::table('comments')->where('slno',$comntno)->count()>0){
                        if(DB::table('comments')->where('slno',$comntno)->where('comment_user_slno',$usersl)->count()>0){
                            DB::table('comments')->where('slno',$comntno)->where('comment_user_slno',$usersl)->delete();
                            return response()->json([
                                'message'=>'Your Comment Was Successfully Deleted.'
                            ],200);
                        }else{
                            return response()->json([
                                'message'=>'You Dont Have The Authority To Delete It.'
                            ],200);
                        }
                    }else{
                        return response()->json([
                            'message'=>'Comment Might Be Removed Already.'
                        ],200);
                    }
                }else{
                    return response()->json([
                        'message'=>'Invalid Token According To Serial No.'
                    ],200);
                }
            }else{
                return response()->json([
                    'message'=>'You Are Not Even Logged In.'
                ],200);
            }
        }else{
            return response()->json([
                'message'=>'Invalid Serial No.'
            ],200);
        }
    }
}
