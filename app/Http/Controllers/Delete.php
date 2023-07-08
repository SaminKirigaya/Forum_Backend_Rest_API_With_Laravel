<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Delete extends Controller
{
    public function delete(Request $req){
        $tokenz = $req->bearerToken();
        if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
            $mailz = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
            $user_slno = DB::table('users')->select('slno')->where('email',$mailz->user_email)->first();
            
            

            $user_deleted = DB::table('users')->where('email',$mailz->user_email)->delete(); //del acc from users db

            if($user_deleted){

                DB::table('posts')->where('user_slno',$user_slno->slno)->delete(); //del this user posts who is deleting acc
                DB::table('tokendb')->where('token',$tokenz)->delete();
                return response()->json([
                    'message' => 'Account Deleted',
                ],200);
            }else{
                return response()->json([
                    'message' => 'Deletion Failed Try Later.',
                ],200);
            }

        }else{
            return response()->json([
                'message' => 'Failed Sorry Unexpected Issue Occured.',
            ],200);
        }
    }
}
