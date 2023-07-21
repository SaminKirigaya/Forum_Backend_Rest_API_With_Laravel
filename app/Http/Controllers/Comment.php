<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Comment extends Controller
{
    public function comment(Request $req, $usersl, $probslno){
        $tokenz = $req->bearerToken();
        if(DB::table('users')->where('slno',$usersl)->count()>0){
            if(DB::table('tokendb')->where('token',$tokenz)->count()>0){

                $tok_email = DB::table('tokendb')->select('user_email')->where('token',$tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno',$usersl)->first();
                if($tok_email->user_email == $usrsl_email->email){

                    $probslnum = intval($probslno);
                    if(DB::table('posts')->where('slno',$probslnum)->count()>0){
                        $validator = Validator::make($req->all(), [
                            'comment' => 'required'

                        ]);
                        if ($validator->fails()) {
                            return response()->json([
                                'message' => 'Validation failed',
                                'errors' => $validator->errors()
                            ], 200);
                        }else{
                            $com = $req->input('comment');
                            $charactersToReplace = ['<', '>', '/', ';'];
                            $replacementCharacters = ['&lt;', '&gt;', '&#47;', '&#59;'];

                            $commnt = str_replace($charactersToReplace, $replacementCharacters, $com);
                            $userslnum = intval($usersl);

                            $com_submit = DB::table('comments')->insert([
                                'post_slno'=> $probslnum,
                                'comment_user_slno'=> $userslnum,
                                'comment'=> $commnt,
                                'like_amount'=>0,
                                'dislike_amount'=>0
                            ]);
                            

                            if($com_submit){
                                $author = DB::table('posts')->select('user_slno')->where('slno',$probslnum)->first();
                                $commenter = DB::table('users')->select('email')->where('slno',$usersl)->first();
                                if($author->user_slno != intval($usersl )){
                                    DB::table('notification')->insert([
                                        'owner_slno' => $author->user_slno,
                                        'commenter_slno' => $usersl,
                                        'commenter_email' => $commenter->email,
                                        'reason' => 'Commenter In Your Post.',
                                        'post_slno' => $probslnum
                                    ]);
                                }

                                $comnt = DB::table('posts')->select('total_comments')->where('slno',$probslnum)->first();
                                $comnt->total_comments = $comnt->total_comments+1;
                                DB::table('posts')->where('slno',$probslnum)->update([
                                    'total_comments'=> $comnt->total_comments
                                ]);

                                $posts = DB::table('posts')->select('*')->where('slno',$probslnum)->first();
                                $user = DB::table('users')->select('email','imglink')->where('slno', $posts->user_slno)->first();
                                if ($user) {
                                    $posts->author = $user->email;
                                    $posts->image = $user->imglink;
                                }

                                $comments = DB::table('comments')->select('*')->where('post_slno',$posts->slno)->orderBy('slno','desc')->get();

                                if($comments->count() == 1){
                                    $comments = DB::table('comments')->select('*')->where('post_slno',$posts->slno)->first();
                                    $users = DB::table('users')->select('email','imglink')->where('slno',$comments->comment_user_slno)->first();
                                    $comments->author = $users->email;
                                    $comments->image = $users->imglink;

                                }else{
                                    foreach($comments as $comnt){
                                        $users = DB::table('users')->select('email','imglink')->where('slno',$comnt->comment_user_slno)->first();

                                        $comnt->author = $users->email;
                                        $comnt->image = $users->imglink;
                                    }
                                }
                                return response()->json([
                                    'message'=>'Comment Successful',
                                    'update_post' => $posts,
                                    'comments' => $comments
                                ],200);
                                

                            }else{
                                return response()->json([
                                    'message'=>'Comment Failed'
                                ],200);
                            }
                        }    
                    }else{
                        return response()->json([
                            'message'=>'Post No Longer Exists...'
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
                'message'=>'User Does Not Exist'
            ],200);
        }
    }
}
