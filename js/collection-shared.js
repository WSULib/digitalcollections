//INITIAL LOAD --COLLECTION.JS AND ALLCOLLECTIONS.JS
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchGo(type){	

	// Set Search Parameters
	searchParams['q'] = "rels_isMemberOfCollection:info:fedora/"+searchParams['id'];	
	searchParams['raw'] = "escapeterms";

	// fix facets / fq	
	searchParams['fq[]'] = searchParams['fq'];
	delete searchParams['fq'];

	// add API functions to mergedParams
	searchParams['functions[]'] = "solrSearch";		
	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);				
	
	var APIcallURL = "/"+config.API_url;	
	$.ajax({          
		url: APIcallURL,      
		dataType: 'json',
		data:mergedParams,	         
		success: callSuccess,
		error: callError
		});

		function callSuccess(response){
			mix(response, APIdata);						
			if (type == "collectionPage"){
				updateCollectionTitle();
				updatePage();
				populateFacets();
				populateResults('templates/singleCollectionObj.htm','.collection_contents');
			}
			
			else if (type == "allCollections"){
				collectionsList("allCollections");
			} 
		}

	function callError(response){

		console.log("API Call unsuccessful.  Back to the drawing board.");
	}
}


