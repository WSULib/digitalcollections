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

	var favParams = new Object();
	favParams.q = "fav_user:"+userData.username_WSUDOR;
	favParams.fl = "fav_item";	
	favParams.start = searchParams.start;
	favParams.rows = searchParams.rows;
	favParams.facet = 'false';	
	favParams['raw'] = "noescape";

	// zip it up
	mergedFavsParams = jQuery.extend(true,{},searchDefs,favParams);
	console.log("Merged FAVs Params:");
	console.log(mergedFavsParams);
	solrParamsString = JSON.stringify(mergedFavsParams);	

	// "raw" parameter as wildcard, used in solr.py to not escape query in this instance
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
	$("#q_string").html(mergedParams.q);	
	$("#num_results").html(APIdata.solrSearch.response.numFound);

	// update rows selecctor
	$("#rows").val(mergedParams.rows).prop('selected',true);

	// show "refined by" facets
	for (var i = 0; i < mergedParams['fq[]'].length; i++){		
		var facet_string = mergedParams['fq[]'][i];				
		var facet_type = facet_string.split(":")[0];
		var facet_value = facet_string.split(":").slice(1).join(":");

		
		var nURL = cURL.replace(("fq[]="+encodeURI(facet_string))+"&",'');
		$("#facet_refine_list").append("<li><a href='"+nURL+"'>x</a> "+rosetta(facet_type)+": "+rosetta(facet_value)+"</li>");
	}

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

	// create q based on ALL favorites of user	
	searchParams.q = "";
	for (var i in APIdata.favs.getUserFavorites.response.docs){		
		var fav_item = APIdata.favs.getUserFavorites.response.docs[i].fav_item;
		searchParams.q += fav_item+" ";		
	}
	searchParams.q = "id:("+searchParams.q+")";


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
function populateFacets(){	

	// get current URL
	var cURL = document.URL;
	// set defaults
	var facet_limit = 18;
	// for each facet field
	for (var facet in APIdata.solrSearch.facet_counts.facet_fields) {
		$("#facets_container").append("<ul class='facet_container' id='"+facet+"_facet'><li><h5 class='tree-toggler'>"+rosetta(facet)+"</h5><ul class='tree facet_list' id='"+facet+"_list'></ul></li>");

		var facet_array = APIdata.solrSearch.facet_counts.facet_fields[facet];		
		for (var i = 0; i < facet_array.length; i = i + 2){			
			// run through rosetta translation
			var facet_value = rosetta(facet_array[i]);			
			if (facet_array[i] != ""){
				// write URL
				//set start to 0, most elegant way to handle less numFound than start count
				cURL = cURL.replace(/\&start=[0-9]+/g,'');
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
			$("#"+facet+"_list").append("<p style='text-align:right;'><strong><a id='"+facet+"_more' href='#' onclick='facetCollapseToggle(\"more\", \""+facet+"\"); return false;'>more >></a></strong></p>");
			$("#"+facet+"_list").append("<p style='text-align:right;'><strong><a class='facet_less' id='"+facet+"_less' href='#' onclick='facetCollapseToggle(\"less\", \""+facet+"\"); return false;'><< less</a></strong></p>");			
		}
	}		
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


// favObjs CRUD

// remove object
function favObjRemove(PID){    
    if (typeof userData.username_WSUDOR != "undefined"){
      // stringify user / item / search object, send to solrAddDoc API function  
      var addDoc = new Object();
      addDoc.id = userData.username_WSUDOR+"_"+PID
      // addDoc.fav_user = userData.username_WSUDOR;
      // addDoc.fav_item = APIdata.APIParams.PID;
      var jsonAddString = '{"delete":'+JSON.stringify(addDoc)+'}';
      console.log(jsonAddString);

      var APIaddURL = "http://silo.lib.wayne.edu/WSUAPI?functions[]=solrRemoveDoc&raw="+jsonAddString;
      console.log(APIaddURL);

      $.ajax({          
        url: APIaddURL,      
        dataType: 'json',
        success: callSuccess,
        error: callError
      });

      function callSuccess(response){
        console.log(response);
        alert(PID+" Removed :(");        
        location.reload();
      }
      function callError(response){
        console.log(response);
        alert("Error.");
      }
    }
  else {
    alert("No user defined!");
  }
}

// add object to list
function favObjAdd(PID){
	alert("we're adding to list "+PID);
}


