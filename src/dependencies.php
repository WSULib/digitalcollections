<?php
// DIC configuration

$container = $app->getContainer();

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

    return $logger;
};

// Register Twig View helper
$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => false,
        'enableAutoReload' => true,
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    // Make Session available to twig
    $view->getEnvironment()->addGlobal('session', $_SESSION);

    return $view;
};

// Create a simple guzzle instance; use whenever you aren't calling to the API
// $this->guzzle->HTTPMETHOD invokes it
$container['guzzle'] = function ($c) {
    $request = new \GuzzleHttp\Client();
    return $request;
};

// Create a guzzle instance already set to query the API; invoked through the API Middleware with APIRequest
// NOTE: Use APIRequest, not APIClient; APIRequest will invoke APIClient and handle everything for you
$container['APIClient'] = function ($c) {
    $request = new \GuzzleHttp\Client(['base_uri' => $c->settings['API']['url'], 'http_errors' => FALSE]);
    return $request;
};

// Create an instance of the APIRequest Middleware; it uses the APIClient guzzle instance
// $this->APIRequest->HTTPMETHOD invokes it
$container['APIRequest'] = function ($c) {
    $API = new \App\Services\APIRequest($c['logger'], $c['APIClient']);
    return $API;
};

// Experimental Streaming data from the API
$container['APIStream'] = function ($c) {
    $API = new \App\Services\APIStream($c['logger'], $c['APIClient']);
    return $API;
};

// QueryBuilder
$container['QueryBuilder'] = function ($c) {
    $QueryBuilder = new \App\Services\QueryBuilder($c['logger']);
    return $QueryBuilder;
};

//Override the default Not Found Handler
$container['notFoundHandler'] = function ($container) {
    return function ($request, $response) use ($container) {        
        return $container['response']->withRedirect('/404');
    };
};

$container['debug'] = new PhpMiddleware\PhpDebugBar\PhpDebugBarMiddlewareFactory();
