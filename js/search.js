// Javascript for search view

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

// Default Search Parameters (pre form submission)
var searchDefs = {};
var mergedParams = {};
searchDefs.rows = 12;
searchDefs.start = 0;
searchDefs.wt = "json";
searchDefs.facet = 'true';
searchDefs['facets[]'] = [];
for (var i=0; i<APIdata.ordered_facets.length; i++){ searchDefs['facets[]'].push(APIdata.ordered_facets[i]) }
searchDefs['f.facet_mods_year.facet.sort'] = "index";
searchDefs['fq[]'] = [];
searchDefs['facet.mincount'] = 1;
searchDefs['fullView'] = '';

// Set Default Views
if (localStorageTest() == true){	
	if (localStorage.getItem("search_resultsView") === null ) {                          
		localStorage.setItem("search_resultsView",'list');
	}	
}
else {
	$("#toggleView").remove();
}

// PAGE UPDATE
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function updatePage(type){

	// get current URL
	var cURL = document.URL;

	// update query box	
	if (cURL.indexOf("?q=") != -1 && cURL.endsWith("?q=") == false ){
		if (cURL.contains("q=*")){
			$("#q").val("");	
		}
		else { $("#q").val(mergedParams.q); }		
	}

	// update rows
	$(".resPerPage option[value='"+mergedParams.rows+"']").attr('selected','selected');	
	
	// update number of results
	updateNumbers();	
	// show "refined by" facets
	showFacets();	
	// pagination
	paginationUpdate();

}

// QUERYING
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchGo(){

	// fix facets / fq
	searchParams['fq[]'] = searchParams['fq'];
	delete searchParams['fq'];	

	if (searchParams['q'] == undefined || searchParams['q'] == "" ) {
		var type = "empty_search"
		searchParams['q'] = "*";
	};

	// add API functions to mergedParams
	searchParams['functions[]'] = "solrSearch";
	// Set Search Parameters - Merge default and URL search parameters
	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);
	// console.log(mergedParams);

	// Calls API functions		
	var APIcallURL = "/"+config.API_url;

	$.ajax({          
	  url: APIcallURL,	        
	  dataType: 'json',
	  data: mergedParams,	  	    
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){

		mix(response,APIdata);		
		$(document).ready(function(){
			updatePage();
			populateFacets();
			// if no results
			if (APIdata.solrSearch.response.docs.length == 0){
				var html = '<li class="obj-cnt object-container-list" style="text-align:center;"><h2>No results found.</h2></li>';				
				$("#results_container").append(html); 				
			}	
			else {
				if (lsTest() === true){
					populateResults(localStorage.search_resultsView,"#results_container");	
				}
				else {
					populateResults("list","#results_container");
				}
			}
		});		
	}

	function callError(response){
		// console.log("API Call unsuccessful.  Back to the drawing board.");	  
	}
}


function updateSearch(){
	// get current URL	
	var nURL = window.location.href;
	// check rows to update
	searchParams.rows = $("#rows").val();
	var nURL = updateURLParameter(nURL, 'rows', searchParams.rows);	
	// adjust start pointer
	if (searchParams.rows > searchParams.start){		
		var nURL = updateURLParameter(nURL, 'start', "0");
	}	
	// refresh page	
	window.location = nURL;
}


