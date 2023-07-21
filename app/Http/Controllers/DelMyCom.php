<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DelMyCom extends Controller
{
    public function delmycom(Request $req, $usersl, $comno){
        $tokenz = $req->bearerToken();
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $user_mail = DB::table('users')->select('email')->where('slno',$usersl)->first();
                $token_mail = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                if($user_mail->email == $token_mail->user_email){ 

                    if(DB::table('comments')->where('slno',$comno)->count()>0){
                        if(DB::table('comments')->where('slno',$comno)->where('comment_user_slno',$usersl)->count()>0){

                            DB::table('comments')->where('slno',$comno)->where('comment_user_slno',$usersl)->delete();
                            return response()->json([
                                'message' => 'Successfully Deleted.'
                            ],200);

                        }else{
                            return response()->json([
                                'message' => 'Not Your Comment.'
                            ],200);
                        }
                    }else{
                        return response()->json([
                            'message' => 'No Such Comment Exist.'
                        ],200);
                    }
                }else{
                    return response()->json([
                        'message' => 'Token and Serial mismatch.'
                    ],200);
                }    
                
                

            }else{
                return response()->json([
                    'message' => 'Invalid Token.'
                ],200);
            }    

        }else{
            return response()->json([
                'message' => 'Not valid user.'
            ],200);
        }



    }
}
