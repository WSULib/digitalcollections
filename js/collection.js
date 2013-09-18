// Javascript for collection view

// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default Search Parameters (pre form submission)
var searchDefs = {};
var mergedParams = {};
searchDefs.rows = 10;
searchDefs.start = 0;
searchDefs.wt = "json";
searchDefs.facet = 'true';
searchDefs.facets = [];
searchDefs.fq = [];
searchDefs.fl = "id dc_title";
// searchDefs['facet.mincount'] = 2;

// Global API response data
APIdata = new Object();

// Facet Hash
var facetHash = {
	"dc_date":"Date",
	"dc_subject":"Subject",
	"dc_creator":"Creator",
	"dc_language":"Language",
	"rels_hasContentModel":"Type"
}

// Content Type Hash 
var contentTypeHash= {
	"info:fedora/CM:Image" : "Image",
	"info:fedora/CM:Document" : "Document",
	"info:fedora/CM:WSUebook" : "WSUebook",
	"info:fedora/CM:Collection" : "Collection",
	"info:fedora/singleObjectCM:WSUebook" : "WSUebook"	
}

//INITIAL LOAD
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function collectionSelect(){
	mergedParams.q = "rels_isMemberOfCollection:info:fedora/wayne:collectionWSUDORCollections";
	debugSearchParams();
	
	//pass solr parameters os stringify-ed JSON, accepted by Python API as dicitonary
	solrParamsString = JSON.stringify(mergedParams);
	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='solrSearch'&GETparams='"+solrParamsString+"'";			

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'jsonp',	  
	  jsonpCallback: "jsonpcallback",          
	  success: callSuccess,
	  // error: callError
	});

	function callSuccess(response){

	    APIdata = response;
	    console.log("APIdata");
	    console.log(APIdata);
	    $(document).ready(function(){
			populateTitleResults();    		
	    });
	    
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

	// update number of results
	$("#q_string").html(mergedParams.q);	
	$("#num_results").html(APIdata.solrSearch.response.numFound);

	// update rows selecctor
	$("#rows").val(mergedParams.rows).prop('selected',true);

	// update query box
	$("#q").val(mergedParams.q);

	// pagination
	var tpages = parseInt((APIdata.solrSearch.response.numFound / mergedParams.rows) + 1);
	var spage = parseInt(mergedParams.start / mergedParams.rows) + 1;
	if (spage == 0) {
		spage = 1;
	}

	
	$('.pagination').bootpag({
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

	// Set Search Parameters	
	// Pre-merge? Push default facets to params, such that they don't overwrite? May not be necessary, facets should be hardcoded...	
	// Merge default and URL search parameters

	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);
	debugSearchParams();
	
	
	//pass solr parameters os stringify-ed JSON, accepted by Python API as dicitonary
	solrParamsString = JSON.stringify(mergedParams);

	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='solrSearch'&GETparams='"+solrParamsString+"'";			

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'jsonp',	  
	  jsonpCallback: "jsonpcallback",          
	  success: callSuccess,
	  // error: callError
	});

	function callSuccess(response){

	    APIdata = response;
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

function updateCollection(){

	// get current URL
	var cURL = document.URL;

	// check rows to update
	searchParams.q = escape($("#q").val());
	console.log(searchParams.q);
	var nURL = updateURLParameter(window.location.href, 'q', searchParams.q);

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
function populateResults(){
	
	//push results to results_container
	for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {		

  		$.ajax({          
		  url: 'templates/collectionResultObj.htm',      
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

function populateTitleResults(){
	
	//push results to results_container
	for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {		

  		$.ajax({          
		  url: 'templates/collectionTitleResultObj.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;
		  	var html = Mustache.to_html(template, APIdata.solrSearch.response.docs[i]);		  	
		  	$("#title").append(html);
		  }		  
		});
	}	
}

function populateCollectionResults(){
	
	//push results to results_container
	for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {		

  		$.ajax({          
		  url: 'templates/collectionResultObj.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;
		  	var html = Mustache.to_html(template, APIdata.solrSearch.response.docs[i]);		  	
		  	$("#title").append(html);
		  }		  
		});
	}	
}

// UTILITIES
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/**
 * http://stackoverflow.com/a/10997390/11236
 */
function updateURLParameter(url, param, paramVal){
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";
    if (additionalURL) {
        tempArray = additionalURL.split("&");
        for (i=0; i<tempArray.length; i++){
            if(tempArray[i].split('=')[0] != param){
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }
    }

    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}

function debugSearchParams(){
	console.log("searchParams:");
	console.log(searchParams);
	console.log("searchDefs:");
	console.log(searchDefs);
	console.log("mergedParams:");
	console.log(mergedParams);

}

//string contains
String.prototype.contains = function(it) { return this.indexOf(it) != -1; };