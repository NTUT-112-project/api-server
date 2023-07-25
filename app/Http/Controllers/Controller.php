<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

//defines a class "Controller" within the namespace "App\Http\Controllers".
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    //AuthorizesRequests: provides authorization-related functionality,
    //allowing the controller to handle user authorization and permissions.
    //This trait includes methods for checking user access to certain resources or actions.

    //ValidatesRequests: provides validation-related functionality,
    //allowing the controller to validate incoming request data.
    //This trait includes methods for validating user input,
    //such as checking for required fields, data formats, or custom validation rules.
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $errorMessages,
        ];

        if(!empty($error)){
            $response['data'] = $error;
        }
        return response()->json($response, $code);
    }

}
