<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeeOther extends Controller
{
    public function seeother(Request $req, $usersl, $mail ){
        $tokenz = $req->bearerToken();
        $user_real = DB::table('users')->where('slno',$usersl)->count()>0;
        if($user_real){
            $logged_in = DB::table('tokendb')->where('token',$tokenz)->count()>0;
            if($logged_in){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    if(DB::table('users')->where('email',$mail)->count()>0){
                        $userdata = DB::table('users')->select('email','imglink','country','age','gender','joined')->where('email',$mail)->first();
                        $ussl = DB::table('users')->select('slno')->where('email',$mail)->first();
                        $totalpost = [];
                        if(DB::table('posts')->where('user_slno',$ussl->slno)->count()>0){
                            
                            $totalpost = DB::table('posts')->select('*')->where('user_slno',$ussl->slno)->get();
                            if($totalpost->count() == 1){
                                $totalpost = DB::table('posts')->select('*')->where('user_slno',$ussl->slno)->first();
                            }else if($totalpost->count()>1){
                                $totalpost = DB::table('posts')->select('*')->where('user_slno',$ussl->slno)->orderBy('slno','desc')->get();
                            }else{
                                $totalpost = [];
                            }

                        }
                        return response()->json([
                            'email' => $userdata->email,
                            'imagelink' => $userdata->imglink,
                            'country' => $userdata->country,
                            'age' => $userdata->age,
                            'gender' => $userdata->gender,
                            'joined' => $userdata->joined,
                            'mother_post' => $totalpost

                        ],200);

                    }
                }
            }
        }
    
                }
}
