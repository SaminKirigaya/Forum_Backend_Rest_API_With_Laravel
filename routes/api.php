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
use App\Http\Controllers\DelPersonalCom;
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

    // Routes that require CORS middleware
    
Route::post('/regs',[Registration::class,'registration']); //registration we need to update image link later

Route::post('/login',[Login::class,'login']); //login

Route::get('/profile/{usersl}',[Profile::class,'profile']); //watching profile page api

Route::get('/changeprofilepage/{usersl}',[Changeprofilepage::class,'changeprofilepage']); // page api for profile page data changing not submiting button

Route::get('/changepasspage/{usersl}',[Changepasspage::class,'changepasspage']); //page api for password change page not submitting button

Route::post('/changeprofilesub/{usersl}',[Changeprofilesub::class,'changeprofilesub']); //after profile edit submit button clik

Route::post('/changepasssub/{usersl}',[Changepasssub::class,'changepasssub']);// after pass submit button clik 

Route::get('/logout/{usersl}',[Logout::class,'logout']); // after logout is clicked

Route::get('/delete',[Delete::class,'delete']); // direct accoount deleting

Route::post('/forgotpass',[Forgotpass::class,'forgotpass']); // forgot password after giving email

Route::post('/post/{usersl}',[Post::class,'post']); // posting a post

Route::get('/postTypes',[Posttypes::class,'posttypes']); // get types of posts when some one edit his post or write first time

Route::get('/homepost',[HomepagePost::class,'homepagepost']); //get random post data for homepage at first page but no view more button there if user logged out

Route::get('/latestpost',[LatestPost::class,'latestpost']); // latest post in sidebar

Route::get('/topic/{codename}',[Topicpost::class,'topicpost']); //navbar dropdown choice to see which code language problem u want

Route::get('/mypost/{usersl}',[MyPost::class,'mypost']); // seeing own post in profile each post will have a button with its serial no

Route::get('/mypostedit/{usersl}/{postno}',[MyPostEdit::class,'mypostedit']); // my post edit page where we see old data first 

Route::post('/myposteditsub/{usersl}/{postno}',[MyPostEditSub::class,'myposteditsub']); // after editing my post in profile clicking the button it work

Route::post ('/searchpost/{usersl}',[SearchPost::class,'searchpost']); // after client logging if search a post

Route::get('/solve/{usersl}/{probslno}',[Solve::class,'solve']); //solving page where we see post comment and see comments for this specific prob no

Route::post('/comment/{usersl}/{probslno}',[Comment::class,'comment']); //submit comment with click

Route::get('/mypostdelete/{usersl}/{postno}',[MyPostDelete::class,'mypostdelete']); // after clicking delete confirm

Route::get('/mycommentedPost/{usersl}',[MyCommentedPost::class,'mycommentedpost']); // when i just go to my comment page to see all post where I comment (no comment shown here only the post data) with the post detail button

Route::get('/mycommentspecific/{usersl}/{postno}',[MyCommentSpecific::class,'mycommentspecific']); // now i will go to that specific post in different page and see what we all commented while my comment is at top

Route::get('/ientered/{usersl}/{postno}',[IEnteredHere::class,'ienteredhere']); // whenever we click view more in post div or comment profile page and see other page view more

Route::get('/postlike/{usersl}/{postno}',[PostLike::class,'postlike']); // post like button click

Route::get('/postdislike/{usersl}/{postno}',[PostDisLike::class,'postdislike']); // post dislike button click

Route::get('/comlike/{usersl}/{comntno}',[ComLike::class,'comlike']); // comment like button click

Route::get('/comdislike/{usersl}/{comntno}',[ComDisLike::class,'comdislike']); // comment like button click

Route::get('/mypostcomdel/{usersl}/{comntno}',[MyPostComDel::class,'mypostcomdel']); // when seeing own post in profile uwll see abutton to delete that post comment

Route::get('/report/{usersl}/{postno}',[Report::class,'report']); // reporting Posts

Route::get('/delpersonalcom/{usersl}/{comntno}',[DelPersonalCom::class,'delpersonalcom']); // deleting personal comments where commenter sl num is deleters tokenz mail number based user sl same
