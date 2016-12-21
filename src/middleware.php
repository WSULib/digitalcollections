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
    // Check for the WSUDOR Cookie
    if($_COOKIE['WSUDOR']) {
        echo "cookie";

        if (isset($_SESSION['wsudorauth'])) {
            echo "sessioned";
            // there's an active wsudorauth session; no need to query wsudorauth
            // with a WSUDOR cookie and valid session, they are good to go
            continue;
        }
        else {
            // No active session; ask wsudorauth if cookie is valid
            try {
                echo "nope";
                // now make sure WSUDOR cookie string hasn't been faked
                $session_check = $this->guzzle->get("http://localhost/wsudorauth/session_check/$_COOKIE[WSUDOR]");
                $session_check = json_decode($session_check->getBody());
                session_start();
                $_SESSION['wsudorauth'] = $session_check;
            } catch (GuzzleHttp\Exception\ClientException $e) {
                // cookie not good; trigger an exception if getting a 400 level error
                // and pass them through with no created session
                continue;

            } //catch
        } //else

    } //$_COOKIE['WSUDOR']
    else {
        echo "destroyed";
        // no cookie; kill any session that's still active;
        // we're assuming they logged out, so killing any session will prevent them from
        // floating through with no cookie and old (but still good) session data
        session_destroy();
    }
    echo "test";
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
 * PHP Debug Bar Middleware
 * Uses https://github.com/php-middleware/phpdebugbar
 * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
 * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
 * @param  callable                                 $next     Next middleware
 *
 * @return \Psr\Http\Message\ResponseInterface
 */
$app->add(function (Request $request, Response $response, callable $next) use ($app) {


    // Check for debug flag
    // if ($request->getQueryParam('debug') == "true") {
        // echo "TRUE";
        // $debug = $app->getContainer()->get('debug');
     // var_dump($debug);
     // Wrap response
        // return $debug($request, $response, $next);
    // }
    // echo "FALSE";
    // Invoke next middleware and return response
    return $next($request, $response);
});

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
        }
        else {
            return $next($request->withUri($uri), $response);
        }
    }

    return $next($request, $response);
});
