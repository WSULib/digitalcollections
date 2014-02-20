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


// INITIAL LOAD -- in collection-shared.js
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// 1. searchGo()



// BUILD LIST
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function collectionsList(type){

	// WSUAPI v2.0 / Stringify MO
	var CollectionListParams = {
		"rows":100,
		"start":0,
		"wt":"json",
		"sort":"id asc",
		"q":"rels_hasContentModel:info:fedora/CM:Collection",
		"raw":"escapeterms"
	}
	
	CollectionListParams = JSON.stringify(CollectionListParams);

	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI/?functions[]=solrSearch&solrParams="+CollectionListParams;

	// Calls API functions
	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){

	    APIdata.collectionsList = response;
	    $(document).ready(function(){

  	  		if (type == "allCollections") {
	    		collectionsCount();
	    	}
		
	    });
	    
	}

	function callError(response){
		console.log("API Call unsuccessful.  Back to the drawing board.");
	}
}



//COUNT RESULTS
//////////////////////////////////////////////////////////////////
function collectionsCount(){	
	var str = searchParams.q;

	var CollectionListParams = {
		"rows":0,
		"start":0,
		"q":"*",
		"facet":"true",
		"facet.field":"rels_isMemberOfCollection"
	}
	
	CollectionListParams = JSON.stringify(CollectionListParams);

	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI/?functions[]=solrFacetSearch&solrParams="+CollectionListParams;

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){
		APIdata.collectionsCount = response;
		populateCollectionsView();
	}

	function callError(response){
		console.log("collectionsCount Error");
		console.log(response);
	}
}


//DISPLAY RESULTS
//////////////////////////////////////////////////////////////////

function populateCollectionsView(){
	for (var i = 0; i < APIdata.collectionsList.solrSearch.response.docs.length; i++) {

		var collectionObject = APIdata.collectionsList.solrSearch.response.docs[i].id;
		collectionObject = "info:fedora/"+collectionObject;

		if ($(APIdata.collectionsCount.solrFacetSearch[collectionObject]).length) {
			APIdata.collectionsList.solrSearch.response.docs[i]['count'] = APIdata.collectionsCount.solrFacetSearch[collectionObject];
		}
		else {
			// console.log("nothing");
		}	  	

  		$.ajax({          
		  url: 'templates/multipleCollectionsObj.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;		  	
		  	var html = Mustache.to_html(template, APIdata.collectionsList.solrSearch.response.docs[i]);		  	
		  	$(".collection_contents").append(html);

		  }		  
		});
	}
}
