<?php
// Routes

// ROOT
$app->get('/', function ($request, $response, $args) {
    $api = $this->APIRequest->get($request->getAttribute('/'));
    $args['data'] = json_decode($api->getBody(), true);

    // scan frontpages directory
    $dir = '../public/img/frontpage';
    $frontpage_images = preg_grep('/^([^.|^..])/', scandir($dir));
    $args['frontpage_images'] = $frontpage_images;

    // Log/Dump Debug Data
    $this->logger->debug(print_r($frontpage_images, true));
    Tracy\Debugger::barDump($args['data']);

    return $this->view->render($response, "index.html.twig", $args);
});

$app->post('/console', 'RunTracy\Controllers\RunTracyConsole:index');


// SEARCH VIEW
$app->get('/search', function ($request, $response, $args) {
    $args['search_params'] = $request->getQueryParams();

    // set search view defaults
    if (!array_key_exists('start', $args['search_params'])) {
        $args['search_params']['start'] = 0;
    }

    if (!array_key_exists('rows', $args['search_params'])) {
        $args['search_params']['rows'] = 20;
    }

    // handle layout parameters
    // if not in args, check if default set, set if not
    if (!array_key_exists('layout', $args['search_params'])) {
        // if layout not in session, add
        if (!array_key_exists('layout', $_SESSION)) {
            $this->logger->debug("layout not in terms, and not in session, setting");
            $_SESSION['layout'] = 'list';
            $args['search_params']['layout'] = 'list';
        }
        else {
            $this->logger->debug("layout found in session, using");
        }
    }
    // else, set session from params
    else {
        $this->logger->debug("layout in terms, setting");
        $_SESSION['layout'] = $args['search_params']['layout'];
    }
    $args['search_params']['layout'] = $_SESSION['layout'];

    if (!array_key_exists('q', $args['search_params'])) {
        $args['search_params']['sort'] = 'random_'.date('ljSFY').' asc';
    }

    $args['query_string'] = $request->getUri()->getQuery();
    $this->logger->debug(print_r($args['search_params'], true));
    $api = $this->APIRequest->get($request->getAttribute('path'), $args['search_params'], true);
    $args['data'] = json_decode($api->getBody(), true);

    // Dump Debug Data
    Tracy\Debugger::barDump($args['data']);

    return $this->view->render($response, 'search.html.twig', $args);
})->setName('search');


// ADVANCED SEARCH VIEW
$app->get('/advanced_search', function ($request, $response, $args) {
    // This will need an API route that returns some values to populate dropdowns
    $api = $this->APIRequest->get("/api/search_limiters");
    $args['data'] = json_decode($api->getBody(), true);

    // Dump Debug Data
    Tracy\Debugger::barDump($args['data']);

    return $this->view->render($response, 'advanced_search.html.twig', $args);
});


// ADVANCED SEARCH PROCESS
$app->post('/advanced_search', function ($request, $response, $args) {

    // get post parameters
    $qp = $request->getParsedBody();

    // run advanced_query_build from QueryBuilder, with "true" flag to return as query string
    $prepared_query_string = $this->QueryBuilder->advanced_query_build($qp, true);

    // Redirect to /search, with prepared query string
    $uri = $this->router->pathFor('search')."?".$prepared_query_string;
    return $response->withRedirect($uri);
});


// ALL COLLECTIONS
$app->get('/collections', function ($request, $response, $args = []) {
    $api = $this->APIRequest->get($request->getAttribute('path'), $request->getQueryParams());
    $args['data'] = json_decode($api->getBody(), true);

    // Dump Debug Data
    Tracy\Debugger::barDump($args['data']);

    return $this->view->render($response, 'collections.html.twig', $args);
});


// SINGLE COLLECTION VIEW
$app->get('/collection[/{pid}]', function ($request, $response, $args = []) {
    $api = $this->APIRequest->get($request->getAttribute('path'), $request->getQueryParams());
    $args['data'] = json_decode($api->getBody(), true);

    // Dump Debug Data
    Tracy\Debugger::barDump($args['data']);

    return $this->view->render($response, 'item_view/collection.html.twig', $args);
});


// SINGLE ITEM/RECORD VIEW
$app->get('/item/{pid}', function ($request, $response, $args) {
    $api = $this->APIRequest->get($request->getAttribute('path'));
    $args['data'] = json_decode($api->getBody(), true);
    $args['settings'] = $this->get('settings');
    
    // confirm exists
    if ($api->getStatusCode() == 404) {
        $this->logger->debug('item does not exist, pushing to 404');
        return $response->withStatus(404)->withHeader('Location', '/404');
    }

    // determine content type
    $content_type = strtolower($args['data']['response']['content_type']);
    $this->logger->debug("loading item type: $content_type");

    // Dump Debug Data
    Tracy\Debugger::barDump($args['data']);

    // load template
    return $this->view->render($response, 'item_view/'.$content_type.'.html.twig', $args);
})->setName('item');


// DATA DISPLAY
// JSON data display
$app->get('/item/{pid}/metadata', function ($request, $response, $args) {
    $api = $this->APIRequest->get("/item/$args[pid]");
    // seamlessly passes through JSON response and headers
    return $api;
});


// MODS DISPLAY
$app->get('/item/{pid}/MODS', function ($request, $response, $args) {
    // $api = $this->APIRequest->get("/item/$args[pid]");
    // seamlessly passes through JSON response and headers
    return $api;
});


// Streaming Content e.g. A/V and to Download Files -- Work in Progress
// See https://www.slimframework.com/docs/objects/response.html#the-response-body
// AV Stream
$app->get('/item/{pid}/stream', function ($request, $response, $args) {
    $stream = $this->APIStream->get("/item/$args[pid]");
    // $streamResponse = $response->withBody($stream);
    return $stream;
});


// Download Items
$app->get('/item/{pid}/{size}/download', function ($request, $response, $args) {
    // Invoke API Streaming Request
    $item = $this->APIStream->get("/item/$args[pid]/$args[size]");
    // Set Headers
    $response = $response->withHeader('Content-Description', 'File Transfer')
    ->withHeader('Content-Type', 'application/octet-stream')
    ->withHeader('Content-Disposition', 'attachment;filename="'.basename($args['pid']).'"')
    ->withHeader('Expires', '0')
    ->withHeader('Cache-Control', 'must-revalidate')
    ->withHeader('Pragma', 'public')
    ->withHeader('Content-Length', filesize($item->getSize()));

    readfile($item);
    return $response;
});


// Contact Page
/*
    This route supports a multi-purpose functioning contact form
    Specifically, for the following purposes:
        - generic contact, contact_type = 'general'
        - permissions requests, contact_type = 'permissions'
        - report a problem, contact_type = 'rap'
    
    If GET, 
        return form with some text filled in, based on contact_type
        and any helpful information about where they were (item id, etc.)
    
    If POST,
        trigger again off contact_type, send email to appropriate people
        (configured in settings.php), and message body and subject from
        form.

        * If report a problem, also fire off Guzzle HTTP request to
        Ouroboros registering the problem
*/

$app->get('/contact', function ($request, $response, $args) {

    $qp = $request->getQueryParams();
    // get settings
    $settings = $this->get('settings');

    // set host
    $host = $settings['server']['host'];

    $api = $this->APIRequest->get("item/$qp[pid]");
    $data = json_decode($api->getBody(), true);

    if (strpos($data['response']['solr_doc']['dc_rights'][0], 'Reuther') !== false) {
        $permissions_routing = "Reuther";
    } else {
        $permissions_routing = "Library System";
    }
    
    // general contact
    if (array_key_exists('type', $qp)) {
        $contact_type = $qp['type'];

        // permission request
        if ($contact_type == 'permissions') {
            $args['form_title'] = 'Permissions Request Form';
            $args['pid'] = $qp['pid'];
            $args['subject'] = "$permissions_routing Permissions Request";
        }

        // report a problem
        if ($contact_type == 'rap') {
            $args['form_title'] = 'Report a Problem';
            $args['pid'] = $qp['pid'];
            $args['subject'] = "Report a Problem";
        }
    } else {
        $contact_type = 'general';
        $args['form_title'] = 'General Contact';
        $args['subject'] = "WSULS Digital Collections Contact Form";
    }

    // final prep
    $args['contact_type'] = $contact_type;
 

    // Dump Debug Data
    Tracy\Debugger::barDump($args);

    return $this->view->render($response, 'contact.html.twig', $args);
});

$app->post('/contact', function ($request, $response, $args) {

    // get settings
    $settings = $this->get('settings');

    // set host
    $host = $settings['server']['host'];

    // get post parameters
    $qp = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $contact_type = $qp['contact_type'];

    // submit form with email client
    /*
        The "to" address is handled by submitting the contact_type ['general','permissions','rap']
        to 'contact_form' in settings.php
    */
    $to = $settings['contact_form'][$contact_type];
    $from = $qp['email'];
    $name = $qp['from'];
    $subject = $qp['subject'];
    $msg = $qp['msg'];
    $pid = $qp['pid'];
    date_default_timezone_set('America/Detroit');
    $dt = new DateTime();
    $date = $dt->format('r');

    $form = [
        'from' => $from,
        'name' => $name,
        'to' => $to,
        'date' => $date,
        'subject' => $subject,
        'msg' => $msg,
        'passphrase' => $settings['contact_form']['passphrase'],
        'pid' => $pid,
        'contact_type' => $contact_type
    ];

    $params = ['form_params' => $form, 'headers' => ['Content-Type' => 'application/x-www-form-urlencoded']];
    $url = "http://$host/ouroboros/email";
    try {
        $this->guzzle->request('POST', $url, $params);
    } catch (GuzzleHttp\Exception\ClientException $e) {
        // set some sort of something to flash and tell people to try again later
        echo "TEMP - flashing a request that something went wrong";
    }

    // confirmation package
    $args['result'] = [
        'to'=>"Digital Collections Team",
        'from'=>$from,
        'subject'=>$subject,
        'msg'=>$msg
    ];
    
    // return response
    return $this->view->render($response, 'contact_result.html.twig', $args);
});


// ABOUT
$app->get('/about', function ($request, $response, $args) {
    $api = $this->APIRequest->get($request->getAttribute('path'));
    $args['data'] = json_decode($api->getBody(), true);

    // Dump Debug Data
    Tracy\Debugger::barDump($args['data']);

    return $this->view->render($response, 'about.html.twig', $args);
});


// 404
$app->get('/404', function ($request, $response, $args) {
    // return 404
    return $this->view->render($response->withStatus(404), '404.html.twig', $args);
});


// Mirador
$app->get('/mirador', function ($request, $response, $args) {
    $args['params'] = $request->getQueryParams();
    $args['settings'] = $this->get('settings');
    return $this->view->render($response, 'mirador.html.twig', $args);
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// V1 Redirects

// root digital collections
$app->get('/digitalcollections', function ($request, $response, $args) {
    return $response->withStatus(302)->withHeader('Location', '/');
});

// single item
$app->get('/digitalcollections/item', function ($request, $response, $args) {    
    $args['params'] = $request->getQueryParams();
    $pid = $args['params']['id'];
    // $this->logger->debug($pid);
    return $response->withStatus(302)->withHeader('Location', '/item/'.$pid);
});

// search
$app->get('/digitalcollections/search.php', function ($request, $response, $args) {
    $args['params'] = $request->getQueryParams();
    $q = $args['params']['q'];
    // $this->logger->debug($q);
    $url = $this->router->pathFor('search')."?q=".$q;
    return $response->withStatus(302)->withHeader('Location', $url);
});

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Dynamic Route
// Catches all /item/{pid}/* routes not already specified above sends request to API
$app->get('/item/{pid}/[{params:.*}]', function ($request, $response, $args) {
    $api = $this->APIRequest->get($request->getAttribute('path'), $request->getQueryParams());
    return $api;    
});


// AFT Omeka redirect
$app->get('/aft', function ($request, $response, $args) {
    // return 302
    return $response->withStatus(302)->withHeader('Location', 'http://projects.lib.wayne.edu/aft');
});


// IAMAMAN Omeka redirect
$app->get('/iamaman', function ($request, $response, $args) {
    // return 302
    return $response->withStatus(302)->withHeader('Location', 'http://projects.lib.wayne.edu/iamaman');
});
