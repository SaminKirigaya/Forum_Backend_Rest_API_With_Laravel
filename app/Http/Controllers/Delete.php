<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Delete extends Controller
{
    public function delete(Request $req, $tokenz){
        if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
            $mailz = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
            $user_deleted = DB::table('users')->where('email',$mailz->user_email)->delete();

            if($user_deleted){

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
