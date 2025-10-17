<?php

$apiKey = 'AIzaSyA7GUSJHf2yCno4NNjqDtajFimEzXg3l00';
$model = 'gemini-2.0-flash-exp'; // ✅ Gemini 2.0 Flash Experimental

$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

$data = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Dis bonjour en français !']
            ]
        ]
    ]
];

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
        'content' => json_encode($data),
        'ignore_errors' => true,
    ],
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ]
]);

$response = file_get_contents($url, false, $context);
$httpCode = 200;
if ($response === false) {
    $httpCode = 500;
    $response = json_encode(['error' => 'Failed to connect']);
}

echo "HTTP Code: $httpCode\n\n";
echo "Response:\n";
echo $response . "\n";

if ($httpCode === 200) {
    $result = json_decode($response, true);
    if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
        echo "\n✅ SUCCESS! Gemini Response:\n";
        echo $result['candidates'][0]['content']['parts'][0]['text'] . "\n";
    }
}
