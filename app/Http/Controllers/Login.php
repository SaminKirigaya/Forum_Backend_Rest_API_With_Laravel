<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class Login extends Controller
{
    public function login(Request $req){

        $validator = Validator::make($req->all(), [
            'email' => 'required',
            'password' => 'required'
            
        ]); //email and password must be sent from form
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 200);
        }else{
                $mail = $req->input('email');
                $pass = $req->input('password');

                $mail_in_tokendb = DB::table('tokendb')->where('user_email',[$mail])->count()>0;
                if($mail_in_tokendb){
                    return response()->json([
                        'message' => 'Sorry You Are Already Logged In ...',
                    ],200);
                }else{
                        $mail_exist = DB::table('users')->where('email',[$mail])->count()>0; //if email in database
                        if($mail_exist){
                            $Db_pass = DB::table('users')->select('pass')->where('email',$mail)->first(); //get emails same row pass
                            if(Hash::check($pass, $Db_pass->pass)){
                                $tokens = Str::random(150); //if pass match here create a token
                                DB::table('tokendb')->insert([ //upon login save the token inside token database
                                        'user_email' => $mail,
                                        'token' => $tokens
                                    ]);

                                $userdet = DB::table('users')->select('*')->where('email',[$mail])->get();
                                foreach ($userdet as $user) {
                                    $usersl = $user->slno;
                                    $usermail = $user->email;
                                // ... use the values as needed
                                }
                                return response()->json([
                                    'message' => 'Login Successful',
                                    'usersl' => $usersl,
                                    'useremail' => $usermail,
                                    'token' =>  $tokens
                                ],200); // send response after login
                

                            }else{
                                return response()->json([
                                    'message' => 'Sorry Password Does Not Match ... Make Sure To Insert Valid Password'
                                ],200);
                            } // wrong password
                        }else{
                                return response()->json([
                                    'message' => 'Sorry Email Do Not Exist ... Make Sure To Insert Valid User Email.'
                                ],200);
                            } //The email that was sent is false
                    }

            

            }

        
    } 
}
