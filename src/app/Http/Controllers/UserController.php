<?php

namespace App\Http\Controllers;

use App\Models\User;//class for users
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;//for data validation
use App\Http\Controllers\Controller;//base controller
use Illuminate\Support\Facades\Auth;//for Auth::user();returens the 
use Str;//for Str::random
use Illuminate\Http\JsonResponse;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function info()
    {
        if (Auth::user()->isAdmin) {
            return $this->sendResponse(User::all()->toArray(),'users retrieved successfully.');
        } else {
            $User=[
                'uid' => Auth::user()->uid,
                'email' => Auth::user()->email,
                'password' => Auth::user()->password,
            ];
            return $this->sendResponse($User,'users retrieved successfully.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
      public function adminStore(Request $request) {//register admin account
        try {
            $validator = Validator::make($request->all(), [ //data validation test
            'uid' => ['required','string', 'max:255', 'unique:users'],
            'email' => ['required','string', 'email', 'max:255', 'unique:users'],
            'password' => ['required','string', 'min:6', 'max:12'],
            ]);
            if ($validator->fails()) {
               return $this->sendError($validator->errors(),"Register failed",403);
            }
            $api_token = Str::random(10);
            $create = User::create([
                'uid' => $request['uid'],
                'email' => $request['email'],
                'password' => hash('sha256',$request['password'],false),
                'isAdmin' => '1',
                'api_token' => $api_token,
            ]);

            if ($create) {
                return $this->sendResponse($api_token,"Register as an admin.");
            }

        } catch (Exception $e) {
            return $this->sendError($e->getMessage(),'Registered failed.',500);
        }

    }
    public function store(Request $request)//register normal account
    {
        $validator = Validator::make($request->all(), [ //data validation test
        'uid' => ['required','string', 'max:255', 'unique:users'],
        'email' => ['required','string', 'email', 'max:255', 'unique:users'],
        'password' => ['required','string', 'min:6', 'max:12'],
        ]);
        if ($validator->fails()) {
            return $this->sendError($validator->errors(),"Register failed",403);
        }
        $api_token = Str::random(10);
        $create = User::create([
            'uid' => $request['uid'],
            'email' => $request['email'],
            'password' => hash('sha256', $request['password'], false),
            'api_token' => $api_token,
        ]);

        if ($create)
            return $this->sendResponse($api_token,"Register as a normal user.");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [ //data validation test
            'uid' => ['string', 'max:255', 'unique:users'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'password' => ['string', 'min:6', 'max:12'],
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(),'Validation Error.',422);
        }
        $User = Auth::user();
        if ($User->update([
            'uid' => $request['uid'],
            'email' => $request['email'],
            'password' => hash('sha256', $request['password'], false),
        ])){
            return $this->sendResponse($User->toArray(), 'User updated successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $users
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Request $request, $uid)
    {
        $user = User::where('uid', $uid)->first();
        if (!$user) {
            return $this->sendError([],'User not found',404);
        }
        $user->delete();
        return $this->sendResponse('user "'. $uid.'" deleted','User deleted successfully');
    }
}

