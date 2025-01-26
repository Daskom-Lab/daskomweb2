<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default CORS Settings
    |--------------------------------------------------------------------------
    |
    | Here you may configure your CORS settings for the application. The default
    | configuration allows all domains, headers, and methods, but you can
    | adjust these values to match the needs of your application.
    |
    */

    'paths' => ['api-v1/*', 'sanctum/csrf-cookie', 'asisten/*', 'praktikan/*', 'login/asisten','login/praktikan'], // Apply CORS to specific routes like API and CSRF

    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], // Allow all HTTP methods (GET, POST, PUT, DELETE, etc.)

    'allowed_origins' => ['http://localhost:5173, http://127.0.0.1:5173, http://localhost:8000'], // Allow all origins; you can replace '*' with specific domains, e.g. ['https://example.com']

    'allowed_origins_patterns' => [], // Allow specific patterns (e.g., 'https://*.example.com')

    'allowed_headers' => ['*'], // Allow all headers (you can specify specific headers like ['Content-Type', 'X-Requested-With'])

    'exposed_headers' => ['Authorization'], // Headers that are allowed to be exposed in the response

    'max_age' => 3600, // Time (in seconds) that the browser should cache preflight response

    'supports_credentials' => true, // Set to true to allow cookies and credentials (important for authentication)
];
