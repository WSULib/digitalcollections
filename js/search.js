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
		$("#q").val(mergedParams.q);
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
	var APIcallURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=solrSearch&solrParams="+solrParamsString;			

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




// DISPLAY RESULTS
//////////////////////////////////////////////////////////////////////////////////////////////////////////////
function populateFacets(type){	

	// get current URL
	var cURL = document.URL;

	// tack on "*" to empty search	
	if (cURL.indexOf("?q=") == -1 ){
		cURL+="?q=*";
	}
	if (cURL.endsWith("?q=") == true ){
		cURL+="*";
	}


	// set defaults
	var facet_limit = 18;
	// for each facet field
	for (var facet in APIdata.solrSearch.facet_counts.facet_fields) {
		$("#facets_container").append("<ul class='facet_container filter' id='"+facet+"_facet'><li><h3 class='tree-toggler'><span>&#9660;</span>"+rosetta(facet)+"</h3><ul class='tree facet_list' id='"+facet+"_list'></ul></li>");

		var facet_array = APIdata.solrSearch.facet_counts.facet_fields[facet];		
		for (var i = 0; i < facet_array.length; i = i + 2){			
			// run through rosetta translation
			var facet_value = rosetta(facet_array[i]);			
			if (facet_array[i] != ""){
				// write URL
				//set start to 0, most elegant way to handle less numFound than start count
				fURL = cURL + "&fq[]=" + facet + ":\"" + facet_array[i] +"\""+"&start=0"; 
				// for long facet lists, initially hide facets over facet_limit
				if (i > facet_limit) { 
					var facet_hidden = "class='hidden_facet'";
				} 
				else {
					var facet_hidden = ""
				}			
				$("#"+facet+"_list").append("<li "+facet_hidden+"><a href='"+fURL+"'>"+facet_value+" ("+facet_array[i+1]+")</a></li>");			
			}
		}
		// add "more" button if longer than facet_limit		
		if (facet_array.length > facet_limit){						
			$("#"+facet+"_list").append("<p class='facet-more'><strong><a id='"+facet+"_more' href='#' onclick='facetCollapseToggle(\"more\", \""+facet+"\"); return false;'>View All &raquo;</a></strong></p>");
			$("#"+facet+"_list").append("<p class='facet-more'><strong><a class='facet_less' id='"+facet+"_less' href='#' onclick='facetCollapseToggle(\"less\", \""+facet+"\"); return false;'>&laquo; View Less</a></strong></p>");			
		}
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





