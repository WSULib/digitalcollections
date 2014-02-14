// Javascript for collection view

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

// ///////////////////////////////////////
// // Default Search Parameters (pre form submission)
// var searchDefs = {};
// var mergedParams = {};
// searchDefs.rows = 10;
// searchDefs.start = 0;
// searchDefs.wt = "json";
// searchDefs.facet = 'true';
// searchDefs['facets[]'] = [];
// searchDefs['facets[]'].push("dc_date","dc_subject","dc_creator","dc_language","rels_hasContentModel","rels_isMemberOfCollection", "dc_coverage");
// searchDefs['f.dc_date.facet.sort'] = "index";
// searchDefs['fq[]'] = [];
// searchDefs['facet.mincount'] = 1;
// searchDefs['fullView'] = '';
// ///////////////////////////////////////////


//INITIAL LOAD
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function collectionsCount(){	
	var str = searchParams.q;

	var CollectionListParams = {
		"rows":0,
		"start":0,
		"q":"*",
		"facet":"true",
		"facet.field":"rels_isMemberOfCollection"
		// "raw":"escapeterms"
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

	    	if (type == "collectionPage") {
				populateCollectionsList();
				}    

	    	else if (type == "allCollections") {
	    		collectionsCount();
	    	}
		
	    });
	    
	}

	function callError(response){
		console.log("API Call unsuccessful.  Back to the drawing board.");
	}
}


// PAGE UPDATE
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function updatePage(){

	// make collection equal q, so everything is passed on correctly through the API
	mergedParams.q = mergedParams.collection;

	// get current URL
	var cURL = document.URL;

	// update number of results
	updateNumbers();	

	// show "refined by" facets
	showFacets();	

	// // pagination
	paginationUpdate();

	// update link to the Collection's single object page
	$("#learn_more").html("<a href='singleObject.php?id="+searchParams['id']+"'>Learn more about this collection</a>");

	// update rows selecctor
	$("#rows").val(mergedParams.rows).prop('selected',true);

	// update query box
	// $("#q").val(mergedParams.q);	

}


//REFINE
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// function refineByKeyword(){

// 	var cURL = window.location.href;

// 	//get word from box
// 	var filter_input = $('#filter_input').val();

// 	// //URL ENCODE
// 	// var encoded = encodeURIComponent('&fq[]=text:');

// 	// check rows to update and add to fq[]
// 	var nURL = cURL+"&fq[]=text:"+filter_input;
// 	// var nURL = updateURLParameter(window.location.href, 'fq[]', "text:"+filter_input);

// 	// Run URL Cleaner
// 	nURL = URLcleaner(nURL);

// 	// refresh page	
// 	window.location = nURL;
// }

// QUERYING
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchGo(type){

	// Set Search Parameters	
	searchParams['q'] = searchParams['id'];
	// Note: to Change your page to collection=, PID=, id=, etc you need to change lines 148 and 244 to match as well
	searchParams['q'] = "rels_isMemberOfCollection:info:fedora/"+searchParams['q'];
	// delete searchParams['collection'];
	searchParams['raw'] = "escapeterms";


	// fix facets / fq
	searchParams['fq[]'] = searchParams['fq'];
	delete searchParams['fq'];

	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);
	debugSearchParams();	
	
	//pass solr parameters os stringify-ed JSON, accepted by Python API as dictionary
	solrParamsString = JSON.stringify(mergedParams);	

	// WSUAPI v2.0
	// Usuing new API function solrSearch()
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI/?functions[]=solrSearch&solrParams="+solrParamsString;
	console.log(APIcallURL);
	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	         
	  success: callSuccess,
	  // error: callError
	});

	function callSuccess(response){
		mix(response, APIdata);
	    $(document).ready(function(){
	    	if (type == "collectionPage"){
	    	collectionsList("collectionPage");
	    	updateCollectionTitle();
	    	updatePage();
	    	populateFacets();
   			if (mergedParams.q == "rels_hasContentModel:info:fedora/CM:Collection"){
	    	populateResults('templates/collectionResultObjAlt.htm','.collection_contents');
	    	}
	    	else {
			populateResults('templates/collectionResultObj.htm','.collection_contents');
	    	}  	
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

function updateCollectionTitle(){	

	var collectionTitle = "info:fedora/"+searchParams['id'];
	if (APIdata.solrTranslationHash[collectionTitle] !== 'undefined'){
		$("h2#collection_title").html(APIdata.solrTranslationHash[collectionTitle]);
	}

	else {
		$("h2#collection_title").html("Collection Title Unknown");
	} 

}

function updateCollection(){

	// get current URL
	var cURL = document.URL;

	// check rows to update
	searchParams.q = $(".form-control").val();
	// searchParams.start = 0; 
	var nURL = updateURLParameter(window.location.href, 'start', 0);
	var nURL = updateURLParameter(nURL, 'collection', searchParams.q);

	// refresh page	
	window.location = nURL;
}


function updateSearch(){

	// get current URL
	var cURL = document.URL;

	// check rows to update
	searchParams.rows = $("#rows").val();
	var nURL = updateURLParameter(window.location.href, 'rows', searchParams.rows);

	// refresh page	
	window.location = nURL;
}

//DISPLAY RESULTS
//////////////////////////////////////////////////////////////////

// populate results - display uniqueness is found in templates
function populateResults(templateLocation,destination){
  
  //push results to results_container
  for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {

    	$.ajax({                
    	url: templateLocation,      
    	dataType: 'html',            
    	async:false,
    	success: function(response){        
        var template = response;
        var html = Mustache.to_html(template, APIdata.solrSearch.response.docs[i]);  
        $(destination).append(html);
      }     
    });
  } 
}

// function populateCollectionsList(){

// 	//push results to collectionSelector
// 	for (var i = 0; i < APIdata.collectionsList.solrSearch.response.docs.length; i++) {		

//   		$.ajax({          
// 		  url: 'templates/collectionsListObj.htm',      
// 		  dataType: 'html',            
// 		  async:false,
// 		  success: function(response){		  	
// 		  	var template = response;
// 		  	var html = Mustache.to_html(template, APIdata.collectionsList.solrSearch.response.docs[i]);		  	
// 		  	// $("select.form-control").append(html);

// 		  }		  
// 		});
// 	}	
// }

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
		  url: 'templates/collectionsViewObj.htm',      
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














