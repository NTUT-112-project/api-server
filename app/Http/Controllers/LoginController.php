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
        $apiToken = Str::random(10); //generate an apiToken
        if($User){
            if ($User->update(['apiToken'=>$apiToken])) { //updata apiToken
                if ($User->isAdmin)
                    return "login as admin, your api token is $apiToken";
                else
                    return "login as user, your api token is $apiToken";
            }
        }else return "Wrong email or password！";

    }
}
