<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyPostEdit extends Controller
{
    public function mypostedit(Request $req, $usersl, $postno){
        $tokenz= $req->bearerToken();
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $user_mail = DB::table('users')->select('email')->where('slno',$usersl)->first();
                $token_mail = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();

                if($user_mail->email == $token_mail->user_email){
                    if(DB::table('posts')->where('slno',$postno)->count()>0){
                        $userslnum = intval($usersl);
                        $postauthor = DB::table('posts')->select('user_slno')->where('slno',$postno)->first();
                        if($postauthor->user_slno==$userslnum){
                            $editPostData = DB::table('posts')->select('*')->where('slno',$postno)->first();
                            return response()->json([
                                'message'=>'Successful',
                                'editPost'=>$editPostData
                            ],200);

                        }else{
                            return response()->json([
                                'message'=>'You Are Not The Author Of This Post !'
                            ],200);
                        }
                    }else{
                        return response()->json([
                            'message'=>'The Post Do Not Exist Anymore.'
                        ],200);
                    }
                }else{
                    return response()->json([
                        'message'=>'Token Is Invalid According To Serial No.'
                    ],200);
                }
            }else{
                return response()->json([
                    'message'=>'You Are Not Logged In Please Log In First.'
                ],200);
            }
        }else{
            return response()->json([
                'message'=>'User Do Not Exist In Database.'
            ],200);
        }
    }
}
