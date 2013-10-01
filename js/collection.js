// Javascript for collection view

// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default Search Parameters (pre form submission)
var searchDefs = {};
var mergedParams = {};
searchDefs.rows = 50;
searchDefs.start = 0;
searchDefs.wt = "json";
searchDefs.facets = [];
searchDefs.fq = [];
searchDefs.fl = "id dc_title";
searchDefs.sort = "id asc";
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

function collectionsList(){

	mergedParams.q = "rels_isMemberOfCollection:info:fedora/wayne:collectionWSUDORPublic";

	// set start as 0 for the collectionsList query
	mergedParams.start = 0;

	//pass solr parameters os stringify-ed JSON, accepted by Python API as dictionary
	solrParamsString = JSON.stringify(mergedParams);

	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='solrSearch'&GETparams='"+solrParamsString+"'";

	// reset the start param to what the user set, so this doesn't mess with other queries
	solrParamsString = JSON.parse(solrParamsString)
	
	if (searchParams.start !== 'undefined'){
	solrParamsString.start = searchParams.start;
	}
	else{
		solrParamsString.start = 0;
	}
	
	solrParamsString = JSON.stringify(solrParamsString);
	
	if (searchParams.start !== 'undefined'){
	mergedParams.start = searchParams.start;
	}
	else{
		mergedParams.start = 0;
	}			

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  
	  success: callSuccess,
	  // error: callError
	});

	function callSuccess(response){

	    APIdata.collectionsList = response;
	    $(document).ready(function(){
			populateCollectionsList();    		
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
	searchParams.q = searchParams.collection;

	searchParams.q = "rels_isMemberOfCollection:'info:fedora/"+searchParams.q+"'";
	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);
	debugSearchParams();
	
	
	//pass solr parameters os stringify-ed JSON, accepted by Python API as dicitonary
	solrParamsString = JSON.stringify(mergedParams);

	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='solrSearch'&GETparams='"+solrParamsString+"'&raw='escapeterms'";			

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	         
	  success: callSuccess,
	  // error: callError
	});

	function callSuccess(response){

	    APIdata = response;
	    $(document).ready(function(){
	    	collectionsList();
	    	updateCollectionTitle();
	    	updatePage();
	    	populateResults();	    		
	    });
	    
	}

	function callError(response){

		console.log("API Call unsuccessful.  Back to the drawing board.");	  
	}
}

function updateCollectionTitle(){
	// searchParams.q = searchParams.collection;
	var str = searchParams.q;
	if (typeof searchParams.q !== 'undefined'){
		str = str.split('/')[1];
		searchParams.q = str.replace("'", " ");

	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='solr4FedObjsID'&PID="+searchParams.q;

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){

	    APIdata.collectionMeta = response;
	    console.log(APIdata);
	    $(document).ready(function(){
	    	if (typeof APIdata.collectionMeta.solr4FedObjsID.response.docs[0].dc_title[0] !== 'undefined'){
			$("#title").html(APIdata.collectionMeta.solr4FedObjsID.response.docs[0].dc_title[0]);
			}	    		
	    });
	    
	}

	function callError(response){
		console.log("No Collection Title has been returned from ajax call");
		console.log(response);
	    $(document).ready(function(){
			$("#title").html("Untitled Collection");	    		
	    });


	}
	}

}

function updateCollection(){

	// get current URL
	var cURL = document.URL;

	// check rows to update
	searchParams.q = $("#collection").val();
	var nURL = updateURLParameter(window.location.href, 'collection', searchParams.q);

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
		if (mergedParams.q == "rels_isMemberOfCollection:info:fedora/wayne:collectionWSUDORCollections"){
		$.ajax({          
		  url: 'templates/collectionResultObjAlt.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;
		  	var html = Mustache.to_html(template, APIdata.solrSearch.response.docs[i]);		  	
		  	$("#results_container").append(html);
		  }		  
		});
	  	}

		 else{
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
}

function populateCollectionsList(){

	//push results to collectionSelector
	for (var i = 0; i < APIdata.collectionsList.solrSearch.response.docs.length; i++) {		

  		$.ajax({          
		  url: 'templates/collectionsListObj.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;
		  	var html = Mustache.to_html(template, APIdata.collectionsList.solrSearch.response.docs[i]);		  	
		  	$("select#collection").append(html);
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