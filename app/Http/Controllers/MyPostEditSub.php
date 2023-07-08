<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class MyPostEditSub extends Controller
{
    public function myposteditsub(Request $req, $usersl, $postno){
        $tokenz = $req->bearerToken();
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){
                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){
                    if(DB::table('posts')->where('slno',$postno)->count()>0){
                        $postUsersl = DB::table('posts')->select('user_slno')->where('slno',$postno)->first();
                        $userslnum = intval($usersl);
                        if($postUsersl->user_slno == $userslnum){
                            $validator = Validator::make($req->all(), [
                                'introduction' => 'required',
                                'mainPost' => 'required',
                                'postType'=> 'required'
                                //have to add imagelink required condition
                            ]);
                            if ($validator->fails()) {
                                return response()->json([
                                    'message' => 'Validation failed',
                                    'errors' => $validator->errors()
                                ], 200);
                            }else{
                                //save it
                                $charactersToReplace = ['<', '>', '/',';'];
                                $replacementCharacters = ['&lt;', '&gt;', '&#47;','&#59;'];

                                $postName = str_replace($charactersToReplace, $replacementCharacters, $req->input('introduction'));
                                $probVal = str_replace($charactersToReplace, $replacementCharacters, $req->input('mainpost'));
                                $postType = $req->input('postType');

                                $updateDB = DB::table('posts')->where('slno',$postno)->update([
                                    'intro'=> $postName,
                                    'problem_type'=> $postType,
                                    'user_post'=> $probVal

                                ]);
                                if($updateDB){
                                    return response()->json([
                                        'message'=>'Post Update Successful.'
                                    ],200);
                                }else{
                                    return response()->json([
                                        'message'=>'Post Update Failed. Please try Later.'
                                    ],200);
                                }
                            }
                        }else{
                            return response()->json([
                                'message'=>'You Are Not Author Of This Post.'
                            ],200);
                        }
                    }else{
                        return response()->json([
                            'message'=>'Post No Longer Exists.'
                        ],200);
                    }
                }else{
                    return response()->json([
                        'message'=>'Token Is Invalid According To Serial.'
                    ],200);
                }
            }else{
                return response()->json([
                    'message'=>'You Are Not Even logged In.'
                ],200);
            }
        }else{
            return response()->json([
                'message'=>'User Do Not Exist.'
            ],200);
        }
    }
}
