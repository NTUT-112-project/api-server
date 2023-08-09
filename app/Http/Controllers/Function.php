<?php

require_once('key.php');
$api_key = GPTAPI_key;

$task = "將得到的句子翻譯成英文";
$question = "原油可以以 1000:27 的比例分餾出乙烯";

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

$response = curl_exec($ch);
curl_close($ch);

$find = "content";
$pos = strpos($response, $find);

$R_response = substr($response, $pos + 11, -1);

$find = "finish_reason";
$pos = strrpos($R_response, $find);         // From offest -1 to search $find

$R_response = substr($R_response, 0, $pos - 18);
echo $R_response;

?>