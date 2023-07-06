<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Changeprofilepage extends Controller
{
    public function changeprofilepage(Request $req, $usersl, $tokenz){
        $num_exist = DB::table('users')->where('slno',$usersl)->count()>0; //if user serial no exist in users db
        if($num_exist){
        
            $is_logged_in = DB::table('tokendb')->where('token',$tokenz)->count()>0; //lets see if he has token in db
            if($is_logged_in){//he has it now

                $user_em = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $all_data = DB::table('users')->select('*')->where('email',$user_em->user_email)->get(); //taking all user slno related data
                foreach($all_data as $userdata){
                    $userSerial = $userdata->slno;
                    $userEmail = $userdata->email;
                    $userImg = $userdata->imglink;
                    $userCountry = $userdata->country;
                    $userAge = $userdata->age;
                    $userGender = $userdata->gender;
                    $userJoined = $userdata->joined;
                }
                return response()->json([
                    'message'=>'Successful',
                    'serial'=> $userSerial,
                    'email'=>$userEmail,
                    'imagelink'=>$userImg,
                    'country'=>$userCountry,
                    'age'=>$userAge,
                    'gender'=>$userGender,
                    'joined'=>$userJoined
                ], 200);// sent datas
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
