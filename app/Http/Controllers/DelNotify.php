<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DelNotify extends Controller
{
    public function delnotify(Request $req, $usersl, $highestsl){
        $tokenz = $req->bearerToken();
        $user_real = DB::table('users')->where('slno',$usersl)->count()>0;
        if($user_real){
            $logged_in = DB::table('tokendb')->where('token',$tokenz)->count()>0;
            if($logged_in){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    $highsl = intval($highestsl);
                    $highsl = $highsl+1;
                    if(DB::table('notification')->where('owner_slno',$usersl)->where('slno','<',$highsl)->delete()){
                        return response()->json([
                            'message'=>'Success'
                        ],200);
                    }
                }else{
                    return response()->json([
                        'message'=>'Invalid Token And User Email.'
                    ],200);
                }
    
            }else{
                return response()->json([
                    'message'=>'Not logged in.'
                ],200);
            }
    
        }else{
            return response()->json([
                'message'=>'Invalid User.'
            ],200);
        }
    
    
    
    }   
}
