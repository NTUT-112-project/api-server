<?php

namespace App\Http\Controllers;

use App\Models\User;//class for Users
use Illuminate\Http\Request;
use Validator;//for data validation
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
            return $this->sendResponse(User::all()->toArray(),'Users retrieved successfully.');
        } else {
            $User=[
                'uid' => Auth::user()->uid,
                'mail' => Auth::user()->email,
                'password' => Auth::user()->password,
            ];
            return $this->sendResponse($User,'Users retrieved successfully.');
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
            'uid' => ['required','string', 'max:255', 'unique:Users'],
            'email' => ['required','string', 'email', 'max:255', 'unique:Users'],
            'password' => ['required','string', 'min:6', 'max:12'],
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
            $apiToken = Str::random(10);
            $create = User::create([
                'uid' => $request['uid'],
                'email' => $request['email'],
                'password' => $request['password'],
                'isAdmin' => '1',
                'apiToken' => $apiToken,
            ]);

            if ($create) {
                return "Register as an admin. Your Token is $apiToken.";
            }

        } catch (Exception $e) {
            return $this->sendError($e->getMessage(),'Registered failed.',500);
        }

    }
    public function store(Request $request)//register normal account
    {
        $validator = Validator::make($request->all(), [ //data validation test
        'uid' => ['required','string', 'max:255', 'unique:Users'],
        'email' => ['required','string', 'email', 'max:255', 'unique:Users'],
        'password' => ['required','string', 'min:6', 'max:12'],
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        $apiToken = Str::random(10);
        $create = User::create([
            'uid' => $request['uid'],
            'email' => $request['email'],
            'password' => $request['password'],
            'apiToken' => $apiToken,
        ]);

        if ($create)
            return "Register as a normal user. Your api token is $apiToken";
        else
            return $validateResult;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $Users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [ //data validation test
            'uid' => ['string', 'max:255', 'unique:Users'],
            'email' => ['string', 'email', 'max:255', 'unique:Users'],
            'password' => ['string', 'min:6', 'max:12'],
        ]);

        if ($validator->fails()) {
            return sendError($validator->errors(),'Validation Error.',422);
        }
        $User = Auth::user();
        if ($User->update($request->all()))
            return $this->sendResponse($User->toArray(),'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $Users
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $Users)
    {
        if (Auth::user()->isAdmin){
            if ($Users->delete())
                return $this->sendResponse($Users->toArray(),'User deleted successfully.');
        }
        else
            return "You have no authority to delete";
    }
}
