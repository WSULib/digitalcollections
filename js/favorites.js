// Javascript for favorites view


// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default Search Parameters (pre form submission)
var searchDefs = {};
var mergedParams = {};
searchDefs.rows = 10;
searchDefs.start = 0;
searchDefs.wt = "json";
searchDefs.facet = 'true';
searchDefs['facets[]'] = [];
searchDefs['facets[]'].push("dc_date","dc_subject","dc_creator","dc_language","rels_hasContentModel","rels_isMemberOfCollection", "dc_coverage");
searchDefs['f.dc_date.facet.sort'] = "index";
searchDefs['fq[]'] = [];
searchDefs['facet.mincount'] = 1;
searchDefs['fullView'] = '';

// Global API response data
APIdata = new Object();

// GET FAVs
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function getFavs(){

	// redirect if no longer logged in
	if (userData.loggedIn_WSUDOR != true){
		window.location = 'index.php';
	}

	var favParams = new Object();
	favParams.q = "fav_user:"+userData.username_WSUDOR;
	favParams.fl = "fav_item";	
	if (typeof searchParams.start != "undefined"){ 
			favParams.start = searchParams.start; 
	}
	else { 
		searchParams.start = 0;
	}	
	favParams.rows = searchParams.rows;	
	favParams.facet = 'false';	
	favParams['raw'] = "noescape";

	// zip it up
	mergedParams = jQuery.extend(true,{},searchDefs,favParams);
	console.log("Merged FAVs Params:",mergedParams);	
	solrParamsString = JSON.stringify(mergedParams);	
	
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=getUserFavorites&solrParams="+solrParamsString;		
	console.log(APIcallURL);	

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){
		APIdata.favs = response;	    
	    console.log(userData.username_WSUDOR+" favorites:");
	    console.log(response)	    
	    searchGo();
	}
	function callError(response){
		console.log("API Call unsuccessful.  Back to the drawing board.");	  
	}
}


// PAGE UPDATE
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function updatePage(){

	// get current URL
	var cURL = document.URL;
	// update fav_user
	$("#fav_user").html(userData.displayName);	
	// update number of results	
	$("#num_results").html(APIdata.favs.getUserFavorites.response.numFound);

	// pagination	
	var tpages = tpagesPaginate(APIdata.favs.getUserFavorites.response.numFound,mergedParams.rows);
	var spage = parseInt(mergedParams.start / mergedParams.rows) + 1;	
	if (spage == 0) {
		spage = 1;
	}	
	$('.pagination-centered').bootpag({
	   total: tpages,
	   page: spage,
	   maxVisible: 10,
	   leaps:true
	}).on('page', function(event, num){			    
	    var nURL = updateURLParameter(window.location.href, "start", ((num * mergedParams.rows) - mergedParams.rows) );
	    // refresh page	
		window.location = nURL;
	});
}


// QUERYING
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function searchGo(){	

	// create q based on ALL favorites of user	
	searchParams.q = "";
	// for (var i in APIdata.favs.getUserFavorites.response.docs){
	for (var i=0; i<APIdata.favs.getUserFavorites.response.docs.length; i++){		
		var fav_item = APIdata.favs.getUserFavorites.response.docs[i].fav_item;
		searchParams.q += fav_item+" ";		
	}	
	
	// toss up current start, set to zero, return before query		
	var juggledValue = searchParams.start;		
	searchParams.start = 0;	

	// fix facets / fq
	searchParams['fq[]'] = searchParams['fq'];
	delete searchParams['fq'];

	// Set Search Parameters		
	// Merge default and URL search parameters
	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);
	debugSearchParams();	
	
	//pass solr parameters os stringify-ed JSON, accepted by Python API as dicitonary
	solrParamsString = JSON.stringify(mergedParams);	
	// Calls API functions	
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=solrSearch&solrParams="+solrParamsString;			
	
	// return to juggled value
	searchParams.start = juggledValue;
	mergedParams.start = juggledValue;	

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
	    	populateResults();	    		
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


function populateResults(){
	
	//push results to results_container
	for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {
  		$.ajax({          
		  url: 'templates/favoritesObj.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;
		  	var html = Mustache.to_html(template, APIdata.solrSearch.response.docs[i]);		  	
		  	$("#results_container").append(html);
		  }		  
		});
	}	
}


