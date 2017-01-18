<?php
// Routes


// ROOT
$app->get('/', function ($request, $response, $args) {
    $api = $this->APIRequest->get($request->getAttribute('/'));
    $args['data'] = json_decode($api->getBody(), true);
    return $this->view->render($response, "index.html.twig", $args);
});


// SEARCH VIEW
$app->get('/search', function ($request, $response, $args) {
    $this->logger->info("Using these query params for search: ".print_r($request->getQueryParams(),True));
    $api = $this->APIRequest->get($request->getAttribute('path'),$request->getQueryParams());
    $args['data'] = json_decode($api->getBody(), true);
    return $this->view->render($response, 'search.html.twig', $args);
})->setName('search');


// ADVANCED SEARCH VIEW
$app->get('/advanced_search', function ($request, $response, $args) {    
    /*
    This will need an API route that returns some values to populate dropdowns
        - content types
        - collections
        - else?
    */
    return $this->view->render($response, 'advanced_search.html.twig', $args);
});


// ADVANCED SEARCH PROCESS
$app->post('/advanced_search', function ($request, $response, $args) {    

    // get settings
    $settings = $this->get('settings');

    // get post parameters
    $qp = $request->getParsedBody();

    // translate advanced search form parameters to Solr-ese
    $search_params = [];

    /* 
    'q'
    prepared for "mighty four" form values
        - all_q
        - exact_q
        - any_q
        - none_q

    prepare the appropriate 'q' string based on these    
    */

    $q_array = [];
    // all
    if (!empty($qp['all_q'])){
        $q_array['all_q'] = implode(" AND ", explode(' ', $qp['all_q']));
    }
    // exacct
    if (!empty($qp['exact_q'])){
        $q_array['exact_q'] = '"' . $qp['exact_q'] . '"';
    }
    // all
    if (!empty($qp['any_q'])){
        $q_array['any_q'] = implode(" OR ", explode(' ', $qp['any_q']));
    }
    // none
    if (!empty($qp['none_q'])){
        $q_array['none_q'] = "-".implode(" -", explode(' ', $qp['none_q']));
    }
    // create search string from q_array
    $q_string = implode(" AND ", $q_array);    
    // add to search_params
    if (!$q_string == ''){
        // add q_string to search_params for 'q'
        $search_params['q'] = $q_string;
        // escape q field in API (needed for advanced solr syntax)
        $search_params['field_skip_escape'] = 'q';
    }
    $this->logger->info("Prepared advanced 'q' parameter: $q_string");

    /* 
    prepare 'fq' section
    reacts to dropdown (e.g. collection, content-type)        
    */

    // begin
    $search_params['fq'] = [];

    if (!empty($qp['select_collection'])){
        // push to 
        array_push($search_params['fq'], "rels_isMemberOfCollection:".$qp['select_collection']);
        array_push($search_params['fq'], "rels_isMemberOfCollection:".$qp['select_collection']);
        // $search_params['field_skip_escape'] = 'fq';
    }
    
    $this->logger->info(print_r($search_params,True));

    // set custom_query_parser
    $search_params['custom_query_parser'] = true;

    // set url using pathFor()
    $url = $this->router->pathFor('search', [], $search_params);
    
    // redirect to /search with prepared parameters
    return $response->withStatus(302)->withHeader('Location', $url);

});


// ALL COLLECTIONS
$app->get('/collections', function ($request, $response, $args = []) {
    $api = $this->APIRequest->get($request->getAttribute('path'),$request->getQueryParams());
    $args['data'] = json_decode($api->getBody(), true);
    return $this->view->render($response, 'collections.html.twig', $args);
});


// SINGLE COLLECTION VIEW
$app->get('/collection[/{pid}]', function ($request, $response, $args = []) {
    $api = $this->APIRequest->get($request->getAttribute('path'),$request->getQueryParams());
    $args['data'] = json_decode($api->getBody(), true);
    return $this->view->render($response, 'item.html.twig', $args);
});


// SINGLE ITEM/RECORD VIEW
$app->get('/item/{pid}', function ($request, $response, $args) {
    $api = $this->APIRequest->get($request->getAttribute('path'));
    $args['data'] = json_decode($api->getBody(), true);
    return $this->view->render($response, 'item.html.twig', $args);
});


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

    // general contact
    if (array_key_exists('contact_type', $qp)) {

        $contact_type = $qp['contact_type'];

        // permission request
        if ($contact_type == 'permissions') {
            $args['form_title'] = 'Permissions Request Form';
            $args['pid'] = 'wayne:foobar';
        }

        // report a problem
        if ($contact_type == 'rap') {
            $args['form_title'] = 'Report a Problem';
            $args['pid'] = 'wayne:foobar';
        }

    }

    else {
        $contact_type = 'general';
        $args['form_title'] = 'General Contact';
    }

    // final prep
    $args['contact_type'] = $contact_type;
    
    return $this->view->render($response, 'contact.html.twig', $args);    

});

$app->post('/contact', function ($request, $response, $args) {

    // get settings
    $settings = $this->get('settings');

    // get post parameters
    $qp = $request->getParsedBody();
    $contact_type = $qp['contact_type'];

    // submit form with email client
    /*    
        The "to" address is handled by submitting the contact_type ['general','permissions','rap']
        to 'contact_form' in settings.php
    */
    $to = $settings['contact_form'][$contact_type];
    $from = $qp['from'];
    $subject = $qp['subject'];
    $msg = $qp['msg'];
    // EMAIL HERE

    // if report-a-problem, fire off Ouroboros HTTP call (with Guzzle?)
    // FIRE HERE

    // confirmation package
    $args['result'] = [
        'to'=>$to,
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
    return $this->view->render($response, 'about.html.twig', $args);
});


// 404
$app->get('/404', function ($request, $response, $args) {
    // return 404
    return $this->view->render($response->withStatus(404), '404.html.twig', $args);
});


// Dynamic Route
// Catches all /item/{pid}/* routes not already specified above sends request to API
$app->get('/item/{pid}/[{params:.*}]', function ($request, $response, $args) {
    $api = $this->APIRequest->get($request->getAttribute('path'),$request->getQueryParams());
    return $api;
    // echo "<pre>";
    // var_dump($api);
    // echo "</pre>";
    // $args['data'] = json_decode($api->getBody(), true);
    // return $this->view->render($response, 'item.html', $args);
});