<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Changepasspage extends Controller
{
    public function changepasspage(Request $req, $usersl, $tokenz){
        $num_exist = DB::table('users')->where('slno',$usersl)->count()>0; //if user serial no exist in users db
        if($num_exist){
        
            $is_logged_in = DB::table('tokendb')->where('token',$tokenz)->count()>0; //lets see if he has token in db
            if($is_logged_in){//he has it now
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    $all_data = DB::table('users')->select('*')->where('slno',$usersl)->get(); //taking all user slno related data
                    
                    return response()->json([
                        'message'=>'Successful',
                        
                    ], 200);// sent datas
                }else{
                    return response()->json([
                        'message'=>'Invalid Token According To Serial.',
                        
                    ], 200);
                }    
            }else{
                return response()->json([
                    'message' => 'Please Log In First To See Profile.',
                ], 200);//token not working hackerrrrrrrrrrrrrrrrr trying to breach
            }
        }
        else{
            return response()->json([
                'message' => 'User Serial Number Error',
            ], 200);// someone tried illigal serials in browser link
        }
    }
}
