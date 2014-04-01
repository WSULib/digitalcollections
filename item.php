<?php
// router for views pertaining to a single PID

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
	$query->addField('id')->addField('rels_isRenderedBy')->addField('mods_abstract_ms')->addField('mods_title_ms')->addField('mods_abstract_transcription_ms')->addField('mods_resource_type_ms')->addField('facet_mods_year');	
	
	$query_response = $client->query($query);
	$response = $query_response->getResponse();	

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


?>