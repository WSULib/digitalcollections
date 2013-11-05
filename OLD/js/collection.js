// Javascript for collection view

// Variables
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Default Search Parameters
var searchDefs = {};
var mergedParams = {};
searchDefs.rows = 50;
searchDefs.start = 0;
searchDefs.wt = "json";
// searchDefs.facets = [];
// searchDefs.fq = [];
searchDefs.fl = "id dc_title";
searchDefs.sort = "id asc";
// Global API response data
APIdata = new Object();


//INITIAL LOAD
//////////////////////////////////////////////////////////////////////////////////////////////////////////////

function collectionsList(){

	// WSUAPI v2.0		
	var CollectionListParams = '{"rows":1000,"start":0,"wt":"json","fl":"id dc_title","sort":"id asc","q":"wayne:collectionWSUDORPublic"}';
	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI/?functions[]=solrGetCollectionObjects&solrParams="+CollectionListParams;

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  
	  success: callSuccess,
	  error: callError
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
	$("#num_results").html(APIdata.solrGetCollectionObjects.response.numFound);

	// update rows selecctor
	$("#rows").val(mergedParams.rows).prop('selected',true);

	// update query box
	$("#q").val(mergedParams.q);	

	// pagination
	var tpages = parseInt((APIdata.solrGetCollectionObjects.response.numFound / mergedParams.rows) + 1);
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
	searchParams['q'] = searchParams['collection'];
	delete searchParams['collection'];
	mergedParams = jQuery.extend(true,{},searchDefs,searchParams);
	debugSearchParams();	
	
	//pass solr parameters os stringify-ed JSON, accepted by Python API as dicitonary
	solrParamsString = JSON.stringify(mergedParams);	
	console.log(solrParamsString);

	// WSUAPI v2.0
	// Usuing new API function solrGetCollectionObjects()
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI/?functions[]=solrGetCollectionObjects&solrParams="+solrParamsString;

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
	var str = searchParams.q;
	// if (typeof searchParams.q !== 'undefined'){
	// 	str = str.split('/')[1];
	// 	searchParams.q = str.replace("'", " ");

	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI/?functions[]=solrGetFedDoc&PID="+searchParams.q;

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',	  
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){

	    APIdata.collectionMeta = response;	    
	    $(document).ready(function(){
		    	if (typeof APIdata.collectionMeta.solrGetFedDoc.response.docs[0].dc_title[0] !== 'undefined'){
				$("#title").html(APIdata.collectionMeta.solrGetFedDoc.response.docs[0].dc_title[0]);
				
				// update currently selected drop-down
				$("#collection [value='"+APIdata.collectionMeta.APIParams.PID[0]+"'").attr('id','currentlySelected');
				document.getElementById('currentlySelected').setAttribute('selected','selected');

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
	// }

}

function updateCollection(){

	// get current URL
	var cURL = document.URL;

	// check rows to update
	searchParams.q = $("#collection").val();
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
function populateResults(){

	//push results to results_container
	for (var i = 0; i < APIdata.solrGetCollectionObjects.response.docs.length; i++) {		
		if (mergedParams.q == "rels_isMemberOfCollection:info:fedora/wayne:collectionWSUDORCollections"){
			$.ajax({          
			  url: 'templates/collectionResultObjAlt.htm',      
			  dataType: 'html',            
			  async:false,
			  success: function(response){		  	
			  	var template = response;
			  	var html = Mustache.to_html(template, APIdata.solrGetCollectionObjects.response.docs[i]);		  	
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
			  	var html = Mustache.to_html(template, APIdata.solrGetCollectionObjects.response.docs[i]);		  	
			  	$("#results_container").append(html);
			  }		  
			});
		 }

	}	
}

function populateCollectionsList(){

	//push results to collectionSelector
	for (var i = 0; i < APIdata.collectionsList.solrGetCollectionObjects.response.docs.length; i++) {		

  		$.ajax({          
		  url: 'templates/collectionsListObj.htm',      
		  dataType: 'html',            
		  async:false,
		  success: function(response){		  	
		  	var template = response;
		  	var html = Mustache.to_html(template, APIdata.collectionsList.solrGetCollectionObjects.response.docs[i]);		  	
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