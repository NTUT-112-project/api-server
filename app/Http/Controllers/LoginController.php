<?php

namespace App\Http\Controllers;


use Str;
use App\Models\User;//class for Users
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if($request->email!=null){
            $User = User::where('email', $request->email)->where('password', $request->password)->first();
        } 
        else{
            $User = User::where('uid', $request->uid)->where('password', $request->password)->first();
        } 
        $api_token = Str::random(10); //generate an api_token
        if($User){
            if ($User->update(['api_token'=>$api_token])) { //updata api_token
                if ($User->isAdmin)
                    return "login as admin, your api token is $api_token";
                else
                    return "login as user, your api token is $api_token";
            }
        }else return "Wrong email or password！";

    }
}
