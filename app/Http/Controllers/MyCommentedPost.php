<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyCommentedPost extends Controller
{
    public function mycommentedpost(Request $req, $usersl)
    {
        $tokenz = $req->bearerToken();
        if (DB::table('users')->where('slno', $usersl)->count() > 0) {
            if (DB::table('tokendb')->where('token', $tokenz)->count() > 0) {
                $tok_email = DB::table('tokendb')->select('user_email')->where('token', $tokenz)->first();
                $usrsl_email = DB::table('users')->select('email')->where('slno', $usersl)->first();
                if ($tok_email->user_email == $usrsl_email->email) {
                    $all_my_comments = DB::table('comments')->select('*')->where('comment_user_slno', $usersl)->get();

                    if ($all_my_comments) {
                        if ($all_my_comments->count() == 1) {
                            $all_my_comments = DB::table('comments')->select('*')->where('comment_user_slno', $usersl)->first();

                            $all_mother_post = DB::table('posts')->select('*')->where('slno', $all_my_comments->post_slno)->first();
                            $author = DB::table('users')->select('email', 'imglink')->where('slno', $all_mother_post->user_slno)->first();
                            $all_mother_post->author = $author->email;
                            $all_mother_post->image = $author->imglink;

                            return response()->json([
                                'message' => 'Successful.',
                                'mother_post' => $all_mother_post
                            ], 200);
                        } else {
                            $all_my_comments = DB::table('comments')->select('*')->where('comment_user_slno', $usersl)->get();
                            $all_mother_post = []; // Initialize the variable

                            foreach ($all_my_comments as $all_com) {
                                $all_mother = DB::table('posts')->select('*')->where('slno', $all_com->post_slno)->orderBy('slno', 'desc')->first();
                                $all_mother_post[] = $all_mother;
                            }

                            foreach ($all_mother_post as $mother_post) {
                                $author = DB::table('users')->select('email', 'imglink')->where('slno', $mother_post->user_slno)->first();
                                $mother_post->author = $author->email;
                                $mother_post->image = $author->imglink;
                            }

                            return response()->json([
                                'message' => 'Successful.',
                                'mother_post' => $all_mother_post
                            ], 200);
                        }
                    } else {
                        return response()->json([
                            'message' => 'No Comment Yet'
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'message' => 'Token Is Invalid According To Serial.'
                    ], 200);
                }
            } else {
                return response()->json([
                    'message' => 'You Are Not Logged In.'
                ], 200);
            }
        } else {
            return response()->json([
                'message' => 'Invalid User Serial.'
            ], 200);
        }
    }
}
