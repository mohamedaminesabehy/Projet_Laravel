<?php

$apiKey = 'AIzaSyA7GUSJHf2yCno4NNjqDtajFimEzXg3l00';
$url = "https://generativelanguage.googleapis.com/v1/models?key={$apiKey}";

$response = file_get_contents($url);

if ($response) {
    $data = json_decode($response, true);
    
    echo "=== MODÈLES DISPONIBLES ===\n\n";
    
    foreach ($data['models'] ?? [] as $model) {
        if (stripos($model['name'], 'gemini') !== false && 
            in_array('generateContent', $model['supportedGenerationMethods'] ?? [])) {
            echo "✅ " . $model['name'] . "\n";
            echo "   Méthodes: " . implode(', ', $model['supportedGenerationMethods']) . "\n";
            echo "   Description: " . ($model['description'] ?? 'N/A') . "\n\n";
        }
    }
} else {
    echo "❌ Erreur lors de la récupération des modèles\n";
}
