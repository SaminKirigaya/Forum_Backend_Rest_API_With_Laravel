<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AmILogged extends Controller
{
    public function amilogged(Request $req, $email){
        if(DB::table('tokendb')->where('user_email',$email)->count()>0){
            return response()->json([
                'message' => 'Yes'
            ],200);
        }else{
            return response()->json([
                'message' => 'No'
            ],200);
        }
    }
}
