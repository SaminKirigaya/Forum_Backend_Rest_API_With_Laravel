<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Notification extends Controller
{
    public function notification(Request $req, $usersl){
        $tokenz = $req->bearerToken();
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){

                $user_mail = DB::table('users')->select('email')->where('slno',$usersl)->first();
                $token_mail = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();

                if($user_mail->email == $token_mail->user_email){

                    if(DB::table('notification')->where('owner_slno',$usersl)->count()>0){
                        if(DB::table('notification')->where('owner_slno',$usersl)->count()==1){
                            $notifi = DB::table('notification')->select('*')->where('owner_slno',$usersl)->first();
                            return response()->json([
                                'message' => 'One New Notification.',
                                'notification' => $notifi
                            ],200);

                        }else if(DB::table('notification')->where('owner_slno',$usersl)->count()>1){
                            $notifi = DB::table('notification')->select('*')->where('owner_slno',$usersl)->orderBy('slno','desc')->get();
                            return response()->json([
                                'message' => 'Too Many New Notification.',
                                'notification' => $notifi
                            ],200);
                        }

                    }else{
                        return response()->json([
                            'message' => 'No New Notification To Show.'
                        ],200);
                    }

                }else{
                    return response()->json([
                        'message' => 'Invalid Token And Serial.'
                    ],200);
                }
           
                    
            }else{
                return response()->json([
                    'message' => 'Invalid Token.'
                ],200);
            }
        }else{
            return response()->json([
                'message' => 'User Do Not Exist.'
            ],200);
        }
    
    
    
    }
}
