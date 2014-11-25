<?php
// router for views pertaining to a single PID

//pull params
$PID = $_REQUEST['id'];
$rendered = $_REQUEST['rendered'];

// checks for "rendered" override as parameter
if( isset($_REQUEST["rendered"]) ){
	$response = solrMetadataCall($PID);
	$fileTemplate = $_REQUEST['rendered'].".php";
	renderTemplate($fileTemplate,$response);
}

// elseif, grabs PID and checks for rels_isRenderedBy relationship in Solr
elseif( isset($_REQUEST["id"]) ){
	$response = solrMetadataCall($PID);
	if ( isset($response['response']['docs'][0]['rels_isRenderedBy']) ){		
		$isRenderedBy_string = $response['response']['docs'][0]['rels_isRenderedBy'][0];
		$isRenderedBy_temp = explode("info:fedora/",$isRenderedBy_string);
		$isRenderedBy = $isRenderedBy_temp[1];
		$fileTemplate = $isRenderedBy.".php";		
		renderTemplate($fileTemplate,$response);				
	}
	else {		
		$fileTemplate = "singleObject.php";
		renderTemplate($fileTemplate,$response);
	}	
}

// else, PID not provided, load 404 page
else{	
	$fileTemplate = "404.php"; 
	renderTemplate($fileTemplate,$response); 	
}

// render selected template
function renderTemplate($fileTemplate,$response){
	include $fileTemplate;	
	return;	
}

function solrMetadataCall($PID){
	$PID = str_replace(":","\:",$PID);   	
	$options = array
	(
	    'hostname' => 'silo.lib.wayne.edu',    
	    'port'     => 8080,
	    'path'     => 'solr4/search'
	);
	$client = new SolrClient($options);
	$query = new SolrQuery();
	$query->setQuery("id:$PID");
	$query->setStart(0);
	$query->setRows(50);	
	$query->addField("*");	
	$query_response = $client->query($query);
	$response = $query_response->getResponse();
	return $response;
}

?>