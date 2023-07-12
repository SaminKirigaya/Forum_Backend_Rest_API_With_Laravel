<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;



class Registration extends Controller
{
    public function registration(Request $req){

        $validator = Validator::make($req->all(), [
            'email' => 'required|email',
            'pass' => 'required|regex:/^([a-zA-Z0-9*!@]+){6,50}$/',
            'cpass' => 'required|same:pass',
            'countrys' => 'required|regex:/^([a-zA-Z]+)$/',
            'ages' => 'required|numeric|min:7|max:90',
            'genders' => 'required|regex:/^([a-zA-Z]+)$/' ,
            'images' => 'required|image|mimes:JPEG,JPG,jpg,jpeg|max:1024'//have to add imagelink required condition
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
                'errors' => $validator->errors()
            ], 200);
        }else{
            $mail = $req->input('email');
            $pass = $req->input('pass');
            $countryz = $req->input('countrys');
            $agez = $req->input('ages');
            $genderz = $req->input('genders');
            $uploadedFile = $req->file('images');
            $directory = 'public/images';
            $fileName = uniqid() . '.' . $uploadedFile->getClientOriginalExtension();
            //image must be added here that will be converted to asset link when front end is created

            $acc_exist = DB::table('users')->where('email',[$mail])->count()>0;
            //if account exist
            if($acc_exist){
                return response()->json([
                    'message' => 'Sorry Email Already Exist ... You Can Not Use Same Email Twice.',
                ],200);
            }else{

                //make hash pass
                $uploadedFile->storeAs($directory, $fileName);
                $url = url(Storage::url("$directory/$fileName"));
                $pass2 = Hash::make($pass);
                DB::table('users')->insert([
                    'email'=> $mail,
                    'pass'=> $pass2,
                    'country' => $countryz,
                    'age'=> $agez,
                    'gender'=> $genderz,
                    'imglink'=> $url //will update later

        
                ]);//enter inside DB
                //set initial recover pass
                
                DB::table('otp_smtp')->insert([
                    'email'=> $mail,
                    'otp'=> $pass2
                    

        
                ]);
                //successful
                return response()->json([
                    'message' => 'Registration Successful Please Login With Your Credential For First Time.',
                ],200);
    

            }



        }


        



            

            

            
 
            
        


        

    }
}
