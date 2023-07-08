<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Changeprofilesub extends Controller
{
    public function changeprofilesub(Request $req, $usersl){
        $tokenz = $req->bearerToken();
        
        $num_exist = DB::table('users')->where('slno',$usersl)->count()>0; //if user serial no exist in users db
        if($num_exist){
        
            $is_logged_in = DB::table('tokendb')->where('token',$tokenz)->count()>0; //lets see if he has token in db
            if($is_logged_in){//he has it now
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    $validator = Validator::make($req->all(), [
                        'email' => 'required|email',
                        'countrys' => 'required|regex:/^([a-zA-Z]+)$/',
                        'ages' => 'required|numeric|min:7|max:90',
                        'genders' => 'required|regex:/^([a-zA-Z]+)$/' //have to add imagelink required condition
                    ]);
                    if ($validator->fails()) {
                        return response()->json([
                            'message' => 'Validation failed',
                            'errors' => $validator->errors()
                        ], 200);
                    }else{

                        $mail = $req->input('email');
                        
                        $countryz = $req->input('countrys');
                        $agez = $req->input('ages');
                        $genderz = $req->input('genders');
                        //image must be added here that will be converted to asset link when front end is created

                        $acc_exist = DB::table('users')->where('email',[$mail])->count()>0;
                        if($acc_exist){
                            $exist_acc_slno = DB::table('users')->select('slno')->where('email',$mail)->first();
                            if($exist_acc_slno->slno == $usersl){

                                $realmail = DB::table('users')->select('email')->where('slno',$usersl)->first();
                                DB::table('tokendb')->where('user_email',$realmail->email)->delete();
                                
                                DB::table('users')->where('slno',$usersl)->update([
                                    'email'=> $mail,
                                    
                                    'country' => $countryz,
                                    'age'=> $agez,
                                    'gender'=> $genderz,
                                    'imglink'=> 'localdisk/something' // will update later
                
                        
                                ]);//update inside DB
                                return response()->json([
                                    'message' => 'Successful',
                                ],200);


                            }else{
                                return response()->json([
                                    'message' => 'Sorry Email Already Exist ... You Can Not Use Same Email Twice.',
                                ],200);
                            }
                            
                        }else{
                            $realmail = DB::table('users')->select('email')->where('slno',$usersl)->first();
                            DB::table('tokendb')->where('user_email',$realmail->email)->delete();

                            DB::table('users')->where('slno',$usersl)->update([
                                'email'=> $mail,
                                
                                'country' => $countryz,
                                'age'=> $agez,
                                'gender'=> $genderz,
                                'imglink'=> 'localdisk/something'// will update later
            
                    
                            ]);//update inside DB
                            return response()->json([
                                'message' => 'Successful Please Login Again.',
                            ],200);
                            
                            
                        }

                    }
                }else{
                    return response()->json([
                        'message' => 'Invalid Token According To Serial',
                        
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
