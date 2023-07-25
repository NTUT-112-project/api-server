<?php
// Use Folloing code in terminal at app folder
// composer require openai-php/client
// composer require php-http/discovery php-http/async-client-implementation:*

ini_set('include_path', dirname(dirname(dirname(__FILE__))));
require_once('vendor//autoload.php');
// For loading OpenAI libary

require_once('key.php');
$api_key = GPTAPI_key;
// For safety reason

$client = OpenAI::client($api_key);

$question_to_GPT = "將下列文本翻譯至中文:";

$question = "The magnitude of the universe is unimaginable.
And our world is just a cloud of dust compared to universe .";

$prompt = $question_to_GPT . $question;

$result = $client->chat()->create([
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'user', 'content' => $prompt]
    ],
]);
// Use "text-davinci-003" need to set "max_token"

echo $result['choices'][0]['message']['content']; 
// Response only 4096 token (16384 characters)

?>