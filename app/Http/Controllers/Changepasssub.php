<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class Changepasssub extends Controller
{
    public function changepasssub(Request $req, $usersl){
        $tokenz = $req->bearerToken();
        $num_exist = DB::table('users')->where('slno',$usersl)->count()>0; //if user serial no exist in users db
        if($num_exist){
        
            $is_logged_in = DB::table('tokendb')->where('token',$tokenz)->count()>0; //lets see if he has token in db
            if($is_logged_in){//he has it now
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){

                

                    $validator = Validator::make($req->all(), [
                        'pass' => 'required|regex:/^([a-zA-Z0-9*!@]+){6,50}$/',
                        'cpass' => 'required|same:pass'
                        
                    ]);
                    if ($validator->fails()) { // validation failed
                        return response()->json([
                            'message' => 'Validation failed',
                            'errors' => $validator->errors()
                        ], 200);
                    }else{ //validation worked


                        $passwd = $req->input('pass');
                        $pass2 = Hash::make($passwd);
                        

                        $realmail = DB::table('users')->select('email')->where('slno',$usersl)->first();
                        DB::table('tokendb')->where('user_email',$realmail->email)->delete();
                        
                        DB::table('users')->where('slno',$usersl)->update([
                            
                            'pass' => $pass2
                
                        ]);//update inside DB
                        return response()->json([
                            'message' => 'Successful Please Login Again.',
                        ],200);


                            
                    }
                }else{
                    return response()->json([
                        'message' => 'Invalid Token According To Serial.',
                    ],200);
                }    

            }else{
                return response()->json([
                    'message' => 'Sorry You Are Not Logged In.',
                ],200);
            }
                
                
        }else{
            return response()->json([
                'message' => 'Sorry User Does Not Exist In Database.',
            ],200);
        }
        
    }
}
