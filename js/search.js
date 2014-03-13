// Javascript for search view


// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default Search Parameters (pre form submission)
var searchDefs = {};
var mergedParams = {};
searchDefs.rows = 12;
searchDefs.start = 0;
searchDefs.wt = "json";
searchDefs.facet = 'true';
searchDefs['facets[]'] = [];
searchDefs['facets[]'].push("facet_mods_year","dc_subject","dc_creator","dc_language","rels_hasContentModel","rels_isMemberOfCollection", "dc_coverage");
searchDefs['f.facet_mods_year.facet.sort'] = "index";
searchDefs['fq[]'] = [];
searchDefs['facet.mincount'] = 1;
searchDefs['fullView'] = '';

// Global API response data
APIdata = new Object();

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

	// update number of results
	updateNumbers();	

	// show "refined by" facets
	showFacets();	

	// // pagination
	paginationUpdate();

}

// QUERYING
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchGo(){

	console.log(searchParams);

	

	// fix facets / fq
	searchParams['fq[]'] = searchParams['fq'];
	delete searchParams['fq'];	

	if (searchParams['q'] == undefined || searchParams['q'] == "" ) {
		var type = "empty_search"
		searchParams['q'] = "*";
	};

	// Set Search Parameters		
	// Merge default and URL search parameters
	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);
	debugSearchParams();	
	
	//pass solr parameters os stringify-ed JSON, accepted by Python API as dicitonary
	solrParamsString = JSON.stringify(mergedParams);	
	// Calls API functions	
	var APIcallURL = "/WSUAPI?functions[]=solrSearch&solrParams="+solrParamsString;			

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  	    
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){

		mix(response,APIdata);
		console.log("APIdata");
		console.log(APIdata);
		$(document).ready(function(){
			updatePage();
			populateFacets();
			populateResults('templates/searchResultObj.htm',"#results_container");	    		
		});
		
	}

	function callError(response){
		console.log("API Call unsuccessful.  Back to the drawing board.");	  
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

// populate results
function populateResults(templateLocation,destination,templateData){
  
  //push results to results_container
  for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {	

	$.ajax({                
		url: templateLocation,      
		dataType: 'html',            
		async:false,
		success: function(response){        
			var template = response;
			if (typeof(templateData) == 'undefined') {          
			  var html = Mustache.to_html(template, APIdata.solrSearch.response.docs[i]);         
			}
			else {
			  var html = Mustache.to_html(template, templateData);           
			}        
			$(destination).append(html);
		}     
	});
  } 
}



