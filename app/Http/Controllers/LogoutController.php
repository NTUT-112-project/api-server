<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Str;
use App\Member;

class LogoutController extends Controller
{
   public function logout()
   {
       if ( Auth::user()->update(['api_token'=>'logged out'])) {//update api_token
           return $this->sendResponse([],"You've logged out");
       }
   }
}
