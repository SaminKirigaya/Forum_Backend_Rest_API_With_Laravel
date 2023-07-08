<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Foreach_;

class MyPost extends Controller
{
    public function mypost(Request $req, $usersl){
        $tokenz = $req->bearerToken();
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){

                $user_mail = DB::table('users')->select('email')->where('slno',$usersl)->first();
                $token_mail = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();

                if($user_mail->email == $token_mail->user_email){
                    $mypost = DB::table('posts')->select('*')->where('user_slno',$usersl)->get();
                    foreach($mypost as $myprofilepost){
                        $myprofilepost->email = $user_mail->email;
                    }
                    return response()->json([
                        'message' => 'Successful',
                        'profilePost' => $mypost
                    ],200);

                }else{
                    return response()->json([
                        'message' => 'Invalid Token According To Serial.',
                    ],200);
                }

            }else{
                return response()->json([
                    'message' => 'User Not Logged In.',
                ],200);
            }
        }else{
            return response()->json([
                'message' => 'Invalid User Serial Id.',
            ],200);
        }
    }
}
