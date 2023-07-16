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
}
