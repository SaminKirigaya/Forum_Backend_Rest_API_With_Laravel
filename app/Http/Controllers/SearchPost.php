<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class SearchPost extends Controller
{
    public function searchpost(Request $req, $usersl, $searchdata){
        $tokenz = $req->bearerToken();
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){

                    $searchQuery = $searchdata;
                    $result = DB::table('posts')->select('*')->whereRaw("MATCH (user_post, intro) AGAINST(? IN BOOLEAN MODE)",[$searchQuery])->orderBy('slno','desc')->get();

                    if($result->count()==1){
                        $result = DB::table('posts')->select('*')->whereRaw("MATCH (user_post, intro) AGAINST(? IN BOOLEAN MODE)",[$searchQuery])->orderBy('slno','desc')->first();
                        $mailval = DB::table('users')->select('email')->where('slno',$result->user_slno)->first();
                        $result->author = $mailval->email;
                        return response()->json([
                            'message'=>'Successful',
                            'searchResult' => $result
                        ],200);

                    }else if($result->count()>1){
                        foreach($result as $resultdata){
                            $mailval = DB::table('users')->select('email')->where('slno',$resultdata->user_slno)->first();
                            $resultdata->author = $mailval->email;
                        }
                        return response()->json([
                            'message'=>'Successful',
                            'searchResult' => $result
                        ],200);
    

                    }else{
                        return response()->json([
                            'message'=>'Nothing Found On This Search.',
                            
                        ],200);
                    }
                    
                   



                }else{
                    return response()->json([
                        'message'=>'Invalid Serial According To Token.'
                    ],200);
                }
            }else{
                return response()->json([
                    'message' => 'User Not Logged In.'
                ],200);
            }
        }else{
            return response()->json([
                'message'=>'Invalid Serial Number'
            ],200);
        }
    }
}
