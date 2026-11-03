<?php

return [
    // Driver notifikasi: wakita (default) atau cloud.
    'whatsapp' => [
        'driver' => env('WHATSAPP_DRIVER', 'wakita'),
        'phone_id' => env('WHATSAPP_PHONE_ID'),
        'token' => env('WHATSAPP_TOKEN'),
        'number' => env('WHATSAPP_NUMBER'),
        'graph_version' => env('WHATSAPP_GRAPH_VERSION', 'v20.0'),
        'template_name' => env('WHATSAPP_TEMPLATE_NAME'),
        'reply_template_name' => env('WHATSAPP_REPLY_TEMPLATE_NAME'),
        'template_language' => env('WHATSAPP_TEMPLATE_LANGUAGE', 'id'),
    ],

    'wakita' => [
    'base_url' => env('WAKITA_BASE_URL', 'https://wakita.aminsproject.com/api/v1'),
    'api_key' => env('WAKITA_API_KEY'),

    'admin_numbers' => array_values(array_filter(
        array_map('trim', explode(',', env('WAKITA_ADMIN_NUMBERS', '')))
    )),
],
];
