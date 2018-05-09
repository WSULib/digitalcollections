<?php
// Application middleware
// Use this file to add closure middlewares to invoke class middleware that reside in the Service directory
// e.g: $app->add(new \Slim\Csrf\Guard);
// Remember that you can invoke middleware by chaining it after $app, a route, or a group
// Keep $app invocations here to avoid cluttering up routes
// Reference: http://www.slimframework.com/docs/concepts/middleware.html


/**
 * Variable Middleware
 * Exposes useful variables and makes them available to all routes
 * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
 * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
 * @param  callable                                 $next     Next middleware
 *
 * @return \Psr\Http\Message\ResponseInterface
 */

use \Slim\Http\Request;
use \Slim\Http\Response;
use Slim\App;
use Tracy\Debugger;

$app->add(function (Request $request, Response $response, callable $next) {

    // $route = $request->getAttribute('route');
    // $name = $route->getName();
    // $groups = $route->getGroups();
    // $methods = $route->getMethods();
    // $arguments = $route->getArguments();

    $uri = $request->getUri();
    $path = substr($uri->getPath(), 1);

    // $request = $request->withAttribute('name', $name);
    // $request = $request->withAttribute('groups', $groups);
    // $request = $request->withAttribute('methods', $methods);
    // $request = $request->withAttribute('arguments', $arguments);
    $request = $request->withAttribute('path', $path);
    $request = $request->withAttribute('uri', $uri);

    return $next($request, $response);
});

/**
 * Login Check Middleware
 * Note: could have used a library like https://github.com/dflydev/dflydev-fig-cookies
 * but since the requirements are so low, a simple middleware suffices
 * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
 * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
 * @param  callable                                 $next     Next middleware
 *
 * @return \Psr\Http\Message\ResponseInterface
 */
$app->add(function (Request $request, Response $response, callable $next) {
    // get settings
    $settings = $this->get('settings');

    // set host
    $host = $settings['server']['host'];
    // Check for the WSUDOR Cookie
    if (isset($_COOKIE['WSUDOR'])) {
        $this->logger->debug("wsudorauth: WSUDOR cookie found, checking");
        if (!isset($_SESSION['wsudorauth'])) {
            // No active wsudorauth session; ask /wsudorauth service if cookie is valid
            try {
                // now make sure WSUDOR cookie string hasn't been faked
                $session_check = $this->guzzle->get("http://$host/wsudorauth/session_check/$_COOKIE[WSUDOR]");
                $session_check = json_decode($session_check->getBody());
                session_start();
                $_SESSION['wsudorauth'] = $session_check;
            } catch (GuzzleHttp\Exception\ClientException $e) {
                // cookie not good bc either bad actor faked it or it is old
                // trigger an exception if getting a 400 level error
                // destroy cookie; destroy session
                setcookie("WSUDOR", "", time()-3600);
                $this->logger->debug("wsudorauth: destroying session from bad session check");
                session_destroy();
            } //catch
        } //isset
        else {
            // if there's an active wsudorauth session, no need to query wsudorauth with a WSUDOR cookie for a valid session
            // Let's just check to see if they are admin
            $this->logger->debug("wsudorauth: wsudorauth session set, checking status of user ".$_SESSION['wsudorauth']->username);
            try {
                if (!$_SESSION['admin']) {
                    $username = $_SESSION['wsudorauth']->username;
                    $admin = $this->guzzle->get("http://$host/api/user/$username/whoami");
                    $admin = json_decode($admin->getBody());                    
                    $_SESSION['admin'] = $admin->response->exists; // they are Ouroboros user, so we consider "admin" here                    
                }
            } catch (GuzzleHttp\Exception\ClientException $e) {
                // destroy session; no need to destroy cookie because this still allows them to use other related services
                session_destroy();
            } //catch            

        } //else
    } //$_COOKIE['WSUDOR']

    /* Removing: can look into more surgically doing this, but for time being, breaking "sticky" layouts from search */
    // else {
    //     // no cookie; kill any session that's still active;
    //     // we're assuming they logged out, so killing any session will prevent them from
    //     // floating around with no cookie and an old (but still good) session
    //     session_destroy();
    // }
    return $next($request, $response);
});

/**
 * Media Type Parser Middleware
 * See Media Type Parsers section at http://www.slimframework.com/docs/objects/request.html#route-object
 * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
 * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
 * @param  callable                                 $next     Next middleware
 *
 * @return \Psr\Http\Message\ResponseInterface
 */

// $app->add(function ($request, $response, $next) {
//     // add media parser
//     $request->registerMediaTypeParser(
//         "text/javascript",
//         function ($input) {
//             return json_decode($input, true);
//         }
//     );

//     return $next($request, $response);
// });

/**
 * Debug Mode
 * Currently using:
 * Tracy Debugger Bar
 * Uses https://github.com/runcmf/runtracy
 * Add other middleware below in similar format; also add any dependencies into the debug section found
 * in the dependency container (dependencies.php); finally, has a section in settings.php that sets its default features/display
 */
$container = $app->getContainer();
$settings = $container->get('settings');
if ($settings['debug']) {
    // Set a debug cookie; this will tell varnish to not cache any responses while debug mode is on
    if (!isset($_COOKIE['SLIMDEBUG'])) {
        setcookie("SLIMDEBUG", true, time()+3600);
    }
    $app->add(new RunTracy\Middlewares\TracyMiddleware($app));
    Debugger::enable(Debugger::DEVELOPMENT,  __DIR__ . '/../logs' );
    Debugger::$maxDepth = 20; // default: 3
    Debugger::$maxLength = 150; // default: 150
} else {
    // Since debug is not on right now, let's make sure there is no old debug mode cookie set
    if (isset($_COOKIE['SLIMDEBUG'], $_COOKIE['tracyPanelsEnabled'])) {
        setcookie("SLIMDEBUG", "", time()-3600);
        $params = session_get_cookie_params();
        setcookie("tracyPanelsEnabled", '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
    }
}

       
/**
 * Redirects/rewrites URLs with a / to a non-trailing / equivalent
 * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
 * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
 * @param  callable                                 $next     Next middleware
 *
 * @return mixed
 */
$app->add(function (Request $request, Response $response, callable $next) {
    $uri = $request->getUri();
    $path = $uri->getPath();
    if ($path != '/' && substr($path, -1) == '/') {
        // permanently redirect paths with a trailing slash
        // to their non-trailing counterpart
        $uri = $uri->withPath(substr($path, 0, -1));
        
        if ($request->getMethod() == 'GET') {
            return $response->withRedirect((string)$uri, 301);
        } else {
            return $next($request->withUri($uri), $response);
        }
    }

    return $next($request, $response);
});
