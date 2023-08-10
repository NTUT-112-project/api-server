<?php

namespace App\Http\Controllers;

use Error;
use Exception;
use Illuminate\Http\Request;
use Validator;

define('GPTAPI_key', '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');
class GptController extends Controller
{
    /**
     * returns a required translate result based on gpt
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function gpt_translate(Request $request)
    {
        $validator = Validator::make($request->all(), [ //data validation test
            'src_language' => ['string'],
            'dist_language' => ['required', 'string'],
            'phrase' => ['required', 'string'],
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors(), "translation failed", 403);
        } 

        $api_key = GPTAPI_key;
        if($request['src_language']!=null){
            $task = "translate from ".$request['src_language']." to ".$request['dist_language'];
        }
        else{
            $task = "translate to " . $request['dist_language'];
        }
        $question = $request['phrase'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $api_key,
        ]);

        curl_setopt($ch, CURLOPT_POSTFIELDS, "{
            \"model\": \"gpt-3.5-turbo\",
            \"messages\": [
                {
                    \"role\": \"system\",
                    \"content\": \"$task\"
                },
                {   
                    \"role\": \"user\",  
                    \"content\": \"$question\"
                }
            ],
            \"temperature\": 0,
            \"max_tokens\": 256,
            \"top_p\": 1,
            \"frequency_penalty\": 0,
            \"presence_penalty\": 0
        }");
        try{
            $response = curl_exec($ch);
            curl_close($ch);

            $find = "content";
            $pos = strpos($response, $find);

            $R_response = substr($response, $pos + 11, -1);

            $find = "finish_reason";
            $pos = strrpos($R_response, $find);         // From offest -1 to search $find

            $R_response = substr($R_response, 0, $pos - 18);
            return $this->sendResponse($response, 'translate successfully.');
        }
        catch (Exception $e){
            return $this->sendError($e, "translation failed", 500);
        }
    }
}
