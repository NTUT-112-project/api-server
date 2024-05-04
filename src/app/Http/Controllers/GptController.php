<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Message;

class GptController extends Controller
{
    /**
     * returns a required translate result based on gpt
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function gpt_translate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'srcLanguage' => ['string'],
            'distLanguage' => ['required', 'string'],
            'srcText' => ['required', 'string'],
            'gptApiKey'=> ['required','string'],
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), "translation failed", 403);
        }

        $api_key = $request['gptApiKey']; // Use environment variable or config for API key

        if ($request['srcLanguage'] != 'none') {
            $task = "translate the phrase below from " . $request['srcLanguage'] . " to " . $request['distLanguage'];
        } else {
            $task = "translate the phrase below to " . $request['distLanguage'];
        }

        $question = $request['srcText'];

        $client = new Client(['base_uri' => 'https://api.openai.com/']);

        $response = $client->request('POST', 'v1/chat/completions', [
            'verify' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $api_key,
            ],
            'json' => [
                "model" => "gpt-3.5-turbo",
                "messages" => [
                    [
                        "role" => "system",
                        "content" => $task,
                    ],
                    [
                        "role" => "user",
                        "content" => $question,
                    ]
                ],
                "temperature" => 0,
                "max_tokens" => 256,
                "top_p" => 1,
                "frequency_penalty" => 0,
                "presence_penalty" => 0
            ]
        ]);
        if($response->getStatusCode()==200){
            $data_obj = json_decode($response->getBody()->getContents());
            $translation = $data_obj->choices[0]->message->content;
            return $this->sendResponse($translation, 'translation successful');
        }
        else
        {
            return $this->sendError($response->getBody(), 'translation failed');
        }
        
    }
}
