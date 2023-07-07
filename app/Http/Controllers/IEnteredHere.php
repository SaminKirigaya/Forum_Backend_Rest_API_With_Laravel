<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IEnteredHere extends Controller
{
    public function ienteredhere(Request $req, $usersl, $tokenz, $postno){
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    if(DB::table('posts')->where('slno',$postno)->count()>0){
                        $usersl= intval($usersl);
                        $postsel = DB::table('posts')->select('user_slno')->where('slno',$postno)->first();
                        if($usersl == $postsel->user_slno){
                            return response()->json([
                                'message'=>'Own Post'
                            ],200);
                        }else{
                            $lastview = DB::table('posts')->select('viewed')->where('slno',$postno)->first();
                            $lastview->viewed = $lastview->viewed+1;
                            DB::table('posts')->where('slno',$postno)->update([
                                'viewed'=> $lastview->viewed
                            ]);

                        }
                    }else{
                        return response()->json([
                            'message'=>'The Post May Have Been Removed.'
                        ],200);
                    }
                }else{
                    return response()->json([
                        'message'=>'Token Is Invalid According To Serial.'
                    ],200);
                }
            }else{
                return response()->json([
                    'message'=>'You Are Not Logged In.'
                ],200);
            }
        }else{
            return response()->json([
                'message'=>'Invalid User Serial'
            ],200);
        }
    }
}
