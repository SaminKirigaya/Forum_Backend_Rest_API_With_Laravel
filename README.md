<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>



# Advanced Interactive Forum Design

The whole project is created to make a full customized forum backend where a user will create id and share their problems to other, everyone will try to give each other solution.
You can use it if you like just mail me and give credit kindly also change my image to your.



## Features Updated

- Account Customization
- Changing Password With Authentication Via Mail
- Hashed System
- Report System In Post
- Post Like Dislike With Comment Like Dislike
- Post Deleting System
- Post Author Can Delete All Comments
- User Comment Deleting System
- Client Images Are Converted Before Saving With Intervention Image.
- Full User Profile Menu
- Now Users Can Individually Check each Other & Their Posts
- All Api Are Currently Working Fine With Our Frontend Project of React Js.
  

## Run Locally

Just clone the project then make sure to : 
Go .env file change 

APP_NAME=Forum
APP_ENV=local
APP_KEY=base64:udZiA7vf60JFvOShux3NbRcU2KC59e6QaZQ9lMFtOCc=
APP_DEBUG=true
APP_URL=http://192.168.0.109

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=forum
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME= Your Smtp Mail
MAIL_PASSWORD= That SMTP PASS
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="Your Email"
MAIL_FROM_NAME="${APP_NAME}"

Smtp was used for password changing at times of forget.
Forum.sql and Forum(1).sql are provided for database import both files are almost same its just one is quick exported!!! ENJOY

## Optimizations

Added more responsive view for different displays.
Made carousel effect optimized with respect to the device dislay change.


## API You Can Check In PostMan & Their Functions :
Some route reuire [{usersl} - a serial] that is fixed for each user at registration, [{codename} - problem type] , [{postno} - post serial no ] , [{comno} - comment no ], [{searchdata} - search values from frontend form ], [{highestsl} - highest notification serial number till that period of a user ] , [{emial} - user mail ] 

- Route::post('/regs',[Registration::class,'registration']); // For Registering A New User
- Route::post('/login',[Login::class,'login']); //login
- Route::get('/profile/{usersl}',[Profile::class,'profile']); // Each User After Registering Get Own Serial So Provide It With Link {usersl} also after Login They Get A Token both of this are used at time of authentication. This rout show profile data.
- 
- Route::get('/changeprofilepage/{usersl}',[Changeprofilepage::class,'changeprofilepage']); //Initial going to change profile data
- Route::post('/changeprofilesub/{usersl}',[Changeprofilesub::class,'changeprofilesub']);  // Profile Data after changing clicking submit
- Route::get('/changepasspage/{usersl}',[Changepasspage::class,'changepasspage']); //Changing Id pass page.
- Route::post('/changepasssub/{usersl}',[Changepasssub::class,'changepasssub']); // After changing pass clicking submit route.
- Route::get('/logout/{usersl}',[Logout::class,'logout']); // logout
- Route::get('/delete',[Delete::class,'delete']);  // Id delete this cases aredone with Token
- Route::post('/forgotpass',[Forgotpass::class,'forgotpass']); //Forgot pass route to get mail
- Route::post('/post/{usersl}',[Post::class,'post']);  // Posting
- Route::get('/postTypes',[Posttypes::class,'posttypes']); // Post types from type Database
- Route::get('/homepost',[HomepagePost::class,'homepagepost']);  // Random & Top posts showing in Home page
- Route::get('/topic/{codename}',[Topicpost::class,'topicpost']); // According to user problem type posts
- Route::get('/mypost/{usersl}',[MyPost::class,'mypost']); // Seeing own post in a page with comments
- Route::get('/mypostedit/{usersl}/{postno}',[MyPostEdit::class,'mypostedit']); // Parsing data from DB for editing of own post
- Route::post('/myposteditsub/{usersl}/{postno}',[MyPostEditSub::class,'myposteditsub']); //Submiting post after changing
- Route::get ('/searchpost/{usersl}/{searchdata}',[SearchPost::class,'searchpost']); // Search Field value sending to get post according to it.
- Route::get('/solve/{usersl}/{probslno}',[Solve::class,'solve']);  // Solving Problems in A page seeing comments there too
- Route::post('/comment/{usersl}/{probslno}',[Comment::class,'comment']); // Submiting comments
- Route::get('/mypostdelete/{usersl}/{postno}',[MyPostDelete::class,'mypostdelete']); // Personal post delete
- Route::get('/mycommentedPost/{usersl}',[MyCommentedPost::class,'mycommentedpost']); // Posts where user personally commented 
- Route::get('/mycommentspecific/{usersl}/{postno}',[MyCommentSpecific::class,'mycommentspecific']); // Finding own comment for a specific post
- Route::get('/ientered/{usersl}/{postno}',[IEnteredHere::class,'ienteredhere']); // After visiting someone's post a view adding function
- Route::get('/postlike/{usersl}/{postno}',[PostLike::class,'postlike']); // post like button click
- Route::get('/postdislike/{usersl}/{postno}',[PostDisLike::class,'postdislike']); // post dislike button click
- Route::get('/comlike/{usersl}/{comntno}',[ComLike::class,'comlike']); // comment like button click
- Route::get('/comdislike/{usersl}/{comntno}',[ComDisLike::class,'comdislike']); // comment like button click
- Route::get('/mypostcomdel/{usersl}/{comntno}',[MyPostComDel::class,'mypostcomdel']); // when seeing own post in profile uwll see abutton to delete that post comment
- Route::get('/report/{usersl}/{postno}',[Report::class,'report']); // reporting Posts
- Route::get('/delpersonalcom/{usersl}/{comntno}',[DelPersonalCom::class,'delpersonalcom']); // deleting personal comments where commenter sl num is deleters tokenz mail number based user sl same
- Route::get('/amilogged/{email}',[AmILogged::class,'amilogged']); // A user can check if he is logged in initially at startup if he had saved localstorage data in react js
- Route::get('/delmycom/{usersl}/{comno}',[DelMyCom::class,'delmycom']); // Deleting personal comemnts in others post
- Route::get('/admindeletecoms/{usersl}/{postno}/{comno}',[AdminDeleteComs::class,'admindeletecoms']); //Getting authority to delete all comments in personal post 
- Route::get('/notification/{usersl}',[Notification::class,'notification']); // Seeing personal notification
- Route::get('/delnotif/{usersl}/{highestsl}',[DelNotify::class,'delnotify']); // Deleting notification
- Route::get('/seeother/{usersl}/{mail}',[SeeOther::class,'seeother']); // Seeing other profile and their post by clicking their name in posts view page it can also be a comment 
