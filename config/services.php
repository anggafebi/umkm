<?php

return [
    'whatsapp' => [
        'phone_id' => env('WHATSAPP_PHONE_ID'),
        'token' => env('WHATSAPP_TOKEN'),
        'number' => env('WHATSAPP_NUMBER'),
        'graph_version' => env('WHATSAPP_GRAPH_VERSION', 'v20.0'),
    ],
];
