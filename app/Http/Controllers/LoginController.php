<?php

namespace App\Http\Controllers;


use Str;
use App\Models\User;//class for Users
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $User = User::where('email', $request->email)->where('password', $request->password)->first();
        $apiToken = Str::random(10); //generate an api_token
        if($User){
            if ($User->update(['api_token'=>$apiToken])) { //updata api_token
                if ($User->isAdmin)
                    return "login as admin, your api token is $apiToken";
                else
                    return "login as user, your api token is $apiToken";
            }
        }else return "Wrong email or password！";

    }
}
