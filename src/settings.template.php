<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => true, // Only set this if you need access to route within middleware

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // API settings
        'API' => [
            'url' => 'http://localhost/api/',
            'username' => null,
            'password' => null,
        ],

        // contact form settings
        'contact_form' => [
            'general' => 'email',
            'permissions' => 'email',
            'rap' => 'email',
            'passphrase' => 'string'
        ]
    ],
];
