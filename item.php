<?php
// router for views pertaining to a single PID
// helpful doc: http://www.php.net/manual/en/solr.examples.php

<<<<<<< HEAD

//pull PID as id
$PID = $_REQUEST['id'];
$PID = str_replace(":","\:",$PID);

// check for PID
if( isset($_GET["id"]) ){
   	// get solr rels_isRenderedBy relationship
=======
//pull params
$PID = $_REQUEST['id'];
$rendered = $_REQUEST['rendered'];

// checks for "rendered" override as parameter
if( isset($_REQUEST["rendered"]) ){
	$fileTemplate = $_REQUEST['rendered'].".php";
	renderTemplate($fileTemplate);
}


// elseif, grabs PID and checks for rels_isRenderedBy relationship in Solr
elseif( isset($_REQUEST["id"]) ){
	$PID = str_replace(":","\:",$PID);   	
>>>>>>> e18ca5b152d75d282c8fb996d344d94bca485250
	$options = array
	(
	    'hostname' => 'localhost',    
	    'port'     => 8080,
	    'path'     => 'solr4/fedobjs'
	);
<<<<<<< HEAD

	$client = new SolrClient($options);
	$query = new SolrQuery();

	$query->setQuery("id:$PID");

=======
	$client = new SolrClient($options);
	$query = new SolrQuery();
	$query->setQuery("id:$PID");
>>>>>>> e18ca5b152d75d282c8fb996d344d94bca485250
	$query->setStart(0);
	$query->setRows(50);
	$query->addField('id')->addField('rels_isRenderedBy');
	$query_response = $client->query($query);
	$response = $query_response->getResponse();	

	if ( isset($response['response']['docs'][0]['rels_isRenderedBy']) ){		
		$isRenderedBy_string = $response['response']['docs'][0]['rels_isRenderedBy'][0];
		$isRenderedBy_temp = explode("info:fedora/",$isRenderedBy_string);
		$isRenderedBy = $isRenderedBy_temp[1];
<<<<<<< HEAD
		$fileTemplate = $isRenderedBy.".php";				
=======
		$fileTemplate = $isRenderedBy.".php";
		renderTemplate($fileTemplate);				
>>>>>>> e18ca5b152d75d282c8fb996d344d94bca485250
	}

	else {		
		$fileTemplate = "singleObject.php";
<<<<<<< HEAD
	}

	
}

else{
	echo "PID not provided, this will render 404 page."; 
	$fileTemplate = "404.php";  	
=======
		renderTemplate($fileTemplate);
	}	
}

// else, PID not provided, load 404 page
else{
	echo "PID not provided, this will render 404 page."; 
	$fileTemplate = "404.php"; 
	renderTemplate($fileTemplate); 	
>>>>>>> e18ca5b152d75d282c8fb996d344d94bca485250
}


// render selected template
<<<<<<< HEAD
include $fileTemplate;	
=======
function renderTemplate($fileTemplate){
	include $fileTemplate;	
	return;	
}
>>>>>>> e18ca5b152d75d282c8fb996d344d94bca485250


?>