<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class Post extends Controller
{
    public function post(Request $req, $usersl, $tokenz){
        $user_real = DB::table('users')->where('slno',$usersl)->count()>0;
        if($user_real){
            $logged_in = DB::table('tokendb')->where('token',$tokenz)->count()>0;
            if($logged_in){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){

                    $validator = Validator::make($req->all(), [
                        'prob_type' => 'required',
                        'post' => 'required',
                        'prob_intro' => 'required'
                
                    ]);
                    if ($validator->fails()) {
                        return response()->json([
                            'message' => 'Validation failed',
                            'errors' => $validator->errors()
                        ], 200);
                    }else{
                        $probType = $req->input('prob_type');
                        $post = $req->input('post');
                        $probName = $req->input('prob_intro');

                        $charactersToReplace = ['<', '>', '/',';'];
                        $replacementCharacters = ['&lt;', '&gt;', '&#47;', '&#59;'];

                        $post = str_replace($charactersToReplace, $replacementCharacters, $post);
                        $probName = str_replace($charactersToReplace, $replacementCharacters, $probName);
                        $usr_sl = intval($usersl);

                        $insert = DB::table('posts')->insert([
                            'user_slno' => $usr_sl,
                            'user_post' => $post,
                            'viewed' => 0,
                            'total_comments' => 0,
                            'like_amount' => 0,
                            'dislike_amount' => 0,
                            'problem_type' => $probType,
                            'intro' => $probName
                        ]);

                        if($insert){
                            return response()->json([
                                'message' => 'Successful',
                                
                            ], 200);
                        }else{
                            return response()->json([
                                'message' => 'Sorry Some Error Occured.',
                                
                            ], 200);
                        }
                    }    
                }else{
                    return response()->json([
                        'message' => 'Invalid Token According To Userserial',
                        
                    ], 200);
                }    
            }else{
                return response()->json([
                    'message' => 'You Are Not Logged In ...',
                    
                ], 200);
            }
        }else{
            return response()->json([
                'message' => 'User Do Not Exist ...',
                
            ], 200);
        }
    }
}
