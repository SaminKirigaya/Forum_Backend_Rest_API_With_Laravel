<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Logout extends Controller
{
    public function logout(Request $req, $usersl){
        $tokenz = $req->bearerToken();
        $usersl= intval($usersl);
        $sl_exist = DB::table('users')->where('slno',$usersl)->count()>0;
        if($sl_exist){
            $token_in_db = DB::table('tokendb')->where('token',$tokenz)->count()>0;
            if($token_in_db){
                DB::table('tokendb')->where('token',$tokenz)->delete();
                return response()->json([
                    'message' => 'Logout Successful'
                    
                ],200);


            }else{
                return response()->json([
                    'message' => 'You Are Not Even Logged In !!!',
                    
                ], 200);
            }
        }else{
            return response()->json([
                'message' => 'User Does Not Exist !!! ',
                
            ], 200);
        }
    }
}
