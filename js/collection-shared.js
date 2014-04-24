//INITIAL LOAD --COLLECTION.JS AND ALLCOLLECTIONS.JS
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchGo(type){

	// Set Search Parameters	
	searchParams['q'] = "rels_isMemberOfCollection:info:fedora/"+searchParams['id'];
	searchParams['raw'] = "escapeterms";

	// fix facets / fq
	searchParams['fq[]'] = searchParams['fq'];
	delete searchParams['fq'];

	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);
	// debugSearchParams();	
	
	//pass solr parameters os stringify-ed JSON, accepted by Python API as dictionary
	solrParamsString = JSON.stringify(mergedParams);	

	// WSUAPI v2.0
	// Usuing new API function solrSearch()	
	var APIcallURL = "/"+config.API_url+"/?functions[]=solrSearch&solrParams="+solrParamsString;
	// console.log(APIcallURL);
	$.ajax({          
		url: APIcallURL,      
		dataType: 'json',	         
		success: callSuccess,
		// error: callError
		});

		function callSuccess(response){
			mix(response, APIdata);
			$(document).ready(function(){
				// console.log("RESULTS", response);
				if (type == "collectionPage"){

					updateCollectionTitle();

					updatePage();

					populateFacets();

					populateResults('templates/singleCollectionObj.htm','.collection_contents');
				}
				
				else if (type == "allCollections"){
					collectionsList("allCollections");
				}    		
			});

		}

	function callError(response){

		console.log("API Call unsuccessful.  Back to the drawing board.");
	}
}


