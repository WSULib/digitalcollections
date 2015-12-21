// Javascript for single collection view

// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Global API response data
APIdata = new Object();

APIdata.ordered_facets = [
  	"rels_hasContentModel",
  	"rels_isMemberOfCollection",  	
  	"facet_mods_year",
  	"dc_subject",
  	"dc_creator",
  	"dc_coverage",
  	"dc_language",
  	"dc_publisher" 	  	
  ];

// Default Search Parameters
var searchDefs = {};
var mergedParams = {};
searchDefs.rows = 20;
searchDefs.start = 0;
searchDefs.wt = "json";
searchDefs.fl = "id dc_title";
searchDefs.sort = "id asc";
searchDefs.facet = 'true';
searchDefs['facets[]'] = [];
for (var i=0; i<APIdata.ordered_facets.length; i++){ searchDefs['facets[]'].push(APIdata.ordered_facets[i]) }
searchDefs['f.facet_mods_year.facet.sort'] = "index";
searchDefs['fq[]'] = [];
searchDefs['facet.mincount'] = 1;
searchDefs['sort'] = 'id asc';
searchDefs['solrSearchContext'] = "collection";


// Set Default Views
if (localStorageTest() == true){	
	if (localStorage.getItem("collection_resultsView") === null ) {                          
		localStorage.setItem("collection_resultsView",'grid');
	}	
}
else {
	$("#toggleView").remove();
}

//INITIAL LOAD --COLLECTION.JS AND ALLCOLLECTIONS.JS
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchGo(){	

	// escape colon in id
	escaped_id = searchParams['id'].replace(":","\\:");

	// Set Search Parameters
	searchParams['q'] = "rels_isMemberOfCollection:info\\:fedora/"+escaped_id;	
	searchParams['raw'] = "noescape";

	// fix facets / fq	
	searchParams['fq[]'] = searchParams['fq'];
	delete searchParams['fq'];

	// add API functions to mergedParams
	searchParams['functions[]'] = "solrSearch";		
	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);

	// save params to localStorage, if lsTest is true
	if (lsTest() == true){
		localStorage.setItem("mergedParams",JSON.stringify(mergedParams));	
	}				
	
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
			$(document).ready(function(){				
				updateCollectionTitle();
				updatePage();
				populateFacets();
				if (lsTest() === true){						
					populateResults(localStorage.collection_resultsView,'#results_container');
				}
				else{					
					populateResults("grid",'#results_container');	
				}
				// init grid freewall	
				gridInit();
			});	
			
		}

		function callError(response){
			load503(APIcallURL);
		}
}


// PAGE UPDATE
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function updateCollectionTitle(){	

	var collectionTitle = "info:fedora/"+searchParams['id'];
	if (solrTranslationHash[collectionTitle] !== 'undefined'){
		$("h2#collection_title").html(solrTranslationHash[collectionTitle]);
	}

	else {
		$("h2#collection_title").html("Collection Title Unknown");
	} 

}

function updatePage(){

	// make collection equal q, so everything is passed on correctly through the API
	mergedParams.q = mergedParams.collection;
	// get current URL
	var cURL = document.URL;
	// update rows
	$(".resPerPage option[value='"+mergedParams.rows+"']").attr('selected','selected');	
	// update number of results
	updateNumbers();
	// show "refined by" facets
	showFacets();
	// // pagination
	paginationUpdate();
	// update link to the Collection's single object page	
	$("#learn_more").attr("href","item?rendered=singleObject&id="+searchParams['id']);
	// update rows selecctor
	$("#rows").val(mergedParams.rows).prop('selected',true);
}












