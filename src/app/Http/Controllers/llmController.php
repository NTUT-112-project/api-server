<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Message;

class llmController extends Controller
{
    /**
     * returns a required translate result based on gpt
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function translate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'srcLanguage' => ['string'],
            'distLanguage' => ['required', 'string'],
            'srcText' => ['required', 'string'],
            'apiKey'=> ['required','string'],
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors(), "translation failed", 403);
        }

        if ($request['srcLanguage'] != 'none') {
            $task = "only translate the phrase below from " . $request['srcLanguage'] . " to " . $request['distLanguage'] . ", and do not change the meaning of the phrase or add any additional information and reply.";
        } else {
            $task = "only translate the phrase below to " . $request['distLanguage'] . ", and do not change the meaning of the phrase or add any additional information and reply.";
        }

        $question = $request['srcText'];

        $client = new Client(['base_uri' => 'http://ollama:11434/']);

        $response = $client->request('POST', 'api/chat', [
            "json" => [
                "model" => "phi3",
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
                "stream" => false,
            ],
        ]);
        if($response->getStatusCode()==200){
            $data_obj = json_decode($response->getBody()->getContents());
            // $translation = $data_obj->choices[0]->message->content;
            // return $this->sendResponse($translation, 'translation successful');
            return $this->sendResponse($data_obj, 'translation successful');
        }
        else
        {
            return $this->sendError($response->getBody(), 'translation failed');
        }
        
    }
}
