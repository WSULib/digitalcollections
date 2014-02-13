<?php
// router for views pertaining to a single PID
// helpful doc: http://www.php.net/manual/en/solr.examples.php


//pull PID as id
$PID = $_REQUEST['id'];
$PID = str_replace(":","\:",$PID);

// get solr rels_isRenderedBy relationship
$options = array
(
    'hostname' => 'localhost',    
    'port'     => 8080,
    'path'     => 'solr4/fedobjs'
);

$client = new SolrClient($options);
$query = new SolrQuery();

$query->setQuery("id:$PID");

$query->setStart(0);
$query->setRows(50);
$query->addField('id')->addField('rels_isRenderedBy');
$query_response = $client->query($query);
$response = $query_response->getResponse();

$isRenderedBy_string = $response['response']['docs'][0]['rels_isRenderedBy'][0];
$isRenderedBy_temp = explode("info:fedora/",$isRenderedBy_string);
$isRenderedBy = $isRenderedBy_temp[1];
$fileTemplate = $isRenderedBy.".php";
echo $fileTemplate;

// render template
include $fileTemplate;



?>