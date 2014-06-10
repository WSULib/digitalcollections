// Javascript for all collections view

// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default Search Parameters
var searchDefs = {};
var mergedParams = {};
searchDefs.rows = 24;
searchDefs.start = 0;
searchDefs.wt = "json";
searchDefs.fl = "id dc_title";
searchDefs.sort = "id asc";
searchDefs.facet = 'true';
searchDefs['facets[]'] = [];
searchDefs['facets[]'].push("facet_mods_year","dc_subject","dc_creator","dc_language","rels_hasContentModel", "dc_coverage");
searchDefs['f.facet_mods_year.facet.sort'] = "index";
searchDefs['fq[]'] = [];
searchDefs['facet.mincount'] = 1;


// Global API response data
APIdata = new Object();
var type = '';


//INITIAL LOAD 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchGo(){		

	// Set Search Parameters
	searchParams['q'] = "rels_hasContentModel:info\\:fedora/CM\\:Collection";
	searchParams['raw'] = "noescape";	

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
			console.log(response);
			mix(response, APIdata);			
			populateCollectionsView();
		}
		function callError(response){
			console.log("API Call unsuccessful.  Back to the drawing board.");
		}
}


//DISPLAY RESULTS
//////////////////////////////////////////////////////////////////
function populateCollectionsView(){
	for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {		
  		$.ajax({          
		  url: 'templates/multipleCollectionsObj.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;		  	
		  	var html = Mustache.to_html(template, APIdata.solrSearch.response.docs[i]);		  	
		  	$(".collection_contents").append(html);
		  }		  
		});
	}
}
