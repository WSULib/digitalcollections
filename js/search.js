// Javascript for search view

// Globals
var searchBlob = {};
searchBlob.rows = 10;
searchBlob.start = 0;
searchBlob.wt = "json";
searchBlob.facet = 'true';
searchBlob.facets = [];
searchBlob.facets.push("dc_date","dc_subject");
searchBlob['facet.mincount'] = 2;


APIdata = new Object();

function searchGo(q){
	//update searchBlob
	var q = $("#q").val();
	searchBlob.q = q;
	console.log(searchBlob);	
	
	//pass solr parameters os stringify-ed JSON, accepted by Python API as dicitonary
	solrParamsString = JSON.stringify(searchBlob);

	// Calls API functions
	var APIcallURL = "http://silo.lib.wayne.edu/api/index.php?functions='solrSearch'&GETparams='"+solrParamsString+"'";		
	console.log(APIcallURL);

	$.ajax({          
	  url: APIcallURL,      
	  dataType: 'json',            
	  success: callSuccess,
	  error: callError
	});

	function callSuccess(response){		
	    APIdata = response;
	    console.log(APIdata);
	    $(document).ready(function(){
	    	populateResults();
	    	populateFacets();	
	    });
	    
	}

	function callError(response){
		console.log("API Call unsuccessful.  Back to the drawing board.");	  
	}
}

function populateResults(){
	
	//push results to results_container
	for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {		

  		$.ajax({          
		  url: 'templates/searchResultObj.htm',      
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

function populateFacets(){
	
	//push results to results_container
	for (var i = 0; i < APIdata.solrSearch.response.docs.length; i++) {		

  		$.ajax({          
		  url: 'templates/searchResultObj.htm',      
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