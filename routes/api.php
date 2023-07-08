<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Registration;
use App\Http\Controllers\Login;
use App\Http\Controllers\Profile;
use App\Http\Controllers\Changeprofilepage;
use App\Http\Controllers\Changepasspage;
use App\Http\Controllers\Changeprofilesub;
use App\Http\Controllers\Changepasssub;
use App\Http\Controllers\Logout;
use App\Http\Controllers\Delete;
use App\Http\Controllers\Forgotpass;
use App\Http\Controllers\Post;
use App\Http\Controllers\Posttypes;
use App\Http\Controllers\HomepagePost;
use App\Http\Controllers\LatestPost;
use App\Http\Controllers\Topicpost;
use App\Http\Controllers\MyPost;
use App\Http\Controllers\SearchPost;
use App\Http\Controllers\Solve;
use App\Http\Controllers\Comment;
use App\Http\Controllers\MyPostEdit;
use App\Http\Controllers\MyPostEditSub;
use App\Http\Controllers\MyPostDelete;
use App\Http\Controllers\MyCommentedPost;
use App\Http\Controllers\MyCommentSpecific;
use App\Http\Controllers\IEnteredHere;
use App\Http\Controllers\PostLike;
use App\Http\Controllers\PostDisLike;
use App\Http\Controllers\ComLike;
use App\Http\Controllers\ComDisLike;
use App\Http\Controllers\MyPostComDel;
use App\Http\Controllers\Report;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/regs',[Registration::class,'registration']); //registration we need to update image link later

Route::post('/login',[Login::class,'login']); //login

Route::get('/profile/{usersl}/{tokenz}',[Profile::class,'profile']); //watching profile page api

Route::get('/changeprofilepage/{usersl}/{tokenz}',[Changeprofilepage::class,'changeprofilepage']); // page api for profile page data changing not submiting button

Route::get('/changepasspage/{usersl}/{tokenz}',[Changepasspage::class,'changepasspage']); //page api for password change page not submitting button

Route::post('/changeprofilesub/{usersl}/{tokenz}',[Changeprofilesub::class,'changeprofilesub']); //after profile edit submit button clik

Route::post('/changepasssub/{usersl}/{tokenz}',[Changepasssub::class,'changepasssub']);// after pass submit button clik 

Route::get('/logout/{usersl}/{tokenz}',[Logout::class,'logout']); // after logout is clicked

Route::get('/delete/{tokenz}',[Delete::class,'delete']); // direct accoount deleting

Route::post('/forgotpass',[Forgotpass::class,'forgotpass']); // forgot password after giving email

Route::post('/post/{usersl}/{tokenz}',[Post::class,'post']); // posting a post

Route::get('/postTypes',[Posttypes::class,'posttypes']); // get types of posts when some one edit his post or write first time

Route::get('/homepost',[HomepagePost::class,'homepagepost']); //get random post data for homepage at first page but no view more button there if user logged out

Route::get('/latestpost',[LatestPost::class,'latestpost']); // latest post in sidebar

Route::get('/topic/{codename}',[Topicpost::class,'topicpost']); //navbar dropdown choice to see which code language problem u want

Route::get('/mypost/{usersl}/{tokenz}',[MyPost::class,'mypost']); // seeing own post in profile each post will have a button with its serial no

Route::get('/mypostedit/{usersl}/{tokenz}/{postno}',[MyPostEdit::class,'mypostedit']); // my post edit page where we see old data first 

Route::post('/myposteditsub/{usersl}/{tokenz}/{postno}',[MyPostEditSub::class,'myposteditsub']); // after editing my post in profile clicking the button it work

Route::post ('/searchpost/{usersl}/{tokenz}',[SearchPost::class,'searchpost']); // after client logging if search a post

Route::get('/solve/{usersl}/{tokenz}/{probslno}',[Solve::class,'solve']); //solving page where we see post comment and see comments for this specific prob no

Route::post('/comment/{usersl}/{tokenz}/{probslno}',[Comment::class,'comment']); //submit comment with click

Route::get('/mypostdelete/{usersl}/{tokenz}/{postno}',[MyPostDelete::class,'mypostdelete']); // after clicking delete confirm

Route::get('/mycommentedPost/{usersl}/{tokenz}',[MyCommentedPost::class,'mycommentedpost']); // when i just go to my comment page to see all post where I comment (no comment shown here only the post data) with the post detail button

Route::get('/mycommentspecific/{usersl}/{tokenz}/{postno}',[MyCommentSpecific::class,'mycommentspecific']); // now i will go to that specific post in different page and see what we all commented while my comment is at top

Route::get('/ientered/{usersl}/{tokenz}/{postno}',[IEnteredHere::class,'ienteredhere']); // whenever we click view more in post div or comment profile page and see other page view more

Route::get('/postlike/{usersl}/{tokenz}/{postno}',[PostLike::class,'postlike']); // post like button click

Route::get('/postdislike/{usersl}/{tokenz}/{postno}',[PostDisLike::class,'postdislike']); // post dislike button click

Route::get('/comlike/{usersl}/{tokenz}/{comntno}',[ComLike::class,'comlike']); // comment like button click

Route::get('/comdislike/{usersl}/{tokenz}/{comntno}',[ComDisLike::class,'comdislike']); // comment like button click

Route::get('/mypostcomdel/{usersl}/{tokenz}/{comntno}',[MyPostComDel::class,'mypostcomdel']); // when seeing own post in profile uwll see abutton to delete that post comment

Route::get('/report/{usersl}/{tokenz}/{postno}',[Report::class,'report']);