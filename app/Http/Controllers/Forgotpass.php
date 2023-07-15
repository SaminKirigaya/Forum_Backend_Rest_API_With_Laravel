<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotMail;


class Forgotpass extends Controller
{
    public function forgotpass(Request $req){
        $validator = Validator::make($req->all(), [
            'mail' => 'required|email',
             //have to add imagelink required condition
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 200);
        }else{
            $mail_exist = DB::table('users')->where('email',$req->input('mail'))->count()>0;
            if($mail_exist){
                $new_pass = Str::random(20);
                
                $usermail = $req->input('mail');


                if(Mail::to($usermail)->send(new ForgotMail($new_pass))){

                    $already_mail_here = DB::table('otp_smtp')->where('email',$usermail)->count()>0;
                    if($already_mail_here){
                        DB::table('otp_smtp')->where('email',$usermail)->delete();
                    }

                    $new_pass_hash = Hash::make($new_pass);
                    DB::table('otp_smtp')->insert([
                        'email'=> $usermail,
                        'otp' => $new_pass_hash
                    ]);
                    return response()->json([
                        'message' => 'Successful!!! Check Your Mail For New Password. After Login With That You Can Change Password As You Want !'
                    ],200);
                }



            }else{
                return response()->json([
                    'message' => 'Mail Do Not Exist In Database !!!',
                ],200);
            }
        }

    }
}
