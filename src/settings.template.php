<?php

defined('DS') || define('DS', DIRECTORY_SEPARATOR);
define('DIR', realpath(__DIR__ . '/../') . DS);

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'determineRouteBeforeAppMiddleware' => true, // Only set this if you need access to route within middleware
        'debug' => false, // Allow the debug bar panel (perhaps other future displays/modes to appear)

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

        // server
        'server' => [
            'host' => 'VM_HOST'
        ],

        // API settings
        'API' => [
            'url' => 'https://VM_HOST/api/',
            'username' => null,
            'password' => null,
            'prefix' => 'api'
        ],

        // contact form settings
        'contact_form' => [
            'general' => 'email',
            'permissions' => 'email',
            'rap' => 'email',
            'passphrase' => 'string'
        ],

        // facet map
        'facet_map' => [
            'human_isMemberOfCollection' => 'Collection',
            'human_hasContentModel' => 'Content Type',
            'facet_mods_year' => 'Date',
            'dc_subject' => 'Subject',
            'dc_creator' => 'Creator',
            'dc_coverage' => 'Coverage',
            'dc_language' => 'Language',
            'dc_publisher' => 'Publisher',
            'text' => 'Keyword',
            'metadata' => 'Metadata Keyword',
            'int_fullText' => 'Fulltext Keyword',
            'mods_key_date_year' => 'Date'
        ],
        
        'tracy' => [
            'showPhpInfoPanel' => 1,
            'showSlimRouterPanel' => 1,
            'showSlimEnvironmentPanel' => 1,
            'showSlimRequestPanel' => 1,
            'showSlimResponsePanel' => 1,
            'showSlimContainer' => 1,
            'showTwigPanel' => 1,
            'showProfilerPanel' => 1,
            'showVendorVersionsPanel' => 1,
            'showXDebugHelper' => 1,
            'showIncludedFiles' => 1,
            'showConsolePanel' => 1,
            'configs' => [
                // XDebugger IDE key
                //'XDebugHelperIDEKey' => 'PHPSTORM',
                // Disable login (don't ask for credentials, be careful) values ( 1 | 0 )
                'ConsoleNoLogin' => 0,
                // Multi-user credentials values( ['user1' => 'password1', 'user2' => 'password2'] )
                'ConsoleAccounts' => [
                    'ouroboros' => 'changeME' // = sha1(Whatever password you want to put here)
                ],
                // Password hash algorithm (password must be hashed) values('md5', 'sha256' ...)
                'ConsoleHashAlgorithm' => 'sha1',
                // Home directory (multi-user mode supported) values ( var || array )
                // '' || '/tmp' || ['user1' => '/home/user1', 'user2' => '/home/user2']
                'ConsoleHomeDirectory' => __DIR__,
                // terminal.js full URI
                'ConsoleTerminalJs' => '/js/jquery.terminal.min.js',
                // terminal.css full URI
                'ConsoleTerminalCss' => '/css/jquery.terminal.min.css',
                'ProfilerPanel' => [
                    // Memory usage 'primaryValue' set as Profiler::enable() or Profiler::enable(1)
//                    'primaryValue' =>                   'effective',    // or 'absolute'
                    'show' => [
                        'memoryUsageChart' => 1, // or false
                        'shortProfiles' => true, // or false
                        'timeLines' => true // or false
                    ]
                ]
            ]
        ] //tracy
    ],
];
